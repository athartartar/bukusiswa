<div x-data='siswaData(
    @json($students),
    @json($kelasOptions),
    "{{ route('siswa.store') }}",
    "{{ csrf_token() }}"
)'
    class="w-full max-w-7xl mx-auto font-sans text-gray-800">

    <x-slot name="header">Manajemen Data Siswa</x-slot>

    <div class="flex flex-col md:flex-row justify-between items-stretch md:items-center gap-4 mb-6">
        <div class="gsap-card opacity-0 translate-y-10 w-full md:w-80 relative group">
            <div
                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-[#37517e] transition-colors">
                <i data-lucide="search" class="w-5 h-5"></i>
            </div>
            <input type="text" x-model="search"
                class="block w-full pl-10 pr-3 py-2.5 border border-gray-200 rounded-xl leading-5 bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#37517e]/20 focus:border-[#37517e] text-sm shadow-sm transition-all"
                placeholder="Cari Nama, NIS...">
        </div>

        <div class="grid grid-cols-2 md:flex md:items-center gap-3 w-full md:w-auto">
            <div x-data="{
                open: false,
                options: [5, 10, 25, 50]
            }" class="gsap-card opacity-0 translate-y-10 relative group w-full md:w-auto"
                @click.outside="open = false">

                <button type="button" @click="open = !open"
                    class="w-full md:w-36 pl-4 pr-10 py-2.5 text-left border bg-white focus:outline-none transition-all flex items-center justify-between relative z-10"
                    :class="open ? 'rounded-t-xl border-[#37517e] ring-2 ring-[#37517e]/20 border-b-transparent' :
                        'rounded-xl border-gray-200 group-hover:border-[#37517e]/50'">
                    <span x-text="rowsPerPage + ' Baris'" class="block truncate font-medium text-gray-700"></span>
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

            <div x-data="{
                previewOpen: false,
                previewData: [],
                isImporting: false,
                handleFileUpload(e) {
                    let file = e.target.files[0];
                    if (!file) return;
            
                    this.isImporting = true;
                    let formData = new FormData();
                    formData.append('file', file);
            
                    fetch('{{ route('siswa.preview') }}', {
                            method: 'POST',
                            body: formData,
                            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                        })
                        .then(res => res.json())
                        .then(data => {
                            this.isImporting = false;
                            if (data.success) {
                                this.previewData = data.data;
                                this.previewOpen = true;
                                e.target.value = '';
                            } else {
                                // Ganti alert dengan Toaster Error
                                Swal.fire({
                                    toast: true,
                                    position: 'top-end',
                                    icon: 'error',
                                    title: data.error,
                                    showConfirmButton: false,
                                    timer: 3000,
                                    timerProgressBar: true
                                });
                            }
                        })
                        .catch(err => {
                            this.isImporting = false;
                            // Ganti alert dengan Toaster Error
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'error',
                                title: 'Terjadi kesalahan saat membaca file.',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true
                            });
                        });
                },
                confirmImport() {
                    this.isLoading = true;
                    fetch('{{ route('siswa.storeBatch') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ data: this.previewData })
                        })
                        .then(res => res.json())
                        .then(data => {
                            this.isLoading = false;
                            if (data.success) {
                                // Tampilkan Toaster Sukses
                                Swal.fire({
                                    toast: true,
                                    position: 'top-end',
                                    icon: 'success',
                                    title: data.success,
                                    showConfirmButton: false,
                                    timer: 2000, // Tampil selama 2 detik
                                    timerProgressBar: true
                                });
            
                                // Beri jeda 2 detik agar toaster terlihat, baru reload halaman
                                setTimeout(() => {
                                    window.location.reload();
                                }, 2000);
            
                            } else {
                                // Ganti alert dengan Toaster Error
                                Swal.fire({
                                    toast: true,
                                    position: 'top-end',
                                    icon: 'error',
                                    title: data.error,
                                    showConfirmButton: false,
                                    timer: 3000,
                                    timerProgressBar: true
                                });
                            }
                        })
                        .catch(err => {
                            this.isLoading = false;
                            // Ganti alert dengan Toaster Error
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'error',
                                title: 'Gagal menyimpan data batch.',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true
                            });
                        });
                }
            }" class="relative group w-full md:w-auto z-20" @click.outside="open = false">

                <div x-data="{ open: false }" class="relative group w-full md:w-auto z-20" @click.outside="open = false">
                    <button @click="open = !open"
                        class="gsap-card opacity-0 translate-y-10 w-full md:w-auto flex items-center justify-center gap-2 bg-[#37517e] hover:bg-[#2a3f63] text-white px-4 sm:px-5 py-2.5 rounded-xl font-medium shadow-lg shadow-[#37517e]/20 transition-all hover:scale-[1.02] active:scale-95 text-sm sm:text-base">
                        <i data-lucide="plus-circle" class="w-5 h-5"></i>
                        <span>Kelola Data</span>
                        <i data-lucide="chevron-down" class="w-4 h-4 ml-1 transition-transform"
                            :class="open ? 'rotate-180' : ''"></i>
                    </button>

                    <div x-show="open" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="transform opacity-0 -translate-y-2"
                        x-transition:enter-end="transform opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="transform opacity-100 translate-y-0"
                        x-transition:leave-end="transform opacity-0 -translate-y-2"
                        class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-xl border border-gray-100 overflow-hidden z-50"
                        style="display: none;">
                        <button @click="openDrawer('add'); open = false"
                            class="w-full text-left px-4 py-3 text-sm text-gray-700 hover:bg-indigo-50 flex items-center gap-2 transition-colors">
                            <i data-lucide="user-plus" class="w-4 h-4 text-[#37517e]"></i>
                            Tambah Manual
                        </button>

                        <a href="{{ route('siswa.template') }}"
                            class="w-full text-left px-4 py-3 text-sm text-gray-700 hover:bg-indigo-50 flex items-center gap-2 transition-colors">
                            <i data-lucide="file-spreadsheet" class="w-4 h-4 text-green-600"></i>
                            Download Template
                        </a>

                        <div class="relative border-t border-gray-100">
                            <input type="file" accept=".xlsx, .xls, .csv" @change="handleFileUpload"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                            <button
                                class="w-full text-left px-4 py-3 text-sm text-gray-700 hover:bg-indigo-50 flex items-center gap-2 transition-colors">
                                <i x-show="!isImporting" data-lucide="upload" class="w-4 h-4 text-blue-600"></i>
                                <svg x-show="isImporting" class="animate-spin h-4 w-4 text-blue-600"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                                <span x-text="isImporting ? 'Memproses...' : 'Import Excel'"></span>
                            </button>
                        </div>

                        <a href="{{ route('siswa.export') }}" @click="open = false"
                            class="w-full text-left px-4 py-3 text-sm text-gray-700 hover:bg-indigo-50 flex items-center gap-2 transition-colors border-t border-gray-100">
                            <i data-lucide="download" class="w-4 h-4 text-orange-600"></i>
                            Export Semua Data
                        </a>
                    </div>
                </div>
                <template x-teleport="body">
                    <div x-show="previewOpen" class="relative" style="z-index: 100; display: none;">
                        <div x-show="previewOpen" @click="previewOpen = false"
                            class="fixed inset-0 bg-[#37517e]/40 backdrop-blur-sm transition-opacity"></div>

                        <div x-show="previewOpen"
                            class="fixed inset-y-0 right-0 w-full sm:w-[600px] bg-white shadow-2xl flex flex-col h-full border-l border-gray-100"
                            x-transition:enter="transition transform ease-out duration-300"
                            x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
                            x-transition:leave="transition transform ease-in duration-200"
                            x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full">

                            <div
                                class="px-6 py-5 border-b border-gray-100 flex items-start justify-between bg-green-50/50">
                                <div>
                                    <h2 class="text-xl font-bold text-green-700">Preview Import Data</h2>
                                    <p class="text-sm text-gray-500 mt-1">Pastikan data di bawah ini benar sebelum
                                        disimpan.</p>
                                </div>
                                <button @click="previewOpen = false"
                                    class="p-2 text-gray-400 hover:text-red-500 transition hover:bg-red-50 rounded-lg shrink-0">
                                    <i data-lucide="x" class="w-5 h-5"></i>
                                </button>
                            </div>

                            <div class="flex-1 overflow-y-auto p-0">
                                <table class="w-full text-left border-collapse">
                                    <thead class="bg-gray-50 sticky top-0 z-10 shadow-sm">
                                        <tr>
                                            <th
                                                class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                                NIS</th>
                                            <th
                                                class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                                Nama</th>
                                            <th
                                                class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                                Kelas</th>
                                            <th
                                                class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                                L/P</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        <template x-for="(row, index) in previewData" :key="index">
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-4 py-3 text-sm font-mono text-gray-600"
                                                    x-text="row.nis">
                                                </td>
                                                <td class="px-4 py-3 text-sm text-gray-800 font-medium"
                                                    x-text="row.namalengkap"></td>
                                                <td class="px-4 py-3 text-sm text-gray-600">
                                                    <span
                                                        class="bg-indigo-50 text-indigo-700 px-2 py-0.5 rounded text-xs"
                                                        x-text="row.kelas"></span>
                                                </td>
                                                <td class="px-4 py-3 text-sm text-center">
                                                    <span class="font-bold"
                                                        :class="row.jeniskelamin === 'L' ? 'text-blue-600' :
                                                            'text-pink-600'"
                                                        x-text="row.jeniskelamin"></span>
                                                </td>
                                            </tr>
                                        </template>
                                    </tbody>
                                </table>

                                <div x-show="previewData.length === 0" class="p-8 text-center text-gray-500">
                                    Tidak ada data yang terbaca.
                                </div>
                            </div>

                            <div class="px-6 py-5 border-t border-gray-100 bg-gray-50 flex gap-3">
                                <button @click="previewOpen = false"
                                    class="flex-1 px-4 py-2.5 bg-white border border-gray-200 text-gray-700 rounded-xl font-medium hover:bg-gray-100 transition shadow-sm">
                                    Batal
                                </button>

                                <button @click="confirmImport()" :disabled="isLoading || previewData.length === 0"
                                    class="flex-[2] px-4 py-2.5 bg-green-600 text-white rounded-xl font-medium hover:bg-green-700 shadow-lg shadow-green-600/20 transition flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
                                    <i x-show="!isLoading" data-lucide="check-circle" class="w-4 h-4"></i>
                                    <svg x-show="isLoading" class="animate-spin h-4 w-4 text-white"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                            stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                    <span
                                        x-text="isLoading ? 'Menyimpan...' : 'Simpan (' + previewData.length + ') Data'"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <div
        class="gsap-card opacity-0 translate-y-10 bg-white rounded-2xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] border border-gray-100 overflow-hidden flex flex-col">
        <div class="overflow-x-auto custom-scrollbar">
            <table class="w-full text-left border-collapse min-w-[800px]">
                <thead>
                    <tr
                        class="bg-gray-50/50 border-b border-gray-100 text-xs uppercase text-gray-500 font-semibold tracking-wider">
                        <th class="px-6 py-4 sm:py-5 cursor-pointer hover:bg-gray-100 transition select-none group w-32"
                            @click="sortBy('nis')">
                            <div class="flex items-center gap-2">NIS
                                <i data-lucide="arrow-up-down"
                                    class="w-3 h-3 text-gray-300 group-hover:text-gray-500"></i>
                            </div>
                        </th>
                        <th class="px-6 py-4 sm:py-5 cursor-pointer hover:bg-gray-100 transition select-none group"
                            @click="sortBy('name')">
                            <div class="flex items-center gap-2">Nama Lengkap
                                <i data-lucide="arrow-up-down"
                                    class="w-3 h-3 text-gray-300 group-hover:text-gray-500"></i>
                            </div>
                        </th>
                        <th class="px-6 py-4 sm:py-5 cursor-pointer hover:bg-gray-100 transition select-none group"
                            @click="sortBy('class')">
                            <div class="flex items-center gap-2">Kelas
                                <i data-lucide="arrow-up-down"
                                    class="w-3 h-3 text-gray-300 group-hover:text-gray-500"></i>
                            </div>
                        </th>
                        <th class="px-6 py-4 sm:py-5 text-center w-16">L/P</th>
                        <th class="px-6 py-4 sm:py-5 text-right w-32">Opsi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    <template x-for="student in paginatedStudents" :key="student.id">
                        <tr class="group hover:bg-blue-50/30 transition-colors duration-200">
                            <td class="px-6 py-4 font-mono text-sm text-gray-600">
                                <span class="bg-gray-100 px-2 py-1 rounded text-xs whitespace-nowrap"
                                    x-text="student.nis"></span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="font-bold text-gray-800 text-sm sm:text-base whitespace-nowrap"
                                    x-text="student.name"></span>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs font-medium bg-indigo-50 text-indigo-700 border border-indigo-100 whitespace-nowrap"
                                    x-text="student.class"></span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span
                                    class="inline-flex items-center justify-center w-8 h-8 rounded-full text-xs font-bold ring-2 ring-white shadow-sm"
                                    :class="student.gender === 'L' ? 'bg-blue-100 text-blue-700' :
                                        'bg-pink-100 text-pink-700'"
                                    x-text="student.gender"></span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <button @click="openDrawer('edit', student)"
                                        class="p-2 text-[#37517e] bg-white hover:bg-[#37517e] hover:text-white rounded-lg border border-gray-200 shadow-sm transition-all"
                                        title="Edit">
                                        <i data-lucide="edit-3" class="w-4 h-4"></i>
                                    </button>
                                    <button @click="openDrawer('delete', student)"
                                        class="p-2 text-red-600 bg-white hover:bg-red-600 hover:text-white rounded-lg border border-gray-200 shadow-sm transition-all"
                                        title="Hapus">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </template>
                    <template x-if="paginatedStudents.length === 0">
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="bg-gray-50 p-4 rounded-full mb-3">
                                        <i data-lucide="search-x" class="w-8 h-8 text-gray-400"></i>
                                    </div>
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

        <div
            class="px-6 py-4 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-4 bg-gray-50/50">
            <span class="text-xs sm:text-sm text-gray-500 order-2 sm:order-1">
                Menampilkan <b x-text="paginatedStudents.length"></b> dari <span
                    x-text="filteredStudents.length"></span> siswa
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
                        :class="page === currentPage ? 'bg-[#37517e] text-white border-[#37517e] shadow-sm' : (
                            typeof page === 'number' ?
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

    <div x-show="drawerOpen" class="relative z-50" style="z-index: 100; display: none;">
        <div x-show="drawerOpen" @click="drawerOpen = false"
            class="fixed inset-0 bg-[#37517e]/20 backdrop-blur-sm transition-opacity"></div>

        <div x-show="drawerOpen"
            class="fixed inset-y-0 right-0 w-full sm:w-[450px] bg-white shadow-2xl flex flex-col h-full border-l border-gray-100"
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
                    <div class="p-2 bg-red-100 rounded-full shrink-0">
                        <i data-lucide="alert-triangle" class="w-5 h-5 text-red-600"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-red-800 text-sm">Peringatan Penting!</h4>
                        <p class="text-sm text-red-700 mt-1">Anda akan menghapus data atas nama <b
                                x-text="formData.name"></b>. Pastikan ini adalah tindakan yang benar.</p>
                    </div>
                </div>

                <div class="space-y-5" :class="drawerMode === 'delete' ? 'opacity-50 pointer-events-none' : ''">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Nomor Induk Siswa (NIS)</label>
                        <div class="relative">
                            <input type="number" x-model="formData.nis" placeholder="Contoh: 20231001"
                                class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 focus:border-[#37517e] focus:ring-2 focus:ring-[#37517e]/20 outline-none transition-all placeholder:text-gray-400">
                            <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none text-gray-400">
                                <i data-lucide="hash" class="w-4 h-4"></i>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Lengkap</label>
                        <div class="relative">
                            <input type="text" x-model="formData.name"
                                @input="formData.name = formData.name.replace(/\b\w/g, l => l.toUpperCase())"
                                placeholder="Masukkan nama lengkap siswa"
                                class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 focus:border-[#37517e] focus:ring-2 focus:ring-[#37517e]/20 outline-none transition-all placeholder:text-gray-400">
                            <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none text-gray-400">
                                <i data-lucide="user" class="w-4 h-4"></i>
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div x-data="{
                            open: false,
                            searchKls: '', // Pakai nama variabel berbeda agar tidak bentrok dengan pencarian utama
                            get filteredOptions() {
                                if (this.searchKls === '') return optionsKelas; // Ambil dari optionsKelas di script induk
                                return optionsKelas.filter(item => item.toLowerCase().includes(this.searchKls.toLowerCase()));
                            }
                        }" class="relative group" @click.outside="open = false">

                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Kelas</label>

                            <button type="button"
                                @click="open = !open; if(open) $nextTick(() => $refs.searchInputKls.focus())"
                                class="w-full pl-10 pr-10 py-2.5 text-left border bg-white focus:outline-none transition-all flex items-center justify-between relative z-10"
                                :class="open ? 'rounded-t-xl border-[#37517e] ring-2 ring-[#37517e]/20 border-b-transparent' :
                                    'rounded-xl border-gray-200 group-hover:border-[#37517e]/50'">
                                <span x-text="formData.class ? formData.class : 'Pilih Kelas...'"
                                    class="block truncate"
                                    :class="formData.class ? 'text-gray-900' : 'text-gray-500'"></span>
                                <span
                                    class="absolute inset-y-0 right-0 flex flex-col justify-center pr-3 pointer-events-none text-gray-400">
                                    <i data-lucide="chevron-down"
                                        class="w-4 h-4 transition-transform duration-300 ease-in-out"
                                        :class="open ? 'rotate-180' : ''"></i>
                                </span>
                            </button>

                            <div
                                class="absolute top-[38px] left-3 flex items-center pointer-events-none text-gray-400 z-20">
                                <i data-lucide="building" class="w-4 h-4"></i>
                            </div>

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
                                        <input x-ref="searchInputKls" x-model="searchKls" type="text"
                                            class="w-full pl-9 pr-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-[#37517e] focus:ring-1 focus:ring-[#37517e] placeholder-gray-400 bg-gray-50/50"
                                            placeholder="Cari kelas...">
                                        <div
                                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i data-lucide="search" class="w-4 h-4 text-gray-400"></i>
                                        </div>
                                    </div>
                                </div>

                                <ul class="py-1 max-h-56 overflow-auto custom-scrollbar"
                                    style="scrollbar-width: none; -ms-overflow-style: none;">
                                    <style>
                                        ul::-webkit-scrollbar {
                                            display: none;
                                        }
                                    </style>
                                    <template x-for="option in filteredOptions" :key="option">
                                        <li @click="formData.class = option; open = false; searchKls = ''"
                                            class="cursor-pointer select-none relative py-2.5 pl-4 pr-9 text-sm hover:bg-indigo-50/80 transition-colors duration-150"
                                            :class="formData.class === option ? 'bg-indigo-50 text-[#37517e] font-semibold' :
                                                'text-gray-700'">
                                            <span x-text="option" class="block truncate"></span>
                                            <span x-show="formData.class === option"
                                                class="absolute inset-y-0 right-0 flex items-center pr-3 text-[#37517e]">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2.5" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <polyline points="20 6 9 17 4 12"></polyline>
                                                </svg>
                                            </span>
                                        </li>
                                    </template>
                                    <div x-show="filteredOptions.length === 0"
                                        class="px-4 py-6 text-sm text-gray-500 text-center flex flex-col items-center justify-center gap-2">
                                        <i data-lucide="info" class="w-6 h-6 text-gray-300"></i>
                                        <p>Kelas tidak ditemukan.</p>
                                    </div>
                                </ul>
                            </div>
                        </div>
                        <div x-data="{
                            open: false,
                            options: [
                                { value: 'L', label: 'Laki-laki' },
                                { value: 'P', label: 'Perempuan' }
                            ],
                            get currentLabel() {
                                let selected = this.options.find(o => o.value === formData.gender);
                                return selected ? selected.label : 'Pilih Gender...';
                            }
                        }" class="relative group" @click.outside="open = false">

                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Gender</label>

                            <button type="button" @click="open = !open"
                                class="w-full pl-10 pr-10 py-2.5 text-left border bg-white focus:outline-none transition-all flex items-center justify-between relative z-10"
                                :class="open ? 'rounded-t-xl border-[#37517e] ring-2 ring-[#37517e]/20 border-b-transparent' :
                                    'rounded-xl border-gray-200 group-hover:border-[#37517e]/50'">
                                <span x-text="currentLabel" class="block truncate"
                                    :class="formData.gender ? 'text-gray-900' : 'text-gray-500'"></span>
                                <span
                                    class="absolute inset-y-0 right-0 flex flex-col justify-center pr-3 pointer-events-none text-gray-400">
                                    <i data-lucide="chevron-down"
                                        class="w-4 h-4 transition-transform duration-300 ease-in-out"
                                        :class="open ? 'rotate-180' : ''"></i>
                                </span>
                            </button>

                            <div
                                class="absolute top-[38px] left-3 flex items-center pointer-events-none text-gray-400 z-20">
                                <i data-lucide="users" class="w-4 h-4"></i>
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
                                        <li @click="formData.gender = option.value; open = false"
                                            class="cursor-pointer select-none relative py-2.5 pl-4 pr-9 text-sm hover:bg-indigo-50/80 transition-colors duration-150"
                                            :class="formData.gender === option.value ?
                                                'bg-indigo-50 text-[#37517e] font-semibold' : 'text-gray-700'">
                                            <span x-text="option.label" class="block truncate"></span>
                                            <span x-show="formData.gender === option.value"
                                                class="absolute inset-y-0 right-0 flex items-center pr-3 text-[#37517e]">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2.5" stroke-linecap="round"
                                                    stroke-linejoin="round">
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
            </div>

            <div class="px-6 py-5 border-t border-gray-100 bg-gray-50 flex gap-3">
                <button @click="drawerOpen = false"
                    class="flex-1 px-4 py-2.5 bg-white border border-gray-200 text-gray-700 rounded-xl font-medium hover:bg-gray-100 transition shadow-sm">
                    Batal
                </button>

                <button x-show="drawerMode !== 'delete'" @click="saveData()" :disabled="isLoading"
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
                    <span x-text="isLoading ? 'Menyimpan...' : 'Simpan Data'"></span>
                </button>

                <button x-show="drawerMode === 'delete'" @click="deleteData()" :disabled="isLoading"
                    class="flex-[2] px-4 py-2.5 bg-red-600 text-white rounded-xl font-medium hover:bg-red-700 shadow-lg shadow-red-600/20 transition flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
                    <i x-show="!isLoading" data-lucide="trash-2" class="w-4 h-4"></i>
                    <span x-text="isLoading ? 'Menghapus...' : 'Ya, Hapus Data'"></span>
                </button>
            </div>
        </div>
    </div>
</div>
