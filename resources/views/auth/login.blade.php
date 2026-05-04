<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Klinik Medika</title>

    <!-- Pastikan directive Vite ini aktif di proyek Laravel kamu -->
    @vite('resources/css/app.css')
</head>

<body class="bg-green-50 h-screen flex items-center justify-center font-sans text-gray-800 antialiased">

    <div class="w-full max-w-md px-6">
        <!-- Card Login (Formal & Clean) -->
        <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">

            <div class="text-center mb-8">
                <h3 class="text-2xl font-bold text-black">Klinik Medika</h3>
                <p class="text-gray-500 mt-2 text-sm">Silakan masukkan kredensial Anda untuk melanjutkan</p>
            </div>

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <!-- Input Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Alamat Email</label>
                    <input type="email" id="email" name="email"
                        class="w-full rounded-lg border-gray-300 border p-3 text-sm focus:border-green-500 focus:ring-1 focus:ring-green-500 outline-none transition-shadow bg-gray-50 focus:bg-white"
                        required autofocus autocomplete="email" placeholder="nama@klinik.com">
                </div>

                <!-- Input Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Kata Sandi</label>
                    <input type="password" id="password" name="password"
                        class="w-full rounded-lg border-gray-300 border p-3 text-sm focus:border-green-500 focus:ring-1 focus:ring-green-500 outline-none transition-shadow bg-gray-50 focus:bg-white"
                        required placeholder="••••••••">
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between pt-1">
                    <div class="flex items-center">
                        <input id="remember" name="remember" type="checkbox"
                            class="h-4 w-4 text-black focus:ring-black border-gray-300 rounded cursor-pointer">
                        <label for="remember" class="ml-2 block text-sm text-gray-600 cursor-pointer">Ingat saya</label>
                    </div>
                    <div class="text-sm">
                        <a href="#"
                            class="font-medium text-black hover:text-green-600 hover:underline transition-colors">Lupa
                            sandi?</a>
                    </div>
                </div>

                <!-- Tombol Login -->
                <div class="pt-4">
                    <button type="submit"
                        class="w-full bg-black text-white font-semibold rounded-lg py-3 shadow-md hover:bg-gray-800 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-black focus:ring-offset-2 transition-all cursor-pointer">
                        Masuk
                    </button>
                </div>
            </form>

        </div>

        <!-- Footer -->
        <p class="text-center text-xs text-gray-400 mt-6">
            &copy; 2026 Sistem Informasi Klinik Medika. Dilindungi Hak Cipta.
        </p>
    </div>

</body>

</html>
