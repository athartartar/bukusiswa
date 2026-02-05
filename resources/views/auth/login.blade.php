<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body class="min-h-screen flex bg-slate-100 font-[\'Plus Jakarta Sans\',sans-serif]">

    <!-- KIRI -->
    <div class="hidden md:flex w-1/2 relative bg-[#37517e]
            items-center justify-center p-10 overflow-hidden">

        <!-- BG IMAGE (overlay) -->
        <div class="absolute inset-0 bg-center bg-cover opacity-10"
            style="background-image: url('/images/upnvj.jpg');">
        </div>

        <!-- CONTENT -->
        <div class="relative z-10 text-white text-center max-w-md">
            <img src="/images/logosmk.png"
                alt="Logo"
                class="mx-auto mb-6 w-28 h-auto">

            <h1 class="text-3xl font-bold mb-4">
                Selamat Datang
            </h1>
            <p class="text-white/80">
                Silakan login untuk melanjutkan ke sistem.
            </p>
        </div>
    </div>


    <!-- KANAN -->
    <div class="w-full md:w-1/2 flex items-center justify-center p-6">

        <!-- CARD -->
        <div class="w-full max-w-sm
            border-[#37517e] border-2
            p-8 rounded-xl shadow-xl hover:shadow-2xl transition-shadow duration-300
            min-h-[360px]
            flex flex-col justify-center
            bg-gradient-to-br
            from-white
            to-[#37517e]">


            <h1 class="text-2xl font-semibold mb-8 text-center text-[#37517e]">
                Login
            </h1>

            <form class="space-y-6">

                <!-- Username -->
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">
                        Username
                    </label>

                    <div class="relative">
                        <!-- Icon @ -->
                        <span
                            class="absolute inset-y-0 left-3 flex items-center
                            text-gray-400 pointer-events-none">
                            <i data-lucide="at-sign" class="w-4 h-4"></i>
                        </span>

                        <input
                            type="number"
                            placeholder="Masukkan username..."
                            class="peer w-full text-sm
                            rounded-lg
                            pl-8 pr-3 py-2.5
                            bg-[#fafafa]
                            border-2 border-[#37517e]
                            placeholder-gray-400
                            placeholder:opacity-0
                            placeholder:translate-x-[-8px]
                            placeholder:transition-all
                            placeholder:duration-300
                            focus:placeholder:opacity-100
                            focus:placeholder:translate-x-0
                            focus:outline-none
                            focus:border-[#37517e]
                            focus:ring-1
                            focus:ring-[#37517e]/30">
                    </div>
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">
                        Password
                    </label>

                    <div class="relative">
                        <!-- Icon lock (kiri) -->
                        <span
                            class="absolute inset-y-0 left-3 flex items-center
                   text-gray-400 pointer-events-none">
                            <i data-lucide="lock" class="w-4 h-4"></i>
                        </span>

                        <input
                            id="password"
                            type="password"
                            placeholder="Masukkan password.."
                            class="peer w-full text-sm
                   rounded-lg
                   pl-9 pr-10 py-2.5
                   bg-[#fafafa]
                   border-2 border-[#37517e]
                   placeholder-gray-400
                   placeholder:opacity-0
                   placeholder:-translate-x-2
                   placeholder:transition-all
                   placeholder:duration-500
                   focus:placeholder:opacity-100
                   focus:placeholder:translate-x-0
                   focus:outline-none
                   focus:border-[#37517e]
                   focus:ring-1
                   focus:ring-[#37517e]/30">

                        <!-- Toggle password (kanan) -->
                        <button
                            type="button"
                            onclick="togglePassword()"
                            class="absolute inset-y-0 right-0 px-3
                            flex items-center text-gray-400
                        hover:text-[#37517e]">

                            <!-- eye -->
                            <i id="eye" data-lucide="eye" class="w-5 h-5"></i>

                            <!-- eye-closed -->
                            <i id="eye-closed" data-lucide="eye-closed" class="w-5 h-5 hidden"></i>
                        </button>
                    </div>
                </div>

                <!-- Button -->
                <button type="button"
                    class="w-full mt-2
                    bg-[#37517e] text-white
                    py-2.5 rounded-lg
                    font-semibold text-sm
                    hover:bg-[#2c4064]
                    transition duration-200">
                    Login
                </button>

            </form>
        </div>

    </div>
    <script src="https://unpkg.com/lucide@latest"></script>
</body>

</html>