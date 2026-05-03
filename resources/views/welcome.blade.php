<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Klinik Medika</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-green-50 font-sans text-black"> <!-- Latar belakang hijau sangat muda -->

    <!-- Navbar Atas (Hitam & Putih) -->
    <header class="bg-black text-white shadow-md">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <div class="text-xl font-bold text-green-400">
                KLINIK <span class="text-white">MEDIKA</span>
            </div>
            <div>
                <span class="mr-4">Halo, {{ Auth::user()->name ?? 'Petugas' }}</span>
                <button class="bg-green-500 hover:bg-green-600 text-black font-semibold py-1 px-4 rounded transition">Logout</button>
            </div>
        </div>
    </header>

    <div class="container mx-auto px-6 py-8 flex gap-6">
        <!-- Sidebar Menu (Sesuai Poin A) -->
        <aside class="w-1/4 bg-white rounded-lg shadow-lg p-5 border-t-4 border-green-400 h-fit">
            <ul class="space-y-3">
                <li>
                    <a href="#" class="block px-4 py-2 bg-green-100 text-black font-semibold rounded hover:bg-green-200 transition">
                        📊 Dashboard (Kunjungan)
                    </a>
                </li>
                <li>
                    <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-green-100 hover:text-black rounded transition">
                        👥 Manajemen Pasien
                    </a>
                </li>
                <li>
                    <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-green-100 hover:text-black rounded transition">
                        ✅ Konfirmasi & Tarif
                    </a>
                </li>
                <li>
                    <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-green-100 hover:text-black rounded transition">
                        📄 Laporan Keuangan
                    </a>
                </li>
            </ul>
        </aside>

        <!-- Konten Utama -->
        <main class="w-3/4">
            @yield('content')
        </main>
    </div>

</body>
</html>