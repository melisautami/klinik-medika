<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Klinik Medika</title>
    @vite('resources/css/app.css')
</head>

<body>
    <header></header>
    <main>
        <nav>
            @include('layouts.navbar')
        </nav>
        @yield('content')
    </main>
    <footer></footer>

    @stack('scripts')

    @vite('resources/js/app.js')
</body>

</html>
