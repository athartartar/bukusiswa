<div x-data='pelanggaranData(
    @json($students),
    "{{ route('pelanggaran.store') }}",
    "{{ csrf_token() }}",
    "{{ $usertype }}",
    {{ $currentSiswaId ?? 'null' }}
)'
    class="w-full max-w-7xl mx-auto font-sans text-gray-800">
    <x-slot name="header">
        @if ($usertype === 'siswa')
            Riwayat Pelanggaran Saya
        @else
            Manajemen Data Siswa
        @endif
    </x-slot>

    <!-- Info Banner untuk Siswa -->
    @if ($usertype === 'siswa')
        <div class="mb-6 bg-blue-50 border border-blue-200 rounded-xl p-4">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-blue-100 rounded-full">
                    <i data-lucide="info" class="w-5 h-5 text-blue-600"></i>
                </div>
                <div>
                    <p class="font-semibold text-blue-900">Mode Siswa</p>
                    <p class="text-sm text-blue-700">Anda hanya dapat melihat riwayat pelanggaran Anda sendiri</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Filter dan Search Section - Hidden untuk siswa -->
    <div class="flex flex-col md:flex-row justify-between items-stretch md:items-center gap-4 mb-6" x-show="!isSiswa">
        <!-- Search Box -->
        <div class="gsap-card opacity-0 translate-y-10 w-full md:w-80 relative group">
            <div
                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-[#37517e] transition-colors">
                <i data-lucide="search" class="w-5 h-5"></i>
            </div>
            <input type="text" x-model="search"
                class="block w-full pl-10 pr-3 py-2.5 border border-gray-200 rounded-xl leading-5 bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#37517e]/20 focus:border-[#37517e] text-sm shadow-sm transition-all"
                placeholder="Cari Nama, NIS...">
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 md:flex md:items-center gap-3 w-full md:w-auto">
            <!-- Filter Kelas -->
            <div x-data="{
                open: false,
                search: ''
            }" class="gsap-card opacity-0 translate-y-10 relative group w-full md:w-auto"
                @click.outside="open = false">

                <button type="button" @click="open = !open"
                    class="w-full md:w-40 pl-4 pr-10 py-2.5 text-left border bg-white focus:outline-none transition-all flex items-center justify-between relative z-10"
                    :class="open ? 'rounded-t-xl border-[#37517e] ring-2 ring-[#37517e]/20 border-b-transparent' :
                        'rounded-xl border-gray-200 group-hover:border-[#37517e]/50'">
                    <span x-text="filterKelas === '' ? 'Semua Kelas' : filterKelas"
                        class="block truncate font-medium text-gray-700 text-sm">
                    </span>

                    <span
                        class="absolute inset-y-0 right-0 flex flex-col justify-center pr-3 pointer-events-none text-gray-500">
                        <i data-lucide="filter" class="w-4 h-4 transition-transform duration-300 ease-in-out"
                            :class="open ? 'rotate-180' : ''"></i>
                    </span>
                </button>

                <div x-show="open" x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="transform opacity-0 -translate-y-2"
                    x-transition:enter-end="transform opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="transform opacity-100 translate-y-0"
                    x-transition:leave-end="transform opacity-0 -translate-y-2"
                    class="absolute z-20 -mt-[2px] w-full bg-white shadow-[0_10px_20px_-5px_rgba(0,0,0,0.1)] rounded-b-xl border border-t-0 border-[#37517e] overflow-hidden"
                    style="display: none;">

                    <div class="sticky top-0 z-30 bg-white p-2 border-b border-gray-100">
                        <div class="relative">
                            <input x-model="search" type="text"
                                class="w-full pl-9 pr-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-[#37517e] focus:ring-1 focus:ring-[#37517e] placeholder-gray-400 bg-gray-50/50"
                                placeholder="Cari kelas...">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i data-lucide="search" class="w-4 h-4 text-gray-400"></i>
                            </div>
                        </div>
                    </div>

                    <ul class="py-1 max-h-56 overflow-auto" style="scrollbar-width: none; -ms-overflow-style: none;">
                        <style>
                            ul::-webkit-scrollbar {
                                display: none;
                            }
                        </style>

                        <li @click="filterKelas = ''; open = false; currentPage = 1"
                            class="cursor-pointer select-none relative py-2.5 pl-4 pr-9 text-sm hover:bg-indigo-50/80 transition-colors duration-150"
                            :class="filterKelas === '' ? 'bg-indigo-50 text-[#37517e] font-semibold' : 'text-gray-700'">
                            <span class="block truncate">Semua Kelas</span>
                            <span x-show="filterKelas === ''"
                                class="absolute inset-y-0 right-0 flex items-center pr-3 text-[#37517e]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="20 6 9 17 4 12"></polyline>
                                </svg>
                            </span>
                        </li>

                        <template x-for="kelas in filteredKelasList" :key="kelas">
                            <li @click="filterKelas = kelas; open = false; search = ''; currentPage = 1"
                                class="cursor-pointer select-none relative py-2.5 pl-4 pr-9 text-sm hover:bg-indigo-50/80 transition-colors duration-150"
                                :class="filterKelas === kelas ? 'bg-indigo-50 text-[#37517e] font-semibold' : 'text-gray-700'">
                                <span x-text="kelas" class="block truncate"></span>
                                <span x-show="filterKelas === kelas"
                                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-[#37517e]">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="20 6 9 17 4 12"></polyline>
                                    </svg>
                                </span>
                            </li>
                        </template>

                        <div x-show="filteredKelasList.length === 0"
                            class="px-4 py-6 text-sm text-gray-500 text-center">
                            <i data-lucide="info" class="w-6 h-6 text-gray-300 mx-auto mb-2"></i>
                            <p>Kelas tidak ditemukan.</p>
                        </div>
                    </ul>
                </div>
            </div>

            <!-- Sort By Poin -->
            <div x-data="{
                open: false,
                options: [
                    { value: '', label: 'Default' },
                    { value: 'desc', label: 'Poin Terbesar' },
                    { value: 'asc', label: 'Poin Terkecil' }
                ],
                get currentLabel() {
                    let selected = this.options.find(o => o.value === sortByPoin);
                    return selected ? selected.label : 'Urutkan';
                }
            }" class="gsap-card opacity-0 translate-y-10 relative group w-full md:w-auto"
                @click.outside="open = false">

                <button type="button" @click="open = !open"
                    class="w-full md:w-40 pl-4 pr-10 py-2.5 text-left border bg-white focus:outline-none transition-all flex items-center justify-between relative z-10"
                    :class="open ? 'rounded-t-xl border-[#37517e] ring-2 ring-[#37517e]/20 border-b-transparent' :
                        'rounded-xl border-gray-200 group-hover:border-[#37517e]/50'">
                    <span x-text="currentLabel" class="block truncate font-medium text-gray-700 text-sm">
                    </span>

                    <span
                        class="absolute inset-y-0 right-0 flex flex-col justify-center pr-3 pointer-events-none text-gray-500">
                        <i data-lucide="arrow-up-down" class="w-4 h-4"></i>
                    </span>
                </button>

                <div x-show="open" x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="transform opacity-0 -translate-y-2"
                    x-transition:enter-end="transform opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="transform opacity-100 translate-y-0"
                    x-transition:leave-end="transform opacity-0 -translate-y-2"
                    class="absolute z-20 -mt-[2px] w-full bg-white shadow-[0_10px_20px_-5px_rgba(0,0,0,0.1)] rounded-b-xl border border-t-0 border-[#37517e] overflow-hidden"
                    style="display: none;">

                    <ul class="py-1">
                        <template x-for="option in options" :key="option.value">
                            <li @click="sortByPoin = option.value; open = false; currentPage = 1"
                                class="cursor-pointer select-none relative py-2.5 pl-4 pr-9 text-sm hover:bg-indigo-50/80 transition-colors duration-150"
                                :class="sortByPoin === option.value ? 'bg-indigo-50 text-[#37517e] font-semibold' :
                                    'text-gray-700'">
                                <span x-text="option.label" class="block truncate"></span>
                                <span x-show="sortByPoin === option.value"
                                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-[#37517e]">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="20 6 9 17 4 12"></polyline>
                                    </svg>
                                </span>
                            </li>
                        </template>
                    </ul>
                </div>
            </div>

            <!-- Rows Per Page -->
            <div x-data="{
                open: false,
                options: [8, 16, 24, 32, 40]
            }" class="gsap-card opacity-0 translate-y-10 relative group w-full md:w-auto"
                @click.outside="open = false">

                <button type="button" @click="open = !open"
                    class="w-full md:w-36 pl-4 pr-10 py-2.5 text-left border bg-white focus:outline-none transition-all flex items-center justify-between relative z-10"
                    :class="open ? 'rounded-t-xl border-[#37517e] ring-2 ring-[#37517e]/20 border-b-transparent' :
                        'rounded-xl border-gray-200 group-hover:border-[#37517e]/50'">
                    <span x-text="rowsPerPage + ' Baris'" class="block truncate font-medium text-gray-700 text-sm">
                    </span>

                    <span
                        class="absolute inset-y-0 right-0 flex flex-col justify-center pr-3 pointer-events-none text-gray-500">
                        <i data-lucide="chevron-down" class="w-4 h-4 transition-transform duration-300 ease-in-out"
                            :class="open ? 'rotate-180' : ''"></i>
                    </span>
                </button>

                <div x-show="open" x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="transform opacity-0 -translate-y-2"
                    x-transition:enter-end="transform opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="transform opacity-100 translate-y-0"
                    x-transition:leave-end="transform opacity-0 -translate-y-2"
                    class="absolute z-20 -mt-[2px] w-full bg-white shadow-[0_10px_20px_-5px_rgba(0,0,0,0.1)] rounded-b-xl border border-t-0 border-[#37517e] overflow-hidden"
                    style="display: none;">

                    <ul class="py-1">
                        <template x-for="option in options" :key="option">
                            <li @click="rowsPerPage = option; updateRows(); open = false"
                                class="cursor-pointer select-none relative py-2.5 pl-4 pr-9 text-sm hover:bg-indigo-50/80 transition-colors duration-150"
                                :class="rowsPerPage === option ? 'bg-indigo-50 text-[#37517e] font-semibold' : 'text-gray-700'">

                                <span x-text="option + ' Baris'" class="block truncate"></span>

                                <span x-show="rowsPerPage === option"
                                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-[#37517e]">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="20 6 9 17 4 12"></polyline>
                                    </svg>
                                </span>
                            </li>
                        </template>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Students Grid -->
    <div
        class="gsap-card opacity-0 translate-y-10 bg-white rounded-2xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] border border-gray-100 overflow-hidden flex flex-col">
        <div class="overflow-x-auto custom-scrollbar">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5 p-5">

                <template x-for="student in paginatedStudents" :key="student.id">
                    <div
                        class="relative bg-white rounded-2xl border border-gray-200 shadow-sm hover:shadow-md transition p-5 flex flex-col justify-between">

                        <!-- poin kanan atas -->
                        <div class="absolute top-3 right-3">
                            <span class="px-3 py-1 rounded-full text-xs font-bold border shadow-sm"
                                :class="{
                                    'bg-emerald-50 text-emerald-600 border-emerald-200': (student.total_poin ?? 0) <=
                                        49,
                                    'bg-yellow-50 text-yellow-600 border-yellow-200': (student.total_poin ?? 0) >= 50 &&
                                        (student.total_poin ?? 0) <= 74,
                                    'bg-red-50 text-red-600 border-red-200': (student.total_poin ?? 0) >= 75
                                }"
                                x-text="student.total_poin ?? 0">
                            </span>
                        </div>

                        <div>
                            <h3 class="font-bold text-gray-800 text-base leading-tight pr-12" x-text="student.name">
                            </h3>

                            <div
                                class="mt-2 text-xs text-gray-500 font-mono bg-gray-100 inline-block px-2 py-1 rounded">
                                NIS: <span x-text="student.nis"></span>
                            </div>

                            <div class="mt-3">
                                <span
                                    class="inline-flex px-2.5 py-0.5 rounded-lg text-xs font-medium bg-indigo-50 text-indigo-700 border border-indigo-100"
                                    x-text="student.class"></span>
                            </div>
                        </div>

                        <!-- tombol -->
