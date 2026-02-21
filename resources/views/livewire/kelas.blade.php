<div x-data='kelasData(
    @json($kelases),
    "{{ route('kelas.store') }}",
    "{{ csrf_token() }}"
)'
    class="w-full max-w-7xl mx-auto font-sans text-gray-800">

    <x-slot name="header">Manajemen Data Kelas</x-slot>

    {{-- HEADER & SEARCH --}}
    <div class="flex flex-col md:flex-row justify-between items-stretch md:items-center gap-4 mb-6">
        <div class="gsap-card opacity-0 translate-y-10 w-full md:w-80 relative group">
            <div
                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-[#37517e] transition-colors">
                <i data-lucide="search" class="w-5 h-5"></i>
            </div>
            <input type="text" x-model="search"
                class="block w-full pl-10 pr-3 py-2.5 border border-gray-200 rounded-xl leading-5 bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#37517e]/20 focus:border-[#37517e] text-sm shadow-sm transition-all"
                placeholder="Cari Kode Kelas...">
        </div>

        <div class="grid grid-cols-2 md:flex md:items-center gap-3 w-full md:w-auto">
            {{-- DROPDOWN ROWS PER PAGE --}}
            <div x-data="{
                open: false,
                options: [5, 10, 25, 50]
            }" class="gsap-card opacity-0 translate-y-10 relative group w-full md:w-auto"
                @click.outside="open = false">

                <button type="button" @click="open = !open"
                    class="w-full md:w-36 pl-4 pr-10 py-2.5 text-left border bg-white focus:outline-none transition-all flex items-center justify-between relative z-10"
                    :class="open ? 'rounded-t-xl border-[#37517e] ring-2 ring-[#37517e]/20 border-b-transparent' :
                        'rounded-xl border-gray-200 group-hover:border-[#37517e]/50'">
                    <span x-text="rowsPerPage + ' Baris'" class="block truncate font-medium text-gray-700">
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

            {{-- TOMBOL TAMBAH --}}
            <button @click="openDrawer('add')"
                class="gsap-card opacity-0 translate-y-10 w-full md:w-auto flex items-center justify-center gap-2 bg-[#37517e] hover:bg-[#2a3f63] text-white px-4 sm:px-5 py-2.5 rounded-xl font-medium shadow-lg shadow-[#37517e]/20 transition-all hover:scale-[1.02] active:scale-95 text-sm sm:text-base">
                <i data-lucide="plus-circle" class="w-5 h-5"></i>
                <span>Tambah Kelas</span>
            </button>
        </div>
    </div>

    {{-- TABLE --}}
    <div
        class="gsap-card opacity-0 translate-y-10 bg-white rounded-2xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] border border-gray-100 overflow-hidden flex flex-col">
        <div class="overflow-x-auto custom-scrollbar">
            <table class="w-full text-left border-collapse min-w-[600px]">
                <thead>
                    <tr
                        class="bg-gray-50/50 border-b border-gray-100 text-xs uppercase text-gray-500 font-semibold tracking-wider">
                        <th class="px-6 py-4 sm:py-5 cursor-pointer hover:bg-gray-100 transition select-none group"
                            @click="sortBy('kode_kelas')">
                            <div class="flex items-center gap-2">Kode Kelas <i data-lucide="arrow-up-down"
                                    class="w-3 h-3 text-gray-300 group-hover:text-gray-500"></i></div>
                        </th>
                        <th class="px-6 py-4 sm:py-5 text-center w-40 cursor-pointer hover:bg-gray-100 transition select-none group"
                            @click="sortBy('status')">
                            <div class="flex justify-center items-center gap-2">Status <i data-lucide="arrow-up-down"
                                    class="w-3 h-3 text-gray-300 group-hover:text-gray-500"></i></div>
                        </th>
                        <th class="px-6 py-4 sm:py-5 text-right w-32">Opsi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    <template x-for="item in paginatedKelas" :key="item.id">
                        <tr class="group hover:bg-blue-50/30 transition-colors duration-200">
                            <td class="px-6 py-4">
                                <span class="font-bold text-gray-800 text-sm sm:text-base whitespace-nowrap"
                                    x-text="item.kode_kelas"></span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold"
                                    :class="item.status === 'Aktif' ? 'bg-green-100 text-green-700' :
                                        'bg-red-100 text-red-700'"
                                    x-text="item.status"></span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <button @click="openDrawer('edit', item)"
                                        class="p-2 text-[#37517e] bg-white hover:bg-[#37517e] hover:text-white rounded-lg border border-gray-200 shadow-sm transition-all"
                                        title="Edit">
                                        <i data-lucide="edit-3" class="w-4 h-4"></i>
                                    </button>
                                    <button @click="openDrawer('delete', item)"
                                        class="p-2 text-red-600 bg-white hover:bg-red-600 hover:text-white rounded-lg border border-gray-200 shadow-sm transition-all"
                                        title="Hapus">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </template>
                    <template x-if="paginatedKelas.length === 0">
                        <tr>
                            <td colspan="3" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="bg-gray-50 p-4 rounded-full mb-3"><i data-lucide="search-x"
                                            class="w-8 h-8 text-gray-400"></i></div>
                                    <h3 class="text-gray-900 font-medium">Data tidak ditemukan</h3>
                                    <p class="text-gray-500 text-sm mt-1">Coba kata kunci lain atau tambahkan data
                                        baru.</p>
                                </div>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        <div
            class="px-6 py-4 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-4 bg-gray-50/50">
            <span class="text-xs sm:text-sm text-gray-500 order-2 sm:order-1">
                Menampilkan <b x-text="paginatedKelas.length"></b> dari <span x-text="filteredKelas.length"></span>
                kelas
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

                <button @click="currentPage < totalPages ? currentPage++ : null" :disabled="currentPage === totalPages"
                    class="px-3 py-2 rounded-md border border-gray-200 bg-white text-gray-500 hover:bg-gray-100 disabled:opacity-50 disabled:cursor-not-allowed transition">
                    <i data-lucide="chevron-right" class="w-4 h-4"></i>
                </button>
            </div>
        </div>
    </div>

    {{-- DRAWER (SIDEBAR FORM) --}}
    <div x-show="drawerOpen" class="relative z-50" style="z-index: 100; display: none;">
        <div x-show="drawerOpen" @click="drawerOpen = false"
            class="fixed inset-0 bg-[#37517e]/20 backdrop-blur-sm transition-opacity"></div>
        <div x-show="drawerOpen"
            class="fixed inset-y-0 right-0 w-full sm:w-[400px] bg-white shadow-2xl flex flex-col h-full border-l border-gray-100"
            x-transition:enter="transition transform ease-out duration-300"
            x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
            x-transition:leave="transition transform ease-in duration-200" x-transition:leave-start="translate-x-0"
            x-transition:leave-end="translate-x-full">

            <div class="px-6 py-5 border-b border-gray-100 flex items-start justify-between"
                :class="drawerMode === 'delete' ? 'bg-red-50' : 'bg-gray-50/50'">
                <div class="pr-4">
                    <h2 class="text-xl font-bold"
                        :class="drawerMode === 'delete' ? 'text-red-700' : 'text-[#37517e]'" x-text="drawerTitle">
                    </h2>
                    <p class="text-sm text-gray-500 mt-2 leading-relaxed" x-text="drawerDescription"></p>
                </div>
                <button @click="drawerOpen = false"
                    class="p-2 text-gray-400 hover:text-red-500 transition hover:bg-red-50 rounded-lg shrink-0">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <div class="flex-1 overflow-y-auto p-6 space-y-6">
                <div x-show="drawerMode === 'delete'"
                    class="bg-red-50 border border-red-100 rounded-xl p-4 flex gap-3 items-start">
                    <div class="p-2 bg-red-100 rounded-full shrink-0"><i data-lucide="alert-triangle"
                            class="w-5 h-5 text-red-600"></i></div>
                    <div>
                        <h4 class="font-bold text-red-800 text-sm">Peringatan Penting!</h4>
                        <p class="text-sm text-red-700 mt-1">Anda akan menghapus data kelas <b
                                x-text="formData.kode_kelas"></b>. Pastikan ini tindakan yang benar.</p>
                    </div>
                </div>

                <div class="space-y-5" :class="drawerMode === 'delete' ? 'opacity-50 pointer-events-none' : ''">
                    {{-- INPUT KODE KELAS --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Kode Kelas</label>
                        <div class="relative">
                            <input type="text" x-model="formData.kode_kelas" placeholder="X TJKT A"
                                class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 focus:border-[#37517e] focus:ring-2 focus:ring-[#37517e]/20 outline-none uppercase transition-all placeholder:text-gray-400">
                            <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none text-gray-400">
                                <i data-lucide="tag" class="w-4 h-4"></i>
                            </div>
                        </div>
                    </div>

                    {{-- INPUT STATUS (CUSTOM DROPDOWN) --}}
                    <div x-data="{
                        open: false,
                        options: [
                            { value: 'Aktif', label: 'Aktif' },
                            { value: 'Nonaktif', label: 'Nonaktif' }
                        ],
                        get currentLabel() {
                            let selected = this.options.find(o => o.value === formData.status);
                            return selected ? selected.label : 'Pilih Status...';
                        }
                    }" class="relative group" @click.outside="open = false">

                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Status</label>

                        <button type="button" @click="open = !open"
                            class="w-full pl-10 pr-10 py-2.5 text-left border bg-white focus:outline-none transition-all flex items-center justify-between relative z-10"
                            :class="open ? 'rounded-t-xl border-[#37517e] ring-2 ring-[#37517e]/20 border-b-transparent' :
                                'rounded-xl border-gray-200 group-hover:border-[#37517e]/50'">
                            <span x-text="currentLabel" class="block truncate"
                                :class="formData.status ? 'text-gray-900' : 'text-gray-500'">
                            </span>

                            <span
                                class="absolute inset-y-0 right-0 flex flex-col justify-center pr-3 pointer-events-none text-gray-400">
                                <i data-lucide="chevron-down"
                                    class="w-4 h-4 transition-transform duration-300 ease-in-out"
                                    :class="open ? 'rotate-180' : ''"></i>
                            </span>
                        </button>

                        <div
                            class="absolute top-[38px] left-3 flex items-center pointer-events-none text-gray-400 z-20">
                            <i data-lucide="activity" class="w-4 h-4"></i>
                        </div>

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
                                    <li @click="formData.status = option.value; open = false"
                                        class="cursor-pointer select-none relative py-2.5 pl-4 pr-9 text-sm hover:bg-indigo-50/80 transition-colors duration-150"
                                        :class="formData.status === option.value ?
                                            'bg-indigo-50 text-[#37517e] font-semibold' : 'text-gray-700'">

                                        <span x-text="option.label" class="block truncate"></span>

                                        <span x-show="formData.status === option.value"
                                            class="absolute inset-y-0 right-0 flex items-center pr-3 text-[#37517e]">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
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

            <div class="px-6 py-5 border-t border-gray-100 bg-gray-50 flex gap-3">
                <button @click="drawerOpen = false"
                    class="flex-1 px-4 py-2.5 bg-white border border-gray-200 text-gray-700 rounded-xl font-medium hover:bg-gray-100 transition shadow-sm">Batal</button>
                <button x-show="drawerMode !== 'delete'" @click="saveData()" :disabled="isLoading"
                    class="flex-[2] px-4 py-2.5 bg-[#37517e] text-white rounded-xl font-medium hover:bg-[#2a3f63] shadow-lg flex items-center justify-center gap-2 transition disabled:opacity-50">
                    <i x-show="!isLoading" data-lucide="save" class="w-4 h-4"></i>
                    <svg x-show="isLoading" class="animate-spin h-4 w-4 text-white"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    <span x-text="isLoading ? 'Menyimpan...' : 'Simpan Data'"></span>
                </button>
                <button x-show="drawerMode === 'delete'" @click="deleteData()" :disabled="isLoading"
                    class="flex-[2] px-4 py-2.5 bg-red-600 text-white rounded-xl font-medium hover:bg-red-700 shadow-lg flex items-center justify-center gap-2 transition disabled:opacity-50">
                    <i x-show="!isLoading" data-lucide="trash-2" class="w-4 h-4"></i>
                    <span x-text="isLoading ? 'Menghapus...' : 'Ya, Hapus Data'"></span>
                </button>
            </div>
        </div>
    </div>
</div>
