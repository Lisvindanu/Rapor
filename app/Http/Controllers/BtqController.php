<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BtqJadwal;
use App\Models\BtqJadwalMahasiswa;

class BtqController extends Controller
{
    public function index()
    {
        if (session('selected_role') == 'Pementor') {
            return $this->indexPenguji();
        } else if (session('selected_role') == 'Admin') {
            return $this->indexAdmin();
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
            ->where('is_active', "!=", "Selesai")
            // ->orderBy('tanggal', 'asc')
            ->orderBy('is_active', 'asc')
            ->get();

        return view('btq.index-penguji', [
            'jadwal' => $jadwal
        ]);
    }

    // riwayatJadwal
    public function riwayatJadwal()
    {
        $jadwal = BtqJadwal::with(['periode', 'penguji'])
            ->where('penguji_id', auth()->user()->username)
            ->where('is_active', "Selesai")
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

    // indexAdmin
    public function indexAdmin()
    {
        // jumlah mahasiswa total
        // jumlah mahasiswa yang ikut BTQ
        // jumlah pementor
        // 


        $jadwal = BtqJadwal::with(['periode', 'penguji'])
            ->where('is_active', "!=", "Selesai")
            ->orderBy('tanggal', 'asc')
            ->get();

        return view('btq.index-admin', [
            'jadwal' => $jadwal
        ]);
    }
}
