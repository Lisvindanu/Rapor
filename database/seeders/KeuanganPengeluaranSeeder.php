<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KeuanganPengeluaran;
use App\Models\KeuanganMataAnggaran;
use App\Models\KeuanganProgram;
use App\Models\KeuanganSumberDana;
use App\Models\KeuanganTahunAnggaran;
use App\Models\KeuanganTandaTangan;
use Carbon\Carbon;

class KeuanganPengeluaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🚀 Starting KeuanganPengeluaran seeder...');

        // Validate master data exists
        if (!$this->validateMasterData()) {
            return;
        }

        // Get master data
        $masterData = $this->getMasterData();

        // Create sample transactions
        $this->createSampleTransactions($masterData);

        $this->command->info('✅ KeuanganPengeluaran seeder completed successfully!');
    }

    /**
     * Validate that all required master data exists
     */
    private function validateMasterData(): bool
    {
        // Gunakan scope aktif() untuk mendapatkan tahun anggaran yang sedang aktif
        $tahunAktif = KeuanganTahunAnggaran::aktif()->first();

        // Jika tidak ada tahun aktif, ambil tahun anggaran terbaru
        if (!$tahunAktif) {
            $tahunAktif = KeuanganTahunAnggaran::orderBy('tgl_awal_anggaran', 'desc')->first();
        }

        $mataAnggaranCount = KeuanganMataAnggaran::count();
        $programCount = KeuanganProgram::count();
        $sumberDanaCount = KeuanganSumberDana::count();
        $tandaTanganCount = KeuanganTandaTangan::count();

        if (!$tahunAktif) {
            $this->command->error('❌ Tidak ada tahun anggaran. Jalankan KeuanganTahunAnggaranSeeder terlebih dahulu.');
            return false;
        }

        if ($mataAnggaranCount < 1) {
            $this->command->error('❌ Mata anggaran tidak ditemukan. Jalankan KeuanganMataAnggaranSeeder terlebih dahulu.');
            return false;
        }

        if ($programCount < 1) {
            $this->command->error('❌ Program tidak ditemukan. Jalankan KeuanganProgramSeeder terlebih dahulu.');
            return false;
        }

        if ($sumberDanaCount < 1) {
            $this->command->error('❌ Sumber dana tidak ditemukan. Jalankan KeuanganSumberDanaSeeder terlebih dahulu.');
            return false;
        }

        if ($tandaTanganCount < 4) {
            $this->command->error('❌ Minimal 4 tanda tangan diperlukan. Jalankan KeuanganTandaTanganSeeder terlebih dahulu.');
            return false;
        }

        $statusInfo = $tahunAktif->is_aktif ? 'aktif' : 'tersedia';
        $this->command->info("✅ Master data validation passed (Tahun anggaran {$tahunAktif->tahun_anggaran} - {$statusInfo})");
        return true;
    }

    /**
     * Get master data for seeding
     */
    private function getMasterData(): array
    {
        // Prioritas: tahun aktif > tahun terbaru
        $tahunAnggaran = KeuanganTahunAnggaran::aktif()->first()
            ?? KeuanganTahunAnggaran::orderBy('tgl_awal_anggaran', 'desc')->first();

        return [
            'tahunAnggaran' => $tahunAnggaran,
            'mataAnggarans' => KeuanganMataAnggaran::all(),
            'programs' => KeuanganProgram::all(),
            'sumberDanas' => KeuanganSumberDana::all(),
            'tandaTangans' => KeuanganTandaTangan::all()
        ];
    }

    /**
     * Create sample transaction data
     */
    private function createSampleTransactions(array $masterData): void
    {
        $sampleData = [
            [
                'tanggal' => '2025-07-01',
                'sudah_terima_dari' => 'Fakultas Teknik Universitas Pasundan',
                'uang_sebanyak' => 'DUA RATUS RIBU RUPIAH',
                'uang_sebanyak_angka' => 200000,
                'untuk_pembayaran' => 'Bantuan Pengobatan Dede Suherman anak dari bapak Rohman',
                'status' => 'paid',
                'keterangan' => 'Pembayaran bantuan kesehatan karyawan'
            ],
            [
                'tanggal' => '2025-07-02',
                'sudah_terima_dari' => 'Fakultas Teknik Universitas Pasundan',
                'uang_sebanyak' => 'LIMA RATUS TUJUH PULUH RIBU RUPIAH',
                'uang_sebanyak_angka' => 570000,
                'untuk_pembayaran' => 'Transport Menghadiri Kegiatan Seminar Internasional kerja sama dengan Universitas Islam negri Siber Syekh Nurjati Cirebon " Irwan Kustiawan,S.I.Kom., M.Kom"',
                'status' => 'approved',
                'keterangan' => 'Transport dosen untuk kegiatan seminar'
            ],
            [
                'tanggal' => '2025-07-15',
                'sudah_terima_dari' => 'Fakultas Teknik Universitas Pasundan',
                'uang_sebanyak' => 'SATU JUTA DUA RATUS RIBU RUPIAH',
                'uang_sebanyak_angka' => 1200000,
                'untuk_pembayaran' => 'Transport Perjalanan Dinas Dosen dan Tenaga Kependidikan',
                'status' => 'pending',
                'keterangan' => 'Perjalanan dinas bulan Juli 2025'
            ],
            [
                'tanggal' => '2025-07-10',
                'sudah_terima_dari' => 'Fakultas Teknik Universitas Pasundan',
                'uang_sebanyak' => 'TIGA RATUS RIBU RUPIAH',
                'uang_sebanyak_angka' => 300000,
                'untuk_pembayaran' => 'Bantuan Musibah / pernikahan / Kelahiran dll',
                'status' => 'draft',
                'keterangan' => 'Draft bantuan sosial karyawan'
            ],
            [
                'tanggal' => '2025-07-05',
                'sudah_terima_dari' => 'Fakultas Teknik Universitas Pasundan',
                'uang_sebanyak' => 'SEMBILAN PULUH ENAM RIBU LIMA RATUS RUPIAH',
                'uang_sebanyak_angka' => 96500,
                'untuk_pembayaran' => 'Inc. Kegiatan Pelaksanaan UAS Semester Genap Gunawan Wibowo',
                'status' => 'approved',
                'keterangan' => 'Insentif pelaksanaan UAS'
            ],
            [
                'tanggal' => '2025-07-03',
                'sudah_terima_dari' => 'Fakultas Teknik Universitas Pasundan',
                'uang_sebanyak' => 'DUA PULUH SEMBILAN RIBU RUPIAH',
                'uang_sebanyak_angka' => 29000,
                'untuk_pembayaran' => 'Jasa Surat pengiriman TP BP untuk Keperluan Mulyana',
                'status' => 'paid',
                'keterangan' => 'Biaya pengiriman dokumen'
            ],
            [
                'tanggal' => '2025-07-07',
                'sudah_terima_dari' => 'Fakultas Teknik Universitas Pasundan',
                'uang_sebanyak' => 'SATU RIBU DUA RATUS RUPIAH',
                'uang_sebanyak_angka' => 1200,
                'untuk_pembayaran' => 'Bukti Pengembalan Vakasi Soal, Koreksi Nilai dan Informasi Wibowo',
                'status' => 'rejected',
                'keterangan' => 'Ditolak karena dokumen tidak lengkap'
            ],
            [
                'tanggal' => '2025-07-08',
                'sudah_terima_dari' => 'Fakultas Teknik Universitas Pasundan',
                'uang_sebanyak' => 'ENAM RIBU RUPIAH',
                'uang_sebanyak_angka' => 6000,
                'untuk_pembayaran' => 'Pembayaran untuk pelaksanaan Qurban di Masjid Agra Mulyana',
                'status' => 'paid',
                'keterangan' => 'Kontribusi kegiatan keagamaan'
            ],
            [
                'tanggal' => '2025-07-12',
                'sudah_terima_dari' => 'Fakultas Teknik Universitas Pasundan',
                'uang_sebanyak' => 'EMPAT RATUS LIMA PULUH RIBU RUPIAH',
                'uang_sebanyak_angka' => 450000,
                'untuk_pembayaran' => 'Honor Koreksi UAS Semester Genap 2024/2025',
                'status' => 'approved',
                'keterangan' => 'Honor koreksi ujian akhir semester'
            ],
            [
                'tanggal' => '2025-07-14',
                'sudah_terima_dari' => 'Fakultas Teknik Universitas Pasundan',
                'uang_sebanyak' => 'TUJUH RATUS LIMA PULUH RIBU RUPIAH',
                'uang_sebanyak_angka' => 750000,
                'untuk_pembayaran' => 'Pembelian ATK dan Keperluan Administrasi Fakultas',
                'status' => 'pending',
                'keterangan' => 'Pembelian supplies kantor'
            ]
        ];

        $totalData = count($sampleData);
        $this->command->info("📝 Creating $totalData sample transactions...");

        foreach ($sampleData as $index => $data) {
            // Generate sequential nomor bukti
            $nomorBukti = 'P.2507.' . sprintf('%03d', $index + 1);

            // Get random mata anggaran with preference for leaf nodes
            $mataAnggaran = $this->getRandomMataAnggaran($masterData['mataAnggarans']);

            // Get random master data
            $program = $masterData['programs']->random();
            $sumberDana = $masterData['sumberDanas']->random();

            // Get 4 different signatures
            $signatures = $this->getRandomSignatures($masterData['tandaTangans']);

            $pengeluaran = KeuanganPengeluaran::create([
                'nomor_bukti' => $nomorBukti,
                'tanggal' => $data['tanggal'],
                'sudah_terima_dari' => $data['sudah_terima_dari'],
                'uang_sebanyak' => $data['uang_sebanyak'],
                'uang_sebanyak_angka' => $data['uang_sebanyak_angka'],
                'untuk_pembayaran' => $data['untuk_pembayaran'],
                'mata_anggaran_id' => $mataAnggaran->id,
                'program_id' => $program->id,
                'sumber_dana_id' => $sumberDana->id,
                'tahun_anggaran_id' => $masterData['tahunAnggaran']->id,
                'dekan_id' => $signatures['dekan']->id,
                'wakil_dekan_ii_id' => $signatures['wakil_dekan']->id,
                'ksb_keuangan_id' => $signatures['ksb_keuangan']->id,
                'penerima_id' => $signatures['penerima']->id,
                'status' => $data['status'],
                'keterangan' => $data['keterangan']
            ]);

            $this->command->info("   ✓ Created: {$pengeluaran->nomor_bukti} - {$data['status']} - Rp " . number_format($data['uang_sebanyak_angka']));
        }

        $this->displaySummary($sampleData, $masterData['tahunAnggaran']);
    }

    /**
     * Get random mata anggaran with preference for leaf nodes (sub mata anggaran)
     */
    private function getRandomMataAnggaran($mataAnggarans)
    {
        // Prefer mata anggaran that have parent (sub mata anggaran)
        $subMataAnggarans = $mataAnggarans->whereNotNull('parent_mata_anggaran');

        if ($subMataAnggarans->isNotEmpty()) {
            return $subMataAnggarans->random();
        }

        return $mataAnggarans->random();
    }

    /**
     * Get 4 different random signatures
     */
    private function getRandomSignatures($tandaTangans)
    {
        $shuffled = $tandaTangans->shuffle();

        return [
            'dekan' => $shuffled->get(0),
            'wakil_dekan' => $shuffled->get(1),
            'ksb_keuangan' => $shuffled->get(2),
            'penerima' => $shuffled->get(3)
        ];
    }

    /**
     * Display seeding summary
     */
    private function displaySummary(array $sampleData, $tahunAnggaran): void
    {
        $statusCounts = collect($sampleData)->countBy('status');
        $totalAmount = collect($sampleData)->sum('uang_sebanyak_angka');

        $this->command->info('');
        $this->command->info('📊 SEEDING SUMMARY');
        $this->command->info('==================');
        $this->command->info('Tahun Anggaran: ' . $tahunAnggaran->tahun_anggaran . ' (' . $tahunAnggaran->periode_lengkap . ')');
        $this->command->info('Total Transactions: ' . count($sampleData));
        $this->command->info('Total Amount: Rp ' . number_format($totalAmount));
        $this->command->info('');
        $this->command->info('Status Distribution:');

        foreach ($statusCounts as $status => $count) {
            $emoji = $this->getStatusEmoji($status);
            $this->command->info("   $emoji $status: $count transactions");
        }

        $this->command->info('');
        $this->command->warn('💡 You can now test the pengeluaran module with realistic data!');
    }

    /**
     * Get emoji for status
     */
    private function getStatusEmoji(string $status): string
    {
        return match($status) {
            'draft' => '📝',
            'pending' => '⏳',
            'approved' => '✅',
            'rejected' => '❌',
            'paid' => '💰',
            default => '📄'
        };
    }
}
