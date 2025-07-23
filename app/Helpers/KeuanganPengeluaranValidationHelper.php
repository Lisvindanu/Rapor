<?php

namespace App\Helpers;

use App\Models\KeuanganTahunAnggaran;

class KeuanganPengeluaranValidationHelper
{
    public static function getPengeluaranRules($id = null)
    {
        $rules = [
            'tanggal' => 'required|date|before_or_equal:today',
            'sudah_terima_dari' => 'required|string|max:255',
            'uang_sebanyak' => 'required|string|max:500',
            'uang_sebanyak_angka' => 'required|numeric|min:0',
            'untuk_pembayaran' => 'required|string|max:2000',
            'mata_anggaran_id' => 'required|exists:keuangan_mtang,id',
            'program_id' => 'required|exists:keuangan_program,id',
            'sumber_dana_id' => 'required|exists:keuangan_sumberdana,id',
            'tahun_anggaran_id' => [
                'required',
                'exists:keuangan_tahun_anggaran,id',
                function ($attribute, $value, $fail) {
                    $tahunAnggaran = KeuanganTahunAnggaran::find($value);
                    if (!$tahunAnggaran || !$tahunAnggaran->is_active) {
                        $fail('Tahun anggaran yang dipilih tidak aktif.');
                    }
                },
            ],
            'dekan_id' => 'required|exists:keuangan_tandatangan,id',
            'wakil_dekan_ii_id' => 'required|exists:keuangan_tandatangan,id',
            'ksb_keuangan_id' => 'required|exists:keuangan_tandatangan,id',
            'penerima_id' => 'required|exists:keuangan_tandatangan,id',
            'status' => 'required|in:draft,pending,approved,rejected,paid',
            'keterangan' => 'nullable|string|max:1000'
        ];

        if ($id) {
            $rules['nomor_bukti'] = 'required|string|max:50|unique:keuangan_pengeluaran,nomor_bukti,' . $id;
        }

        return $rules;
    }

    public static function getMessages()
    {
        return [
            'tanggal.required' => 'Tanggal harus diisi.',
            'tanggal.before_or_equal' => 'Tanggal tidak boleh lebih dari hari ini.',
            'sudah_terima_dari.required' => 'Penerima harus diisi.',
            'uang_sebanyak.required' => 'Terbilang uang harus diisi.',
            'uang_sebanyak_angka.required' => 'Jumlah uang harus diisi.',
            'uang_sebanyak_angka.numeric' => 'Jumlah uang harus berupa angka.',
            'uang_sebanyak_angka.min' => 'Jumlah uang tidak boleh negatif.',
            'untuk_pembayaran.required' => 'Keterangan pembayaran harus diisi.',
            'mata_anggaran_id.required' => 'Mata anggaran harus dipilih.',
            'program_id.required' => 'Program harus dipilih.',
            'sumber_dana_id.required' => 'Sumber dana harus dipilih.',
            'tahun_anggaran_id.required' => 'Tahun anggaran harus dipilih.',
            'dekan_id.required' => 'Dekan harus dipilih.',
            'wakil_dekan_ii_id.required' => 'Wakil Dekan II harus dipilih.',
            'ksb_keuangan_id.required' => 'KSB Keuangan harus dipilih.',
            'penerima_id.required' => 'Penerima harus dipilih.',
            'status.required' => 'Status harus dipilih.',
        ];
    }

    public static function numberToWords($number)
    {
        $angka = ["", "SATU", "DUA", "TIGA", "EMPAT", "LIMA", "ENAM", "TUJUH", "DELAPAN", "SEMBILAN"];
        $satuan = ["", "RIBU", "JUTA", "MILIAR"];

        if ($number == 0) return "NOL RUPIAH";

        $result = "";
        $i = 0;

        while ($number > 0) {
            $group = $number % 1000;
            if ($group != 0) {
                $groupText = self::convertHundreds($group, $angka);
                $result = $groupText . " " . $satuan[$i] . " " . $result;
            }
            $number = intval($number / 1000);
            $i++;
        }

        return trim($result) . " RUPIAH";
    }

    private static function convertHundreds($number, $angka)
    {
        $result = "";
        $hundreds = intval($number / 100);
        $remainder = $number % 100;

        if ($hundreds > 0) {
            $result .= ($hundreds == 1) ? "SERATUS " : $angka[$hundreds] . " RATUS ";
        }

        if ($remainder >= 20) {
            $tens = intval($remainder / 10);
            $ones = $remainder % 10;
            $result .= $angka[$tens] . " PULUH ";
            if ($ones > 0) $result .= $angka[$ones] . " ";
        } elseif ($remainder >= 11) {
            $result .= $angka[$remainder - 10] . " BELAS ";
        } elseif ($remainder == 10) {
            $result .= "SEPULUH ";
        } elseif ($remainder > 0) {
            $result .= $angka[$remainder] . " ";
        }

        return trim($result);
    }
}
