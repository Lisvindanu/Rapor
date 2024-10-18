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

        if (session('selected_role') == 'Admin' || session('selected_role') == 'Penguji') {
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
            ->orderBy('tanggal', 'asc')
            ->get();

        return view('btq.index-penguji', [
            'jadwal' => $jadwal
        ]);
    }

    // index-peserta
    public function indexMahasiswa()
    {
        $user = auth()->user();

        // Cek apakah jeniskelamin di mahasiswa null
        $showModal = false; // Default, modal tidak ditampilkan

        if ($user->mahasiswa && is_null($user->mahasiswa->jeniskelamin)) {
            $showModal = true; // Tampilkan modal jika jeniskelamin null
        }


        $jadwal = BtqJadwalMahasiswa::with(['jadwal', 'mahasiswa'])
            ->where('mahasiswa_id', auth()->user()->username)
            ->get();

        return view('btq.index-mahasiswa', [
            'jadwal' => $jadwal,
            'showModal' => $showModal
        ]);
    }
}
