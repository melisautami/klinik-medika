<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Klinik Medika</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-green-50 min-h-screen flex items-center justify-center font-sans text-gray-800 antialiased">
    <div class="w-full max-w-md px-6">
        <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">
            <div class="text-center mb-8">
                <h3 class="text-2xl font-bold text-black">Login Petugas</h3>
                <p class="text-gray-500 mt-2 text-sm">Masuk untuk mengelola sistem klinik</p>
            </div>

            @if ($errors->any())
                <div class="mb-5 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.admin.post') }}" class="space-y-6">
                @csrf

                <div>
                    <label for="login_id" class="block text-sm font-bold text-gray-700 mb-2">Alamat Email</label>
                    <input type="email" id="login_id" name="login_id" value="{{ old('login_id') }}" required
                        class="w-full rounded-xl border-gray-300 border-2 p-3.5 text-sm font-medium focus:border-green-500 focus:ring-0 outline-none transition-colors bg-white placeholder-gray-400"
                        placeholder="admin@klinik.com">
                </div>

                <div>
                    <label for="password" class="block text-sm font-bold text-gray-700 mb-2">Kata Sandi</label>
                    <input type="password" id="password" name="password" required
                        class="w-full rounded-xl border-gray-300 border-2 p-3.5 text-sm font-medium focus:border-green-500 focus:ring-0 outline-none transition-colors bg-white placeholder-gray-400"
                        placeholder="••••••••">
                </div>

                <div class="pt-2">
                    <button type="submit"
                        class="w-full bg-black text-white font-bold rounded-xl py-4 shadow-sm hover:bg-gray-800 hover:-translate-y-0.5 transform transition-all cursor-pointer text-sm tracking-wide">MASUK</button>
                </div>
            </form>

        </div>
    </div>
</body>

</html>
