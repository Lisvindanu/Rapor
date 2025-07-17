<script>
    function generateJurnalPengeluaranHTML(data) {
        return `
            <div style="text-align: center; margin-bottom: 30px;">
                <h4 style="font-weight: bold; margin-bottom: 20px;">JURNAL PENGELUARAN ANGGARAN PROGRAM Reguler Pagi</h4>
            </div>
            <div style="margin-bottom: 15px;">
                <strong>Periode : sampai</strong>
            </div>
            <table class="preview-table">
                <thead>
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th style="width: 15%;">Kwitansi</th>
                        <th style="width: 15%;">Tanggal</th>
                        <th style="width: 50%;">Uraian</th>
                        <th style="width: 15%;">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    ${data.items.map((item, index) => `
                        <tr>
                            <td style="text-align: center;">${index + 1}</td>
                            <td>${item.kwitansi}</td>
                            <td>${item.tanggal}</td>
                            <td>${item.uraian}</td>
                            <td style="text-align: right;">${item.jumlah}</td>
                        </tr>
                    `).join('')}
                </tbody>
            </table>
            <div style="margin-top: 20px; text-align: right;">
                <strong>Jumlah: 345,</strong>
                <br><small style="font-size: 10px;">M.A.</small>
            </div>
            <div class="alert alert-info mt-3">
                <i class="fas fa-info-circle"></i>
                <strong>Preview Mode:</strong> Data contoh hasil mock sesuai aplikasi yang ada
            </div>
        `;
    }

    function generateJurnalPerMataAnggaranHTML(data) {
        return `
            <div style="text-align: center; margin-bottom: 30px;">
                <h4 style="font-weight: bold; margin-bottom: 20px;">JURNAL PENGELUARAN ANGGARAN PROGRAM Reguler Pagi</h4>
            </div>
            <div style="margin-bottom: 15px;">
                <strong>Periode : sampai</strong>
            </div>
            <div style="margin-bottom: 15px;">
                <strong>Mata Anggaran: 1.2(Pendanaan Kegiatan Implementasi Visi dan Misi)</strong>
                <span style="float: right;"><strong>Jumlah : 4,503,250</strong></span>
            </div>
            <table class="preview-table">
                <thead>
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th style="width: 15%;">Kwitansi</th>
                        <th style="width: 15%;">Tanggal</th>
                        <th style="width: 50%;">Uraian</th>
                        <th style="width: 15%;">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    ${data.mataAnggaranItems.map((item, index) => `
                        <tr>
                            <td style="text-align: center;">${index + 1}</td>
                            <td>${item.kwitansi}</td>
                            <td>${item.tanggal}</td>
                            <td>${item.uraian}</td>
                            <td style="text-align: right;">${item.jumlah}</td>
                        </tr>
                    `).join('')}
                </tbody>
            </table>
            <div class="alert alert-info mt-3">
                <i class="fas fa-info-circle"></i>
                <strong>Preview Mode:</strong> Data ini adalah contoh tampilan laporan per mata anggaran.
            </div>
        `;
    }

    function generatePembayaranTugasAkhirHTML(data) {
        return `
            <div style="text-align: center; margin-bottom: 30px;">
                <h4 style="font-weight: bold;">LAPORAN PEMBAYARAN TUGAS AKHIR</h4>
            </div>
            <div style="margin-bottom: 15px;">
                <strong>Tanggal : 12-10-2023</strong>
                <span style="float: right;"><strong>Jumlah : 1,200,000</strong></span>
            </div>
            <table class="preview-table">
                <thead>
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th style="width: 15%;">NPM</th>
                        <th style="width: 30%;">Nama Mahasiswa</th>
                        <th style="width: 25%;">Program Studi</th>
                        <th style="width: 10%;">Periode</th>
                        <th style="width: 15%;">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    ${data.mahasiswa.map((item, index) => `
                        <tr>
                            <td style="text-align: center;">${index + 1}</td>
                            <td>${item.npm}</td>
                            <td>${item.nama}</td>
                            <td>${item.prodi}</td>
                            <td style="text-align: center;">${item.periode}</td>
                            <td style="text-align: right;">${item.jumlah}</td>
                        </tr>
                    `).join('')}
                </tbody>
            </table>
            <div style="margin-top: 40px;">
                <table style="width: 100%; font-size: 12px;">
                    <tr>
                        <td style="width: 33%; text-align: center; padding: 20px;">
                            <div style="border-top: 1px solid #000; padding-top: 5px; margin-top: 60px;">
                                <strong>Mengetahui</strong>
                            </div>
                        </td>
                        <td style="width: 33%; text-align: center; padding: 20px;">
                            <div style="border-top: 1px solid #000; padding-top: 5px; margin-top: 60px;">
                                <strong>Menyetujui</strong>
                            </div>
                        </td>
                        <td style="width: 33%; text-align: center; padding: 20px;">
                            <div>
                                <strong>Bandung, 15-07-2025</strong><br>
                                <div style="border-top: 1px solid #000; padding-top: 5px; margin-top: 60px;">
                                    <strong>Dilaporkan Oleh</strong>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="alert alert-info mt-3">
                <i class="fas fa-info-circle"></i>
                <strong>Preview Mode:</strong> Format laporan pembayaran tugas akhir dengan tanda tangan.
            </div>
        `;
    }

    function generateDefaultPreview() {
        return `
            <div class="text-center text-muted">
                <i class="fas fa-file-alt" style="font-size: 2rem; margin-bottom: 10px;"></i>
                <p>Preview untuk jenis laporan ini sedang dalam pengembangan.</p>
                <p>Format akan disesuaikan dengan kebutuhan masing-masing laporan.</p>
            </div>
        `;
    }
</script>
