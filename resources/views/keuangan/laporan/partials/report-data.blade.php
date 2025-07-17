<script>
    // Mock data for reports
    function getReportData(reportType) {
        const mockData = {
            'jurnal-pengeluaran': {
                items: [
                    { kwitansi: 'P.2507.001', tanggal: '01-07-2025', uraian: 'Bantuan Pengobatan Dede Suherman anak dari bapak Rohman', jumlah: '6.4' },
                    { kwitansi: 'P.2507.002', tanggal: '01-07-2025', uraian: 'Transport Membantu Pelaksanaan Kegiatan Tata Usaha', jumlah: '6.6' },
                    { kwitansi: 'P.2507.003', tanggal: '01-07-2025', uraian: 'Transport Penataan Ruang Keuangan FT Unpas', jumlah: '7.4' },
                    { kwitansi: 'P.2507.004', tanggal: '01-07-2025', uraian: 'Pembelian Tinta Printer dan Toner DHMO B dan C', jumlah: '7.1' },
                    { kwitansi: 'P.2507.005', tanggal: '01-07-2025', uraian: 'Inc. Kegiatan Pelaksanaan UAS Semester Genap 2024/2025', jumlah: '2.5' },
                    { kwitansi: 'P.2507.006', tanggal: '01-07-2025', uraian: 'Jasa Sewa Perangkat Jaringan 17 AP untuk Kegiatan Pelaksanaan UAS Genap 24/25', jumlah: '2.5' },
                    { kwitansi: 'P.2507.007', tanggal: '01-07-2025', uraian: 'Bukti Pengambilan Vakasi Soal, Koreksi Nilai dan Insentif UAS semester Genap 2024-2025 Jur.TI,TP,MS,IF,TL dan PL', jumlah: '2.5' },
                    { kwitansi: 'P.2507.008', tanggal: '01-07-2025', uraian: 'Pembayaran untuk pelaksanaan Qurban di Majalengka', jumlah: '1.3' },
                    { kwitansi: 'P.2507.009', tanggal: '02-07-2025', uraian: 'Bantuan Khitanan Anak dari Bpk Agus Suherman Karyawan Unpas', jumlah: '6.4' },
                    { kwitansi: 'P.2507.010', tanggal: '02-07-2025', uraian: 'Bukti Pengambilan Vakasi Soal, Koreksi Nilai dan Insentif UAS semester Genap 2024-2025 Jur.TI,TP,MS,IF,TL dan PL', jumlah: '2.5' },
                    { kwitansi: 'P.2507.011', tanggal: '02-07-2025', uraian: 'Bantuan Program Kepakaran Kegiatan Publikasi Daftar Nama Terlanggir)', jumlah: '2.4' }
                ]
            },
            'jurnal-per-mata-anggaran': {
                mataAnggaranItems: [
                    { kwitansi: 'P.2507.030', tanggal: '04-07-2025', uraian: 'Transport Kegiatan Festival Harmoni IIKU Unpas sabtu, 14 Juni 2025', jumlah: '3,300,000' },
                    { kwitansi: 'P.2507.037', tanggal: '07-07-2025', uraian: 'Dana operasional DKM bulan Juli 2025', jumlah: '500,000' },
                    { kwitansi: 'P.2507.056', tanggal: '10-07-2025', uraian: 'Percetakan Buku Renstra Teknik 2024-2025', jumlah: '603,250' },
                    { kwitansi: 'P.2507.071', tanggal: '14-07-2025', uraian: 'Inc. Pelaksanaan Visi dan Misi Bulan Juli 2025', jumlah: '100,000' }
                ]
            },
            'pembayaran-tugas-akhir': {
                mahasiswa: [
                    { npm: '223040038', nama: 'Lisvindanu', prodi: 'Teknik Informatika', periode: '20201', jumlah: '300,000' },
                    { npm: '223040038', nama: 'Lisvindanu', prodi: 'Teknik Informatika', periode: '20202', jumlah: '300,000' },
                    { npm: '223040038', nama: 'Lisvindanu', prodi: 'Teknik Informatika', periode: '20211', jumlah: '300,000' },
                    { npm: '223040038', nama: 'Lisvindanu', prodi: 'Teknik Informatika', periode: '20212', jumlah: '300,000' }
                ]
            }
        };

        return mockData[reportType] || { items: [] };
    }
</script>
