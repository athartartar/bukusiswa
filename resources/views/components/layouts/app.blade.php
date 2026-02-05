<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Sekolah</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
</head>

<body class="bg-[#f3f4f6] font-['Plus Jakarta Sans',sans-serif]" x-data="{ sidebarOpen: false }">

    <div class="flex h-screen overflow-hidden">

        <aside class="absolute inset-y-0 left-0 z-50 w-64 bg-[#37517e] text-white transition-transform duration-300 transform md:relative md:translate-x-0"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">

            <div class="flex items-center justify-center h-18 border-b border-white/10 bg-[#2a3f63]">
                <i data-lucide = "book-open-text"></i><span class="ml-3 text-lg font-bold tracking-wide">BUKUSISWA</span>
            </div>

            <nav class="mt-5 px-4 space-y-2">
                <a href="/dashboard" class="flex items-center px-4 py-3 bg-white/10 rounded-lg text-white group transition-colors">
                    <i data-lucide="house" class="w-5 h-5 mr-3"></i>
                    <span class="font-medium">Dashboard</span>
                </a>

                <a href="#" class="flex items-center px-4 py-3 text-gray-300 hover:bg-white/10 hover:text-white rounded-lg transition-colors">
                    <i data-lucide="users" class="w-5 h-5 mr-3"></i>
                    <span class="font-medium">Data Siswa</span>
                </a>

                <a href="#" class="flex items-center px-4 py-3 text-gray-300 hover:bg-white/10 hover:text-white rounded-lg transition-colors">
                    <i data-lucide="clipboard-check" class="w-5 h-5 mr-3"></i>
                    <span class="font-medium">Pelanggaran</span>
                </a>

                <div class="pt-4 mt-4 border-t border-white/10">
                    <p class="px-4 text-xs font-semibold text-gray-400 uppercase mb-2">Akun</p>

                    <button wire:click="logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                        class="flex w-full items-center px-4 py-3 text-red-300 hover:bg-red-500/10 hover:text-red-200 rounded-lg transition-colors">
                        <i data-lucide="log-out" class="w-5 h-5 mr-3"></i>
                        <span class="font-medium">Logout</span>
                    </button>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                        @csrf
                    </form>
                </div>
            </nav>
        </aside>

        <div class="flex-1 flex flex-col overflow-hidden relative">

            <header class="flex items-center justify-between px-6 py-4 bg-white border-b border-gray-200">
                <div class="flex items-center">
                    <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 focus:outline-none md:hidden">
                        <i data-lucide="menu" class="w-6 h-6"></i>
                    </button>
                    <h2 class="text-xl font-bold text-[#37517e] ml-4 md:ml-0">
                        {{ $header ?? 'Dashboard' }}
                    </h2>
                </div>

                <div class="flex items-center space-x-4">
                    <div class="flex items-center space-x-2">
                        <div class="text-right hidden md:block">
                            <p class="text-sm font-bold text-gray-700">{{ Auth::user()->namalengkap ?? 'User' }}</p>
                            <p class="text-xs text-gray-500 capitalize">{{ Auth::user()->usertype ?? 'Guest' }}</p>
                        </div>
                        <div class="w-10 h-10 rounded-full bg-[#37517e] flex items-center justify-center text-white font-bold">
                            {{ substr(Auth::user()->namalengkap ?? 'U', 0, 1) }}
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-[#f3f4f6] p-6">
                {{ $slot }}
            </main>
        </div>

        <div x-show="sidebarOpen" @click="sidebarOpen = false"
            class="fixed inset-0 z-40 bg-black opacity-50 md:hidden"></div>
    </div>

    <script src="https://unpkg.com/lucide@latest"></script>
</body>

</html>