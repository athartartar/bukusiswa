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
    Alpine.data("siswaData", (initialStudents, routeStore, csrfToken) => ({
        search: "",
        rowsPerPage: 5,
        currentPage: 1,
        drawerOpen: false,
        drawerMode: "add",
        sortCol: "name",
        sortAsc: true,
        isLoading: false,
        formData: { id: null, name: "", nis: "", class: "", gender: "" },

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
            return Math.ceil(this.filteredStudents.length / this.rowsPerPage);
        },
        get paginatedStudents() {
            let start = (this.currentPage - 1) * this.rowsPerPage;
            return this.filteredStudents.slice(start, start + this.rowsPerPage);
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
                    throw new Error(result.message || "Gagal menyimpan data");

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
    }));
});

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
        drawerMode: "add", // add, edit, delete
        sortCol: "namalengkap",
        sortAsc: true,
        isLoading: false,

        // Sesuai dengan struktur tabel database Anda
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

        // ===== LOGIC FILTER & PAGINATION (Tetap Sama) =====
        get filteredUsers() {
            let result = this.users;
            if (this.search !== "") {
                const q = this.search.toLowerCase();
                result = result.filter(u => 
                    u.namalengkap.toLowerCase().includes(q) ||
                    u.username.toLowerCase().includes(q) ||
                    u.usertype.toLowerCase().includes(q)
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

        get totalPages() { return Math.ceil(this.filteredUsers.length / this.rowsPerPage); },
        get paginatedUsers() {
            let start = (this.currentPage - 1) * this.rowsPerPage;
            return this.filteredUsers.slice(start, start + this.rowsPerPage);
        },

        // ===== DRAWER CONTROL =====
        get drawerTitle() {
            return { add: "Tambah User Baru", edit: "Edit Informasi User", delete: "Hapus User" }[this.drawerMode];
        },

        get drawerDescription() {
            return { 
                add: "Silahkan lengkapi data kredensial user baru.", 
                edit: "Perbarui data user. Kosongkan password jika tidak ingin mengubahnya.", 
                delete: "Tindakan ini permanen. User tidak akan bisa login kembali." 
            }[this.drawerMode];
        },

        openDrawer(mode, user = null) {
            this.drawerMode = mode;
            if (mode === "add") {
                this.formData = {
                    id_user: null,
                    namalengkap: "",
                    username: "",
                    password: "",
                    usertype: "siswa", // default
                    foto: "",
                    status: "aktif",
                };
            } else {
                // Mapping data dari tabel ke form
                this.formData = {
                    id_user: user.id_user,
                    namalengkap: user.namalengkap,
                    username: user.username,
                    password: "", // Jangan tampilkan password lama
                    usertype: user.usertype,
                    foto: user.foto || "",
                    status: user.status,
                };
            }
            this.drawerOpen = true;
            // Trigger Lucide icons setelah drawer render
            this.$nextTick(() => lucide.createIcons());
        },

        // ===== DATABASE ACTIONS =====
        async saveData() {
            // Validasi sederhana
            if(!this.formData.namalengkap || !this.formData.username || !this.formData.usertype) {
                return Toast.fire({ icon: 'warning', title: 'Mohon lengkapi data wajib' });
            }

            this.isLoading = true;
            try {
                // Jika edit, arahkan ke route update (biasanya /users/{id})
                let url = this.drawerMode === 'edit' ? `${routeStore}/${this.formData.id_user}` : routeStore;
                let method = this.drawerMode === 'edit' ? "PUT" : "POST";

                let response = await fetch(url, {
                    method: method,
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": csrfToken,
                        "Accept": "application/json"
                    },
                    body: JSON.stringify(this.formData),
                });

                if (!response.ok) throw new Error("Server Error");

                this.drawerOpen = false;
                Toast.fire({ icon: "success", title: "Data berhasil disimpan" })
                    .then(() => location.reload());

            } catch (error) {
                Toast.fire({ icon: "error", title: "Gagal menyimpan data" });
            } finally {
                this.isLoading = false;
            }
        },

        async deleteData() {
            this.isLoading = true;
            try {
                let response = await fetch(`${routeStore}/${this.formData.id_user}`, {
                    method: "DELETE",
                    headers: {
                        "X-CSRF-TOKEN": csrfToken,
                        "Accept": "application/json"
                    },
                });

                if (!response.ok) throw new Error();

                this.drawerOpen = false;
                Toast.fire({ icon: "success", title: "User telah dihapus" })
                    .then(() => location.reload());

            } catch (error) {
                Toast.fire({ icon: "error", title: "Gagal menghapus user" });
            } finally {
                this.isLoading = false;
            }
        },

        init() {
            // Re-inisialisasi icon saat ganti halaman atau drawer terbuka
            this.$watch("currentPage", () => this.$nextTick(() => lucide.createIcons()));
            this.$watch("search", () => { this.currentPage = 1; this.$nextTick(() => lucide.createIcons()); });
            this.$nextTick(() => lucide.createIcons());
        }
    }));
});
