<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Rapor;
use Maatwebsite\Excel\Row;
use App\Models\Pegawai;

class ImportController extends Controller
{
    public function importRaporKinerja1(Request $request)
    {
        $message = '';
        //validate file
        $validasi = $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        // Cek apakah file yang diupload adalah file excel
        if ($validasi) {
            try {
                $file = $request->file('file');
                $data = Excel::toArray([], $file);

                // Hapus baris pertama dan ke dua pada array untuk menghilangkan header
                array_shift($data[0]);
                array_shift($data[0]);

                foreach ($data[0] as $row) {
                    //update data Rapor
                    $rapor = Rapor::where('periode_rapor', $row[1])
                        //ilike %dosen_nip%
                        ->where('dosen_nip', 'ilike', '%' . $row[2] . '%')
                        ->where('programstudi', $row[5])
                        ->first();

                    // dd($rapor);
                    // print_r($rapor);

                    if ($rapor) {
                        $rapor->bkd_total = $row[6];
                        $rapor->edom_materipembelajaran = $row[7];
                        $rapor->edom_pengelolaankelas = $row[8];
                        $rapor->edom_prosespengajaran = $row[9];
                        $rapor->edom_penilaian = $row[10];
                        $rapor->edasep_atasan = $row[11];
                        $rapor->edasep_sejawat = $row[12];
                        $rapor->edasep_bawahan = $row[13];
                        $rapor->save();
                    } else {
                        //insert data Rapor
                        // $rapor = new Rapor();
                        // $rapor->periode_rapor = $row[1];
                        // $rapor->dosen_nip = $row[2];
                        // $rapor->programstudi = $row[5];
                        // $rapor->bkd_total = $row[6];
                        // $rapor->edom_materipembelajaran = $row[7];
                        // $rapor->edom_pengelolaankelas = $row[8];
                        // $rapor->edom_prosespengajaran = $row[9];
                        // $rapor->edom_penilaian = $row[10];
                        // $rapor->edasep_atasan = $row[11];
                        // $rapor->edasep_sejawat = $row[12];
                        // $rapor->edasep_bawahan = $row[13];
                        // $rapor->save();
                    }
                }
                $message = 'File berhasil diupload';
            } catch (\Exception $e) {
                $message = $e->getMessage();
            }
        } else {
            // Jika file yang diupload bukan file excel
            $message = 'File yang diupload bukan file excel';
        }
        return redirect()->back()->with('message', $message);
    }

    public function importRaporKinerja(Request $request)
    {
        $message = '';
        //validate file
        $validasi = $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        // Cek apakah file yang diupload adalah file excel
        if ($validasi) {
            try {
                $file = $request->file('file');
                $data = Excel::toArray([], $file);

                // Hapus baris pertama dan ke dua pada array untuk menghilangkan header
                array_shift($data[0]);

                foreach ($data[0] as $row) {
                    //update data Rapor
                    $pegawai = Pegawai::where('nip', $row[2])
                        ->first();

                    // dd($rapor);
                    // print_r($rapor);

                    if ($pegawai) {
                        $pegawai->nama = $row[1];
                        $pegawai->nik = $row[4];
                        $pegawai->npwp = $row[5];
                        $pegawai->pangkat = $row[6];
                        $pegawai->jabatan_fungsional = $row[7];
                        $pegawai->jenis_pegawai = $row[8];
                        $pegawai->jk = $row[9];
                        $pegawai->agama = $row[10];
                        $pegawai->tempat_lahir = $row[11];
                        $pegawai->email = $row[13];
                        $pegawai->no_hp = $row[14];
                        $pegawai->unit_kerja_id = $row[15];
                        $pegawai->save();
                    } else {
                        // insert data Pegawai
                        $pegawai = new Pegawai();
                        $pegawai->nama = $row[1];
                        $pegawai->nip = $row[2];
                        $pegawai->nik = $row[4];
                        $pegawai->npwp = $row[5];
                        $pegawai->pangkat = $row[6];
                        $pegawai->jabatan_fungsional = $row[7];
                        $pegawai->jenis_pegawai = $row[8];
                        $pegawai->jk = $row[9];
                        $pegawai->agama = $row[10];
                        $pegawai->tempat_lahir = $row[11];
                        $pegawai->email = $row[13];
                        $pegawai->no_hp = $row[14];
                        $pegawai->unit_kerja_id = $row[15];
                        $pegawai->save();
                    }
                }
                $message = 'File berhasil diupload';
            } catch (\Exception $e) {
                $message = $e->getMessage();
            }
        } else {
            // Jika file yang diupload bukan file excel
            $message = 'File yang diupload bukan file excel';
        }
        return redirect()->back()->with('message', $message);
    }
}
