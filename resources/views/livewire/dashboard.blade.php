<div>
    <x-slot name="header">Overview Statistik</x-slot>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="gsap-card opacity-0 translate-y-10 bg-white p-6 rounded-2xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] border border-gray-100 flex items-center transition-transform hover:-translate-y-1 duration-300">
        <div class="p-4 rounded-xl bg-blue-50 text-blue-600 mr-4">
            <i data-lucide="users" class="w-6 h-6"></i>
        </div>
        <div>
            <p class="text-sm text-gray-500 font-medium">Total Siswa</p>
            <h3 class="counter text-2xl font-bold text-gray-800 mt-1" data-target="1240">0</h3>
        </div>
    </div>
    <div class="gsap-card opacity-0 translate-y-10 bg-white p-6 rounded-2xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] border border-gray-100 flex items-center transition-transform hover:-translate-y-1 duration-300">
        <div class="p-4 rounded-xl bg-emerald-50 text-emerald-600 mr-4">
            <i data-lucide="user-check" class="w-6 h-6"></i>
        </div>
        <div>
            <p class="text-sm text-gray-500 font-medium">Hadir Hari Ini</p>
            <div class="flex items-end gap-2 mt-1">
                <h3 class="counter text-2xl font-bold text-gray-800" data-target="1180">0</h3>
                <span class="text-xs text-emerald-600 font-bold bg-emerald-100 px-2 py-0.5 rounded-full mb-1">+95%</span>
            </div>
        </div>
    </div>
    <div class="gsap-card opacity-0 translate-y-10 bg-white p-6 rounded-2xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] border border-gray-100 flex items-center transition-transform hover:-translate-y-1 duration-300">
        <div class="p-4 rounded-xl bg-orange-50 text-orange-600 mr-4">
            <i data-lucide="clipboard" class="w-6 h-6"></i>
        </div>
        <div>
            <p class="text-sm text-gray-500 font-medium">Izin / Sakit</p>
            <h3 class="counter text-2xl font-bold text-gray-800 mt-1" data-target="45">0</h3>
        </div>
    </div>
    <div class="gsap-card opacity-0 translate-y-10 bg-white p-6 rounded-2xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] border border-gray-100 flex items-center transition-transform hover:-translate-y-1 duration-300">
        <div class="p-4 rounded-xl bg-red-50 text-red-600 mr-4">
            <i data-lucide="alert-circle" class="w-6 h-6"></i>
        </div>
        <div>
            <p class="text-sm text-gray-500 font-medium">Tanpa Keterangan</p>
            <h3 class="counter text-2xl font-bold text-gray-800 mt-1" data-target="15">0</h3>
        </div>
    </div>
</div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <div class="gsap-chart opacity-0 translate-y-10 lg:col-span-2 bg-white p-6 rounded-2xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] border border-gray-100">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Tren Kehadiran</h3>
                    <p class="text-sm text-gray-400">Statistik kehadiran 7 hari terakhir</p>
                </div>
                <button class="p-2 hover:bg-gray-100 rounded-lg text-gray-400 transition">
                    <i data-lucide="more-horizontal" class="w-5 h-5"></i>
                </button>
            </div>

            <div id="chart-attendance" class="w-full h-[350px]"></div>
        </div>

        <div class="gsap-chart opacity-0 translate-y-10 bg-white p-6 rounded-2xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] border border-gray-100 flex flex-col justify-between">
            <h3 class="text-lg font-bold text-gray-800 mb-2">Persentase Hari Ini</h3>

            <div class="relative flex items-center justify-center h-full min-h-[300px]">
                <div id="chart-pie" class="w-full flex justify-center"></div>
            </div>
        </div>
    </div>
</div>