<div class="mt-5 flex gap-2" x-data="{ isUserWalas: {{ $isWalas ? 'true' : 'false' }} }">
                            
                            <button @click="openDrawer('tambahPelanggaran', student)" 
                                x-show="usertype === 'guru' || usertype === 'admin'"
                                class="flex-1 text-xs bg-[#37517e] hover:bg-[#2c4064] text-white font-semibold py-2 rounded-lg shadow-sm transition">
                                <i data-lucide="plus-circle" class="w-4 h-4 inline mr-1"></i>Catat
                            </button>

                            <button @click="openDrawer('tindakPembinaan', student)" 
                                x-show="(usertype === 'walas' || isUserWalas) && ((student.total_poin ?? 0) > 0 && (student.total_poin ?? 0) <= 25)"
                                class="flex-1 text-xs bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-2 rounded-lg shadow-sm transition">
                                <i data-lucide="heart-handshake" class="w-4 h-4 inline mr-1"></i>Bina Siswa
                            </button>

                            <button @click="openDrawer('tindakPembinaan', student)" 
                                x-show="usertype === 'bk' && (student.total_poin ?? 0) > 25"
                                class="flex-1 text-xs bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-2 rounded-lg shadow-sm transition">
                                <i data-lucide="heart-handshake" class="w-4 h-4 inline mr-1"></i>Bina (BK)
                            </button>

                            <button @click="openDrawer('tindakSP', student)" 
                                x-show="usertype === 'kesiswaan' && (student.total_poin ?? 0) > 25"
                                class="flex-1 text-xs bg-red-600 hover:bg-red-700 text-white font-semibold py-2 rounded-lg shadow-sm transition">
                                <i data-lucide="mail-warning" class="w-4 h-4 inline mr-1"></i>Beri SP
                            </button>

                            <button @click="openDrawer('riwayat', student)" 
                                :class="(
                                    usertype === 'siswa' || 
                                    ((usertype === 'walas' || isUserWalas) && ((student.total_poin ?? 0) == 0 || (student.total_poin ?? 0) > 25)) ||
                                    (usertype === 'bk' && (student.total_poin ?? 0) <= 25) ||
                                    (usertype === 'kesiswaan' && (student.total_poin ?? 0) <= 25)
                                ) ? 'w-full' : 'flex-1'"
                                class="text-xs bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-2 rounded-lg transition">
                                <i data-lucide="history" class="w-4 h-4 inline mr-1"></i>Riwayat
                            </button>

                        </div>

                    </div>
                </template>

                <template x-if="paginatedStudents.length === 0">
                    <div class="col-span-full text-center py-16">
                        <div class="flex flex-col items-center">
                            <div class="bg-gray-50 p-4 rounded-full mb-3">
                                <i data-lucide="users-x" class="w-8 h-8 text-gray-400"></i>
                            </div>
                            <h3 class="text-gray-900 font-medium">Tidak ada data siswa</h3>
                            <p class="text-gray-500 text-sm mt-1">
                                <span x-show="filterKelas !== ''">Tidak ada siswa di kelas <b
                                        x-text="filterKelas"></b></span>
                                <span x-show="filterKelas === '' && search !== ''">Tidak ada hasil untuk "<b
                                        x-text="search"></b>"</span>
                                <span x-show="filterKelas === '' && search === ''">Belum ada data siswa</span>
                            </p>
                        </div>
                    </div>
                </template>

            </div>

        </div>

        <!-- Pagination - Hidden untuk siswa karena hanya 1 data -->
        <div x-show="!isSiswa"
            class="px-6 py-4 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-4 bg-gray-50/50">
            <span class="text-xs sm:text-sm text-gray-500 order-2 sm:order-1">
                Menampilkan <b x-text="paginatedStudents.length"></b> dari <span
                    x-text="filteredStudents.length"></span> siswa
                <span x-show="filterKelas !== ''" class="text-[#37517e] font-semibold">
                    (Kelas: <span x-text="filterKelas"></span>)
                </span>
            </span>

            <div class="flex items-center gap-1 order-1 sm:order-2 w-full sm:w-auto justify-center"
                x-show="totalPages > 0">
                <button @click="currentPage > 1 ? currentPage-- : null" :disabled="currentPage === 1"
                    class="px-3 py-2 rounded-md border border-gray-200 bg-white text-gray-500 hover:bg-gray-100 disabled:opacity-50 disabled:cursor-not-allowed transition">
                    <i data-lucide="chevron-left" class="w-4 h-4"></i>
                </button>

                <template x-for="page in pageNumbers">
                    <button @click="typeof page === 'number' ? currentPage = page : null"
                        class="min-w-[36px] px-3 py-2 rounded-md text-sm font-medium border transition-colors focus:outline-none"
                        :class="page === currentPage ?
                            'bg-[#37517e] text-white border-[#37517e] shadow-sm' :
                            (typeof page === 'number' ?
                                'bg-white text-gray-700 border-gray-200 hover:bg-gray-50' :
                                'bg-transparent border-transparent text-gray-400 cursor-default')"
                        x-text="page" :disabled="typeof page !== 'number'">
                    </button>
                </template>

                <button @click="currentPage < totalPages ? currentPage++ : null"
                    :disabled="currentPage === totalPages"
                    class="px-3 py-2 rounded-md border border-gray-200 bg-white text-gray-500 hover:bg-gray-100 disabled:opacity-50 disabled:cursor-not-allowed transition">
                    <i data-lucide="chevron-right" class="w-4 h-4"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- DRAWER CATAT PELANGGARAN - TIDAK MUNCUL untuk siswa -->
    <div x-show="drawerOpen && drawerMode === 'tambahPelanggaran' && canCreate" class="relative z-50"
        style="z-index: 100; display: none;">
        <div x-show="drawerOpen" @click="drawerOpen = false"
            class="fixed inset-0 bg-[#37517e]/20 backdrop-blur-sm transition-opacity"></div>

        <div x-show="drawerOpen"
            class="fixed inset-y-0 right-0 w-full sm:w-[550px] bg-white shadow-2xl flex flex-col h-full border-l border-gray-100"
            x-transition:enter="transition transform ease-out duration-300"
            x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
            x-transition:leave="transition transform ease-in duration-200" x-transition:leave-start="translate-x-0"
            x-transition:leave-end="translate-x-full">

            <div class="px-6 py-5 border-b border-gray-100 flex items-start justify-between bg-gray-50/50">
                <div class="pr-4">
                    <h2 class="text-xl font-bold text-[#37517e]">Catat Pelanggaran</h2>
                    <p class="text-sm text-gray-500 mt-2 leading-relaxed">
                        <span x-text="selectedStudent?.name"></span> - <span class="font-mono"
                            x-text="selectedStudent?.nis"></span>
                    </p>
                </div>
                <button @click="drawerOpen = false"
                    class="p-2 text-gray-400 hover:text-red-500 transition hover:bg-red-50 rounded-lg shrink-0">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <div class="flex-1 overflow-y-auto p-6 space-y-6">

                <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 flex items-center gap-3">
                    <div class="p-2 bg-blue-100 rounded-full">
                        <i data-lucide="info" class="w-5 h-5 text-blue-600"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-blue-800">Total Poin yang Dipilih</p>
                        <p class="text-2xl font-bold text-blue-900" x-text="totalSelectedPoin + ' Poin'"></p>
                    </div>
                </div>

                <!-- Kategori Ringan -->
                <div>
                    <h3 class="text-sm font-bold text-gray-700 mb-3 flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full bg-yellow-400"></div>
                        Kategori Ringan
                    </h3>
                    <div class="space-y-2">
                        <template x-for="item in pelanggaranList.ringan" :key="item.id">
                            <div class="border border-gray-200 rounded-xl p-3 hover:border-[#37517e] transition"
                                :class="selectedPelanggaran[item.id] ? 'bg-indigo-50 border-[#37517e]' : 'bg-white'">
                                <label class="flex items-center justify-between cursor-pointer">
                                    <div class="flex items-center gap-3">
                                        <input type="checkbox" :id="'pel-' + item.id"
                                            @change="togglePelanggaran(item.id, item.jenis, item.poin)"
                                            :checked="selectedPelanggaran[item.id]"
                                            class="w-5 h-5 text-[#37517e] border-gray-300 rounded focus:ring-2 focus:ring-[#37517e]/20">
                                        <div>
                                            <p class="font-medium text-gray-800" x-text="item.jenis"></p>
                                            <p class="text-xs text-gray-500"><span x-text="item.poin"></span> Poin</p>
                                        </div>
                                    </div>
                                    <span
                                        class="px-2.5 py-1 rounded-lg text-xs font-bold bg-yellow-100 text-yellow-700"
                                        x-text="'+' + item.poin"></span>
                                </label>

                                <div x-show="selectedPelanggaran[item.id]" x-transition
                                    class="mt-3 pt-3 border-t border-gray-200">
                                    <input type="file" :id="'file-' + item.id"
                                        @change="handleFileUpload($event, item.id)" accept="image/*"
                                        :capture="isMobile ? 'environment' : false" class="hidden">

                                    <div x-show="!photoPreview[item.id]">
                                        <button type="button"
                                            @click="document.getElementById('file-' + item.id).click()"
                                            class="w-full px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm font-medium transition flex items-center justify-center gap-2">
                                            <i data-lucide="camera" class="w-4 h-4"></i>
                                            <span x-text="isMobile ? 'Ambil Foto' : 'Upload Foto'"></span>
                                            <span class="text-xs text-gray-500">(Opsional)</span>
                                        </button>
                                    </div>

                                    <div x-show="photoPreview[item.id]" class="relative">
                                        <img :src="photoPreview[item.id]"
                                            @click="openFullscreen(photoPreview[item.id])"
                                            class="w-full h-32 object-cover rounded-lg border border-gray-200 cursor-pointer hover:opacity-90 transition">
                                        <button type="button" @click="removePhoto(item.id)"
                                            class="absolute top-2 right-2 p-1.5 bg-red-500 hover:bg-red-600 text-white rounded-full shadow-lg transition">
                                            <i data-lucide="x" class="w-4 h-4"></i>
                                        </button>
                                        <p class="text-xs text-gray-500 mt-1 text-center">Klik foto untuk fullscreen •
                                            Auto-compress max 500KB</p>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Kategori Sedang -->
                <div>
                    <h3 class="text-sm font-bold text-gray-700 mb-3 flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full bg-orange-400"></div>
                        Kategori Sedang
                    </h3>
                    <div class="space-y-2">
                        <template x-for="item in pelanggaranList.sedang" :key="item.id">
                            <div class="border border-gray-200 rounded-xl p-3 hover:border-[#37517e] transition"
                                :class="selectedPelanggaran[item.id] ? 'bg-indigo-50 border-[#37517e]' : 'bg-white'">
                                <label class="flex items-center justify-between cursor-pointer">
                                    <div class="flex items-center gap-3">
                                        <input type="checkbox" :id="'pel-' + item.id"
                                            @change="togglePelanggaran(item.id, item.jenis, item.poin)"
                                            :checked="selectedPelanggaran[item.id]"
                                            class="w-5 h-5 text-[#37517e] border-gray-300 rounded focus:ring-2 focus:ring-[#37517e]/20">
                                        <div>
                                            <p class="font-medium text-gray-800" x-text="item.jenis"></p>
                                            <p class="text-xs text-gray-500"><span x-text="item.poin"></span> Poin</p>
                                        </div>
                                    </div>
                                    <span
                                        class="px-2.5 py-1 rounded-lg text-xs font-bold bg-orange-100 text-orange-700"
                                        x-text="'+' + item.poin"></span>
                                </label>

                                <div x-show="selectedPelanggaran[item.id]" x-transition
                                    class="mt-3 pt-3 border-t border-gray-200">
                                    <input type="file" :id="'file-' + item.id"
                                        @change="handleFileUpload($event, item.id)" accept="image/*"
                                        :capture="isMobile ? 'environment' : false" class="hidden">

                                    <div x-show="!photoPreview[item.id]">
                                        <button type="button"
                                            @click="document.getElementById('file-' + item.id).click()"
                                            class="w-full px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm font-medium transition flex items-center justify-center gap-2">
                                            <i data-lucide="camera" class="w-4 h-4"></i>
                                            <span x-text="isMobile ? 'Ambil Foto' : 'Upload Foto'"></span>
                                            <span class="text-xs text-gray-500">(Opsional)</span>
                                        </button>
                                    </div>

                                    <div x-show="photoPreview[item.id]" class="relative">
                                        <img :src="photoPreview[item.id]"
                                            @click="openFullscreen(photoPreview[item.id])"
                                            class="w-full h-32 object-cover rounded-lg border border-gray-200 cursor-pointer hover:opacity-90 transition">
                                        <button type="button" @click="removePhoto(item.id)"
                                            class="absolute top-2 right-2 p-1.5 bg-red-500 hover:bg-red-600 text-white rounded-full shadow-lg transition">
                                            <i data-lucide="x" class="w-4 h-4"></i>
                                        </button>
                                        <p class="text-xs text-gray-500 mt-1 text-center">Klik foto untuk fullscreen •
                                            Auto-compress max 500KB</p>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Kategori Berat -->
                <div>
                    <h3 class="text-sm font-bold text-gray-700 mb-3 flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full bg-red-500"></div>
                        Kategori Berat
                    </h3>
                    <div class="space-y-2">
                        <template x-for="item in pelanggaranList.berat" :key="item.id">
                            <div class="border border-gray-200 rounded-xl p-3 hover:border-[#37517e] transition"
                                :class="selectedPelanggaran[item.id] ? 'bg-indigo-50 border-[#37517e]' : 'bg-white'">
                                <label class="flex items-center justify-between cursor-pointer">
                                    <div class="flex items-center gap-3">
                                        <input type="checkbox" :id="'pel-' + item.id"
                                            @change="togglePelanggaran(item.id, item.jenis, item.poin)"
                                            :checked="selectedPelanggaran[item.id]"
                                            class="w-5 h-5 text-[#37517e] border-gray-300 rounded focus:ring-2 focus:ring-[#37517e]/20">
                                        <div>
                                            <p class="font-medium text-gray-800" x-text="item.jenis"></p>
                                            <p class="text-xs text-gray-500"><span x-text="item.poin"></span> Poin</p>
                                        </div>
                                    </div>
                                    <span class="px-2.5 py-1 rounded-lg text-xs font-bold bg-red-100 text-red-700"
                                        x-text="'+' + item.poin"></span>
                                </label>

                                <div x-show="selectedPelanggaran[item.id]" x-transition
                                    class="mt-3 pt-3 border-t border-gray-200">
                                    <input type="file" :id="'file-' + item.id"
                                        @change="handleFileUpload($event, item.id)" accept="image/*"
                                        :capture="isMobile ? 'environment' : false" class="hidden">

                                    <div x-show="!photoPreview[item.id]">
                                        <button type="button"
                                            @click="document.getElementById('file-' + item.id).click()"
                                            class="w-full px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm font-medium transition flex items-center justify-center gap-2">
                                            <i data-lucide="camera" class="w-4 h-4"></i>
                                            <span x-text="isMobile ? 'Ambil Foto' : 'Upload Foto'"></span>
                                            <span class="text-xs text-gray-500">(Opsional)</span>
                                        </button>
                                    </div>

                                    <div x-show="photoPreview[item.id]" class="relative">
                                        <img :src="photoPreview[item.id]"
                                            @click="openFullscreen(photoPreview[item.id])"
                                            class="w-full h-32 object-cover rounded-lg border border-gray-200 cursor-pointer hover:opacity-90 transition">
                                        <button type="button" @click="removePhoto(item.id)"
                                            class="absolute top-2 right-2 p-1.5 bg-red-500 hover:bg-red-600 text-white rounded-full shadow-lg transition">
                                            <i data-lucide="x" class="w-4 h-4"></i>
                                        </button>
                                        <p class="text-xs text-gray-500 mt-1 text-center">Klik foto untuk fullscreen •
                                            Auto-compress max 500KB</p>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Keterangan Tambahan
                        (Opsional)</label>
                    <textarea x-model="keteranganTambahan" rows="3" placeholder="Tambahkan keterangan jika diperlukan..."
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-[#37517e] focus:ring-2 focus:ring-[#37517e]/20 outline-none transition-all placeholder:text-gray-400 resize-none"></textarea>
                </div>
            </div>

            <div class="px-6 py-5 border-t border-gray-100 bg-gray-50 flex gap-3">
                <button @click="drawerOpen = false"
                    class="flex-1 px-4 py-2.5 bg-white border border-gray-200 text-gray-700 rounded-xl font-medium hover:bg-gray-100 transition shadow-sm">
                    Batal
                </button>

                <button @click="savePelanggaranBatch()"
                    :disabled="isLoading || Object.keys(selectedPelanggaran).length === 0"
                    class="flex-[2] px-4 py-2.5 bg-[#37517e] text-white rounded-xl font-medium hover:bg-[#2a3f63] shadow-lg shadow-[#37517e]/20 transition flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
                    <i x-show="!isLoading" data-lucide="save" class="w-4 h-4"></i>
                    <svg x-show="isLoading" class="animate-spin h-4 w-4 text-white"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    <span x-text="isLoading ? 'Menyimpan...' : 'Simpan Pelanggaran'"></span>
                </button>
            </div>
        </div>
    </div>

    <!-- DRAWER RIWAYAT PELANGGARAN - DENGAN TOMBOL DELETE -->
<div x-show="drawerOpen && drawerMode === 'riwayat'" class="relative z-50" style="z-index: 100; display: none;">
        <div x-show="drawerOpen" @click="drawerOpen = false"
            class="fixed inset-0 bg-[#37517e]/20 backdrop-blur-sm transition-opacity"></div>

        <div x-show="drawerOpen"
            class="fixed inset-y-0 right-0 w-full sm:w-[500px] bg-white shadow-2xl flex flex-col h-full border-l border-gray-100"
            x-transition:enter="transition transform ease-out duration-300"
            x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
            x-transition:leave="transition transform ease-in duration-200" x-transition:leave-start="translate-x-0"
            x-transition:leave-end="translate-x-full">

            <div class="px-6 py-5 border-b border-gray-100 flex flex-col bg-gray-50/50">
                <div class="flex items-start justify-between">
                    <div class="pr-4">
                        <h2 class="text-xl font-bold text-[#37517e]">Riwayat Siswa</h2>
                        <p class="text-sm text-gray-500 mt-1 leading-relaxed">
                            <span x-text="selectedStudent?.name"></span> - <span class="font-mono" x-text="selectedStudent?.nis"></span>
                        </p>
                    </div>
                    <button @click="drawerOpen = false" class="p-2 text-gray-400 hover:text-red-500 transition hover:bg-red-50 rounded-lg shrink-0">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>

                <div class="mt-4 flex items-center justify-between">
                    <span class="px-3 py-1 rounded-full text-xs font-bold border shadow-sm"
                        :class="{
                            'bg-emerald-50 text-emerald-600 border-emerald-200': (selectedStudent?.total_poin ?? 0) <= 49,
                            'bg-yellow-50 text-yellow-600 border-yellow-200': (selectedStudent?.total_poin ?? 0) >= 50 && (selectedStudent?.total_poin ?? 0) <= 74,
                            'bg-red-50 text-red-600 border-red-200': (selectedStudent?.total_poin ?? 0) >= 75
                        }">
                        Total Poin Saat Ini: <span x-text="selectedStudent?.total_poin ?? 0"></span>
                    </span>
                </div>

                <div class="flex items-center gap-2 mt-5 bg-gray-200/50 p-1.5 rounded-xl">
                    <button @click="filterRiwayat = 'semua'" :class="filterRiwayat === 'semua' ? 'bg-white shadow-sm text-[#37517e]' : 'text-gray-500 hover:text-gray-700'" class="flex-1 py-2 text-xs font-bold rounded-lg transition">Semua</button>
                    <button @click="filterRiwayat = 'pelanggaran'" :class="filterRiwayat === 'pelanggaran' ? 'bg-white shadow-sm text-red-600' : 'text-gray-500 hover:text-gray-700'" class="flex-1 py-2 text-xs font-bold rounded-lg transition">Pelanggaran</button>
                    <button @click="filterRiwayat = 'pembinaan'" :class="filterRiwayat === 'pembinaan' ? 'bg-white shadow-sm text-emerald-600' : 'text-gray-500 hover:text-gray-700'" class="flex-1 py-2 text-xs font-bold rounded-lg transition">Pembinaan</button>
                </div>
            </div>

            <div class="flex-1 overflow-y-auto p-6">
                <div x-show="isLoadingRiwayat" class="text-center py-16">
                    <div class="flex flex-col items-center">
                        <svg class="animate-spin h-8 w-8 text-[#37517e] mb-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <p class="text-gray-500 text-sm">Memuat riwayat...</p>
                    </div>
                </div>

                <template x-if="!isLoadingRiwayat && filteredRiwayat.length === 0">
                    <div class="text-center py-16">
                        <div class="flex flex-col items-center">
                            <div class="bg-gray-50 p-4 rounded-full mb-3">
                                <i data-lucide="clipboard-list" class="w-8 h-8 text-gray-400"></i>
                            </div>
                            <h3 class="text-gray-900 font-medium">Data tidak ditemukan</h3>
                            <p class="text-gray-500 text-sm mt-1">Belum ada riwayat pada kategori ini.</p>
                        </div>
                    </div>
                </template>

                <div class="space-y-4" x-show="!isLoadingRiwayat && filteredRiwayat.length > 0">
                    <template x-for="item in filteredRiwayat" :key="item.type + '-' + item.id">
                        <div class="border rounded-xl p-4 transition"
                            :class="item.type === 'pelanggaran' ? 'bg-white border-red-100 hover:shadow-md hover:border-red-300' : 'bg-emerald-50/30 border-emerald-100 hover:shadow-md hover:border-emerald-300'">
                            
                            <div class="flex items-start justify-between mb-2">
                                <h4 class="font-bold flex-1" :class="item.type === 'pelanggaran' ? 'text-gray-800' : 'text-emerald-800'" x-text="item.judul"></h4>
                                <div class="flex items-center gap-2">
                                    <span class="px-2.5 py-1 rounded-lg text-xs font-bold border"
                                        :class="item.type === 'pelanggaran' ? 'bg-red-50 text-red-600 border-red-200' : 'bg-emerald-100 text-emerald-700 border-emerald-200'">
                                        <span x-text="item.type === 'pelanggaran' ? '+' : '-'"></span><span x-text="item.poin"></span> Poin
                                    </span>

                                    <button x-show="item.type === 'pelanggaran' && item.can_delete" @click="deletePelanggaran(item.id)"
                                        class="p-1.5 text-red-500 hover:text-red-700 hover:bg-red-50 rounded-lg transition" title="Hapus pelanggaran">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </div>
                            </div>

                            <div x-show="item.type === 'pelanggaran' && item.bukti_foto" class="my-3">
                                <img :src="'/storage/' + item.bukti_foto" @click="openFullscreen('/storage/' + item.bukti_foto)"
                                    class="w-full h-40 object-cover rounded-lg border border-gray-200 cursor-pointer hover:opacity-90 transition" :alt="item.judul">
                            </div>

                            <p class="text-sm mb-3" :class="item.type === 'pelanggaran' ? 'text-gray-600' : 'text-emerald-700'" x-text="item.keterangan || 'Tidak ada keterangan.'"></p>

                            <div class="flex items-center justify-between text-xs" :class="item.type === 'pelanggaran' ? 'text-gray-500' : 'text-emerald-600'">
                                <div class="flex items-center gap-2">
                                    <i data-lucide="calendar" class="w-3.5 h-3.5"></i>
                                    <span x-text="formatDate(item.tanggal)"></span>
                                </div>
                                <div class="flex items-center gap-1" x-show="item.aktor">
                                    <i data-lucide="user" class="w-3.5 h-3.5"></i>
                                    <span x-text="item.aktor"></span>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>
