import "./bootstrap";

import gsap from "gsap";

document.addEventListener("DOMContentLoaded", () => {
    if (window.lucide) {
        lucide.createIcons();
    }
});

window.togglePassword = function () {
    const input = document.getElementById("password");
    const eye = document.getElementById("eye");
    const eyeOff = document.getElementById("eye-closed");

    if (!input) return;

    if (input.type === "password") {
        input.type = "text";
        eye.classList.add("hidden");
        eyeOff.classList.remove("hidden");
    } else {
        input.type = "password";
        eye.classList.remove("hidden");
        eyeOff.classList.add("hidden");
    }
};

document.addEventListener("livewire:initialized", () => {
    lucide.createIcons();
});

document.addEventListener("livewire:initialized", () => {
    Livewire.hook("morph.updated", (el) => {
        lucide.createIcons();
    });
});

// Variabel global untuk menyimpan instance chart biar bisa di-destroy
var chartInstance1 = null;
var chartInstance2 = null;

// Fungsi render chart
function renderCharts() {
    if (chartInstance1) chartInstance1.destroy();
    if (chartInstance2) chartInstance2.destroy();

    // Kehadiran
    var optionsArea = {
        series: [
            { name: "Hadir", data: [1150, 1180, 1190, 1160, 1180, 1200] },
            { name: "Tidak Hadir", data: [90, 60, 50, 80, 60, 40] },
        ],
        chart: {
            height: 320,
            type: "area",
            toolbar: { show: false },
            fontFamily: "Plus Jakarta Sans, sans-serif",
            zoom: { enabled: false },
            animations: {
                enabled: true,
                easing: "easeinout",
                speed: 800, // kecepatan animasi
                animateGradually: { enabled: true, delay: 200 }, // delay antar point
                dynamicAnimation: { enabled: true, speed: 350 },
            },
        },
        colors: ["#37517e", "#ef4444"],
        dataLabels: { enabled: false },
        stroke: { curve: "smooth", width: 3 },
        xaxis: {
            categories: ["Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"],
            axisBorder: { show: false },
            axisTicks: { show: false },
            labels: { style: { colors: "#94a3b8" } },
        },
        yaxis: { labels: { style: { colors: "#94a3b8" } } },
        grid: { borderColor: "#f1f5f9", strokeDashArray: 4 },
        fill: {
            type: "gradient",
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.6,
                opacityTo: 0.05,
                stops: [0, 90, 100],
            },
        },
        legend: { position: "top", horizontalAlign: "right" },
    };

    var elArea = document.querySelector("#chart-attendance");
    if (elArea) {
        chartInstance1 = new ApexCharts(elArea, optionsArea);
        chartInstance1.render();
    }

    // --- CHART 2: DONUT (Persentase) ---
    var optionsDonut = {
        series: [1180, 45, 15],
        labels: ["Hadir", "Izin/Sakit", "Alfa"],
        chart: {
            type: "donut",
            height: 320,
            fontFamily: "Plus Jakarta Sans, sans-serif",
            animations: {
                enabled: true,
                easing: "easeinout",
                speed: 800,
            },
        },
        colors: ["#37517e", "#fb923c", "#ef4444"],
        plotOptions: {
            pie: {
                donut: {
                    size: "75%",
                    labels: {
                        show: true,
                        name: { fontSize: "14px", color: "#64748b" },
                        value: {
                            fontSize: "24px",
                            fontWeight: 700,
                            color: "#1e293b",
                        },
                        total: {
                            show: true,
                            label: "Total Siswa",
                            color: "#64748b",
                            formatter: function (w) {
                                return w.globals.seriesTotals.reduce(
                                    (a, b) => a + b,
                                    0,
                                );
                            },
                        },
                    },
                },
            },
        },
        stroke: { show: false },
        dataLabels: { enabled: false },
        legend: {
            position: "bottom",
            offsetY: 0,
            itemMargin: { horizontal: 10, vertical: 5 },
        },
    };

    var elPie = document.querySelector("#chart-pie");
    if (elPie) {
        chartInstance2 = new ApexCharts(elPie, optionsDonut);
        chartInstance2.render();
    }
}

// --- Delay 2 detik setelah halaman load ---
document.addEventListener("DOMContentLoaded", () => {
    setTimeout(() => {
        renderCharts();
    }, 500);
});

document.addEventListener("livewire:navigated", () => {
    setTimeout(() => {
        renderCharts();
    }, 500);
});

// Animasi Masuk (Initial Load)
document.addEventListener("DOMContentLoaded", function () {
    const kiri = document.getElementById("leftPanel");
    const kanan = document.getElementById("rightPanel");

    gsap.fromTo(
        kiri,
        { x: "-100%", opacity: 0 },
        { x: "0%", opacity: 1, duration: 1.2, ease: "power4.out", delay: 0.2 },
    );

    gsap.fromTo(
        kanan,
        { x: "100%", opacity: 0 },
        { x: "0%", opacity: 1, duration: 1.2, ease: "power4.out", delay: 0.2 },
    );
});

// Animasi Berhasil Login (Exit Animation)
document.addEventListener("livewire:init", () => {
    Livewire.on("loginSuccess", () => {
        const kiri = document.getElementById("leftPanel");
        const kanan = document.getElementById("rightPanel");
        const wrap = document.getElementById("loginWrapper");

        [kiri, kanan].forEach((el) => {
            if (el) el.style.transition = "none";
        });

        const tl = gsap.timeline({
            onComplete: () => {
                window.location.href = "/dashboard";
            },
        });

        tl.to(kiri, {
            xPercent: -100,
            opacity: 0,
            duration: 0.7,
            ease: "expo.in",
        })
            .to(
                kanan,
                {
                    xPercent: 100,
                    opacity: 0,
                    duration: 0.7,
                    ease: "expo.in",
                },
                "<",
            )

            .to(
                wrap,
                {
                    backgroundColor: "#f3f4f6",
                    duration: 0.4,
                },
                "-=0.5",
            );
    });
});
const SESSION_KEY = "dashboard_intro_played";

