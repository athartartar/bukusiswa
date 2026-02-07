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

// Animasi sidebar login
document.addEventListener("DOMContentLoaded", function () {
    const sidebar = document.getElementById("sidebar");
    const topbar = document.getElementById("topbar");
    const statCards = document.querySelectorAll(".gsap-card");
    const charts = document.querySelectorAll(".gsap-chart");

    const tl = gsap.timeline({ delay: 0.1 });

    // Sidebar & Topbar
    tl.to(sidebar, {
        x: "0%",
        opacity: 1,
        duration: 1.0,
        ease: "expo.out",
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
        )

        // Statistik
        .to(
            statCards,
            {
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
            },
            "-=0.7",
        )

        // Grafik
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

// Animasi in Footbar (Mobile)
document.addEventListener("DOMContentLoaded", () => {
    const footbar = document.querySelector("#footbar");

    gsap.to(footbar, {
        y: 0,
        opacity: 1,
        duration: 0.8,
        ease: "expo.out",
        delay: 1,
    });
});

// Animasi Logout
document.addEventListener("DOMContentLoaded", () => {
    const logoutButton = document.getElementById("logoutButton");
    const sidebar = document.getElementById("sidebar");
    const topbar = document.getElementById("topbar");
    const statCards = document.querySelectorAll(".gsap-card");
    const charts = document.querySelectorAll(".gsap-chart");
    const footbar = document.querySelector("#footbar");

    logoutButton.addEventListener("click", (e) => {
        e.preventDefault(); // mencegah aksi default

        const tlLogout = gsap.timeline({
            onComplete: () => {
                // Submit form sekali setelah animasi selesai
                document.getElementById("logout-form").submit();
            },
        });

        // Sidebar keluar ke kiri
        tlLogout.to(sidebar, {
            x: "-100%",
            opacity: 0,
            duration: 0.8,
            ease: "expo.in",
        });

        // Topbar keluar ke atas, bersamaan dengan sidebar
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

        // Stat cards keluar ke bawah
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

        // Charts keluar ke bawah
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

        // Footbar turun/fade out di HP
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
    });
});

// Animasi hitung angka
document.addEventListener("DOMContentLoaded", initCounter);
document.addEventListener("livewire:navigated", initCounter);

function initCounter() {
    const counters = document.querySelectorAll(".counter");

    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
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
    }, { threshold: 0.6 });

    counters.forEach(c => observer.observe(c));
}

