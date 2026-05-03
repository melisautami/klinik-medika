<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin - Klinik</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f5f7fb;
        }

        .sidebar {
            height: 100vh;
            background: #4e73df;
            color: white;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 12px;
        }

        .sidebar a:hover {
            background: #2e59d9;
        }

        .card-stat {
            border-radius: 12px;
            color: white;
        }

        .bg-pasien {
            background: #1cc88a;
        }

        .bg-kunjungan {
            background: #36b9cc;
        }

        .bg-petugas {
            background: #f6c23e;
        }

        .bg-pendapatan {
            background: #e74a3b;
        }
    </style>
</head>

<body>

    <div class="container-fluid">
        <div class="row">

            <!-- Sidebar -->
            <div class="col-md-2 sidebar p-3">
                <h4 class="text-center">🏥 Klinik</h4>
                <hr>

                <a href="#">Dashboard</a>
                <a href="#">Data Pasien</a>
                <a href="#">Kunjungan</a>
                <a href="#">Petugas</a>
                <a href="#">Laporan</a>
                <form action="{{ url('/logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn w-100 text-start text-white">
                        Logout
                    </button>
                </form>
            </div>

            <!-- Content -->
            <div class="col-md-10 p-4">

                <h3 class="mb-4">Dashboard Admin</h3>

                <div class="row g-4">

                    <!-- Total Pasien -->
                    <div class="col-md-3">
                        <div class="card card-stat bg-pasien p-3">
                            <h5>Total Pasien</h5>
                            <h2>{{ $totalPasien ?? 0 }}</h2>
                        </div>
                    </div>

                    <!-- Total Kunjungan -->
                    <div class="col-md-3">
                        <div class="card card-stat bg-kunjungan p-3">
                            <h5>Kunjungan Hari Ini</h5>
                            <h2>{{ $kunjunganHariIni ?? 0 }}</h2>
                        </div>
                    </div>

                    <!-- Petugas -->
                    <div class="col-md-3">
                        <div class="card card-stat bg-petugas p-3">
                            <h5>Total Petugas</h5>
                            <h2>{{ $totalPetugas ?? 0 }}</h2>
                        </div>
                    </div>

                    <!-- Pendapatan -->
                    <div class="col-md-3">
                        <div class="card card-stat bg-pendapatan p-3">
                            <h5>Pendapatan</h5>
                            <h2>Rp {{ number_format($pendapatan ?? 0) }}</h2>
                        </div>
                    </div>

                </div>

                <!-- Tabel Kunjungan -->
                <div class="card mt-4">
                    <div class="card-header">
                        <strong>Kunjungan Terbaru</strong>
                    </div>
                    <div class="card-body">

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Pasien</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($kunjungans ?? [] as $k)
                                    <tr>
                                        <td>{{ $k->pasien->user->name ?? '-' }}</td>
                                        <td>{{ $k->tanggal_kunjungan }}</td>
                                        <td>{{ $k->status }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">Tidak ada data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                    </div>
                </div>

            </div>

        </div>
    </div>

</body>

</html>
