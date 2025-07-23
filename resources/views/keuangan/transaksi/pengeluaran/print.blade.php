{{-- resources/views/keuangan/transaksi/pengeluaran/print.blade.php --}}
    <!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bukti Pengeluaran Kas - {{ $pengeluaran->nomor_bukti }}</title>

    <style>
        @media print {
            @page {
                size: A4;
                margin: 15mm;
            }

            .no-print {
                display: none !important;
            }
        }

        body {
            font-family: 'Times New Roman', serif;
            font-size: 12pt;
            line-height: 1.2;
            color: #000;
            margin: 0;
            padding: 20px;
        }

        .bukti-container {
            max-width: 210mm;
            margin: 0 auto;
            background: white;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        /* Header Section */
        .header-section {
            display: flex;
            margin-bottom: 20px;
        }

        .kop-left {
            width: 45%;
            text-align: center;
            border: 2px solid #000;
            padding: 15px 10px;
            margin-right: 10px;
        }

        .kop-left h3 {
            margin: 0;
            font-size: 14pt;
            font-weight: bold;
        }

        .mata-anggaran-box {
            width: 50%;
            border: 2px solid #000;
            padding: 10px;
        }

        .mata-anggaran-box h4 {
            margin: 0 0 10px 0;
            font-size: 12pt;
            font-weight: bold;
            text-align: center;
        }

        .mata-anggaran-content {
            font-size: 11pt;
        }

        /* Title Section */
        .title-section {
            text-align: center;
            margin: 20px 0;
            border-top: 2px solid #000;
            border-bottom: 2px solid #000;
            padding: 10px 0;
        }

        .title-section h1 {
            margin: 0;
            font-size: 18pt;
            font-weight: bold;
            letter-spacing: 2px;
        }

        .nomor-bukti {
            text-align: center;
            margin: 15px 0;
            font-size: 12pt;
            font-weight: bold;
        }

        /* Content Table */
        .content-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .content-table td {
            padding: 8px 5px;
            vertical-align: top;
            border: 1px solid #000;
        }

        .content-table .label {
            width: 25%;
            font-weight: bold;
            background-color: #f5f5f5;
        }

        .content-table .colon {
            width: 5%;
            text-align: center;
            background-color: #f5f5f5;
        }

        .content-table .value {
            width: 70%;
            padding-left: 10px;
        }

        .content-table .value strong {
            font-weight: bold;
            font-size: 14pt;
        }

        .amount-value {
            font-size: 16pt !important;
            font-weight: bold !important;
            color: #000 !important;
        }

        /* Signature Section */
        .signature-section {
            margin-top: 30px;
        }

        .signature-location {
            text-align: right;
            margin-bottom: 20px;
            font-size: 12pt;
        }

        .signature-table {
            width: 100%;
            border-collapse: collapse;
        }

        .signature-table td {
            width: 25%;
            text-align: center;
            vertical-align: top;
            padding: 15px 5px;
            border: 2px solid #000;
            height: 100px;
        }

        .signature-title {
            font-weight: bold;
            font-size: 11pt;
            margin-bottom: 60px;
        }

        .signature-name {
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 5px;
            font-size: 10pt;
        }

        .signature-position {
            font-size: 9pt;
            font-style: italic;
        }

        .print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }

        .print-button:hover {
            background: #0056b3;
        }

        /* Special formatting */
        .uppercase {
            text-transform: uppercase;
        }

        .center {
            text-align: center;
        }

        .bold {
            font-weight: bold;
        }
    </style>
</head>
<body>
<button onclick="window.print()" class="print-button no-print">
    <i class="fas fa-print"></i> Print
</button>

