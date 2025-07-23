{{-- resources/views/keuangan/transaksi/pengeluaran/pdf.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bukti Pengeluaran Kas - {{ $pengeluaran->nomor_bukti }}</title>

    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11pt;
            line-height: 1.4;
            color: #000;
            margin: 0;
            padding: 15px;
        }

        .bukti-container {
            width: 100%;
            margin: 0;
            background: white;
        }

        .header {
            text-align: center;
            margin-bottom: 25px;
            border-bottom: 2px solid #000;
            padding-bottom: 12px;
        }

        .header h1 {
            font-size: 16pt;
            font-weight: bold;
            margin: 0 0 5px 0;
            text-transform: uppercase;
        }

        .header h2 {
            font-size: 14pt;
            font-weight: bold;
            margin: 0 0 8px 0;
        }

        .nomor-bukti {
            text-align: right;
            font-size: 10pt;
            margin-bottom: 18px;
            font-weight: bold;
        }

        .content-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .content-table td {
            padding: 6px 4px;
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
            padding: 12px;
            margin: 15px 0;
            background-color: #f5f5f5;
        }

        .amount-row {
            margin-bottom: 4px;
        }

        .amount-number {
            font-size: 12pt;
            font-weight: bold;
            float: right;
        }

        .amount-words {
            font-style: italic;
            margin-top: 8px;
            border-top: 1px solid #999;
            padding-top: 8px;
            clear: both;
        }

        .signature-section {
            margin-top: 30px;
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
            padding: 8px 4px;
            border: 1px solid #000;
            height: 80px;
        }

        .signature-title {
            font-weight: bold;
            font-size: 10pt;
            margin-bottom: 35px;
        }

        .signature-name {
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 3px;
            font-size: 9pt;
        }

        .signature-position {
            font-size: 8pt;
            font-style: italic;
        }

        .mata-anggaran-section {
            border: 1px solid #000;
            padding: 8px;
            margin: 12px 0;
        }

        .footer-info {
            margin-top: 25px;
            font-size: 8pt;
            text-align: center;
            color: #666;
            border-top: 1px solid #ccc;
            padding-top: 8px;
        }

        /* Khusus untuk PDF - pastikan tidak ada float issues */
        .clearfix::after {
            content: "";
            display: table;
            clear: both;
        }

        /* Responsive untuk PDF */
        @media print {
            body {
                margin: 0;
                padding: 10px;
            }
        }
    </style>
</head>
<body>
<div class="bukti-container">
    {{-- Header --}}
    <div class="header">
        <h1>Universitas Pasundan</h1>
        <h2>Bukti Pengeluaran Kas</h2>
    </div>

    {{-- Nomor Bukti --}}
    <div class="nomor-bukti">
        Nomor: {{ $pengeluaran->nomor_bukti }}
    </div>

    {{-- Main Content --}}
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
    <div class="amount-section clearfix">
        <div class="amount-row">
            <strong>Uang sebanyak:</strong>
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
        Dicetak pada: {{ now()->format('d F Y H:i:s') }} |
        Status: {{ ucfirst($pengeluaran->status) }} |
        Sistem Keuangan UNIVERSITAS PASUNDAN
    </div>
</div>
</body>
</html>
