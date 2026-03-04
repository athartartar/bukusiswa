<div>
    <x-slot name="header">Overview Statistik</x-slot>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div
            class="gsap-card opacity-0 translate-y-10 bg-white p-6 rounded-2xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] border border-gray-100 flex items-center justify-between transition-transform hover:-translate-y-1 duration-300">
            <div class="flex items-center">
                <div class="p-4 rounded-xl bg-blue-50 text-blue-600 mr-4">
                    <i data-lucide="bell" class="w-6 h-6"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium">Status Notifikasi</p>

                    <div id="notif-container" class="mt-1">
                        @if (empty(auth()->user()->fcm_token))
                            <button id="btn-get-token"
                                class="text-sm bg-[#37517e] hover:bg-[#2c435f] text-white font-semibold py-2 px-3 rounded-lg transition-colors">
                                Kaitkan HP
                            </button>
                            <p id="notif-status" class="hidden text-sm font-bold text-green-600 mt-1">
                                Aktif
                            </p>
                        @else
                            <p class="text-sm font-bold text-green-600 mt-1">
                                Aktif
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div
            class="gsap-card opacity-0 translate-y-10 bg-white p-6 rounded-2xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] border border-gray-100 flex items-center transition-transform hover:-translate-y-1 duration-300">
            <div class="p-4 rounded-xl bg-emerald-50 text-emerald-600 mr-4">
                <i data-lucide="user-check" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Hadir Hari Ini</p>
                <div class="flex items-end gap-2 mt-1">
                    <h3 class="counter text-2xl font-bold text-gray-800" data-target="1180">0</h3>
                    <span
                        class="text-xs text-emerald-600 font-bold bg-emerald-100 px-2 py-0.5 rounded-full mb-1">+95%</span>
                </div>
            </div>
        </div>
        <div
            class="gsap-card opacity-0 translate-y-10 bg-white p-6 rounded-2xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] border border-gray-100 flex items-center transition-transform hover:-translate-y-1 duration-300">
            <div class="p-4 rounded-xl bg-orange-50 text-orange-600 mr-4">
                <i data-lucide="clipboard" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Izin / Sakit</p>
                <h3 class="counter text-2xl font-bold text-gray-800 mt-1" data-target="45">0</h3>
            </div>
        </div>
        <div
            class="gsap-card opacity-0 translate-y-10 bg-white p-6 rounded-2xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] border border-gray-100 flex items-center transition-transform hover:-translate-y-1 duration-300">
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

        <div
            class="gsap-chart opacity-0 translate-y-10 lg:col-span-2 bg-white p-6 rounded-2xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] border border-gray-100">
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

        <div
            class="gsap-chart opacity-0 translate-y-10 bg-white p-6 rounded-2xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] border border-gray-100 flex flex-col justify-between">
            <h3 class="text-lg font-bold text-gray-800 mb-2">Persentase Hari Ini</h3>

            <div class="relative flex items-center justify-center h-full min-h-[300px]">
                <div id="chart-pie" class="w-full flex justify-center"></div>
            </div>
        </div>
    </div>
    <script src="https://www.gstatic.com/firebasejs/10.8.0/firebase-app-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/10.8.0/firebase-messaging-compat.js"></script>
    <script>
        const firebaseConfig = {
            apiKey: "AIzaSyCCS4tA3AS-faG_yW6ELauREM1S-O4z5cQ",
            authDomain: "bukusiswa-ec0d6.firebaseapp.com",
            projectId: "bukusiswa-ec0d6",
            storageBucket: "bukusiswa-ec0d6.firebasestorage.app",
            messagingSenderId: "551546808094",
            appId: "1:551546808094:web:c4b939883e0048947acb0f",
            measurementId: "G-ZTVNYKER5N",
        };

        firebase.initializeApp(firebaseConfig);
        const messaging = firebase.messaging();

        document.getElementById('btn-get-token').addEventListener('click', async function() {
            const btn = this;

            // 1. Ubah tombol jadi mode Loading & Disable
            btn.disabled = true;
            btn.classList.add('opacity-70', 'cursor-not-allowed');
            btn.innerHTML =
                `<svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Memproses...`;

            // Fungsi bantuan untuk mengembalikan tombol ke semula jika terjadi error
            const resetButton = () => {
                btn.disabled = false;
                btn.classList.remove('opacity-70', 'cursor-not-allowed');
                btn.innerHTML = 'Kaitkan HP';
            };

            try {
                const permission = await Notification.requestPermission();
                if (permission === 'granted') {
                    // 1. REGISTER SERVICE WORKER MANUAL
                    const registration = await navigator.serviceWorker.register('/firebase-messaging-sw.js');
                    console.log('Service Worker registered:', registration);

                    // MASUKKAN VAPID KEY KAMU DARI LANGKAH 2 DI SINI
                    const currentToken = await messaging.getToken({
                        vapidKey: "BGRfozH_HZq4xNbT6P3qgbgxF1skMLHkCWjGSjEef0eqPCpqoFmkGWoyaTB6-IzxaSPjVP0mJR7y0xMeIfj8kM0",
                        serviceWorkerRegistration: registration
                    });

                    if (currentToken) {
                        console.log('FCM Token:', currentToken);

                        // Kirim token ke database lewat AJAX
                        fetch('{{ route('saveToken') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    token: currentToken
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                console.log(data);
                                // Karena sukses, hilangkan tombolnya dan munculkan tulisan Aktif
                                document.getElementById('btn-get-token').classList.add('hidden');
                                document.getElementById('notif-status').classList.remove('hidden');
                                if (typeof lucide !== 'undefined') {
                                    lucide.createIcons();
                                }
                            }).catch(err => {
                                console.error(err);
                                resetButton(); // Balikkan tombol jika gagal simpan ke DB
                            });

                    } else {
                        alert('Gagal mendapatkan token.');
                        resetButton(); // Balikkan tombol
                    }
                } else {
                    alert("Kamu harus mengizinkan notifikasi browser untuk HP ini!");
                    resetButton(); // Balikkan tombol
                }
            } catch (error) {
                console.error('Error FCM:', error);
                alert('Terjadi kesalahan: ' + error.message);
                resetButton(); // Balikkan tombol
            }
        });

        messaging.onMessage((payload) => {
            console.log("Notif masuk saat web terbuka: ", payload);

            // Munculkan Toaster (bukan SweetAlert pop-up tengah) biar konsisten dan rapi
            Swal.fire({
                toast: true,
                position: 'top', // Sengaja di 'top' biar kelihatan jelas di HP
                showConfirmButton: false,
                timer: 5000, // Tampil 5 detik
                timerProgressBar: true,
                icon: 'warning',
                title: payload.notification.title,
                text: payload.notification.body,
                background: '#fff',
                color: '#37517e',
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });

            // Opsional: Bikin getar HP secara manual (jalan di Android)
            if (navigator.vibrate) {
                navigator.vibrate([200, 100, 200]);
            }
        });
    </script>
</div>