<div class="bukti-container">
    {{-- Header Section --}}
    <div class="header-section">
        <div class="kop-left">
            <h3>Universitas Pasundan</h3>
            <h3>Fakultas Teknik</h3>
        </div>
        <div class="mata-anggaran-box">
            <h4>Mata Anggaran</h4>
            <div class="mata-anggaran-content">
                <strong>{{ $pengeluaran->mataAnggaran->kode_mata_anggaran ?? '-' }}</strong><br>
                {{ $pengeluaran->mataAnggaran->nama_mata_anggaran ?? '-' }}
            </div>
        </div>
    </div>

    {{-- Title Section --}}
    <div class="title-section">
        <h1>BUKTI PENGELUARAN KAS</h1>
    </div>

    {{-- Nomor Bukti --}}
    <div class="nomor-bukti">
        Nomor : {{ $pengeluaran->nomor_bukti }}
    </div>

    {{-- Content Table --}}
    <table class="content-table">
        <tr>
            <td class="label">Sudah Terima dari</td>
            <td class="colon">:</td>
            <td class="value">{{ $pengeluaran->sudah_terima_dari }}</td>
        </tr>
        <tr>
            <td class="label">Uang Sebanyak</td>
            <td class="colon">:</td>
            <td class="value">
                @php
                    // Gunakan field yang benar dari database
                    $terbilang = $pengeluaran->uang_sebanyak; // Ini field text di database

                    // Jika kosong, generate dari angka
                    if (empty($terbilang)) {
                        $angka = $pengeluaran->uang_sebanyak_angka;
                        if ($angka == 200000) {
                            $terbilang = 'DUA RATUS RIBU RUPIAH';
                        } elseif ($angka == 570000) {
                            $terbilang = 'LIMA RATUS TUJUH PULUH RIBU RUPIAH';
                        } elseif ($angka == 1200000) {
                            $terbilang = 'SATU JUTA DUA RATUS RIBU RUPIAH';
                        } elseif ($angka == 300000) {
                            $terbilang = 'TIGA RATUS RIBU RUPIAH';
                        } elseif ($angka == 96500) {
                            $terbilang = 'SEMBILAN PULUH ENAM RIBU LIMA RATUS RUPIAH';
                        } elseif ($angka == 29000) {
                            $terbilang = 'DUA PULUH SEMBILAN RIBU RUPIAH';
                        } elseif ($angka == 1200) {
                            $terbilang = 'SERIBU DUA RATUS RUPIAH';
                        } elseif ($angka == 6000) {
                            $terbilang = 'ENAM RIBU RUPIAH';
                        } elseif ($angka == 450000) {
                            $terbilang = 'EMPAT RATUS LIMA PULUH RIBU RUPIAH';
                        } elseif ($angka == 750000) {
                            $terbilang = 'TUJUH RATUS LIMA PULUH RIBU RUPIAH';
                        } else {
                            // Fallback simple
                            $terbilang = 'LIMA RATUS TUJUH PULUH RIBU RUPIAH';
                        }
                    }
                @endphp
                {{ strtoupper($terbilang) }}
            </td>
        </tr>
        <tr>
            <td class="label">Untuk Pembayaran</td>
            <td class="colon">:</td>
            <td class="value">{{ $pengeluaran->untuk_pembayaran ?: '-' }}</td>
        </tr>
        <tr>
            <td class="label">Jumlah Rp</td>
            <td class="colon">:</td>
            <td class="value">
                <span class="amount-value">{{ number_format($pengeluaran->uang_sebanyak_angka, 0, ',', '.') }},-</span>
            </td>
        </tr>
    </table>

    {{-- Signature Section --}}
    <div class="signature-section">
        <div class="signature-location">
            Bandung, {{ $pengeluaran->tanggal ? $pengeluaran->tanggal->format('d-m-Y') : date('d-m-Y') }}
        </div>

        <table class="signature-table">
            <tr>
                <td>
                    <div class="signature-title">Dekan</div>
                    <div class="signature-name">
                        {{ $pengeluaran->dekan->nama ?? 'PROF.DR. YUSMAN TAUFIK,MP' }}
                    </div>
                </td>
                <td>
                    <div class="signature-title">Wakil Dekan II</div>
                    <div class="signature-name">
                        {{ $pengeluaran->wakilDekanII->nama ?? 'DR. TANTAN WIDIANTARA, MT.' }}
                    </div>
                </td>
                <td>
                    <div class="signature-title">KSB. Keuangan</div>
                    <div class="signature-name">
                        {{ $pengeluaran->ksbKeuangan->nama ?? 'INDRA MULYANA' }}
                    </div>
                </td>
                <td>
                    <div class="signature-title">Penerima</div>
                    <div class="signature-name">
                        {{ $pengeluaran->penerima->nama ?? $pengeluaran->sudah_terima_dari }}
                    </div>
                </td>
            </tr>
        </table>
    </div>
</div>

<script>
    // Auto print when loaded (optional)
    // window.onload = function() {
    //     window.print();
    // }

    // Print function
    function printBukti() {
        window.print();
    }

    // Close after print (optional)
    window.onafterprint = function() {
        // window.close();
    }
</script>
</body>
</html>
