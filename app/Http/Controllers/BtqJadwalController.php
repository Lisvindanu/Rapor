<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Periode;
use App\Models\BtqJadwal;
use App\Models\BtqJadwalMahasiswa;

class BtqJadwalController extends Controller
{
    //create
    public function create()
    {
        try {
            $daftar_periode = Periode::orderBy('kode_periode', 'desc')->take(10)->get();
            return view(
                'btq.jadwal.create',
                [
                    'daftar_periode' => $daftar_periode,
                ]
            );
        } catch (\Exception $e) {
            return back()->with('message', "Terjadi kesalahan" . $e->getMessage());
        }
    }

    //store
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'kode_periode' => 'required|string|max:255',
                'penguji_id'   => 'required|string|max:255',
                'kuota'        => 'required|numeric|min:1',
                'hari'         => 'required|string|max:255',
                'tanggal'      => 'required|date',
                'jam_mulai'    => 'required|date_format:H:i',
                'jam_selesai'  => 'required|date_format:H:i|after:jam_mulai',
                'ruang'        => 'required|string|max:255',
                'peserta'      => 'required|string|in:L,P', // Assuming L for male, P for female
                'is_active'    => 'nullable|boolean',
            ]);
            $jadwal = BtqJadwal::create($validated);

            return redirect()->route('btq')->with('message', 'Jadwal berhasil disimpan');
        } catch (\Exception $e) {
            return back()->with('message', "Terjadi kesalahan" . $e->getMessage());
        }
    }

    // daftarJadwal
    public function daftarJadwal()
    {
        try {
            $daftar_jadwal = BtqJadwal::with(['periode', 'penguji'])
                ->where('is_active', true)  // Hanya menampilkan jadwal yang is_active = true
                ->orderBy('tanggal', 'asc')
                ->get()
                ->filter(function ($jadwal) {
                    // Filter jadwal di mana jumlah mahasiswa terdaftar kurang dari kuota
                    return $jadwal->jumlahMahasiswaTerdaftar() < $jadwal->kuota;
                });

            // return response()->json($daftar_jadwal);

            $daftar_periode = Periode::orderBy('kode_periode', 'desc')->take(10)->get();

            return view(
                'btq.jadwal.daftar-jadwal',
                [
                    'data' => $daftar_jadwal,
                    'daftar_periode' => $daftar_periode,
                ]
            );
        } catch (\Exception $e) {
            return back()->with('message', "Terjadi kesalahan" . $e->getMessage());
        }
    }

    //edit
    public function edit($id)
    {
        try {
            $jadwal = BtqJadwal::find($id);
            $daftar_periode = Periode::orderBy('kode_periode', 'desc')->take(10)->get();

            // return response()->json($jadwal);
            return view(
                'btq.jadwal.edit',
                [
                    'jadwal' => $jadwal,
                    'daftar_periode' => $daftar_periode,
                ]
            );
        } catch (\Exception $e) {
            return back()->with('message', "Terjadi kesalahan" . $e->getMessage());
        }
    }

    //update
    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'kode_periode' => 'required|string|max:255',
                'penguji_id'   => 'required|string|max:255',
                'kuota'        => 'required|numeric|min:1',
                'hari'         => 'required|string|max:255',
                'tanggal'      => 'required|date',
                'jam_mulai'    => 'required|date_format:H:i',
                'jam_selesai'  => 'required|date_format:H:i|after:jam_mulai',
                'ruang'        => 'required|string|max:255',
                'peserta'      => 'required|string|in:L,P', // Assuming L for 
                'is_active'    => 'nullable|boolean',
            ]);
            $jadwal = BtqJadwal::find($id);
            $jadwal->update($validated);

            return back()->with('message', 'Jadwal berhasil diubah');
        } catch (\Exception $e) {
            return back()->with('message', "Terjadi kesalahan" . $e->getMessage());
        }
    }

    // daftarPeserta
    public function daftarPeserta($id)
    {
        try {
            $jadwal = BtqJadwal::with('mahasiswaTerdaftar.mahasiswa')->find($id);

            // return response()->json($jadwal);
            return view(
                'btq.jadwal.peserta',
                [
                    'jadwal' => $jadwal,
                    'daftar_peserta' => $jadwal->mahasiswaTerdaftar ?? [],
                ]
            );
        } catch (\Exception $e) {
            return back()->with('message', "Terjadi kesalahan" . $e->getMessage());
        }
    }
}
