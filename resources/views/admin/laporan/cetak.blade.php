<!DOCTYPE html>
<html>

<head>
    <title>Laporan Klinik</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .table th {
            background-color: #f2f2f2;
        }

        .summary {
            margin-top: 20px;
        }

        /* Perbaikan: Blok kontainer digeser ke kanan menggunakan float atau margin-left: auto */
        .signature-container {
            float: right;
            width: 250px;
            margin-top: 40px;
            text-align: center;
            /* Membuat semua teks di dalamnya otomatis sejajar tengah */
            page-break-inside: avoid;
        }

        .signature-date {
            font-size: 12px;
            margin-bottom: 4px;
        }

        .signature-title {
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Tempat tanda tangan fisik / space kosong */
        .signature-space {
            height: 70px;
        }

        /* Nama terang diberikan garis bawah (underline) sesuai standar surat resmi di gambar */
        .signature-name {
            font-size: 13px;
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 4px;
        }

        .signature-nip {
            font-size: 12px;
        }

        /* Clearfix untuk mengamankan layout setelah menggunakan float */
        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }
    </style>
</head>

<body>

    <div class="header">
        <h2>KLINIK MEDIKA</h2>
        <p>Laporan Pendapatan & Kunjungan Pasien</p>
        <p>Periode: Bulan {{ $bulan }} Tahun {{ $tahun }}</p>
    </div>

    <div class="summary">
        <p><strong>Total Rawat Jalan:</strong> {{ $rawatJalan }} Pasien</p>
        <p><strong>Total Rawat Inap:</strong> {{ $rawatInap }} Pasien</p>
        <p><strong>Total Kunjungan:</strong> {{ $totalKunjungan }} Pasien</p>
        <p><strong>Total Pendapatan:</strong> Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Nama Pasien</th>
                <th>Tipe Kunjungan</th>
                <th>Nominal Pembayaran</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($laporans as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_kunjungan)->format('d/m/Y') }}</td>
                    <td>{{ $item->pasien->pengguna->name ?? '-' }}</td>
                    <td>{{ str_replace('_', ' ', $item->tipe) }}</td>
                    <td>Rp {{ number_format($item->pembayaran->total_bayar ?? 0, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pembungkus blok TTD menggunakan clearfix agar tata letak halaman di bawahnya tidak rusak -->
    <div class="clearfix">
        <div class="signature-container">
            <div class="signature-date">
                Lampung, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
            </div>

            <div class="signature-title">
                Bendahara Klinik Medika,
            </div>

            <!-- Space kosong untuk tempat tanda tangan tangan -->
            <div class="signature-space"></div>

            <div class="signature-name">
                Susilowati Ningsih, A.Md.Fam
            </div>

            <div class="signature-nip">
                SIP:503.440/035/SIP-TTK/429.111/2024
            </div>
        </div>
    </div>

</body>

</html>
