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

// Variabel global untuk menyimpan instance chart agar bisa di-destroy
var chartInstance1 = null;
var chartInstance2 = null;

document.addEventListener("livewire:navigated", () => {
    renderCharts();
});

// Initial load
renderCharts();

function renderCharts() {
    // PENTING: Hapus chart lama sebelum render baru (Mencegah Duplikasi)
    if (chartInstance1) chartInstance1.destroy();
    if (chartInstance2) chartInstance2.destroy();

    // --- CHART 1: AREA (Kehadiran) ---
    var optionsArea = {
        series: [
            {
                name: "Hadir",
                data: [1150, 1180, 1190, 1160, 1180, 1200],
            },
            {
                name: "Tidak Hadir",
                data: [90, 60, 50, 80, 60, 40],
            },
        ],
        chart: {
            height: 320, // Samakan tinggi visual
            type: "area",
            toolbar: {
                show: false,
            }, // Hilangkan menu zoom biar clean
            fontFamily: "Plus Jakarta Sans, sans-serif",
            zoom: {
                enabled: false,
            },
        },
        colors: ["#37517e", "#ef4444"],
        dataLabels: {
            enabled: false,
        },
        stroke: {
            curve: "smooth",
            width: 3,
        },
        xaxis: {
            categories: ["Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"],
            axisBorder: {
                show: false,
            },
            axisTicks: {
                show: false,
            },
            labels: {
                style: {
                    colors: "#94a3b8",
                },
            },
        },
        yaxis: {
            labels: {
                style: {
                    colors: "#94a3b8",
                },
            },
        },
        grid: {
            borderColor: "#f1f5f9",
            strokeDashArray: 4, // Garis putus-putus biar modern
        },
        fill: {
            type: "gradient",
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.6,
                opacityTo: 0.05,
                stops: [0, 90, 100],
            },
        },
        legend: {
            position: "top",
            horizontalAlign: "right",
        },
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
            height: 320, // Samakan tinggi dengan sebelahnya
            fontFamily: "Plus Jakarta Sans, sans-serif",
        },
        colors: ["#37517e", "#fb923c", "#ef4444"],
        plotOptions: {
            pie: {
                donut: {
                    size: "75%", // Lebih tipis biar modern
                    labels: {
                        show: true,
                        name: {
                            fontSize: "14px",
                            color: "#64748b",
                        },
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
        stroke: {
            show: false,
        }, // Hilangkan garis putih di antar slice
        dataLabels: {
            enabled: false,
        }, // Hilangkan angka di dalam donut biar clean
        legend: {
            position: "bottom", // Pindahkan ke bawah agar grafik tidak kegencet
            offsetY: 0,
            itemMargin: {
                horizontal: 10,
                vertical: 5,
            },
        },
    };

    var elPie = document.querySelector("#chart-pie");
    if (elPie) {
        chartInstance2 = new ApexCharts(elPie, optionsDonut);
        chartInstance2.render();
    }
}

// Animasi Masuk (Initial Load)
document.addEventListener("DOMContentLoaded", function () {
    const kiri = document.getElementById("leftPanel");
    const kanan = document.getElementById("rightPanel");

    // Kita set posisi awal (from) dan biarkan GSAP menganimasikan ke posisi asli
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
// Di file JS Login
document.addEventListener("livewire:init", () => {
    Livewire.on("loginSuccess", () => {
        const kiri = document.getElementById("leftPanel");
        const kanan = document.getElementById("rightPanel");
        const wrap = document.getElementById("loginWrapper");

        // Hapus transisi CSS bawaan agar GSAP ambil alih total
        [kiri, kanan].forEach((el) => {
            if (el) el.style.transition = "none";
        });

        const tl = gsap.timeline({
            onComplete: () => {
                window.location.href = "/dashboard";
            },
        });

        // EFEK MEMBELAH (Cepat & Tajam)
        tl.to(kiri, {
            xPercent: -100,
            opacity: 0,
            duration: 0.7, // Dipercepat biar snappy
            ease: "expo.in", // Akselerasi keluar (makin lama makin cepat)
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
            ) // Jalan bareng kiri

            // Background memutih sedikit lebih cepat agar mata siap ke dashboard
            .to(
                wrap,
                {
                    backgroundColor: "#f3f4f6", // Sesuaikan dengan warna BG Dashboard kamu
                    duration: 0.4,
                },
                "-=0.5",
            );
    });
});

// Animasi sidebar login
// Di file JS Dashboard / app.js
document.addEventListener("DOMContentLoaded", function () {
    const sidebar = document.getElementById("sidebar");
    const topbar = document.getElementById("topbar");
    const statCards = document.querySelectorAll(".gsap-card");
    const charts = document.querySelectorAll(".gsap-chart");

    // Timeline dimulai sedikit lebih cepat (delay dikurangi jadi 0.1)
    // Agar user tidak bengong nunggu animasi mulai
    const tl = gsap.timeline({ delay: 0.1 });

    // --- PHASE 1: STRUKTUR UTAMA (Sidebar & Topbar) ---
    // Durasi 1s, tapi terasa smooth karena expo.out
    tl.to(sidebar, {
        x: "0%",
        opacity: 1,
        duration: 1.0,
        ease: "expo.out", // Deselerasi (Cepat di awal, ngerem di akhir)
        onComplete: () => {
            sidebar.classList.remove("opacity-0", "-translate-x-full");
            gsap.set(sidebar, { clearProps: "all" });
        },
    })
        .to(
            topbar,
            {
                y: "0%",
                opacity: 1,
                duration: 1.0,
                ease: "expo.out",
                onComplete: () => {
                    topbar.classList.remove("opacity-0", "-translate-y-full");
                    gsap.set(topbar, { clearProps: "all" });
                },
            },
            "<",
        ) // Sidebar & Topbar masuk barengan

        // --- PHASE 2: WATERFALL KONTEN (Kartu Statistik) ---
        // Start di "-=0.7" artinya: Mulai saat Sidebar & Topbar BARU JALAN 0.3 detik.
        // Ini rahasia agar terlihat "Fluid/Menyatu"
        .to(
            statCards,
            {
                y: 0,
                opacity: 1,
                duration: 0.8,
                ease: "power3.out", // Easing sedikit lebih lembut dari sidebar
                stagger: 0.08, // Jeda antar kartu dipercepat (biar ga lambat nungguin satu2)
                onComplete: () => {
                    statCards.forEach((el) => {
                        el.classList.remove("opacity-0", "translate-y-10");
                        gsap.set(el, { clearProps: "all" });
                    });
                },
            },
            "-=0.7",
        )

        // --- PHASE 3: GRAFIK (Penutup) ---
        // Masuk berurutan setelah kartu mulai muncul
        .to(
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
});