// 1. Animasi Masuk
document.addEventListener("DOMContentLoaded", function () {
    const sidebar = document.getElementById("sidebar");
    const topbar = document.getElementById("topbar");
    const footbar = document.getElementById("footbar"); // Footbar didefinisikan di sini
    const statCards = document.querySelectorAll(".gsap-card");
    const charts = document.querySelectorAll(".gsap-chart");

    if (!sidebar) return;

    if (!sessionStorage.getItem(SESSION_KEY)) {
        const tlStructure = gsap.timeline({ delay: 0.1 });

        // Animasi Sidebar
        tlStructure
            .to(sidebar, {
                x: "0%",
                opacity: 1,
                duration: 1.0,
                ease: "expo.out",
                onComplete: () => {
                    sidebar.classList.remove("opacity-0", "-translate-x-full");
                    gsap.set(sidebar, { clearProps: "all" });
                },
            })
            // Animasi Topbar
            .to(
                topbar,
                {
                    y: "0%",
                    opacity: 1,
                    duration: 1.0,
                    ease: "expo.out",
                    onComplete: () => {
                        topbar.classList.remove(
                            "opacity-0",
                            "-translate-y-full",
                        );
                        gsap.set(topbar, { clearProps: "all" });
                    },
                },
                "<",
            );

        if (footbar) {
            tlStructure.to(
                footbar,
                {
                    y: "0%",
                    opacity: 1,
                    duration: 0.8,
                    ease: "expo.out",
                },
                "-=0.5",
            );
        }

        sessionStorage.setItem(SESSION_KEY, "true");
    } else {
        if (sidebar) {
            sidebar.classList.remove("opacity-0", "-translate-x-full");
            gsap.set(sidebar, { x: "0%", opacity: 1, clearProps: "all" });
        }

        if (topbar) {
            topbar.classList.remove("opacity-0", "-translate-y-full");
            gsap.set(topbar, { y: "0%", opacity: 1, clearProps: "all" });
        }

        if (footbar) {
            gsap.set(footbar, { y: "0%", opacity: 1 });
        }
    }

    // ANIMASI KONTEN
    const tlContent = gsap.timeline({ delay: 0.4 });

    if (statCards.length > 0) {
        tlContent.to(statCards, {
            y: 0,
            opacity: 1,
            duration: 0.8,
            ease: "power3.out",
            stagger: 0.08,
            onComplete: () => {
                statCards.forEach((el) => {
                    el.classList.remove("opacity-0", "translate-y-10");
                    gsap.set(el, { clearProps: "all" });
                });
            },
        });
    }

    if (charts.length > 0) {
        tlContent.to(
            charts,
            {
                y: 0,
                opacity: 1,
                duration: 0.8,
                ease: "power3.out",
                stagger: 0.15,
                onComplete: () => {
                    charts.forEach((el) => {
                        el.classList.remove("opacity-0", "translate-y-10");
                        gsap.set(el, { clearProps: "all" });
                    });
                },
            },
            "-=0.6",
        );
    }
});

// 2. Animasi Logout
document.addEventListener("DOMContentLoaded", () => {
    const logoutButton = document.getElementById("logoutButton");
    const sidebar = document.getElementById("sidebar");
    const topbar = document.getElementById("topbar");
    const statCards = document.querySelectorAll(".gsap-card");
    const charts = document.querySelectorAll(".gsap-chart");
    const footbar = document.querySelector("#footbar");

    if (logoutButton) {
        logoutButton.addEventListener("click", (e) => {
            e.preventDefault();
            sessionStorage.removeItem(SESSION_KEY);

            const tlLogout = gsap.timeline({
                onComplete: () => {
                    document.getElementById("logout-form").submit();
                },
            });

            tlLogout.to(sidebar, {
                x: "-100%",
                opacity: 0,
                duration: 0.8,
                ease: "expo.in",
            });

            tlLogout.to(
                topbar,
                {
                    y: "-100%",
                    opacity: 0,
                    duration: 0.8,
                    ease: "expo.in",
                },
                "<",
            );

            tlLogout.to(
                statCards,
                {
                    y: 20,
                    opacity: 0,
                    duration: 0.5,
                    stagger: 0.05,
                    ease: "power2.in",
                },
                "-=0.6",
            );

            tlLogout.to(
                charts,
                {
                    y: 20,
                    opacity: 0,
                    duration: 0.5,
                    stagger: 0.1,
                    ease: "power2.in",
                },
                "-=0.45",
            );

            if (footbar) {
                tlLogout.to(
                    footbar,
                    {
                        y: 50,
                        opacity: 0,
                        duration: 0.6,
                        ease: "expo.in",
                    },
                    "-=0.5",
                );
            }
        });
    }
});

// Siswa Table
document.addEventListener("DOMContentLoaded", initCounter);
document.addEventListener("livewire:navigated", initCounter);

function initCounter() {
    const counters = document.querySelectorAll(".counter");

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) return;

                const el = entry.target;
                const target = parseInt(el.dataset.target);
                let count = 0;

                const update = () => {
                    const inc = Math.ceil(target / 75);

                    if (count < target) {
                        count += inc;
                        el.innerText = count.toLocaleString();
                        requestAnimationFrame(update);
                    } else {
                        el.innerText = target.toLocaleString();
                    }
                };

                update();
                observer.unobserve(el);
            });
        },
        { threshold: 0.6 },
    );

    counters.forEach((c) => observer.observe(c));
}

