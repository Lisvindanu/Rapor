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
            line-height: 1.4;
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

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #000;
            padding-bottom: 15px;
        }

        .header h1 {
            font-size: 18pt;
            font-weight: bold;
            margin: 0 0 5px 0;
            text-transform: uppercase;
        }

        .header h2 {
            font-size: 16pt;
            font-weight: bold;
            margin: 0 0 10px 0;
        }

        .nomor-bukti {
            text-align: right;
            font-size: 11pt;
            margin-bottom: 20px;
        }

        .content-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .content-table td {
            padding: 8px 5px;
            vertical-align: top;
            border: none;
        }

        .content-table .label {
            width: 25%;
            font-weight: bold;
        }

        .content-table .colon {
            width: 5%;
        }

        .content-table .value {
            width: 70%;
        }

        .amount-section {
            border: 1px solid #000;
            padding: 15px;
            margin: 20px 0;
            background-color: #f9f9f9;
        }

        .amount-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 5px;
        }

        .amount-number {
            font-size: 14pt;
            font-weight: bold;
        }

        .amount-words {
            font-style: italic;
            margin-top: 5px;
            border-top: 1px solid #ccc;
            padding-top: 5px;
        }

        .signature-section {
            margin-top: 40px;
            page-break-inside: avoid;
        }

        .signature-table {
            width: 100%;
            border-collapse: collapse;
        }

        .signature-table td {
            width: 25%;
            text-align: center;
            vertical-align: top;
            padding: 10px 5px;
            border: 1px solid #000;
        }

        .signature-title {
            font-weight: bold;
            font-size: 11pt;
            margin-bottom: 50px;
        }

        .signature-name {
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 5px;
        }

        .signature-position {
            font-size: 10pt;
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

        .mata-anggaran-section {
            border: 1px solid #000;
            padding: 10px;
            margin: 15px 0;
        }

        .footer-info {
            margin-top: 30px;
            font-size: 10pt;
            text-align: center;
            color: #666;
        }
    </style>
</head>
<body>
<button onclick="window.print()" class="print-button no-print">
    <i class="fas fa-print"></i> Print
</button>

<div class="bukti-container">
    {{-- Header --}}
    <div class="header">
        <h1>Universitas Pasundan</h1>
        <h2>Bukti Pengeluaran Kas</h2>
    </div>

    {{-- Nomor Bukti --}}
    <div class="nomor-bukti">
        <strong>Nomor: {{ $pengeluaran->nomor_bukti }}</strong>
    </div>

    {{-- Content --}}
    <table class="content-table">
        <tr>
            <td class="label">Tanggal</td>
            <td class="colon">:</td>
            <td class="value">{{ $pengeluaran->tanggal ? $pengeluaran->tanggal->format('d F Y') : '-' }}</td>
        </tr>
        <tr>
            <td class="label">Sudah terima dari</td>
            <td class="colon">:</td>
            <td class="value">{{ $pengeluaran->sudah_terima_dari }}</td>
        </tr>
    </table>

    {{-- Amount Section --}}
    <div class="amount-section">
        <div class="amount-row">
            <span><strong>Uang sebanyak:</strong></span>
            <span class="amount-number">Rp {{ number_format($pengeluaran->uang_sebanyak_angka, 0, ',', '.') }}</span>
        </div>
        <div class="amount-words">
            <strong>Terbilang:</strong> {{ $pengeluaran->uang_sebanyak_huruf }}
        </div>
    </div>

    {{-- Mata Anggaran Section --}}
    <div class="mata-anggaran-section">
        <table class="content-table">
            <tr>
                <td class="label">Mata Anggaran</td>
                <td class="colon">:</td>
                <td class="value">
                    {{ $pengeluaran->mataAnggaran->kode_mata_anggaran ?? '-' }} -
                    {{ $pengeluaran->mataAnggaran->nama_mata_anggaran ?? '-' }}
                </td>
            </tr>
            <tr>
                <td class="label">Program</td>
                <td class="colon">:</td>
                <td class="value">{{ $pengeluaran->program->nama_program ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Sumber Dana</td>
                <td class="colon">:</td>
                <td class="value">{{ $pengeluaran->sumberDana->nama_sumber_dana ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Tahun Anggaran</td>
                <td class="colon">:</td>
                <td class="value">{{ $pengeluaran->tahunAnggaran->tahun ?? '-' }}</td>
            </tr>
        </table>
    </div>

    {{-- Untuk Pembayaran --}}
    @if($pengeluaran->untuk_pembayaran)
        <table class="content-table">
            <tr>
                <td class="label">Untuk pembayaran</td>
                <td class="colon">:</td>
                <td class="value">{{ $pengeluaran->untuk_pembayaran }}</td>
            </tr>
        </table>
    @endif

    {{-- Signature Section --}}
    <div class="signature-section">
        <table class="signature-table">
            <tr>
                <td>
                    <div class="signature-title">Dekan</div>
                    <div class="signature-name">
                        {{ $pengeluaran->dekan->nama ?? '(..................................)' }}
                    </div>
                    <div class="signature-position">
                        {{ $pengeluaran->dekan->jabatan ?? 'Dekan' }}
                    </div>
                </td>
                <td>
                    <div class="signature-title">Wakil Dekan II</div>
                    <div class="signature-name">
                        {{ $pengeluaran->wakilDekanII->nama ?? '(..................................)' }}
                    </div>
                    <div class="signature-position">
                        {{ $pengeluaran->wakilDekanII->jabatan ?? 'Wakil Dekan II' }}
                    </div>
                </td>
                <td>
                    <div class="signature-title">KSB Keuangan</div>
                    <div class="signature-name">
                        {{ $pengeluaran->ksbKeuangan->nama ?? '(..................................)' }}
                    </div>
                    <div class="signature-position">
                        {{ $pengeluaran->ksbKeuangan->jabatan ?? 'KSB Keuangan' }}
                    </div>
                </td>
                <td>
                    <div class="signature-title">Yang Menerima</div>
                    <div class="signature-name">
                        {{ $pengeluaran->penerima->nama ?? '(..................................)' }}
                    </div>
                    <div class="signature-position">
                        {{ $pengeluaran->penerima->jabatan ?? 'Penerima' }}
                    </div>
                </td>
            </tr>
        </table>
    </div>

    {{-- Footer --}}
    <div class="footer-info">
        <small>
            Dicetak pada: {{ now()->format('d F Y H:i:s') }} |
            Status: {{ ucfirst($pengeluaran->status) }}
        </small>
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
