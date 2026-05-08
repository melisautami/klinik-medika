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
    </style>
</head>

<body>

    <div class="header">
        <h2>KLINIK MEDIKA</h2>
        <p>Laporan Pendapatan & Kunjungan Pasien</p>
        <p>Periode: Bulan {{ $bulan }} Tahun {{ $tahun }}</p>
    </div>

    <div class="summary">
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

</body>

</html>