document.addEventListener("alpine:init", () => {
    // 1. Definisikan Style Toaster SweetAlert
    const Toast = Swal.mixin({
        toast: true,
        position: "top-end", // Muncul di pojok kanan atas
        showConfirmButton: false,
        timer: 1000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener("mouseenter", Swal.stopTimer);
            toast.addEventListener("mouseleave", Swal.resumeTimer);
        },
    });

    // 2. Definisikan Component Alpine 'siswaData'
    // Perhatikan parameter: (dataSiswa, urlSimpan, tokenCsrf)
    Alpine.data(
        "siswaData",
        (initialStudents, listKelas, routeStore, csrfToken) => ({
            search: "",
            rowsPerPage: 5,
            currentPage: 1,
            drawerOpen: false,
            drawerMode: "add",
            sortCol: "name",
            sortAsc: true,
            isLoading: false,
            formData: { id: null, name: "", nis: "", class: "", gender: "" },
            optionsKelas: listKelas,
            // Ambil data dari parameter yang dikirim Blade
            students: initialStudents,

            get filteredStudents() {
                let result = this.students;
                if (this.search !== "") {
                    const q = this.search.toLowerCase();
                    result = result.filter(
                        (s) =>
                            s.name.toLowerCase().includes(q) ||
                            s.nis.includes(q) ||
                            s.class.toLowerCase().includes(q),
                    );
                }
                result = result.sort((a, b) => {
                    let valA = a[this.sortCol].toString().toLowerCase();
                    let valB = b[this.sortCol].toString().toLowerCase();
                    if (valA < valB) return this.sortAsc ? -1 : 1;
                    if (valA > valB) return this.sortAsc ? 1 : -1;
                    return 0;
                });
                return result;
            },
            get totalPages() {
                return Math.ceil(
                    this.filteredStudents.length / this.rowsPerPage,
                );
            },
            get paginatedStudents() {
                let start = (this.currentPage - 1) * this.rowsPerPage;
                return this.filteredStudents.slice(
                    start,
                    start + this.rowsPerPage,
                );
            },
            get pageNumbers() {
                let pages = [];
                let total = this.totalPages;
                let current = this.currentPage;
                if (total <= 7) {
                    for (let i = 1; i <= total; i++) pages.push(i);
                } else {
                    if (current <= 4) {
                        pages = [1, 2, 3, 4, 5, "...", total];
                    } else if (current >= total - 3) {
                        pages = [
                            1,
                            "...",
                            total - 4,
                            total - 3,
                            total - 2,
                            total - 1,
                            total,
                        ];
                    } else {
                        pages = [
                            1,
                            "...",
                            current - 1,
                            current,
                            current + 1,
                            "...",
                            total,
                        ];
                    }
                }
                return pages;
            },
            get drawerTitle() {
                if (this.drawerMode === "add") return "Tambah Siswa Baru";
                if (this.drawerMode === "edit") return "Edit Data Siswa";
                return "Konfirmasi Hapus";
            },
            get drawerDescription() {
                if (this.drawerMode === "add")
                    return "Silakan lengkapi formulir di bawah ini.";
                if (this.drawerMode === "edit")
                    return "Lakukan perubahan pada data siswa.";
                return "Tindakan ini akan menghapus data siswa secara permanen.";
            },
            sortBy(col) {
                if (this.sortCol === col) {
                    this.sortAsc = !this.sortAsc;
                } else {
                    this.sortCol = col;
                    this.sortAsc = true;
                }
            },
            openDrawer(mode, student = null) {
                this.drawerMode = mode;
                if (mode === "add") {
                    this.formData = {
                        id: null,
                        name: "",
                        nis: "",
                        class: "",
                        gender: "",
                    };
                } else {
                    this.formData = { ...student };
                }
                this.drawerOpen = true;
            },
            updateRows() {
                this.currentPage = 1;
            },

            // --- SAVE DATA (Pake Toaster) ---
            async saveData() {
                this.isLoading = true;
                try {
                    // Gunakan parameter routeStore dan csrfToken
                    let response = await fetch(routeStore, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": csrfToken,
                        },
                        body: JSON.stringify(this.formData),
                    });

                    let result = await response.json();
                    if (!response.ok)
                        throw new Error(
                            result.message || "Gagal menyimpan data",
                        );

                    this.drawerOpen = false;

                    // Panggil Toast
                    Toast.fire({
                        icon: "success",
                        title: "Berhasil disimpan",
                    }).then(() => {
                        location.reload();
                    });
                } catch (error) {
                    Toast.fire({
                        icon: "error",
                        title: "Gagal menyimpan data",
                    });
                } finally {
                    this.isLoading = false;
                }
            },

            // --- DELETE DATA (Pake Toaster) ---
            async deleteData() {
                this.isLoading = true;
                try {
                    // Untuk delete URL-nya manual build string gapapa, tapi token tetep pake param
                    let response = await fetch("/siswa/" + this.formData.id, {
                        method: "DELETE",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": csrfToken,
                        },
                    });
                    if (!response.ok) throw new Error("Gagal menghapus data");
                    this.drawerOpen = false;

                    // Panggil Toast
                    Toast.fire({
                        icon: "success",
                        title: "Data dihapus",
                    }).then(() => {
                        location.reload();
                    });
                } catch (error) {
                    Toast.fire({
                        icon: "error",
                        title: "Gagal menghapus data",
                    });
                } finally {
                    this.isLoading = false;
                }
            },

            init() {
                this.$watch("paginatedStudents", () => {
                    setTimeout(() => lucide.createIcons(), 50);
                });
                this.$watch("drawerOpen", () => {
                    setTimeout(() => lucide.createIcons(), 50);
                });
            },
        }),
    );
});

//plot-walas tabel
document.addEventListener("alpine:init", () => {
    Alpine.data(
        "walasData",
        (initialPlots, gurus, kelases, routeStore, csrfToken) => ({
            search: "",
            rowsPerPage: 5,
            currentPage: 1,
            drawerOpen: false,
            drawerMode: "add",
            sortCol: "namaguru",
            sortAsc: true,
            isLoading: false,

            plots: initialPlots,
            listGuru: gurus,
            listKelas: kelases,

            formData: {
                id: null,
                id_guru: "",
                id_kelas: "",
                namaguru: "", // Hanya untuk display saat delete
                kode_kelas: "", // Hanya untuk display saat delete
            },

            // Helper untuk memunculkan teks di Dropdown
            get guruLabel() {
                let g = this.listGuru.find(
                    (x) => x.id_guru === this.formData.id_guru,
                );
                return g ? g.namaguru : "Pilih Guru...";
            },
            get kelasLabel() {
                let k = this.listKelas.find(
                    (x) => x.id_kelas === this.formData.id_kelas,
                );
                return k ? k.kode_kelas : "Pilih Kelas...";
            },

            get filteredData() {
                let result = this.plots;
                if (this.search !== "") {
                    const q = this.search.toLowerCase();
                    result = result.filter(
                        (p) =>
                            p.namaguru.toLowerCase().includes(q) ||
                            p.kode_kelas.toLowerCase().includes(q),
                    );
                }
                result = result.sort((a, b) => {
                    let valA = a[this.sortCol].toString().toLowerCase();
                    let valB = b[this.sortCol].toString().toLowerCase();
                    if (valA < valB) return this.sortAsc ? -1 : 1;
                    if (valA > valB) return this.sortAsc ? 1 : -1;
                    return 0;
                });
                return result;
            },
            get totalPages() {
                return Math.ceil(this.filteredData.length / this.rowsPerPage);
            },
            get paginatedData() {
                let start = (this.currentPage - 1) * this.rowsPerPage;
                return this.filteredData.slice(start, start + this.rowsPerPage);
            },
            get pageNumbers() {
                let pages = [];
                let total = this.totalPages;
                let current = this.currentPage;
                if (total <= 7) {
                    for (let i = 1; i <= total; i++) pages.push(i);
                } else {
                    if (current <= 4) pages = [1, 2, 3, 4, 5, "...", total];
                    else if (current >= total - 3)
                        pages = [
                            1,
                            "...",
                            total - 4,
                            total - 3,
                            total - 2,
                            total - 1,
                            total,
                        ];
                    else
                        pages = [
                            1,
                            "...",
                            current - 1,
                            current,
                            current + 1,
                            "...",
                            total,
                        ];
                }
                return pages;
            },
            get drawerTitle() {
                if (this.drawerMode === "add") return "Tambah Wali Kelas";
                if (this.drawerMode === "edit") return "Edit Wali Kelas";
                return "Konfirmasi Hapus";
            },

            sortBy(col) {
                if (this.sortCol === col) this.sortAsc = !this.sortAsc;
                else {
                    this.sortCol = col;
                    this.sortAsc = true;
                }
            },
            updateRows() {
                this.currentPage = 1;
            },

            openDrawer(mode, item = null) {
                this.drawerMode = mode;
                if (mode === "add") {
                    this.formData = {
                        id: null,
                        id_guru: "",
                        id_kelas: "",
                        namaguru: "",
                        kode_kelas: "",
                    };
                } else {
                    this.formData = { ...item };
                }
                this.drawerOpen = true;
            },

            async saveData() {
                this.isLoading = true;
                try {
                    let response = await fetch(routeStore, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": csrfToken,
                            Accept: "application/json",
                        },
                        body: JSON.stringify(this.formData),
                    });
                    let result = await response.json();
                    if (!response.ok) {
                        // Cek jika error validasi (Misal: kelas sudah punya walas)
                        let errorMsg = result.message || "Gagal menyimpan data";
                        if (result.errors && result.errors.id_kelas)
                            errorMsg = result.errors.id_kelas[0];
                        throw new Error(errorMsg);
                    }

                    // Gunakan Swal/Toast milikmu di sini (saya asumsikan variabel Toast sudah ada)
                    Swal.fire({
                        toast: true,
                        position: "top-end",
                        icon: "success",
                        title: "Berhasil disimpan",
                        showConfirmButton: false,
                        timer: 1500,
                    }).then(() => location.reload());
                } catch (error) {
                    Swal.fire({
                        toast: true,
                        position: "top-end",
                        icon: "error",
                        title: error.message,
                        showConfirmButton: false,
                        timer: 2000,
                    });
                } finally {
                    this.isLoading = false;
                }
            },

            async deleteData() {
                this.isLoading = true;
                try {
                    let response = await fetch(
                        "/plot-walas/" + this.formData.id,
                        {
                            method: "DELETE",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": csrfToken,
                            },
                        },
                    );
                    if (!response.ok) throw new Error("Gagal menghapus data");
                    Swal.fire({
                        toast: true,
                        position: "top-end",
                        icon: "success",
                        title: "Data dihapus",
                        showConfirmButton: false,
                        timer: 1500,
                    }).then(() => location.reload());
                } catch (error) {
                    Swal.fire({
                        toast: true,
                        position: "top-end",
                        icon: "error",
                        title: "Gagal menghapus data",
                        showConfirmButton: false,
                        timer: 2000,
                    });
                } finally {
                    this.isLoading = false;
                }
            },

            init() {
                this.$watch("paginatedData", () => {
                    setTimeout(
                        () =>
                            typeof lucide !== "undefined" &&
                            lucide.createIcons(),
                        50,
                    );
                });
                this.$watch("drawerOpen", () => {
                    setTimeout(
                        () =>
                            typeof lucide !== "undefined" &&
                            lucide.createIcons(),
                        50,
                    );
                });
            },
        }),
    );
});