<div x-show="drawerOpen && drawerMode === 'tindakPembinaan'" class="relative z-50" style="z-index: 100; display: none;">
        <div x-show="drawerOpen" @click="drawerOpen = false" class="fixed inset-0 bg-[#37517e]/20 backdrop-blur-sm transition-opacity"></div>
        <div x-show="drawerOpen" class="fixed inset-y-0 right-0 w-full sm:w-[500px] bg-white shadow-2xl flex flex-col h-full border-l border-gray-100"
            x-transition:enter="transition transform ease-out duration-300" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
            x-transition:leave="transition transform ease-in duration-200" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full">

            <div class="px-6 py-5 border-b border-gray-100 flex items-start justify-between bg-emerald-50/50">
                <div class="pr-4">
                    <h2 class="text-xl font-bold text-emerald-700">Bina Siswa</h2>
                    <p class="text-sm text-gray-500 mt-2">
                        <span x-text="selectedStudent?.name"></span> - <span class="font-mono" x-text="selectedStudent?.nis"></span>
                    </p>
                    <p class="text-xs font-semibold text-red-600 mt-1">Total Poin Saat Ini: <span x-text="selectedStudent?.total_poin ?? 0"></span></p>
                </div>
                <button @click="drawerOpen = false" class="p-2 text-gray-400 hover:text-red-500 transition hover:bg-red-50 rounded-lg shrink-0">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <div class="flex-1 overflow-y-auto p-6 space-y-5">
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Tindakan Pembinaan</label>
                    <div x-data="{
                        open: false,
                        options: [
                            { value: 'Teguran Lisan & Nasihat', label: 'Teguran Lisan & Nasihat' },
                            { value: 'Membersihkan Area Sekolah', label: 'Membersihkan Area Sekolah (Pertaubatan)' },
                            { value: 'Membaca Buku & Merangkum', label: 'Membaca Buku & Merangkum (Pertaubatan)' },
                            { value: 'Salat Dhuha / Ibadah Tambahan', label: 'Salat Dhuha / Ibadah Tambahan' },
                            { value: 'Pemanggilan Orang Tua / Wali', label: 'Pemanggilan Orang Tua / Wali (Khusus BK)' },
                            { value: 'Konseling Mendalam', label: 'Konseling Mendalam (Khusus BK)' }
                        ],
                        get currentLabel() {
                            let selected = this.options.find(o => o.value === (typeof formPembinaan !== 'undefined' ? formPembinaan.tindakan : ''));
                            return selected ? selected.label : 'Pilih Tindakan...';
                        }
                    }" class="relative w-full" @click.outside="open = false">

                        <button type="button" @click="open = !open"
                            class="w-full pl-4 pr-10 py-2.5 text-left border bg-white focus:outline-none transition-all flex items-center justify-between relative z-10"
                            :class="open ? 'rounded-t-xl border-emerald-500 ring-2 ring-emerald-500/20 border-b-transparent' : 'rounded-xl border-gray-200 hover:border-emerald-500/50'">
                            <span x-text="currentLabel" class="block truncate text-sm" :class="currentLabel === 'Pilih Tindakan...' ? 'text-gray-400' : 'text-gray-700'"></span>
                            <span class="absolute inset-y-0 right-0 flex flex-col justify-center pr-3 pointer-events-none text-gray-500">
                                <i data-lucide="chevron-down" class="w-4 h-4 transition-transform duration-300 ease-in-out" :class="open ? 'rotate-180' : ''"></i>
                            </span>
                        </button>

                        <div x-show="open" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="transform opacity-0 -translate-y-2" x-transition:enter-end="transform opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="transform opacity-100 translate-y-0" x-transition:leave-end="transform opacity-0 -translate-y-2"
                            class="absolute z-20 -mt-[2px] w-full bg-white shadow-[0_10px_20px_-5px_rgba(0,0,0,0.1)] rounded-b-xl border border-t-0 border-emerald-500 overflow-hidden"
                            style="display: none;">
                            <ul class="py-1 max-h-48 overflow-auto">
                                <template x-for="option in options" :key="option.value">
                                    <li @click="if(typeof formPembinaan !== 'undefined') { formPembinaan.tindakan = option.value; open = false; }"
                                        class="cursor-pointer select-none relative py-2.5 pl-4 pr-9 text-sm hover:bg-emerald-50/80 transition-colors duration-150"
                                        :class="(typeof formPembinaan !== 'undefined' ? formPembinaan.tindakan : '') === option.value ? 'bg-emerald-50 text-emerald-700 font-semibold' : 'text-gray-700'">
                                        <span x-text="option.label" class="block truncate"></span>
                                        <span x-show="(typeof formPembinaan !== 'undefined' ? formPembinaan.tindakan : '') === option.value"
                                            class="absolute inset-y-0 right-0 flex items-center pr-3 text-emerald-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                                <polyline points="20 6 9 17 4 12"></polyline>
                                            </svg>
                                        </span>
                                    </li>
                                </template>
                            </ul>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Feedback / Hasil Evaluasi</label>
                    <textarea x-model="formPembinaan.feedback" rows="3" 
                        @input="$el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'"
                        placeholder="Siswa menyadari kesalahannya dan berjanji..." 
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition-all placeholder:text-gray-400 resize-none text-sm overflow-hidden"></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Pengurangan Poin (Reward Taubat)</label>
                    <input type="number" x-model="formPembinaan.pengurangan_poin" min="0" :max="selectedStudent?.total_poin ?? 0" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition-all text-sm bg-white" placeholder="Contoh: 5">
                    <p class="text-xs text-gray-500 mt-1">Isi 0 jika tidak ada pengurangan poin.</p>
                </div>
            </div>

            <div class="px-6 py-5 border-t border-gray-100 bg-gray-50 flex gap-3">
                <button @click="drawerOpen = false" class="flex-1 px-4 py-2.5 bg-white border border-gray-200 text-gray-700 rounded-xl font-medium hover:bg-gray-100 transition shadow-sm">Batal</button>
                
                <button @click="submitPembinaan()" 
                    :disabled="(typeof isLoadingPembinaan !== 'undefined' && isLoadingPembinaan) || (typeof formPembinaan !== 'undefined' && !formPembinaan.tindakan)" 
                    class="flex-[2] px-4 py-2.5 bg-emerald-600 text-white rounded-xl font-medium hover:bg-emerald-700 shadow-lg shadow-emerald-600/20 transition flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
                    <i x-show="typeof isLoadingPembinaan === 'undefined' || !isLoadingPembinaan" data-lucide="save" class="w-4 h-4"></i>
                    <svg x-show="typeof isLoadingPembinaan !== 'undefined' && isLoadingPembinaan" class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    <span x-text="(typeof isLoadingPembinaan !== 'undefined' && isLoadingPembinaan) ? 'Menyimpan...' : 'Simpan Pembinaan'"></span>
                </button>
            </div>
        </div>
    </div>

    <div x-show="drawerOpen && drawerMode === 'tindakSP'" class="relative z-50" style="z-index: 100; display: none;">
        <div x-show="drawerOpen" @click="drawerOpen = false" class="fixed inset-0 bg-[#37517e]/20 backdrop-blur-sm transition-opacity"></div>
        <div x-show="drawerOpen" class="fixed inset-y-0 right-0 w-full sm:w-[500px] bg-white shadow-2xl flex flex-col h-full border-l border-gray-100"
            x-transition:enter="transition transform ease-out duration-300" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
            x-transition:leave="transition transform ease-in duration-200" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full">

            <div class="px-6 py-5 border-b border-gray-100 flex items-start justify-between bg-red-50/50">
                <div class="pr-4">
                    <h2 class="text-xl font-bold text-red-700">Tindak Lanjut Kesiswaan</h2>
                    <p class="text-sm text-gray-500 mt-2">
                        <span x-text="selectedStudent?.name"></span> - <span class="font-mono" x-text="selectedStudent?.nis"></span>
                    </p>
                    <p class="text-xs font-semibold text-red-600 mt-1">Total Poin Saat Ini: <span x-text="selectedStudent?.total_poin ?? 0"></span></p>
                </div>
                <button @click="drawerOpen = false" class="p-2 text-gray-400 hover:text-red-500 transition hover:bg-red-50 rounded-lg shrink-0">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <div class="flex-1 overflow-y-auto p-6 space-y-5">
                <div class="bg-red-50 border border-red-200 rounded-xl p-4 flex items-center gap-3 mb-4">
                    <div class="p-2 bg-red-100 rounded-full"><i data-lucide="alert-triangle" class="w-5 h-5 text-red-600"></i></div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-red-800">Rekomendasi Tindakan</p>
                        <p class="text-lg font-bold text-red-900" x-text="(selectedStudent?.total_poin ?? 0) >= 51 ? 'Surat Peringatan 2 (SP 2) & Panggilan Ortu' : 'Surat Peringatan 1 (SP 1)'"></p>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Tindakan Kesiswaan</label>
                    <div x-data="{
                        open: false,
                        options: [
                            { value: 'Penerbitan SP 1', label: 'Penerbitan Surat Peringatan 1 (SP 1)' },
                            { value: 'Penerbitan SP 2 & Pemanggilan Ortu', label: 'Penerbitan SP 2 & Pemanggilan Orang Tua' },
                            { value: 'Penerbitan SP 3 / Skorsing', label: 'Penerbitan SP 3 / Skorsing' }
                        ],
                        get currentLabel() {
                            let selected = this.options.find(o => o.value === (typeof formPembinaan !== 'undefined' ? formPembinaan.tindakan : ''));
                            return selected ? selected.label : 'Pilih Tindakan...';
                        }
                    }" class="relative w-full" @click.outside="open = false">

                        <button type="button" @click="open = !open"
                            class="w-full pl-4 pr-10 py-2.5 text-left border bg-white focus:outline-none transition-all flex items-center justify-between relative z-10"
                            :class="open ? 'rounded-t-xl border-red-500 ring-2 ring-red-500/20 border-b-transparent' : 'rounded-xl border-gray-200 hover:border-red-500/50'">
                            <span x-text="currentLabel" class="block truncate text-sm" :class="currentLabel === 'Pilih Tindakan...' ? 'text-gray-400' : 'text-gray-700'"></span>
                            <span class="absolute inset-y-0 right-0 flex flex-col justify-center pr-3 pointer-events-none text-gray-500">
                                <i data-lucide="chevron-down" class="w-4 h-4 transition-transform duration-300 ease-in-out" :class="open ? 'rotate-180' : ''"></i>
                            </span>
                        </button>

                        <div x-show="open" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="transform opacity-0 -translate-y-2" x-transition:enter-end="transform opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="transform opacity-100 translate-y-0" x-transition:leave-end="transform opacity-0 -translate-y-2"
                            class="absolute z-20 -mt-[2px] w-full bg-white shadow-[0_10px_20px_-5px_rgba(0,0,0,0.1)] rounded-b-xl border border-t-0 border-red-500 overflow-hidden"
                            style="display: none;">
                            <ul class="py-1 max-h-48 overflow-auto">
                                <template x-for="option in options" :key="option.value">
                                    <li @click="if(typeof formPembinaan !== 'undefined') { formPembinaan.tindakan = option.value; open = false; }"
                                        class="cursor-pointer select-none relative py-2.5 pl-4 pr-9 text-sm hover:bg-red-50/80 transition-colors duration-150"
                                        :class="(typeof formPembinaan !== 'undefined' ? formPembinaan.tindakan : '') === option.value ? 'bg-red-50 text-red-700 font-semibold' : 'text-gray-700'">
                                        <span x-text="option.label" class="block truncate"></span>
                                        <span x-show="(typeof formPembinaan !== 'undefined' ? formPembinaan.tindakan : '') === option.value"
                                            class="absolute inset-y-0 right-0 flex items-center pr-3 text-red-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                                <polyline points="20 6 9 17 4 12"></polyline>
                                            </svg>
                                        </span>
                                    </li>
                                </template>
                            </ul>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Catatan Tambahan (Feedback)</label>
                    <textarea x-model="formPembinaan.feedback" rows="3" 
                        @input="$el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'"
                        placeholder="Alasan SP dikeluarkan..." 
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-red-500 focus:ring-2 focus:ring-red-500/20 outline-none transition-all placeholder:text-gray-400 resize-none text-sm overflow-hidden"></textarea>
                </div>
            </div>

            <div class="px-6 py-5 border-t border-gray-100 bg-gray-50 flex gap-3">
                <button @click="drawerOpen = false" class="flex-1 px-4 py-2.5 bg-white border border-gray-200 text-gray-700 rounded-xl font-medium hover:bg-gray-100 transition shadow-sm">Batal</button>
                <button @click="submitPembinaan()" 
                    :disabled="(typeof isLoadingPembinaan !== 'undefined' && isLoadingPembinaan) || (typeof formPembinaan !== 'undefined' && !formPembinaan.tindakan)" 
                    class="flex-[2] px-4 py-2.5 bg-red-600 text-white rounded-xl font-medium hover:bg-red-700 shadow-lg shadow-red-600/20 transition flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
                    <i x-show="typeof isLoadingPembinaan === 'undefined' || !isLoadingPembinaan" data-lucide="send" class="w-4 h-4"></i>
                    <svg x-show="typeof isLoadingPembinaan !== 'undefined' && isLoadingPembinaan" class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    <span x-text="(typeof isLoadingPembinaan !== 'undefined' && isLoadingPembinaan) ? 'Menyimpan...' : 'Catat Tindakan'"></span>
                </button>
            </div>
        </div>
    </div>

    <!-- FULLSCREEN IMAGE MODAL -->
    <div x-show="fullscreenImage" @click="fullscreenImage = null"
        class="fixed inset-0 z-[200] bg-black/90 flex items-center justify-center p-4"
        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" style="display: none;">

        <button @click.stop="fullscreenImage = null"
            class="absolute top-4 right-4 p-3 bg-white/10 hover:bg-white/20 text-white rounded-full backdrop-blur-sm transition z-10">
            <i data-lucide="x" class="w-6 h-6"></i>
        </button>

        <img :src="fullscreenImage" @click.stop class="max-w-full max-h-full object-contain rounded-lg shadow-2xl"
            alt="Foto Bukti Fullscreen">
    </div>
</div>
