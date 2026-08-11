<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Login - Klinik Medika</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-green-50 min-h-screen flex items-center justify-center font-sans text-gray-800 antialiased">
    <div class="w-full max-w-5xl px-6 py-8">
        <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
            <div class="px-8 py-8 text-center border-b border-gray-100">
                <h1 class="text-3xl font-black text-gray-900">Klinik Medika</h1>
                <p class="mt-2 text-sm text-gray-500">Pilih akses login sesuai peran Anda</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 p-8">
                <a href="{{ route('login.admin') }}"
                    class="group rounded-2xl border border-gray-200 p-6 text-center shadow-sm hover:shadow-lg hover:border-green-500 transition-all">
                    <div
                        class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-green-100 text-green-700 text-2xl font-bold">
                        A</div>
                    <h2 class="mt-4 text-xl font-bold text-gray-900">Admin</h2>
                    <p class="mt-2 text-sm text-gray-500">Akses manajemen pasien, kunjungan, tarif, dan laporan.</p>
                    <span
                        class="mt-4 inline-flex items-center text-sm font-semibold text-green-600 group-hover:translate-x-1 transition-transform">Masuk
                        sebagai Admin →</span>
                </a>

                <a href="{{ route('login.perawat') }}"
                    class="group rounded-2xl border border-gray-200 p-6 text-center shadow-sm hover:shadow-lg hover:border-green-500 transition-all">
                    <div
                        class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-blue-100 text-blue-700 text-2xl font-bold">
                        P</div>
                    <h2 class="mt-4 text-xl font-bold text-gray-900">Perawat</h2>
                    <p class="mt-2 text-sm text-gray-500">Pantau antrean pasien dan rekam hasil pemeriksaan.</p>
                    <span
                        class="mt-4 inline-flex items-center text-sm font-semibold text-green-600 group-hover:translate-x-1 transition-transform">Masuk
                        sebagai Perawat →</span>
                </a>

                <a href="{{ route('login.pasien') }}"
                    class="group rounded-2xl border border-gray-200 p-6 text-center shadow-sm hover:shadow-lg hover:border-green-500 transition-all">
                    <div
                        class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-purple-100 text-purple-700 text-2xl font-bold">
                        S</div>
                    <h2 class="mt-4 text-xl font-bold text-gray-900">Pasien</h2>
                    <p class="mt-2 text-sm text-gray-500">Lihat informasi kunjungan dan status pemeriksaan Anda.</p>
                    <span
                        class="mt-4 inline-flex items-center text-sm font-semibold text-green-600 group-hover:translate-x-1 transition-transform">Masuk
                        sebagai Pasien →</span>
                </a>
            </div>
        </div>
    </div>
</body>

</html>