// user tabel
document.addEventListener("alpine:init", () => {
    const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 1200,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener("mouseenter", Swal.stopTimer);
            toast.addEventListener("mouseleave", Swal.resumeTimer);
        },
    });

    Alpine.data("userData", (initialUsers, routeStore, csrfToken) => ({
        search: "",
        rowsPerPage: 5,
        currentPage: 1,
        drawerOpen: false,
        drawerMode: "add",
        sortCol: "namalengkap",
        sortAsc: true,
        isLoading: false,

        // TAMBAHAN: Untuk Toggle Password
        showPassword: false,

        formData: {
            id_user: null,
            namalengkap: "",
            username: "",
            password: "",
            usertype: "",
            foto: "",
            status: "aktif",
        },

        users: initialUsers,

        get filteredUsers() {
            let result = [...this.users];

            if (this.search !== "") {
                const q = this.search.toLowerCase();
                result = result.filter(
                    (u) =>
                        u.namalengkap.toLowerCase().includes(q) ||
                        u.username.toLowerCase().includes(q) ||
                        u.usertype.toLowerCase().includes(q),
                );
            }
            result.sort((a, b) => {
                let valA = (a[this.sortCol] || "").toString().toLowerCase();
                let valB = (b[this.sortCol] || "").toString().toLowerCase();
                if (valA < valB) return this.sortAsc ? -1 : 1;
                if (valA > valB) return this.sortAsc ? 1 : -1;
                return 0;
            });
            return result;
        },

        get totalPages() {
            return Math.ceil(this.filteredUsers.length / this.rowsPerPage);
        },
        get paginatedUsers() {
            let start = (this.currentPage - 1) * this.rowsPerPage;
            return this.filteredUsers.slice(start, start + this.rowsPerPage);
        },
        get pageNumbers() {
            let pages = [];
            let total = this.totalPages;
            let current = this.currentPage;

            if (total <= 7) {
                for (let i = 1; i <= total; i++) pages.push(i);
            } else {
                if (current <= 4) {
                    pages = [1, 2, 3, 4, 5, "...", total];
                } else if (current >= total - 3) {
                    pages = [
                        1,
                        "...",
                        total - 4,
                        total - 3,
                        total - 2,
                        total - 1,
                        total,
                    ];
                } else {
                    pages = [
                        1,
                        "...",
                        current - 1,
                        current,
                        current + 1,
                        "...",
                        total,
                    ];
                }
            }
            return pages;
        },
        get drawerTitle() {
            return {
                add: "Tambah User Baru",
                edit: "Edit Informasi User",
                delete: "Hapus User",
            }[this.drawerMode];
        },
        get drawerDescription() {
            return {
                add: "Silahkan lengkapi data kredensial user baru.",
                edit: "Perbarui data user. Kosongkan password jika tidak ingin mengubahnya.",
                delete: "Tindakan ini permanen. User tidak akan bisa login kembali.",
            }[this.drawerMode];
        },
        sortBy(col) {
            if (this.sortCol === col) {
                this.sortAsc = !this.sortAsc;
            } else {
                this.sortCol = col;
                this.sortAsc = true;
            }
            // Reset ke halaman pertama setiap kali sorting diubah
            this.currentPage = 1;
        },
        openDrawer(mode, user = null) {
            this.drawerMode = mode;
            this.showPassword = false; // Reset tampilan password setiap buka drawer

            if (mode === "add") {
                this.formData = {
                    id_user: null,
                    namalengkap: "",
                    username: "",
                    password: "",
                    usertype: "", // Default kosong biar user pilih
                    foto: "",
                    status: "aktif",
                };
            } else {
                this.formData = {
                    id_user: user.id_user,
                    namalengkap: user.namalengkap,
                    username: user.username,
                    password: "",
                    usertype: user.usertype,
                    foto: user.foto || "",
                    status: user.status,
                };
            }
            this.drawerOpen = true;
            this.$nextTick(() => lucide.createIcons());
        },

        async saveData() {
            if (
                !this.formData.namalengkap ||
                !this.formData.username ||
                !this.formData.usertype
            ) {
                return Toast.fire({
                    icon: "warning",
                    title: "Mohon lengkapi data wajib",
                });
            }

            this.isLoading = true;
            try {
                // PERBAIKAN: Gunakan POST untuk Add & Edit agar sesuai Controller updateOrCreate
                // Kita kirim ID di body (formData), jadi backend tahu ini edit atau baru.
                let response = await fetch(routeStore, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": csrfToken,
                        Accept: "application/json",
                    },
                    body: JSON.stringify({
                        id: this.formData.id_user, // Mapping id agar ditangkap controller
                        ...this.formData,
                    }),
                });

                if (!response.ok) throw new Error("Server Error");

                this.drawerOpen = false;
                Toast.fire({
                    icon: "success",
                    title: "Data berhasil disimpan",
                }).then(() => location.reload());
            } catch (error) {
                Toast.fire({ icon: "error", title: "Gagal menyimpan data" });
            } finally {
                this.isLoading = false;
            }
        },

        async deleteData() {
            this.isLoading = true;
            try {
                // Pastikan route delete di web.php: Route::delete('/user/{id}', ...)
                // Sesuaikan URL prefix '/user/' dengan route kamu
                let response = await fetch(`/user/${this.formData.id_user}`, {
                    method: "DELETE",
                    headers: {
                        "X-CSRF-TOKEN": csrfToken,
                        Accept: "application/json",
                    },
                });

                if (!response.ok) throw new Error();

                this.drawerOpen = false;
                Toast.fire({
                    icon: "success",
                    title: "User telah dihapus",
                }).then(() => location.reload());
            } catch (error) {
                Toast.fire({ icon: "error", title: "Gagal menghapus user" });
            } finally {
                this.isLoading = false;
            }
        },

        updateRows() {
            this.currentPage = 1;
        },

        // PERBAIKAN: Gunakan $watch 'paginatedUsers' agar ikon selalu ter-render saat tampilannya diubah
        init() {
            this.$watch("paginatedUsers", () => {
                setTimeout(() => lucide.createIcons(), 50);
            });
            this.$watch("drawerOpen", () => {
                setTimeout(() => lucide.createIcons(), 50);
            });
            this.$watch("search", () => {
                this.currentPage = 1;
            });

            setTimeout(() => lucide.createIcons(), 50);
        },
    }));
});

