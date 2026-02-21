<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Sekolah</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
</head>

<body class="bg-[#f3f4f6] font-['Plus Jakarta Sans',sans-serif]">

    <div class="flex h-screen overflow-hidden">

        <aside id="sidebar"
            class="hidden md:flex md:flex-col md:w-64 bg-[#37517e] text-white opacity-0 -translate-x-full">

            <div class="flex items-center justify-center h-18 py-5 border-b border-white/10 bg-[#2a3f63] shrink-0">
                <div class="flex items-center justify-center bg-white p-1 rounded-xl shadow-sm">
                    <img src="/images/logosmk.png" alt="Logo SMK" class="h-7 w-auto">
                </div>

                <span class="ml-3 text-lg font-bold tracking-wide text-white">BUKUSISWA</span>
            </div>

            <div class="flex flex-col flex-1 justify-between overflow-y-auto">

                <nav class="mt-5 px-4 space-y-2">
                    <a href="/dashboard"
                        class="flex items-center px-4 py-3 rounded-lg transition-colors
                        {{ Route::is('dashboard') ? 'bg-white/90 text-[#37517e]' : 'text-gray-300 hover:bg-white/10 hover:text-white' }}">
                        <i data-lucide="house"
                            class="w-5 h-5 mr-3 {{ Route::is('dashboard') ? 'fill-[#37517e]/20 stroke-[#37517e]' : '' }}"
                            @if (Route::is('dashboard')) stroke-width="3" @endif>
                        </i>
                        <span class="{{ Route::is('dashboard') ? 'font-bold' : 'font-medium' }}">Dashboard</span>
                    </a>
                    @if (auth()->user() && auth()->user()->usertype === 'admin')
                        <a href="/siswa"
                            class="flex items-center px-4 py-3 rounded-lg transition-colors
                        {{ Route::is('siswa') ? 'bg-white/90 text-[#37517e]' : 'text-gray-300 hover:bg-white/10 hover:text-white' }}">
                            <i data-lucide="users"
                                class="w-5 h-5 mr-3 {{ Route::is('siswa') ? 'fill-[#37517e]/20 stroke-[#37517e]' : '' }}"
                                @if (Route::is('siswa')) stroke-width="3" @endif>
                            </i>
                            <span class="{{ Route::is('siswa') ? 'font-bold' : 'font-medium' }}">Data Siswa</span>
                        </a>
                        <a href="/kelas"
                            class="flex items-center px-4 py-3 rounded-lg transition-colors
                        {{ Route::is('kelas') ? 'bg-white/90 text-[#37517e]' : 'text-gray-300 hover:bg-white/10 hover:text-white' }}">
                            <i data-lucide="building"
                                class="w-5 h-5 mr-3 {{ Route::is('kelas') ? 'fill-[#37517e]/20 stroke-[#37517e]' : '' }}"
                                @if (Route::is('kelas')) stroke-width="3" @endif>
                            </i>
                            <span class="{{ Route::is('kelas') ? 'font-bold' : 'font-medium' }}">Data Kelas</span>
                        </a>

                        <a href="/guru"
                            class="flex items-center px-4 py-3 rounded-lg transition-colors
                        {{ Route::is('guru') ? 'bg-white/90 text-[#37517e]' : 'text-gray-300 hover:bg-white/10 hover:text-white' }}">
                            <i data-lucide="graduation-cap"
                                class="w-5 h-5 mr-3 {{ Route::is('guru') ? 'fill-[#37517e]/20 stroke-[#37517e]' : '' }}"
                                @if (Route::is('guru')) stroke-width="3" @endif>
                            </i>
                            <span class="{{ Route::is('guru') ? 'font-bold' : 'font-medium' }}">Data Guru</span>
                        </a>
                        <a href="/plot-walas"
                            class="flex items-center px-4 py-3 rounded-lg transition-colors
                        {{ Route::is('plot-walas') ? 'bg-white/90 text-[#37517e]' : 'text-gray-300 hover:bg-white/10 hover:text-white' }}">
                            <i data-lucide="user-cog"
                                class="w-5 h-5 mr-3 {{ Route::is('plot-walas') ? 'fill-[#37517e]/20 stroke-[#37517e]' : '' }}"
                                @if (Route::is('plot-walas')) stroke-width="3" @endif>
                            </i>
                            <span class="{{ Route::is('plot-walas') ? 'font-bold' : 'font-medium' }}">Data Walas</span>
                        </a>

                        <a href="/user"
                            class="flex items-center px-4 py-3 rounded-lg transition-colors
                        {{ Route::is('user') ? 'bg-white/90 text-[#37517e]' : 'text-gray-300 hover:bg-white/10 hover:text-white' }}">
                            <i data-lucide="book-user"
                                class="w-5 h-5 mr-3 {{ Route::is('user') ? 'fill-[#37517e]/20 stroke-[#37517e]' : '' }}"
                                @if (Route::is('user')) stroke-width="3" @endif>
                            </i>
                            <span class="{{ Route::is('user') ? 'font-bold' : 'font-medium' }}">Data User</span>
                        </a>
                    @endif
                    <a href="/pelanggaran"
                        class="flex items-center px-4 py-3 rounded-lg transition-colors
                        {{ Route::is('pelanggaran') ? 'bg-white/90 text-[#37517e]' : 'text-gray-300 hover:bg-white/10 hover:text-white' }}">
                        <i data-lucide="shield-off"
                            class="w-5 h-5 mr-3 {{ Route::is('pelanggaran') ? 'fill-[#37517e]/20 stroke-[#37517e]' : '' }}"
                            @if (Route::is('pelanggaran')) stroke-width="3" @endif>
                        </i>
                        <span class="{{ Route::is('pelanggaran') ? 'font-bold' : 'font-medium' }}">Pelanggaran</span>
                    </a>
                </nav>
            </div>
        </aside>

        <div class="flex-1 flex flex-col overflow-hidden relative">

            <header id="topbar"
                class="flex items-center justify-between px-6 py-4 bg-white border-b border-gray-200 shrink-0 opacity-0 -translate-y-full">
                <div class="flex items-center">
                    <h2 class="text-xl font-bold text-[#37517e]">
                        {{ $header ?? 'Dashboard' }}
                    </h2>
                </div>

                <div class="flex items-center space-x-4">
                    <a href="/profile" class=" transition-opacity">
                        <div class="flex items-center space-x-2">
                            <div class="text-right hidden md:block">
                                <p class="text-sm font-bold text-gray-700">{{ Auth::user()->namalengkap ?? 'User' }}
                                </p>
                                <p class="text-xs text-gray-500 capitalize">{{ Auth::user()->usertype ?? 'Guest' }}</p>
                            </div>
                            <div class="relative">
                                @if (Auth::user()->foto)
                                    <img src="{{ asset('storage/' . Auth::user()->foto) }}" alt="Avatar"
                                        class="w-10 h-10 rounded-full object-cover border-2 border-[#37517e] shadow-sm">
                                @else
                                    <div
                                        class="w-10 h-10 rounded-full bg-[#37517e] flex items-center justify-center text-white font-bold shadow-sm">
                                        {{ substr(Auth::user()->namalengkap ?? 'U', 0, 1) }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </a>
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-[#f3f4f6] p-6 pb-32 md:pb-6">
                {{ $slot }}
            </main>
        </div>
    </div>

    <nav id="footbar" x-data="{ open: false }"
        class="md:hidden fixed bottom-6 left-4 right-4 z-50 bg-white/95 backdrop-blur-xl border border-white/20 rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.12)] transition-all duration-300 ease-in-out flex flex-col justify-end overflow-hidden"
        :class="open ? 'h-auto max-h-[80vh]' : 'h-[70px]'">

        <div x-show="open" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-4"
            class="w-full px-4 pt-4 pb-2 border-b border-gray-100/50 overflow-y-auto no-scrollbar">

            <p class="text-xs font-bold text-gray-400 mb-3 uppercase tracking-wider">Menu Administrator</p>

            <div class="grid grid-cols-3 gap-3">

                {{-- MENU SISWA --}}
                <a href="/siswa"
                    class="flex flex-col items-center gap-2 p-3 rounded-xl active:scale-95 transition-all border
        {{ Request::is('siswa*')
            ? 'bg-blue-50 border-[#37517e]/30 shadow-sm'
            : 'bg-gray-50 border-transparent hover:bg-gray-100' }}">

                    <div
                        class="p-2 rounded-full transition-colors
            {{ Request::is('siswa*') ? 'bg-[#37517e] text-white' : 'bg-blue-100 text-[#37517e]' }}">
                        <i data-lucide="users" class="w-5 h-5"></i>
                    </div>

                    <span
                        class="text-[10px] transition-colors
            {{ Request::is('siswa*') ? 'font-bold text-[#37517e]' : 'font-semibold text-gray-600' }}">
                        Siswa
                    </span>
                </a>

                {{-- MENU GURU --}}
                <a href="/guru"
                    class="flex flex-col items-center gap-2 p-3 rounded-xl active:scale-95 transition-all border
        {{ Request::is('guru*')
            ? 'bg-blue-50 border-[#37517e]/30 shadow-sm'
            : 'bg-gray-50 border-transparent hover:bg-gray-100' }}">

                    <div
                        class="p-2 rounded-full transition-colors
            {{ Request::is('guru*') ? 'bg-[#37517e] text-white' : 'bg-blue-100 text-[#37517e]' }}">
                        <i data-lucide="graduation-cap" class="w-5 h-5"></i>
                    </div>

                    <span
                        class="text-[10px] transition-colors
            {{ Request::is('guru*') ? 'font-bold text-[#37517e]' : 'font-semibold text-gray-600' }}">
                        Guru
                    </span>
                </a>

                {{-- MENU USER --}}
                <a href="/user"
                    class="flex flex-col items-center gap-2 p-3 rounded-xl active:scale-95 transition-all border
        {{ Request::is('user*')
            ? 'bg-blue-50 border-[#37517e]/30 shadow-sm'
            : 'bg-gray-50 border-transparent hover:bg-gray-100' }}">

                    <div
                        class="p-2 rounded-full transition-colors
            {{ Request::is('user*') ? 'bg-[#37517e] text-white' : 'bg-blue-100 text-[#37517e]' }}">
                        <i data-lucide="book-user" class="w-5 h-5"></i>
                    </div>

                    <span
                        class="text-[10px] transition-colors
            {{ Request::is('user*') ? 'font-bold text-[#37517e]' : 'font-semibold text-gray-600' }}">
                        User
                    </span>
                </a>

                {{-- MENU KELAS --}}
                <a href="/kelas"
                    class="flex flex-col items-center gap-2 p-3 rounded-xl active:scale-95 transition-all border
        {{ Request::is('kelas*')
            ? 'bg-blue-50 border-[#37517e]/30 shadow-sm'
            : 'bg-gray-50 border-transparent hover:bg-gray-100' }}">

                    <div
                        class="p-2 rounded-full transition-colors
            {{ Request::is('kelas*') ? 'bg-[#37517e] text-white' : 'bg-blue-100 text-[#37517e]' }}">
                        <i data-lucide="building" class="w-5 h-5"></i>
                    </div>

                    <span
                        class="text-[10px] transition-colors
            {{ Request::is('kelas*') ? 'font-bold text-[#37517e]' : 'font-semibold text-gray-600' }}">
                        Kelas
                    </span>
                </a>

                {{-- MENU walas --}}
                <a href="/plot-walas"
                    class="flex flex-col items-center gap-2 p-3 rounded-xl active:scale-95 transition-all border
        {{ Request::is('plot-walas*')
            ? 'bg-blue-50 border-[#37517e]/30 shadow-sm'
            : 'bg-gray-50 border-transparent hover:bg-gray-100' }}">

                    <div
                        class="p-2 rounded-full transition-colors
            {{ Request::is('plot-walas*') ? 'bg-[#37517e] text-white' : 'bg-blue-100 text-[#37517e]' }}">
                        <i data-lucide="user-cog" class="w-5 h-5"></i>
                    </div>

                    <span
                        class="text-[10px] transition-colors
            {{ Request::is('plot-walas*') ? 'font-bold text-[#37517e]' : 'font-semibold text-gray-600' }}">
                        Walas
                    </span>
                </a>

            </div>
        </div>
        <div class="flex justify-around items-center h-[70px] px-2 shrink-0 w-full bg-white/50 backdrop-blur-sm">
            <a href="/dashboard" class="relative flex flex-col items-center justify-center w-full h-full group"
                @click="open = false">
                @if (Request::routeIs('dashboard'))
                    <span class="absolute top-2 w-1 h-1 bg-[#37517e] rounded-full shadow-sm"></span>
                @endif
                <div
                    class="transition-all duration-300 ease-out {{ Request::routeIs('dashboard') ? '-translate-y-2' : '' }}">
                    <i data-lucide="house"
                        class="w-6 h-6 transition-colors duration-300 {{ Request::routeIs('dashboard') ? 'text-[#37517e] fill-[#37517e]/20' : 'text-gray-400 group-hover:text-gray-600' }}"></i>
                </div>
                <span
                    class="absolute bottom-2 text-[10px] font-bold text-[#37517e] transition-all duration-300 {{ Request::routeIs('dashboard') ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4 pointer-events-none' }}">
                    Beranda
                </span>
            </a>

            @if (auth()->user() && auth()->user()->usertype === 'admin')
                {{-- Cek apakah URL saat ini adalah salah satu dari sub-menu master --}}
                @php
                    $isMasterActive = Request::is('siswa*', 'guru*', 'user*', 'kelas*', 'plot-walas*');
                @endphp

                <button @click="open = !open"
                    class="relative flex flex-col items-center justify-center w-full h-full group focus:outline-none">

                    {{-- 1. Titik Indikator (Hanya muncul jika Route Active) --}}
                    @if ($isMasterActive)
                        <span class="absolute top-2 w-1 h-1 bg-[#37517e] rounded-full shadow-sm"></span>
                    @endif

                    {{-- 2. Container Ikon (Naik jika Active ATAU Open) --}}
                    <div class="transition-all duration-300 ease-out"
                        :class="open || {{ $isMasterActive ? 'true' : 'false' }} ? '-translate-y-2' : ''">

                        {{-- Ikon saat menu tertutup --}}
                        <div x-show="!open">
                            <i data-lucide="database"
                                class="w-6 h-6 transition-colors duration-300 {{ $isMasterActive ? 'text-[#37517e] fill-[#37517e]/20' : 'text-gray-400 group-hover:text-gray-600' }}"></i>
                        </div>

                        {{-- Ikon Chevron saat menu terbuka (tetap biru) --}}
                        <div x-show="open" x-cloak>
                            <i data-lucide="chevron-down" class="w-6 h-6 text-[#37517e]"></i>
                        </div>
                    </div>

                    {{-- 3. Teks Label (Muncul jika Active ATAU Open) --}}
                    <span class="absolute bottom-2 text-[10px] font-bold text-[#37517e] transition-all duration-300"
                        :class="open || {{ $isMasterActive ? 'true' : 'false' }} ? 'opacity-100 translate-y-0' :
                            'opacity-0 translate-y-4 pointer-events-none'">
                        Master
                    </span>
                </button>
            @endif

            <a href="/pelanggaran" class="relative flex flex-col items-center justify-center w-full h-full group"
                @click="open = false">
                @if (Request::routeIs('pelanggaran'))
                    <span class="absolute top-2 w-1 h-1 bg-[#37517e] rounded-full shadow-sm"></span>
                @endif
                <div
                    class="transition-all duration-300 ease-out {{ Request::routeIs('pelanggaran') ? '-translate-y-2' : '' }}">
                    <i data-lucide="shield-off"
                        class="w-6 h-6 transition-colors duration-300 {{ Request::routeIs('pelanggaran') ? 'text-[#37517e] fill-[#37517e]/20' : 'text-gray-400 group-hover:text-gray-600' }}"></i>
                </div>
                <span
                    class="absolute bottom-2 text-[10px] font-bold text-[#37517e] transition-all duration-300 {{ Request::routeIs('pelanggaran') ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4 pointer-events-none' }}">
                    Point
                </span>
            </a>

            <a href="/profile" class="relative flex flex-col items-center justify-center w-full h-full group"
                @click="open = false">
                @if (Request::routeIs('profile'))
                    <span class="absolute top-2 w-1 h-1 bg-[#37517e] rounded-full shadow-sm"></span>
                @endif
                <div
                    class="transition-all duration-300 ease-out {{ Request::routeIs('profile') ? '-translate-y-2' : '' }}">
                    <i data-lucide="user"
                        class="w-6 h-6 transition-colors duration-300 {{ Request::routeIs('profile') ? 'text-[#37517e] fill-[#37517e]/20' : 'text-gray-400 group-hover:text-gray-600' }}"></i>
                </div>
                <span
                    class="absolute bottom-2 text-[10px] font-bold text-[#37517e] transition-all duration-300 {{ Request::routeIs('profile') ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4 pointer-events-none' }}">
                    Profil
                </span>
            </a>

        </div>
    </nav>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
        @csrf
    </form>

    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        lucide.createIcons();
    </script>
</body>

</html>
