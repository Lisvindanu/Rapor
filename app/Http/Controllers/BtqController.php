<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BtqJadwal;
use App\Models\BtqJadwalMahasiswa;

class BtqController extends Controller
{
    public function index()
    {
        // $jadwal = BtqJadwal::with(['periode', 'penguji'])
        //     ->where('penguji_id', auth()->user()->username)
        //     ->get();

        // // return response()->json($jadwal);

        // return view('btq.index-penguji', [
        //     'jadwal' => $jadwal
        // ]);

        if (session('selected_role') == 'Admin') {
            return $this->indexPenguji();
        } else if (session('selected_role') == 'Mahasiswa') {
            // return "Mahasiswa";
            return $this->indexMahasiswa();
        } else {
            return redirect()->route('home');
        }
    }

    // index-penguji
    public function indexPenguji()
    {
        $jadwal = BtqJadwal::with(['periode', 'penguji'])
            ->where('penguji_id', auth()->user()->username)
            ->orderBy('is_active', 'desc')
            ->orderBy('tanggal', 'asc')
            ->get();

        return view('btq.index-penguji', [
            'jadwal' => $jadwal
        ]);
    }

    // index-peserta
    public function indexMahasiswa()
    {
        $jadwal = BtqJadwalMahasiswa::with(['jadwal', 'mahasiswa'])
            ->where('mahasiswa_id', auth()->user()->username)
            ->get();

        return view('btq.index-mahasiswa', [
            'jadwal' => $jadwal
        ]);
    }
}