//guru tabel
document.addEventListener("alpine:init", () => {
    // 1. Definisikan Style Toaster SweetAlert (Sama persis)
    const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 1000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener("mouseenter", Swal.stopTimer);
            toast.addEventListener("mouseleave", Swal.resumeTimer);
        },
    });

    // 2. Definisikan Component Alpine 'guruData'
    Alpine.data("guruData", (initialGurus, routeStore, csrfToken) => ({
        search: "",
        rowsPerPage: 5,
        currentPage: 1,
        drawerOpen: false,
        drawerMode: "add",
        sortCol: "name",
        sortAsc: true,
        isLoading: false,
        // Field disesuaikan: nik, kodeguru, status
        formData: {
            id: null,
            name: "",
            nik: "",
            kodeguru: "",
            status: "Aktif",
        },

        // Ambil data dari parameter blade
        gurus: initialGurus,

        get filteredGurus() {
            let result = this.gurus;
            if (this.search !== "") {
                const q = this.search.toLowerCase();
                result = result.filter(
                    (g) =>
                        g.name.toLowerCase().includes(q) ||
                        g.nik.includes(q) ||
                        g.kodeguru.toLowerCase().includes(q),
                );
            }
            result = result.sort((a, b) => {
                let valA = a[this.sortCol].toString().toLowerCase();
                let valB = b[this.sortCol].toString().toLowerCase();
                if (valA < valB) return this.sortAsc ? -1 : 1;
                if (valA > valB) return this.sortAsc ? 1 : -1;
                return 0;
            });
            return result;
        },
        get totalPages() {
            return Math.ceil(this.filteredGurus.length / this.rowsPerPage);
        },
        get paginatedGurus() {
            let start = (this.currentPage - 1) * this.rowsPerPage;
            return this.filteredGurus.slice(start, start + this.rowsPerPage);
        },
        get pageNumbers() {
            let pages = [];
            let total = this.totalPages;
            let current = this.currentPage;
            if (total <= 7) {
                for (let i = 1; i <= total; i++) pages.push(i);
            } else {
                if (current <= 4) {
                    pages = [1, 2, 3, 4, 5, "...", total];
                } else if (current >= total - 3) {
                    pages = [
                        1,
                        "...",
                        total - 4,
                        total - 3,
                        total - 2,
                        total - 1,
                        total,
                    ];
                } else {
                    pages = [
                        1,
                        "...",
                        current - 1,
                        current,
                        current + 1,
                        "...",
                        total,
                    ];
                }
            }
            return pages;
        },
        get drawerTitle() {
            if (this.drawerMode === "add") return "Tambah Guru Baru";
            if (this.drawerMode === "edit") return "Edit Data Guru";
            return "Konfirmasi Hapus";
        },
        get drawerDescription() {
            if (this.drawerMode === "add")
                return "Silakan lengkapi formulir di bawah ini.";
            if (this.drawerMode === "edit")
                return "Lakukan perubahan pada data guru.";
            return "Tindakan ini akan menghapus data guru secara permanen.";
        },
        sortBy(col) {
            if (this.sortCol === col) {
                this.sortAsc = !this.sortAsc;
            } else {
                this.sortCol = col;
                this.sortAsc = true;
            }
        },
        openDrawer(mode, guru = null) {
            this.drawerMode = mode;
            if (mode === "add") {
                this.formData = {
                    id: null,
                    name: "",
                    nik: "",
                    kodeguru: "",
                    status: "Aktif",
                };
            } else {
                // Spread operator untuk copy data guru ke form
                this.formData = {
                    ...guru,
                };
            }
            this.drawerOpen = true;
        },
        updateRows() {
            this.currentPage = 1;
        },

        // --- SAVE DATA ---
        async saveData() {
            this.isLoading = true;
            try {
                let response = await fetch(routeStore, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": csrfToken,
                    },
                    body: JSON.stringify(this.formData),
                });

                let result = await response.json();
                if (!response.ok)
                    throw new Error(result.message || "Gagal menyimpan data");

                this.drawerOpen = false;
                Toast.fire({
                    icon: "success",
                    title: "Berhasil disimpan",
                }).then(() => {
                    location.reload();
                });
            } catch (error) {
                Toast.fire({
                    icon: "error",
                    title: "Gagal menyimpan data",
                });
            } finally {
                this.isLoading = false;
            }
        },

        // --- DELETE DATA ---
        async deleteData() {
            this.isLoading = true;
            try {
                // Endpoint delete disesuaikan ke /guru/
                let response = await fetch("/guru/" + this.formData.id, {
                    method: "DELETE",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": csrfToken,
                    },
                });
                if (!response.ok) throw new Error("Gagal menghapus data");
                this.drawerOpen = false;
                Toast.fire({
                    icon: "success",
                    title: "Data dihapus",
                }).then(() => {
                    location.reload();
                });
            } catch (error) {
                Toast.fire({
                    icon: "error",
                    title: "Gagal menghapus data",
                });
            } finally {
                this.isLoading = false;
            }
        },

        init() {
            this.$watch("paginatedGurus", () => {
                setTimeout(() => lucide.createIcons(), 50);
            });
            this.$watch("drawerOpen", () => {
                setTimeout(() => lucide.createIcons(), 50);
            });
        },
    }));
});

