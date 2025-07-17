// Laporan Actions and Form Handling
function quickReport(reportType) {
    document.getElementById('nama_laporan').value = reportType;

    // Auto select current period if available
    const periodeSelect = document.getElementById('kode_periode');
    if (periodeSelect.options.length > 1) {
        periodeSelect.selectedIndex = 1; // Select first real option
    }

    // Show preview if both values are set
    if (periodeSelect.value) {
        showPreview(reportType, periodeSelect.value);
    }
}

function resetForm() {
    document.getElementById('laporanForm').reset();
    document.getElementById('previewCard').style.display = 'none';
}

function initFormValidation() {
    // Form validation before submit
    document.getElementById('laporanForm').addEventListener('submit', function(e) {
        const requiredFields = ['kode_periode', 'nama_laporan', 'programstudi', 'format_export'];
        let isValid = true;

        requiredFields.forEach(function(field) {
            const element = document.getElementById(field);
            if (!element.value) {
                isValid = false;
                element.classList.add('is-invalid');
            } else {
                element.classList.remove('is-invalid');
            }
        });

        if (!isValid) {
            e.preventDefault();
            alert('Mohon lengkapi semua field yang wajib diisi');
        }
    });
}

// Mock data for reports
function getReportData(reportType) {
    const mockData = {
        'jurnal-pengeluaran': {
            items: [
                { kwitansi: 'P.2507.001', tanggal: '01-07-2025', uraian: 'Bantuan Pengobatan Dede Suherman anak dari bapak Rohman', jumlah: '6.4' },
                { kwitansi: 'P.2507.002', tanggal: '01-07-2025', uraian: 'Transport Membantu Pelaksanaan Kegiatan Tata Usaha', jumlah: '6.6' },
                { kwitansi: 'P.2507.003', tanggal: '01-07-2025', uraian: 'Transport Penataan Ruang Keuangan FT Unpas', jumlah: '7.4' },
                { kwitansi: 'P.2507.004', tanggal: '01-07-2025', uraian: 'Pembelian Tinta Printer dan Toner DHMO B dan C', jumlah: '7.1' },
                { kwitansi: 'P.2507.005', tanggal: '01-07-2025', uraian: 'Inc. Kegiatan Pelaksanaan UAS Semester Genap 2024/2025', jumlah: '2.5' }
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
