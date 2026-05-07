<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Klinik Medika</title>

    @vite('resources/css/app.css')
</head>

<body class="bg-green-50 h-screen flex items-center justify-center font-sans text-gray-800 antialiased">

    <div class="w-full max-w-md px-6">

        <!-- Card -->
        <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">

            <!-- Header -->
            <div class="text-center mb-8">

                <h3 class="text-2xl font-bold text-black">
                    Klinik Medika
                </h3>

                <p class="text-gray-500 mt-2 text-sm">
                    Silakan masuk untuk melanjutkan
                </p>
            </div>

            <!-- Error -->
            @if ($errors->any())
                <div class="mb-5 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">

                    {{ $errors->first() }}
                </div>
            @endif

            <!-- Form -->
            <form method="POST" action="{{ route('login') }}" class="space-y-5">

                @csrf

                <!-- Jenis Login -->
                <div>

                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Login Sebagai
                    </label>

                    <select id="login_type"
                        class="w-full rounded-lg border-gray-300 border p-3 text-sm focus:border-green-500 focus:ring-1 focus:ring-green-500 outline-none bg-gray-50 focus:bg-white">

                        <option value="email">
                            Admin / Perawat
                        </option>

                        <option value="nik">
                            Pasien
                        </option>

                    </select>
                </div>

                <!-- Email -->
                <div id="email_field">

                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">

                        Alamat Email
                    </label>

                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                        class="w-full rounded-lg border-gray-300 border p-3 text-sm focus:border-green-500 focus:ring-1 focus:ring-green-500 outline-none transition-shadow bg-gray-50 focus:bg-white"
                        placeholder="nama@klinik.com">

                </div>

                <!-- NIK -->
                <div id="nik_field" class="hidden">

                    <label for="nik" class="block text-sm font-medium text-gray-700 mb-1">

                        Nomor NIK
                    </label>

                    <input type="text" id="nik" name="nik" value="{{ old('nik') }}"
                        class="w-full rounded-lg border-gray-300 border p-3 text-sm focus:border-green-500 focus:ring-1 focus:ring-green-500 outline-none transition-shadow bg-gray-50 focus:bg-white"
                        placeholder="Masukkan NIK pasien">

                </div>

                <!-- Password -->
                <div>

                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">

                        Kata Sandi
                    </label>

                    <input type="password" id="password" name="password"
                        class="w-full rounded-lg border-gray-300 border p-3 text-sm focus:border-green-500 focus:ring-1 focus:ring-green-500 outline-none transition-shadow bg-gray-50 focus:bg-white"
                        required placeholder="••••••••">

                </div>

                <!-- Remember -->
                <div class="flex items-center justify-between pt-1">

                    <div class="flex items-center">

                        <input id="remember" name="remember" type="checkbox"
                            class="h-4 w-4 text-black focus:ring-black border-gray-300 rounded cursor-pointer">

                        <label for="remember" class="ml-2 block text-sm text-gray-600 cursor-pointer">

                            Ingat saya
                        </label>
                    </div>

                    <div class="text-sm">

                        <a href="#"
                            class="font-medium text-black hover:text-green-600 hover:underline transition-colors">

                            Lupa sandi?
                        </a>

                    </div>
                </div>

                <!-- Button -->
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

            &copy; 2026 Sistem Informasi Klinik Medika.
            Dilindungi Hak Cipta.
        </p>
    </div>

    <!-- Script -->
    <script>
        const loginType = document.getElementById('login_type');
        const emailField = document.getElementById('email_field');
        const nikField = document.getElementById('nik_field');

        loginType.addEventListener('change', function() {

            if (this.value === 'nik') {

                emailField.classList.add('hidden');
                nikField.classList.remove('hidden');

            } else {

                emailField.classList.remove('hidden');
                nikField.classList.add('hidden');
            }
        });
    </script>

</body>

</html>