//kelas tabel
document.addEventListener("alpine:init", () => {
    const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 1000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener("mouseenter", Swal.stopTimer);
            toast.addEventListener("mouseleave", Swal.resumeTimer);
        },
    });

    // --- COMPONENT DATA KELAS ---
    Alpine.data("kelasData", (initialKelas, routeStore, csrfToken) => ({
        search: "",
        rowsPerPage: 5, // Disamakan dengan guru (5 baris)
        currentPage: 1,
        drawerOpen: false,
        drawerMode: "add",
        sortCol: "kode_kelas", // Default sorting pakai kode_kelas
        sortAsc: true,
        isLoading: false,

        // Field untuk Kelas (Hanya id, kode_kelas, status)
        formData: {
            id: null,
            kode_kelas: "",
            status: "Aktif",
        },

        // Ambil data dari parameter blade
        kelases: initialKelas,

        get filteredKelas() {
            let result = this.kelases;
            if (this.search !== "") {
                const q = this.search.toLowerCase();
                result = result.filter(
                    (k) =>
                        k.kode_kelas.toLowerCase().includes(q) ||
                        k.status.toLowerCase().includes(q),
                );
            }
            result = result.sort((a, b) => {
                let valA = a[this.sortCol].toString().toLowerCase();
                let valB = b[this.sortCol].toString().toLowerCase();
                if (valA < valB) return this.sortAsc ? -1 : 1;
                if (valA > valB) return this.sortAsc ? 1 : -1;
                return 0;
            });
            return result;
        },
        get totalPages() {
            return Math.ceil(this.filteredKelas.length / this.rowsPerPage);
        },
        get paginatedKelas() {
            let start = (this.currentPage - 1) * this.rowsPerPage;
            return this.filteredKelas.slice(start, start + this.rowsPerPage);
        },
        get pageNumbers() {
            let pages = [];
            let total = this.totalPages;
            let current = this.currentPage;
            if (total <= 7) {
                for (let i = 1; i <= total; i++) pages.push(i);
            } else {
                if (current <= 4) {
                    pages = [1, 2, 3, 4, 5, "...", total];
                } else if (current >= total - 3) {
                    pages = [
                        1,
                        "...",
                        total - 4,
                        total - 3,
                        total - 2,
                        total - 1,
                        total,
                    ];
                } else {
                    pages = [
                        1,
                        "...",
                        current - 1,
                        current,
                        current + 1,
                        "...",
                        total,
                    ];
                }
            }
            return pages;
        },
        get drawerTitle() {
            if (this.drawerMode === "add") return "Tambah Kelas Baru";
            if (this.drawerMode === "edit") return "Edit Data Kelas";
            return "Konfirmasi Hapus";
        },
        get drawerDescription() {
            if (this.drawerMode === "add")
                return "Silakan lengkapi formulir di bawah ini.";
            if (this.drawerMode === "edit")
                return "Lakukan perubahan pada data kelas.";
            return "Tindakan ini akan menghapus data kelas secara permanen.";
        },
        sortBy(col) {
            if (this.sortCol === col) {
                this.sortAsc = !this.sortAsc;
            } else {
                this.sortCol = col;
                this.sortAsc = true;
            }
        },
        openDrawer(mode, kelas = null) {
            this.drawerMode = mode;
            if (mode === "add") {
                this.formData = {
                    id: null,
                    kode_kelas: "",
                    status: "Aktif",
                };
            } else {
                // Spread operator untuk copy data kelas ke form
                this.formData = {
                    ...kelas,
                };
            }
            this.drawerOpen = true;
        },
        updateRows() {
            this.currentPage = 1;
        },

        // --- SAVE DATA ---
        async saveData() {
            this.isLoading = true;
            try {
                let response = await fetch(routeStore, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": csrfToken,
                    },
                    body: JSON.stringify(this.formData),
                });

                let result = await response.json();
                if (!response.ok)
                    throw new Error(result.message || "Gagal menyimpan data");

                this.drawerOpen = false;
                Toast.fire({
                    icon: "success",
                    title: "Berhasil disimpan",
                }).then(() => {
                    location.reload();
                });
            } catch (error) {
                Toast.fire({
                    icon: "error",
                    title: "Gagal menyimpan data",
                });
            } finally {
                this.isLoading = false;
            }
        },

        // --- DELETE DATA ---
        async deleteData() {
            this.isLoading = true;
            try {
                // Endpoint delete ke /kelas/id
                let response = await fetch("/kelas/" + this.formData.id, {
                    method: "DELETE",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": csrfToken,
                    },
                });
                if (!response.ok) throw new Error("Gagal menghapus data");
                this.drawerOpen = false;
                Toast.fire({
                    icon: "success",
                    title: "Data dihapus",
                }).then(() => {
                    location.reload();
                });
            } catch (error) {
                Toast.fire({
                    icon: "error",
                    title: "Gagal menghapus data",
                });
            } finally {
                this.isLoading = false;
            }
        },

        init() {
            this.$watch("paginatedKelas", () => {
                setTimeout(
                    () => typeof lucide !== "undefined" && lucide.createIcons(),
                    50,
                );
            });
            this.$watch("drawerOpen", () => {
                setTimeout(
                    () => typeof lucide !== "undefined" && lucide.createIcons(),
                    50,
                );
            });
        },
    }));
});

