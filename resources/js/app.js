import "./bootstrap";

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

// Animasi laod Login
document.addEventListener("DOMContentLoaded", function () {

    const kiri = document.getElementById('leftPanel');
    const kanan = document.getElementById('rightPanel');

    setTimeout(() => {
        kiri.classList.remove('-translate-x-full', 'opacity-0');
        kanan.classList.remove('translate-x-full', 'opacity-0');

        kiri.classList.add('enter-left');
        kanan.classList.add('enter-right');
    }, 150);

});

// Animasi berhasil login
document.addEventListener("livewire:init", () => {

    Livewire.on('loginSuccess', () => {

        const kiri = document.getElementById('leftPanel');
        const kanan = document.getElementById('rightPanel');
        const wrap = document.getElementById('loginWrapper');

        kiri.classList.add('swipe-left');
        kanan.classList.add('swipe-right');
        wrap.classList.add('fade-white');

        setTimeout(() => {
            window.location.href = "/dashboard";
        }, 700);
    });

});