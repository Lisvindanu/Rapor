<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BtqJadwalMahasiswa;
use App\Models\BtqJadwal;

class BtqJadwalMahasiswaController extends Controller
{
    //store
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'jadwal_id'     => 'required|string|max:255',
            ]);

            $jadwal = BtqJadwal::find($validated['jadwal_id']);

            if (!$jadwal) {
                return response()->json([
                    'success' => false,
                    'message' => 'Jadwal tidak ditemukan.',
                ]);
            }

            $jumlahPeserta = $jadwal->jumlahMahasiswaTerdaftar();
            if ($jumlahPeserta >= $jadwal->kuota) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kuota jadwal sudah penuh. Anda tidak bisa memilih jadwal ini.',
                ]);
            }

            $existing = BtqJadwalMahasiswa::where('jadwal_id', $validated['jadwal_id'])
                ->where('mahasiswa_id', auth()->user()->username)
                ->first();

            if ($existing) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda sudah terdaftar di jadwal ini.',
                ]);
            }

            $existing_periode = BtqJadwalMahasiswa::where('mahasiswa_id', auth()->user()->username)
                ->join('btq_jadwal', 'btq_jadwal.id', '=', 'btq_jadwal_mahasiswa.jadwal_id')
                ->where('btq_jadwal.kode_periode', $jadwal->kode_periode)
                ->first();

            if ($existing_periode) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda sudah terdaftar di jadwal periode ini.',
                ]);
            }

            BtqJadwalMahasiswa::create([
                'jadwal_id'     => $validated['jadwal_id'],
                'mahasiswa_id'  => auth()->user()->username,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Jadwal berhasil dipilih!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ]);
        }
    }
}