document.addEventListener("alpine:init", () => {
    const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 1200,
        timerProgressBar: true,
    });

    Alpine.data(
        "pelanggaranData",
        (initialStudents, routeStore, csrfToken, usertype, currentSiswaId) => ({
            search: "",
            rowsPerPage: 8,
            currentPage: 1,
            drawerOpen: false,
            drawerMode: "add",
            sortCol: "name",
            sortAsc: true,
            isLoading: false,
            isLoadingRiwayat: false,

            students: initialStudents,
            selectedStudent: null,
            riwayatList: [],

            usertype: usertype || "guest",
            currentSiswaId: currentSiswaId || null,

            filterKelas: "",
            sortByPoin: "",

            formData: {
                id: null,
                name: "",
                nis: "",
                class: "",
                gender: "",
            },

            pelanggaranList: {
                ringan: [
                    { id: "ringan_1", jenis: "Terlambat", poin: 5 },
                    { id: "ringan_2", jenis: "Atribut Tidak Lengkap", poin: 5 },
                    { id: "ringan_3", jenis: "Tidak bawa buku", poin: 2 },
                ],
                sedang: [
                    { id: "sedang_1", jenis: "Rambut Gondrong", poin: 10 },
                    { id: "sedang_2", jenis: "Baju dikeluarkan", poin: 5 },
                    { id: "sedang_3", jenis: "Celana Ketat", poin: 10 },
                ],
                berat: [
                    { id: "berat_1", jenis: "Bolos Pelajaran", poin: 20 },
                    { id: "berat_2", jenis: "Merokok", poin: 50 },
                    { id: "berat_3", jenis: "Berkelahi", poin: 75 },
                ],
            },

            selectedPelanggaran: {},
            photoFiles: {},
            photoPreview: {},
            keteranganTambahan: "",
            fullscreenImage: null,

            get isMobile() {
                return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(
                    navigator.userAgent,
                );
            },

            // Cek apakah user adalah siswa
            get isSiswa() {
                return this.usertype === "siswa";
            },

            // Cek apakah bisa mencatat (siswa tidak bisa)
            get canCreate() {
                return this.usertype !== "siswa";
            },

            get totalSelectedPoin() {
                let total = 0;
                for (let key in this.selectedPelanggaran) {
                    if (this.selectedPelanggaran[key]) {
                        total += this.selectedPelanggaran[key].poin;
                    }
                }
                return total;
            },

            get kelasList() {
                const kelasSet = new Set();
                this.students.forEach((s) => {
                    if (s.class) kelasSet.add(s.class);
                });
                return Array.from(kelasSet).sort();
            },

            get filteredKelasList() {
                if (!this.search) return this.kelasList;
                return this.kelasList.filter((k) =>
                    k.toLowerCase().includes(this.search.toLowerCase()),
                );
            },

            get filteredStudents() {
                let result = this.students;

                if (this.search !== "") {
                    const q = this.search.toLowerCase();
                    result = result.filter(
                        (s) =>
                            s.name.toLowerCase().includes(q) ||
                            s.nis.includes(q) ||
                            s.class.toLowerCase().includes(q),
                    );
                }

                if (this.filterKelas !== "") {
                    result = result.filter((s) => s.class === this.filterKelas);
                }

                if (this.sortByPoin !== "") {
                    result = result.sort((a, b) => {
                        const poinA = a.total_poin ?? 0;
                        const poinB = b.total_poin ?? 0;
                        return this.sortByPoin === "desc"
                            ? poinB - poinA
                            : poinA - poinB;
                    });
                } else {
                    result = result.sort((a, b) => {
                        let valA = a[this.sortCol].toString().toLowerCase();
                        let valB = b[this.sortCol].toString().toLowerCase();
                        if (valA < valB) return this.sortAsc ? -1 : 1;
                        if (valA > valB) return this.sortAsc ? 1 : -1;
                        return 0;
                    });
                }

                return result;
            },

            get totalPages() {
                return Math.ceil(
                    this.filteredStudents.length / this.rowsPerPage,
                );
            },

            get paginatedStudents() {
                let start = (this.currentPage - 1) * this.rowsPerPage;
                return this.filteredStudents.slice(
                    start,
                    start + this.rowsPerPage,
                );
            },

            get pageNumbers() {
                let pages = [];
                let total = this.totalPages;
                let current = this.currentPage;

                if (total <= 7) {
                    for (let i = 1; i <= total; i++) pages.push(i);
                } else {
                    if (current <= 4) {
                        pages = [1, 2, 3, 4, 5, "...", total];
                    } else if (current >= total - 3) {
                        pages = [
                            1,
                            "...",
                            total - 4,
                            total - 3,
                            total - 2,
                            total - 1,
                            total,
                        ];
                    } else {
                        pages = [
                            1,
                            "...",
                            current - 1,
                            current,
                            current + 1,
                            "...",
                            total,
                        ];
                    }
                }
                return pages;
            },

            get drawerTitle() {
                if (this.drawerMode === "add") return "Tambah Siswa";
                if (this.drawerMode === "edit") return "Edit Siswa";
                if (this.drawerMode === "delete") return "Hapus Siswa";
                if (this.drawerMode === "tambahPelanggaran")
                    return "Catat Pelanggaran";
                if (this.drawerMode === "riwayat") return "Riwayat Pelanggaran";
                return "";
            },

            get drawerDescription() {
                if (this.drawerMode === "tambahPelanggaran")
                    return "Pilih pelanggaran dan upload bukti foto";
                if (this.drawerMode === "riwayat")
                    return "Daftar riwayat pelanggaran siswa";
                return "Silakan isi data.";
            },

            togglePelanggaran(id, jenis, poin) {
                if (this.selectedPelanggaran[id]) {
                    delete this.selectedPelanggaran[id];
                    this.removePhoto(id);
                } else {
                    this.selectedPelanggaran[id] = {
                        jenis: jenis,
                        poin: poin,
                    };
                }

                this.selectedPelanggaran = { ...this.selectedPelanggaran };
            },

            async compressImage(file) {
                return new Promise((resolve, reject) => {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        const img = new Image();
                        img.onload = () => {
                            const canvas = document.createElement("canvas");
                            const ctx = canvas.getContext("2d");

                            const MAX_WIDTH = 1200;
                            const MAX_HEIGHT = 1200;
                            let width = img.width;
                            let height = img.height;

                            if (width > height) {
                                if (width > MAX_WIDTH) {
                                    height *= MAX_WIDTH / width;
                                    width = MAX_WIDTH;
                                }
                            } else {
                                if (height > MAX_HEIGHT) {
                                    width *= MAX_HEIGHT / height;
                                    height = MAX_HEIGHT;
                                }
                            }

                            canvas.width = width;
                            canvas.height = height;

                            ctx.drawImage(img, 0, 0, width, height);

                            let quality = 0.8;
                            const tryCompress = (q) => {
                                canvas.toBlob(
                                    (blob) => {
                                        if (blob.size > 500 * 1024 && q > 0.1) {
                                            tryCompress(q - 0.1);
                                        } else {
                                            const compressedFile = new File(
                                                [blob],
                                                file.name,
                                                {
                                                    type: "image/jpeg",
                                                    lastModified: Date.now(),
                                                },
                                            );
                                            resolve(compressedFile);
                                        }
                                    },
                                    "image/jpeg",
                                    q,
                                );
                            };

                            tryCompress(quality);
                        };
                        img.onerror = reject;
                        img.src = e.target.result;
                    };
                    reader.onerror = reject;
                    reader.readAsDataURL(file);
                });
            },

            async handleFileUpload(event, pelanggaranId) {
                const file = event.target.files[0];
                if (!file) return;

                if (!file.type.startsWith("image/")) {
                    Toast.fire({
                        icon: "error",
                        title: "File harus berupa gambar",
                    });
                    return;
                }

                try {
                    Toast.fire({
                        icon: "info",
                        title: "Mengompres foto...",
                        timer: 500,
                    });

                    let processedFile = file;

                    if (file.size > 500 * 1024) {
                        processedFile = await this.compressImage(file);
                        const sizeKB = (processedFile.size / 1024).toFixed(0);
                        console.log(
                            `Foto dikompres dari ${(file.size / 1024).toFixed(0)}KB ke ${sizeKB}KB`,
                        );

                        Toast.fire({
                            icon: "success",
                            title: `Foto dikompres ke ${sizeKB}KB`,
                            timer: 1000,
                        });
                    }

                    this.photoFiles[pelanggaranId] = processedFile;

                    const reader = new FileReader();
                    reader.onload = (e) => {
                        this.photoPreview[pelanggaranId] = e.target.result;
                        this.photoPreview = { ...this.photoPreview };

                        setTimeout(() => lucide.createIcons(), 50);
                    };
                    reader.readAsDataURL(processedFile);
                } catch (error) {
                    console.error("Error compressing image:", error);
                    Toast.fire({
                        icon: "error",
                        title: "Gagal memproses foto",
                    });
                }
            },

            removePhoto(pelanggaranId) {
                delete this.photoFiles[pelanggaranId];
                delete this.photoPreview[pelanggaranId];

                const fileInput = document.getElementById(
                    "file-" + pelanggaranId,
                );
                if (fileInput) {
                    fileInput.value = "";
                }

                this.photoFiles = { ...this.photoFiles };
                this.photoPreview = { ...this.photoPreview };

                setTimeout(() => lucide.createIcons(), 50);
            },

            openFullscreen(imageUrl) {
                this.fullscreenImage = imageUrl;
                setTimeout(() => lucide.createIcons(), 50);
            },

            openDrawer(mode, student = null) {
                this.drawerMode = mode;
                this.selectedStudent = student;

                if (mode === "tambahPelanggaran") {
                    // Siswa tidak bisa catat
                    if (this.isSiswa) {
                        Toast.fire({
                            icon: "error",
                            title: "Siswa tidak dapat mencatat pelanggaran",
                        });
                        return;
                    }

                    this.selectedPelanggaran = {};
                    this.photoFiles = {};
                    this.photoPreview = {};
                    this.keteranganTambahan = "";
                }

                if (mode === "riwayat") {
                    console.log("Loading riwayat untuk student:", student);
                    this.loadRiwayat(student.id);
                }

                if (mode === "edit" || mode === "delete") {
                    this.formData = { ...student };
                }

                if (mode === "add") {
                    this.formData = {
                        id: null,
                        name: "",
                        nis: "",
                        class: "",
                        gender: "",
                    };
                }

                this.drawerOpen = true;
            },

            async loadRiwayat(studentId) {
                this.isLoadingRiwayat = true;
                this.riwayatList = [];

                try {
                    console.log("Fetching riwayat for student ID:", studentId);

                    let res = await fetch(`/pelanggaran/riwayat/${studentId}`);

                    console.log("Response status:", res.status);

                    if (!res.ok) {
                        const errorText = await res.text();
                        console.error("Response error:", errorText);
                        throw new Error(`HTTP error! status: ${res.status}`);
                    }

                    let data = await res.json();
                    console.log("Riwayat data received:", data);

                    this.riwayatList = data;

                    setTimeout(() => lucide.createIcons(), 100);
                } catch (e) {
                    console.error("Gagal load riwayat:", e);
                    Toast.fire({
                        icon: "error",
                        title: "Gagal memuat riwayat: " + e.message,
                    });
                } finally {
                    this.isLoadingRiwayat = false;
                }
            },

            formatDate(dateString) {
                if (!dateString) return "-";
                try {
                    const date = new Date(dateString);
                    return date.toLocaleDateString("id-ID", {
                        day: "numeric",
                        month: "long",
                        year: "numeric",
                        hour: "2-digit",
                        minute: "2-digit",
                    });
                } catch (e) {
                    return dateString;
                }
            },

            // ================= DELETE PELANGGARAN =================
            async deletePelanggaran(id_pelanggaran) {
                // Confirm delete
                const result = await Swal.fire({
                    title: "Hapus Pelanggaran?",
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#dc2626",
                    cancelButtonColor: "#6b7280",
                    confirmButtonText: "Ya, Hapus!",
                    cancelButtonText: "Batal",
                });

                if (!result.isConfirmed) return;

                try {
                    const response = await fetch(
                        `/pelanggaran/${id_pelanggaran}`,
                        {
                            method: "DELETE",
                            headers: {
                                "X-CSRF-TOKEN": csrfToken,
                                "Content-Type": "application/json",
                            },
                        },
                    );

                    const data = await response.json();

                    if (response.ok && data.success) {
                        Toast.fire({
                            icon: "success",
                            title: "Pelanggaran berhasil dihapus",
                        }).then(() => {
                            // Reload riwayat
                            this.loadRiwayat(this.selectedStudent.id);
                            // Reload page untuk update total poin
                            setTimeout(() => location.reload(), 500);
                        });
                    } else {
                        throw new Error(data.message || "Gagal menghapus");
                    }
                } catch (error) {
                    console.error("Error deleting:", error);
                    Toast.fire({
                        icon: "error",
                        title: error.message || "Gagal menghapus pelanggaran",
                    });
                }
            },

            async savePelanggaranBatch() {
                if (Object.keys(this.selectedPelanggaran).length === 0) {
                    Toast.fire({
                        icon: "warning",
                        title: "Pilih minimal 1 pelanggaran",
                    });
                    return;
                }

                this.isLoading = true;

                try {
                    const promises = [];

                    for (let pelanggaranId in this.selectedPelanggaran) {
                        const pelanggaran =
                            this.selectedPelanggaran[pelanggaranId];

                        const formData = new FormData();
                        formData.append("id_siswa", this.selectedStudent.id);
                        formData.append("jenis_pelanggaran", pelanggaran.jenis);
                        formData.append("poin", pelanggaran.poin);
                        formData.append("keterangan", this.keteranganTambahan);

                        if (this.photoFiles[pelanggaranId]) {
                            formData.append(
                                "bukti_foto",
                                this.photoFiles[pelanggaranId],
                            );
                        }

                        const promise = fetch("/pelanggaran/store", {
                            method: "POST",
                            headers: {
                                "X-CSRF-TOKEN": csrfToken,
                            },
                            body: formData,
                        });

                        promises.push(promise);
                    }

                    const results = await Promise.all(promises);

                    const allSuccess = results.every((res) => res.ok);

                    if (allSuccess) {
                        this.drawerOpen = false;
                        Toast.fire({
                            icon: "success",
                            title: `${promises.length} pelanggaran berhasil disimpan`,
                        }).then(() => location.reload());
                    } else {
                        throw new Error("Beberapa pelanggaran gagal disimpan");
                    }
                } catch (error) {
                    console.error("Error:", error);
                    Toast.fire({
                        icon: "error",
                        title: "Gagal menyimpan pelanggaran",
                    });
                } finally {
                    this.isLoading = false;
                }
            },

            async saveData() {
                this.isLoading = true;

                try {
                    let response = await fetch(routeStore, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": csrfToken,
                        },
                        body: JSON.stringify(this.formData),
                    });

                    if (!response.ok) throw new Error();

                    this.drawerOpen = false;

                    Toast.fire({
                        icon: "success",
                        title: "Berhasil disimpan",
                    }).then(() => location.reload());
                } catch {
                    Toast.fire({
                        icon: "error",
                        title: "Gagal menyimpan",
                    });
                } finally {
                    this.isLoading = false;
                }
            },

            async deleteData() {
                this.isLoading = true;

                try {
                    let response = await fetch("/siswa/" + this.formData.id, {
                        method: "DELETE",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": csrfToken,
                        },
                    });

                    if (!response.ok) throw new Error();

                    Toast.fire({
                        icon: "success",
                        title: "Data dihapus",
                    }).then(() => location.reload());
                } catch {
                    Toast.fire({
                        icon: "error",
                        title: "Gagal hapus",
                    });
                } finally {
                    this.isLoading = false;
                }
            },

            updateRows() {
                this.currentPage = 1;
            },

            init() {
                this.$watch("paginatedStudents", () => {
                    setTimeout(() => lucide.createIcons(), 50);
                });
                this.$watch("drawerOpen", () => {
                    setTimeout(() => lucide.createIcons(), 50);
                });
                this.$watch("selectedPelanggaran", () => {
                    setTimeout(() => lucide.createIcons(), 50);
                });
                this.$watch("photoPreview", () => {
                    setTimeout(() => lucide.createIcons(), 50);
                });
                this.$watch("riwayatList", () => {
                    setTimeout(() => lucide.createIcons(), 100);
                });
                this.$watch("filterKelas", () => {
                    setTimeout(() => lucide.createIcons(), 50);
                });
                this.$watch("fullscreenImage", () => {
                    setTimeout(() => lucide.createIcons(), 50);
                });
                this.$watch("sortByPoin", () => {
                    setTimeout(() => lucide.createIcons(), 50);
                });

                setTimeout(() => lucide.createIcons(), 100);
            },
        }),
    );
});
