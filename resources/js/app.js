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

    Alpine.data(
        "siswaData",
        (initialStudents, listKelas, routeStore, csrfToken) => ({
            // --- VARIABEL UTAMA (Jangan sampai terhapus) ---
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
            students: initialStudents,

            // --- 1. FUNGSI FILTER & SORT ---
            get filteredStudents() {
                // Gunakan .slice() agar aman dari modifikasi saat disort
                let result = (this.students || []).slice();

                if (this.search !== "") {
                    const q = this.search.toLowerCase();
                    result = result.filter((s) => {
                        // Tambahkan pengaman .toString() agar error tidak terjadi jika data berupa angka
                        let nama = (s.name || "").toString().toLowerCase();
                        let nis = (s.nis || "").toString().toLowerCase();
                        let kls = (s.class || "").toString().toLowerCase();

                        return (
                            nama.includes(q) ||
                            nis.includes(q) ||
                            kls.includes(q)
                        );
                    });
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

            // --- PAGINATION ---
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

            // --- TAMPILAN DRAWER ---
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

            // --- FUNGSI INTERAKSI ---
            sortBy(col) {
                if (this.sortCol === col) {
                    this.sortAsc = !this.sortAsc;
                } else {
                    this.sortCol = col;
                    this.sortAsc = true;
                }
            },

            // --- 2. OPEN DRAWER ---
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
                    // Amankan ID (jaga-jaga kalau propertinya id_siswa)
                    this.formData.id = student.id || student.id_siswa;
                }
                this.drawerOpen = true;
            },

            updateRows() {
                this.currentPage = 1;
            },

            // --- 3. SAVE DATA ---
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
                        throw new Error(
                            result.message || "Gagal menyimpan data",
                        );

                    let newData = result.data;

                    // Update ke array langsung tanpa reload
                    if (this.drawerMode === "add") {
                        this.students.unshift(newData);
                    } else if (this.drawerMode === "edit") {
                        let index = this.students.findIndex(
                            (s) => s.id === this.formData.id,
                        );
                        if (index !== -1) {
                            this.students[index] = newData;
                        }
                    }

                    this.drawerOpen = false;
                    Toast.fire({ icon: "success", title: "Berhasil disimpan" });
                } catch (error) {
                    Toast.fire({
                        icon: "error",
                        title: "Gagal menyimpan data",
                    });
                } finally {
                    this.isLoading = false;
                }
            },

            // --- 4. DELETE DATA ---
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
                    if (!response.ok) throw new Error("Gagal menghapus data");

                    // Filter array langsung tanpa reload
                    this.students = this.students.filter(
                        (s) => s.id !== this.formData.id,
                    );

                    this.drawerOpen = false;
                    Toast.fire({ icon: "success", title: "Data dihapus" });
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
                namaguru: "",
                kode_kelas: "",
            },

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
                let result = (this.plots || []).slice(); // Copy array
                if (this.search !== "") {
                    const q = this.search.toLowerCase();
                    result = result.filter(
                        (p) =>
                            (p.namaguru &&
                                p.namaguru.toLowerCase().includes(q)) ||
                            (p.kode_kelas &&
                                p.kode_kelas.toLowerCase().includes(q)),
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
                    this.formData.id = item.id || item.id_walas;
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
                            Accept: "application/json", // Pengaman anti-crash
                            "X-CSRF-TOKEN": csrfToken,
                        },
                        body: JSON.stringify(this.formData),
                    });

                    let result = await response.json();

                    if (!response.ok) {
                        let errorMsg = result.message || "Gagal menyimpan data";
                        if (result.errors && result.errors.id_kelas)
                            errorMsg = result.errors.id_kelas[0];
                        else if (result.error) errorMsg = result.error;
                        throw new Error(errorMsg);
                    }

                    let newData = result.data;
                    newData.id = newData.id || newData.id_walas;

                    if (this.drawerMode === "add") {
                        this.plots.unshift(newData);
                    } else if (this.drawerMode === "edit") {
                        let index = this.plots.findIndex(
                            (p) => p.id === this.formData.id,
                        );
                        if (index !== -1) {
                            this.plots[index] = newData;
                        }
                    }

                    this.drawerOpen = false;
                    Swal.fire({
                        toast: true,
                        position: "top-end",
                        icon: "success",
                        title: "Berhasil disimpan",
                        showConfirmButton: false,
                        timer: 1500,
                    });
                } catch (error) {
                    Swal.fire({
                        toast: true,
                        position: "top-end",
                        icon: "error",
                        title: error.message,
                        showConfirmButton: false,
                        timer: 2500,
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
                                Accept: "application/json", // Pengaman anti-crash
                                "X-CSRF-TOKEN": csrfToken,
                            },
                        },
                    );

                    let result = await response.json();
                    if (!response.ok)
                        throw new Error(
                            result.error ||
                                result.message ||
                                "Gagal menghapus data",
                        );

                    // Filter tabel di memori
                    this.plots = this.plots.filter(
                        (p) => p.id !== this.formData.id,
                    );

                    this.drawerOpen = false;
                    Swal.fire({
                        toast: true,
                        position: "top-end",
                        icon: "success",
                        title: "Data dihapus",
                        showConfirmButton: false,
                        timer: 1500,
                    });
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

        // --- FILTER & SORT (Hanya Tampilkan Status 'aktif') ---
        get filteredUsers() {
            let result = (this.users || []).slice();

            // 1. FILTER WAJIB: HANYA TAMPILKAN YANG AKTIF
            result = result.filter((u) => u.status === "aktif");

            // 2. FILTER PENCARIAN
            if (this.search !== "") {
                const q = this.search.toLowerCase();
                result = result.filter(
                    (u) =>
                        (u.namalengkap &&
                            u.namalengkap.toLowerCase().includes(q)) ||
                        (u.username &&
                            u.username.toString().toLowerCase().includes(q)) ||
                        (u.usertype && u.usertype.toLowerCase().includes(q)),
                );
            }

            // 3. SORTING
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
            if (this.sortCol === col) this.sortAsc = !this.sortAsc;
            else {
                this.sortCol = col;
                this.sortAsc = true;
            }
            this.currentPage = 1;
        },

        openDrawer(mode, user = null) {
            this.drawerMode = mode;
            this.showPassword = false;

            if (mode === "add") {
                this.formData = {
                    id_user: null,
                    namalengkap: "",
                    username: "",
                    password: "",
                    usertype: "",
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
            this.$nextTick(
                () => typeof lucide !== "undefined" && lucide.createIcons(),
            );
        },

        updateRows() {
            this.currentPage = 1;
        },

        // --- SAVE DATA (Seamless) ---
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
                let response = await fetch(routeStore, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        Accept: "application/json", // Pengaman anti-crash
                        "X-CSRF-TOKEN": csrfToken,
                    },
                    body: JSON.stringify({
                        id: this.formData.id_user,
                        ...this.formData,
                    }),
                });

                let result = await response.json();

                if (!response.ok) {
                    let errorMsg = result.message || "Gagal menyimpan data";
                    if (result.errors && result.errors.username)
                        errorMsg = result.errors.username[0];
                    else if (result.error) errorMsg = result.error;
                    throw new Error(errorMsg);
                }

                let newData = result.data;
                newData.id_user = newData.id_user || newData.id;

                // Perbarui tabel secara langsung
                if (this.drawerMode === "add") {
                    this.users.unshift(newData);
                } else if (this.drawerMode === "edit") {
                    let index = this.users.findIndex(
                        (u) => u.id_user === this.formData.id_user,
                    );
                    if (index !== -1) {
                        this.users[index] = newData;
                    }
                }

                this.drawerOpen = false;
                Toast.fire({
                    icon: "success",
                    title: "Data berhasil disimpan",
                });
                // reload dihapus
            } catch (error) {
                Toast.fire({ icon: "error", title: error.message });
            } finally {
                this.isLoading = false;
            }
        },

        // --- DELETE DATA (Seamless) ---
        async deleteData() {
            this.isLoading = true;
            try {
                let response = await fetch(`/user/${this.formData.id_user}`, {
                    method: "DELETE",
                    headers: {
                        "Content-Type": "application/json",
                        Accept: "application/json", // Pengaman anti-crash
                        "X-CSRF-TOKEN": csrfToken,
                    },
                });

                let result = await response.json();
                if (!response.ok)
                    throw new Error(
                        result.error ||
                            result.message ||
                            "Gagal menghapus user",
                    );

                // Hapus data dari array lokal
                this.users = this.users.filter(
                    (u) => u.id_user !== this.formData.id_user,
                );

                this.drawerOpen = false;
                Toast.fire({ icon: "success", title: "User telah dihapus" });
                // reload dihapus
            } catch (error) {
                Toast.fire({ icon: "error", title: error.message });
            } finally {
                this.isLoading = false;
            }
        },

        init() {
            this.$watch("paginatedUsers", () => {
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
            this.$watch("search", () => {
                this.currentPage = 1;
            });
        },
    }));
});

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

    Alpine.data("guruData", (initialGurus, routeStore, csrfToken) => ({
        // --- VARIABEL UTAMA ---
        search: "",
        rowsPerPage: 5,
        currentPage: 1,
        drawerOpen: false,
        drawerMode: "add",
        sortCol: "name",
        sortAsc: true,
        isLoading: false,
        formData: {
            id: null,
            name: "",
            nik: "",
            kodeguru: "",
            status: "Aktif",
        },
        gurus: initialGurus,

        // --- 1. FUNGSI FILTER & SORT (Anti-Bug) ---
        get filteredGurus() {
            let result = (this.gurus || []).slice(); // Copy array agar aman
            if (this.search !== "") {
                const q = this.search.toLowerCase();
                result = result.filter(
                    (g) =>
                        (g.name && g.name.toLowerCase().includes(q)) ||
                        (g.nik && g.nik.toString().toLowerCase().includes(q)) ||
                        (g.kodeguru && g.kodeguru.toLowerCase().includes(q)),
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

        // --- 2. OPEN DRAWER (Aman dari ID Kosong) ---
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
                this.formData = { ...guru };
                // Jaga-jaga jika ID dari database bernama id_guru
                this.formData.id = guru.id || guru.id_guru;
            }
            this.drawerOpen = true;
        },

        updateRows() {
            this.currentPage = 1;
        },

        // --- 3. SAVE DATA (Tanpa Reload) ---
        // --- 3. SAVE DATA (Tanpa Reload) ---
        async saveData() {
            this.isLoading = true;
            try {
                let response = await fetch(routeStore, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        Accept: "application/json", // <--- TAMBAHKAN BARIS INI (SANGAT PENTING!)
                        "X-CSRF-TOKEN": csrfToken,
                    },
                    body: JSON.stringify(this.formData),
                });

                let result = await response.json();

                // Jika error (termasuk error validasi seperti NIK duplikat)
                if (!response.ok) {
                    // Tangkap pesan error dari validasi Laravel
                    let errorMessage = "Gagal menyimpan data";
                    if (result.errors) {
                        // Ambil pesan error pertama dari daftar validasi
                        errorMessage = Object.values(result.errors)[0][0];
                    } else if (result.error || result.message) {
                        errorMessage = result.error || result.message;
                    }
                    throw new Error(errorMessage);
                }

                let newData = result.data;
                newData.id = newData.id || newData.id_guru;

                if (this.drawerMode === "add") {
                    this.gurus.unshift(newData);
                } else if (this.drawerMode === "edit") {
                    let index = this.gurus.findIndex(
                        (g) => g.id === this.formData.id,
                    );
                    if (index !== -1) {
                        this.gurus[index] = newData;
                    }
                }

                this.drawerOpen = false;
                Toast.fire({ icon: "success", title: "Berhasil disimpan" });
            } catch (error) {
                // Sekarang toaster merah akan menampilkan error aslinya (misal: "NIK sudah terdaftar")
                Toast.fire({ icon: "error", title: error.message });
            } finally {
                this.isLoading = false;
            }
        },

        // --- 4. DELETE DATA (Tanpa Reload) ---
        async deleteData() {
            this.isLoading = true;
            try {
                let response = await fetch("/guru/" + this.formData.id, {
                    method: "DELETE",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": csrfToken,
                    },
                });
                if (!response.ok) throw new Error("Gagal menghapus data");

                // Hapus data dari array memori
                this.gurus = this.gurus.filter(
                    (g) => g.id !== this.formData.id,
                );

                this.drawerOpen = false;
                Toast.fire({ icon: "success", title: "Data dihapus" });
                // location.reload() dihapus
            } catch (error) {
                Toast.fire({ icon: "error", title: "Gagal menghapus data" });
            } finally {
                this.isLoading = false;
            }
        },

        init() {
            this.$watch("paginatedGurus", () => {
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
            // PERUBAHAN 1: Kita gunakan spread operator [...] untuk membuat 'copy' dari array.
            // Ini sangat penting agar array asli (this.kelases) tidak rusak/berubah saat di-sort.
            let result = [...this.kelases];

            if (this.search !== "") {
                const q = this.search.toLowerCase();
                result = result.filter(
                    (k) =>
                        // PERUBAHAN 2: Tambahkan pengaman (k.kode_kelas && ...)
                        // untuk mencegah error jika ada data yang kosong (undefined)
                        (k.kode_kelas &&
                            k.kode_kelas.toLowerCase().includes(q)) ||
                        (k.status && k.status.toLowerCase().includes(q)),
                );
            }

            result.sort((a, b) => {
                // PERUBAHAN 3: Tambahkan pengaman ( || "" )
                // agar jika data baru belum punya kolom yang lengkap, tidak menyebabkan bug baris kosong
                let valA = (a[this.sortCol] || "").toString().toLowerCase();
                let valB = (b[this.sortCol] || "").toString().toLowerCase();

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
        // --- OPEN DRAWER ---
        openDrawer(mode, kelas = null) {
            this.drawerMode = mode;
            if (mode === "add") {
                this.formData = {
                    id: null,
                    kode_kelas: "",
                    status: "Aktif",
                };
            } else {
                // Mode Edit atau Delete
                this.formData = { ...kelas };

                // KODE PENGAMAN: Ambil 'id' jika ada, kalau kosong ambil 'id_kelas'
                this.formData.id = kelas.id || kelas.id_kelas;
            }
            this.drawerOpen = true;
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

                // KODE PENGAMAN: Kita seragamkan data dari server
                let newData = result.data;
                newData.id = newData.id || newData.id_kelas;

                if (this.drawerMode === "add") {
                    this.kelases.unshift(newData);
                } else if (this.drawerMode === "edit") {
                    let index = this.kelases.findIndex(
                        (k) => k.id === this.formData.id,
                    );
                    if (index !== -1) {
                        this.kelases[index] = newData;
                    }
                }

                this.drawerOpen = false;
                Toast.fire({
                    icon: "success",
                    title: "Berhasil disimpan",
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
                let response = await fetch("/kelas/" + this.formData.id, {
                    method: "DELETE",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": csrfToken,
                    },
                });

                if (!response.ok) throw new Error("Gagal menghapus data");

                // Kita kembalikan menghapus menggunakan .id
                this.kelases = this.kelases.filter(
                    (k) => k.id !== this.formData.id,
                );

                this.drawerOpen = false;
                Toast.fire({
                    icon: "success",
                    title: "Data dihapus",
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
            filterRiwayat: "semua",

            get filteredRiwayat() {
                if (this.filterRiwayat === "pelanggaran") {
                    return this.riwayatList.filter(item => item.type === "pelanggaran");
                }
                if (this.filterRiwayat === "pembinaan") {
                    return this.riwayatList.filter(item => item.type === "pembinaan");
                }
                return this.riwayatList;
            },

            usertype: usertype || "guest",
            currentSiswaId: currentSiswaId || null,

            filterKelas: "",
            sortByPoin: "",

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

            formPembinaan: {
                tindakan: "",
                feedback: "",
                pengurangan_poin: 0
            },
            isLoadingPembinaan: false,

            get isMobile() {
                return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(
                    navigator.userAgent,
                );
            },
            get isSiswa() {
                return this.usertype === "siswa";
            },
            get canCreate() {
                return this.usertype !== "siswa";
            },

            get totalSelectedPoin() {
                let total = 0;
                for (let key in this.selectedPelanggaran) {
                    if (this.selectedPelanggaran[key])
                        total += this.selectedPelanggaran[key].poin;
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
                let result = (this.students || []).slice(); // Copy Array
                if (this.search !== "") {
                    const q = this.search.toLowerCase();
                    result = result.filter(
                        (s) =>
                            (s.name && s.name.toLowerCase().includes(q)) ||
                            (s.nis &&
                                s.nis.toString().toLowerCase().includes(q)) ||
                            (s.class && s.class.toLowerCase().includes(q)),
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
                        let valA = (a[this.sortCol] || "")
                            .toString()
                            .toLowerCase();
                        let valB = (b[this.sortCol] || "")
                            .toString()
                            .toLowerCase();
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
                    this.selectedPelanggaran[id] = { jenis: jenis, poin: poin };
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
                    return Toast.fire({
                        icon: "error",
                        title: "File harus berupa gambar",
                    });
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
                        setTimeout(
                            () =>
                                typeof lucide !== "undefined" &&
                                lucide.createIcons(),
                            50,
                        );
                    };
                    reader.readAsDataURL(processedFile);
                } catch (error) {
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
                if (fileInput) fileInput.value = "";
                this.photoFiles = { ...this.photoFiles };
                this.photoPreview = { ...this.photoPreview };
            },

            openFullscreen(imageUrl) {
                this.fullscreenImage = imageUrl;
                setTimeout(
                    () => typeof lucide !== "undefined" && lucide.createIcons(),
                    50,
                );
            },

            openDrawer(mode, student = null) {
                this.drawerMode = mode;
                this.selectedStudent = student;

                if (mode === "tambahPelanggaran") {
                    if (this.isSiswa)
                        return Toast.fire({
                            icon: "error",
                            title: "Siswa tidak dapat mencatat pelanggaran",
                        });
                    this.selectedPelanggaran = {};
                    this.photoFiles = {};
                    this.photoPreview = {};
                    this.keteranganTambahan = "";
                }

                if (mode === "tindakPembinaan" || mode === "tindakSP") {
                    this.formPembinaan = {
                        tindakan: "",
                        feedback: "",
                        pengurangan_poin: mode === "tindakSP" ? 0 : "" // SP tidak ngurangin poin
                    };
                }

                if (mode === "riwayat") {
                    this.filterRiwayat = "semua";
                    this.loadRiwayat(student.id || student.id_siswa);
                }

                this.drawerOpen = true;
            },

                async loadRiwayat(studentId) {
                this.isLoadingRiwayat = true;
                this.riwayatList = [];
                try {
                    let res = await fetch(`/pelanggaran/riwayat/${studentId}`);
                    if (!res.ok) throw new Error("Gagal load");
                    this.riwayatList = await res.json();
                } catch (e) {
                    Toast.fire({
                        icon: "error",
                        title: "Gagal memuat riwayat",
                    });
                } finally {
                    this.isLoadingRiwayat = false;
                    setTimeout(
                        () =>
                            typeof lucide !== "undefined" &&
                            lucide.createIcons(),
                        100,
                    );
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

            // ================= UPDATE POIN REALTIME (HELPER) =================
            updateSiswaPoin(studentId, newTotal) {
                let index = this.students.findIndex(
                    (s) => (s.id || s.id_siswa) === studentId,
                );
                if (index !== -1) {
                    this.students[index].total_poin = newTotal;
                }
                // Jika sedang buka riwayat, update header poinnya juga
                if (
                    this.selectedStudent &&
                    (this.selectedStudent.id ||
                        this.selectedStudent.id_siswa) === studentId
                ) {
                    this.selectedStudent.total_poin = newTotal;
                }
            },

            // ================= SAVE BATCH (SEAMLESS) =================
            async savePelanggaranBatch() {
                if (Object.keys(this.selectedPelanggaran).length === 0) {
                    return Toast.fire({
                        icon: "warning",
                        title: "Pilih minimal 1 pelanggaran",
                    });
                }
                this.isLoading = true;
                try {
                    const keys = Object.keys(this.selectedPelanggaran);
                    const totalItems = keys.length;
                    let lastResponseData = null;
                    let allSuccess = true;

                    for (let i = 0; i < totalItems; i++) {
                        let pelanggaranId = keys[i];
                        const pelanggaran =
                            this.selectedPelanggaran[pelanggaranId];
                        const isLastItem = i === totalItems - 1;

                        const formData = new FormData();
                        formData.append(
                            "id_siswa",
                            this.selectedStudent.id ||
                                this.selectedStudent.id_siswa,
                        );
                        formData.append("jenis_pelanggaran", pelanggaran.jenis);
                        formData.append("poin", pelanggaran.poin);
                        formData.append("keterangan", this.keteranganTambahan);
                        formData.append("is_last", isLastItem ? "1" : "0");
                        if (this.photoFiles[pelanggaranId])
                            formData.append(
                                "bukti_foto",
                                this.photoFiles[pelanggaranId],
                            );

                        const response = await fetch("/pelanggaran/store", {
                            method: "POST",
                            headers: {
                                "X-CSRF-TOKEN": csrfToken,
                                Accept: "application/json", // Anti crash
                            },
                            body: formData,
                        });

                        if (!response.ok) {
                            allSuccess = false;
                            break;
                        }

                        let responseData = await response.json();
                        if (isLastItem) lastResponseData = responseData;
                    }

                    if (allSuccess) {
                        this.drawerOpen = false;

                        // UPDATE UI POIN SECARA REALTIME!
                        if (
                            lastResponseData &&
                            lastResponseData.total_poin !== undefined
                        ) {
                            this.updateSiswaPoin(
                                this.selectedStudent.id ||
                                    this.selectedStudent.id_siswa,
                                lastResponseData.total_poin,
                            );
                        }

                        if (
                            lastResponseData &&
                            lastResponseData.swal_konfirmasi
                        ) {
                            Toast.fire({
                                icon: lastResponseData.swal_konfirmasi.icon,
                                title: lastResponseData.swal_konfirmasi.text,
                            }); // location.reload() DIHAPUS
                        } else {
                            Toast.fire({
                                icon: "success",
                                title: `${totalItems} pelanggaran berhasil dicatat`,
                            });
                        }
                    } else {
                        throw new Error("Beberapa pelanggaran gagal disimpan");
                    }
                } catch (error) {
                    Toast.fire({
                        icon: "error",
                        title: "Gagal menyimpan pelanggaran",
                    });
                } finally {
                    this.isLoading = false;
                }
            },

// ================= SUBMIT PEMBINAAN & SP =================
            async submitPembinaan() {
                if (!this.formPembinaan.tindakan) {
                    return Toast.fire({
                        icon: "warning",
                        title: "Pilih tindakan terlebih dahulu!",
                    });
                }

                this.isLoadingPembinaan = true;

                try {
                    const formData = new FormData();
                    formData.append("id_siswa", this.selectedStudent.id || this.selectedStudent.id_siswa);
                    formData.append("tindakan", this.formPembinaan.tindakan);
                    formData.append("feedback", this.formPembinaan.feedback || "");
                    
                    // Kalau ini mode SP dari kesiswaan, pengurangan poin selalu 0
                    let poinKurang = this.drawerMode === 'tindakSP' ? 0 : (this.formPembinaan.pengurangan_poin || 0);
                    formData.append("pengurangan_poin", poinKurang);

                    const response = await fetch("/pembinaan/store", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": csrfToken,
                            Accept: "application/json",
                        },
                        body: formData,
                    });

                    const data = await response.json();

                    if (!response.ok) {
                        throw new Error(data.message || "Gagal menyimpan pembinaan");
                    }

                    // Berhasil
                    this.drawerOpen = false;

                    // Update total poin siswa secara realtime di UI
                    if (data.total_poin !== undefined) {
                        this.updateSiswaPoin(this.selectedStudent.id || this.selectedStudent.id_siswa, data.total_poin);
                    }

                    Toast.fire({
                        icon: "success",
                        title: this.drawerMode === 'tindakSP' ? "Surat Peringatan dicatat!" : "Pembinaan berhasil dicatat!",
                    });

                } catch (error) {
                    Toast.fire({
                        icon: "error",
                        title: error.message || "Terjadi kesalahan sistem",
                    });
                } finally {
                    this.isLoadingPembinaan = false;
                }
            },

            // ================= DELETE PELANGGARAN (SEAMLESS) =================
            async deletePelanggaran(id_pelanggaran) {
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
                                Accept: "application/json", // Anti crash
                            },
                        },
                    );

                    const data = await response.json();

                    if (response.ok && data.success) {
                        // UPDATE UI POIN SECARA REALTIME
                        if (data.total_poin !== undefined) {
                            this.updateSiswaPoin(
                                this.selectedStudent.id ||
                                    this.selectedStudent.id_siswa,
                                data.total_poin,
                            );
                        }

                        // HILANGKAN DATA DARI LIST RIWAYAT TANPA RELOAD
                        this.riwayatList = this.riwayatList.filter(
                            (r) => r.id_pelanggaran !== id_pelanggaran,
                        );

                        Toast.fire({
                            icon: "success",
                            title: "Pelanggaran berhasil dihapus",
                        }); // location.reload() DIHAPUS
                    } else {
                        throw new Error(data.message || "Gagal menghapus");
                    }
                } catch (error) {
                    Toast.fire({
                        icon: "error",
                        title: error.message || "Gagal menghapus pelanggaran",
                    });
                }
            },

            updateRows() {
                this.currentPage = 1;
            },

            init() {
                this.$watch("paginatedStudents", () => {
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
                this.$watch("selectedPelanggaran", () => {
                    setTimeout(
                        () =>
                            typeof lucide !== "undefined" &&
                            lucide.createIcons(),
                        50,
                    );
                });
                this.$watch("photoPreview", () => {
                    setTimeout(
                        () =>
                            typeof lucide !== "undefined" &&
                            lucide.createIcons(),
                        50,
                    );
                });
                this.$watch("filterRiwayat", () => {
                    setTimeout(
                        () =>
                            typeof lucide !== "undefined" &&
                            lucide.createIcons(),
                        50,
                    );
                });
                this.$watch("filterKelas", () => {
                    setTimeout(
                        () =>
                            typeof lucide !== "undefined" &&
                            lucide.createIcons(),
                        50,
                    );
                });
                this.$watch("sortByPoin", () => {
                    setTimeout(
                        () =>
                            typeof lucide !== "undefined" &&
                            lucide.createIcons(),
                        50,
                    );
                });

                setTimeout(
                    () => typeof lucide !== "undefined" && lucide.createIcons(),
                    100,
                );
            },
        }),
    );
});
