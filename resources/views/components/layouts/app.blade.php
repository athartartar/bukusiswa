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

                    <a href="/siswa"
                        class="flex items-center px-4 py-3 rounded-lg transition-colors
                        {{ Route::is('siswa') ? 'bg-white/90 text-[#37517e]' : 'text-gray-300 hover:bg-white/10 hover:text-white' }}">
                        <i data-lucide="users"
                            class="w-5 h-5 mr-3 {{ Route::is('siswa') ? 'fill-[#37517e]/20 stroke-[#37517e]' : '' }}"
                            @if (Route::is('siswa')) stroke-width="3" @endif>
                        </i>
                        <span class="{{ Route::is('siswa') ? 'font-bold' : 'font-medium' }}">Data Siswa</span>
                    </a>

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

                {{-- <div class="p-4 border-t border-white/10 mb-2">
                    <button id="logoutButton"
                        class="flex w-full items-center px-4 py-3 text-red-300 hover:bg-red-500/25 hover:text-red-200 rounded-lg transition-colors">
                        <i data-lucide="log-out" class="w-5 h-5 mr-3"></i>
                        <span class="font-medium">Logout</span>
                    </button>
                </div> --}}
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

    <nav id="footbar"
        class="md:hidden fixed bottom-6 left-4 right-4 z-50 bg-white/95 backdrop-blur-xl border border-white/20 rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.12)]">
        <div class="flex justify-around items-center h-[70px] px-2">

            <a href="/dashboard" class="relative flex flex-col items-center justify-center w-full h-full group">
                @if (Request::routeIs('dashboard'))
                    <span class="absolute top-2 w-1 h-1 bg-[#37517e] rounded-full shadow-sm"></span>
                @endif

                <div
                    class="transition-all duration-300 ease-out {{ Request::routeIs('dashboard') ? '-translate-y-2' : '' }}">
                    <i data-lucide="house"
                        class="w-6 h-6 transition-colors duration-300 
                        {{ Request::routeIs('dashboard') ? 'text-[#37517e] fill-[#37517e]/20' : 'text-gray-400 group-hover:text-gray-600' }}">
                    </i>
                </div>

                <span
                    class="absolute bottom-2 text-[10px] font-bold text-[#37517e] transition-all duration-300 
                        {{ Request::routeIs('dashboard') ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4 pointer-events-none' }}">
                    Beranda
                </span>
            </a>

            <a href="/siswa" class="relative flex flex-col items-center justify-center w-full h-full group">
                @if (Request::routeIs('siswa'))
                    <span class="absolute top-2 w-1 h-1 bg-[#37517e] rounded-full shadow-sm"></span>
                @endif

                <div
                    class="transition-all duration-300 ease-out {{ Request::routeIs('siswa') ? '-translate-y-2' : '' }}">
                    <i data-lucide="users"
                        class="w-6 h-6 transition-colors duration-300 
                        {{ Request::routeIs('siswa') ? 'text-[#37517e] fill-[#37517e]/20' : 'text-gray-400 group-hover:text-gray-600' }}">
                    </i>
                </div>

                <span
                    class="absolute bottom-2 text-[10px] font-bold text-[#37517e] transition-all duration-300 
                        {{ Request::routeIs('siswa') ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4 pointer-events-none' }}">
                    Siswa
                </span>
            </a>

            <a href="/pelanggaran" class="relative flex flex-col items-center justify-center w-full h-full group">
                @if (Request::routeIs('pelanggaran'))
                    <span class="absolute top-2 w-1 h-1 bg-[#37517e] rounded-full shadow-sm"></span>
                @endif

                <div
                    class="transition-all duration-300 ease-out {{ Request::routeIs('pelanggaran') ? '-translate-y-2' : '' }}">
                    <i data-lucide="shield-off"
                        class="w-6 h-6 transition-colors duration-300 
                        {{ Request::routeIs('pelanggaran') ? 'text-[#37517e] fill-[#37517e]/20' : 'text-gray-400 group-hover:text-gray-600' }}">
                    </i>
                </div>

                <span
                    class="absolute bottom-2 text-[10px] font-bold text-[#37517e] transition-all duration-300 
                        {{ Request::routeIs('pelanggaran') ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4 pointer-events-none' }}">
                    Point
                </span>
            </a>

            <a href="/profile" class="relative flex flex-col items-center justify-center w-full h-full group">
                @if (Request::routeIs('profile'))
                    <span class="absolute top-2 w-1 h-1 bg-[#37517e] rounded-full shadow-sm"></span>
                @endif

                <div
                    class="transition-all duration-300 ease-out {{ Request::routeIs('profile') ? '-translate-y-2' : '' }}">
                    <i data-lucide="user"
                        class="w-6 h-6 transition-colors duration-300 
                        {{ Request::routeIs('profile') ? 'text-[#37517e] fill-[#37517e]/20' : 'text-gray-400 group-hover:text-gray-600' }}">
                    </i>
                </div>

                <span
                    class="absolute bottom-2 text-[10px] font-bold text-[#37517e] transition-all duration-300 
                        {{ Request::routeIs('profile') ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4 pointer-events-none' }}">
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
