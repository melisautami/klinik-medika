<nav class="bg-white border-b border-gray-200 shadow-sm sticky top-0 z-50">
    <div class="max-w-none mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between min-h-16">

            <div class="flex flex-1 overflow-hidden">
                <div class="flex-shrink-0 flex items-center">
                    <span class="text-xl font-black tracking-tight text-black">
                        🏥 Klinik <span class="text-green-600">Medika</span>
                    </span>
                </div>

                <div class="hidden sm:ml-3 sm:flex sm:flex-1 sm:flex-wrap sm:items-center sm:gap-x-3 lg:gap-x-4 min-w-0">

                    @if (auth()->user()->role == 'admin')
                        <a href="{{ route('admin.dashboard') }}"
                            class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-semibold whitespace-nowrap transition-colors {{ request()->routeIs('admin.dashboard') ? 'border-green-500 text-green-700' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-800' }}">
                            Dashboard
                        </a>

                        <a href="{{ route('admin.perawat.index') }}"
                            class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-semibold whitespace-nowrap transition-colors {{ request()->routeIs('admin.perawat.*') ? 'border-green-500 text-green-700' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-800' }}">
                            Perawat
                        </a>

                        <a href="{{ route('admin.pasien.index') }}"
                            class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-semibold whitespace-nowrap transition-colors {{ request()->routeIs('admin.pasien.*') ? 'border-green-500 text-green-700' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-800' }}">
                            Pasien
                        </a>

                        <a href="{{ route('admin.tarif.index') }}"
                            class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-semibold whitespace-nowrap transition-colors {{ request()->routeIs('admin.tarif.*') ? 'border-green-500 text-green-700' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-800' }}">
                            Katalog Tarif
                        </a>

                        <a href="{{ route('admin.kunjungan.index') }}"
                            class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-semibold whitespace-nowrap transition-colors {{ request()->routeIs('admin.kunjungan.*') ? 'border-green-500 text-green-700' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-800' }}">
                            Antrean Kunjungan
                        </a>

                        <a href="{{ route('admin.pembayaran.index') }}"
                            class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-semibold whitespace-nowrap transition-colors {{ request()->routeIs('admin.pembayaran.*') ? 'border-green-500 text-green-700' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-800' }}">
                            Konfirmasi Tagihan
                        </a>

                        <a href="{{ route('admin.pendaftaran.index') }}"
                            class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-semibold whitespace-nowrap transition-colors {{ request()->routeIs('admin.pendaftaran.*') ? 'border-green-500 text-green-700' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-800' }}">
                            Pendaftaran Online
                        </a>

                        <a href="{{ route('admin.laporan.index') }}"
                            class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-semibold whitespace-nowrap transition-colors {{ request()->routeIs('admin.laporan.*') ? 'border-green-500 text-green-700' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-800' }}">
                            Laporan
                        </a>
                    @endif

                    @if (auth()->user()->role == 'perawat')
                        <a href="{{ route('perawat.dashboard') }}"
                            class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-semibold whitespace-nowrap transition-colors {{ request()->routeIs('perawat.dashboard') ? 'border-green-500 text-green-700' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-800' }}">
                            Dashboard
                        </a>
                        <a href="{{ route('perawat.kunjungan') }}"
                            class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-semibold whitespace-nowrap transition-colors {{ request()->routeIs('perawat.kunjungan.*') ? 'border-green-500 text-green-700' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-800' }}">
                            Pemeriksaan Aktif
                        </a>
                        {{-- <a href="{{ route('perawat.riwayat') }}"
                            class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-semibold whitespace-nowrap transition-colors {{ request()->routeIs('perawat.riwayat') ? 'border-green-500 text-green-700' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-800' }}">
                            Riwayat Medis
                        </a> --}}
                    @endif

                </div>
            </div>

            <div class="hidden sm:ml-6 sm:flex sm:items-center flex-shrink-0">
                @if (auth()->user()->role == 'admin')
                    <span class="text-sm font-medium text-gray-700 mr-4">
                        Petugas
                    </span>
                @else
                    <span class="text-sm font-medium text-gray-700 mr-4">
                        {{ auth()->user()->name ?? 'Pengguna' }}
                    </span>
                @endif
                <form method="POST" action="{{ route('logout') }}" class="m-0">
                    @csrf
                    <button type="submit"
                        class="bg-black text-white text-sm font-semibold px-5 py-2.5 rounded-lg hover:bg-gray-800 transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900">
                        Keluar
                    </button>
                </form>
            </div>

            <div class="-mr-2 flex items-center sm:hidden flex-shrink-0">
                <button type="button" id="mobile-menu-button"
                    class="bg-gray-50 inline-flex items-center justify-center p-2 rounded-md text-gray-500 hover:text-green-600 hover:bg-green-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors"
                    aria-controls="mobile-menu" aria-expanded="false">
                    <span class="sr-only">Buka menu utama</span>
                    <svg class="block h-6 w-6" id="icon-menu" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg class="hidden h-6 w-6" id="icon-close" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div class="hidden sm:hidden border-t border-gray-200" id="mobile-menu">
        <div class="pt-2 pb-3 space-y-1">
            @if (auth()->user()->role == 'admin')
                <a href="{{ route('admin.dashboard') }}"
                    class="block pl-3 pr-4 py-2 border-l-4 text-base font-medium {{ request()->routeIs('admin.dashboard') ? 'bg-green-50 border-green-500 text-green-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }}">Dashboard</a>

                <a href="{{ route('admin.perawat.index') }}"
                    class="block pl-3 pr-4 py-2 border-l-4 text-base font-medium {{ request()->routeIs('admin.perawat.*') ? 'bg-green-50 border-green-500 text-green-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }}">Perawat</a>

                <a href="{{ route('admin.pasien.index') }}"
                    class="block pl-3 pr-4 py-2 border-l-4 text-base font-medium {{ request()->routeIs('admin.pasien.*') ? 'bg-green-50 border-green-500 text-green-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }}">Pasien</a>

                {{-- <a href="{{ route('admin.tarif.index') }}"
                    class="block pl-3 pr-4 py-2 border-l-4 text-base font-medium {{ request()->routeIs('admin.tarif.*') ? 'bg-green-50 border-green-500 text-green-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }}">Katalog
                    Tarif</a> --}}

                <a href="{{ route('admin.kunjungan.index') }}"
                    class="block pl-3 pr-4 py-2 border-l-4 text-base font-medium {{ request()->routeIs('admin.kunjungan.*') ? 'bg-green-50 border-green-500 text-green-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }}">Antrean
                    Kunjungan</a>

                <a href="{{ route('admin.pembayaran.index') }}"
                    class="block pl-3 pr-4 py-2 border-l-4 text-base font-medium {{ request()->routeIs('admin.pembayaran.*') ? 'bg-green-50 border-green-500 text-green-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }}">Konfirmasi
                    Tagihan</a>

                <a href="{{ route('admin.pendaftaran.index') }}"
                    class="block pl-3 pr-4 py-2 border-l-4 text-base font-medium {{ request()->routeIs('admin.pendaftaran.*') ? 'bg-green-50 border-green-500 text-green-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }}">Pendaftaran
                    Online</a>

                <a href="{{ route('admin.laporan.index') }}"
                    class="block pl-3 pr-4 py-2 border-l-4 text-base font-medium {{ request()->routeIs('admin.laporan.*') ? 'bg-green-50 border-green-500 text-green-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }}">Laporan</a>
            @endif

            @if (auth()->user()->role == 'perawat')
                <a href="{{ route('perawat.dashboard') }}"
                    class="block pl-3 pr-4 py-2 border-l-4 text-base font-medium {{ request()->routeIs('perawat.dashboard') ? 'bg-green-50 border-green-500 text-green-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }}">Dashboard</a>
                <a href="{{ route('perawat.kunjungan') }}"
                    class="block pl-3 pr-4 py-2 border-l-4 text-base font-medium {{ request()->routeIs('perawat.kunjungan.*') ? 'bg-green-50 border-green-500 text-green-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }}">Pemeriksaan
                    Aktif</a>
                <a href="{{ route('perawat.riwayat') }}"
                    class="block pl-3 pr-4 py-2 border-l-4 text-base font-medium {{ request()->routeIs('perawat.riwayat') ? 'bg-green-50 border-green-500 text-green-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }}">Riwayat
                    Medis</a>
            @endif
        </div>

        <div class="pt-4 pb-4 border-t border-gray-200 bg-gray-50">
            <div class="flex items-center px-4">
                <div class="flex-shrink-0">
                    <div
                        class="h-10 w-10 rounded-full bg-green-200 flex items-center justify-center text-green-800 font-black text-lg shadow-sm">
                        {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                    </div>
                </div>
                <div class="ml-3">
                    <div class="text-base font-bold text-gray-800">{{ auth()->user()->name ?? 'Pengguna' }}</div>
                    <div class="text-sm font-medium text-gray-500">{{ auth()->user()->email ?? '-' }}</div>
                </div>
            </div>
            <div class="mt-4 space-y-1 px-2">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="block w-full text-center px-4 py-2.5 text-base font-bold text-white bg-black hover:bg-gray-800 rounded-lg shadow-sm transition-colors">
                        Keluar dari Sistem
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const btn = document.getElementById('mobile-menu-button');
        const menu = document.getElementById('mobile-menu');
        const iconMenu = document.getElementById('icon-menu');
        const iconClose = document.getElementById('icon-close');

        btn.addEventListener('click', () => {
            menu.classList.toggle('hidden');
            iconMenu.classList.toggle('hidden');
            iconClose.classList.toggle('hidden');

            const isExpanded = btn.getAttribute('aria-expanded') === 'true';
            btn.setAttribute('aria-expanded', !isExpanded);
        });
    });
</script>
