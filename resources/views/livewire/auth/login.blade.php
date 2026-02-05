<div id="loginWrapper" class="min-h-screen flex bg-white overflow-hidden">

    <div id="leftPanel" wire:ignore class="hidden md:flex w-1/2 relative bg-[#37517e] items-center justify-center p-10 overflow-hidden opacity-0">
        <div class="absolute inset-0 bg-center bg-cover opacity-10" style="background-image: url('/images/upnvj.jpg');">
        </div>

        <div class="relative z-10 text-white text-center max-w-md">
            <img src="/images/logosmk.png" alt="Logo" class="mx-auto mb-6 w-28 h-auto">
            <h1 class="text-3xl font-bold mb-4">Selamat Datang</h1>
            <p class="text-white/80">Silakan login untuk melanjutkan ke sistem.</p>
        </div>
    </div>

    <div id="rightPanel" wire:ignore class="w-full md:w-1/2 flex items-center justify-center p-6 opacity-0">
        <div class="md:hidden absolute top-40 left-1/2 -translate-x-1/2 text-center">
            <img src="/images/logosmk.png" alt="Logo" class="mx-auto mb-3 w-20 h-auto">
            <h1 class="text-xl font-bold text-[#37517e]">Selamat Datang</h1>
            <p class="text-xs text-gray-500">Silakan login untuk melanjutkan</p>
        </div>

        <div class="w-full max-w-sm z-10 mt-32 md:mt-0
                    border-[#37517e] border-2
                    p-8 rounded-xl shadow-xl hover:shadow-2xl transition-shadow duration-300
                    min-h-[360px]
                    flex flex-col justify-center
                    bg-gradient-to-br from-white to-[#37517e]">

            <h1 class="text-2xl font-semibold mb-8 text-center text-[#37517e]">
                Login
            </h1>

            <form wire:submit="login" class="space-y-6">
                @if (session()->has('error'))
                <div class="p-3 bg-red-100 border border-red-400 text-red-700 rounded text-sm text-center">
                    {{ session('error') }}
                </div>
                @endif

                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">
                        Username
                    </label>

                    <div class="relative">
                        <span class="absolute inset-y-0 left-3 flex items-center text-gray-400 pointer-events-none">
                            <i data-lucide="at-sign" class="w-4 h-4"></i>
                        </span>

                        <input wire:model="username" type="number" placeholder="Masukkan username..." class="peer w-full text-sm
                                   rounded-lg
                                   pl-8 pr-3 py-2.5
                                   bg-[#fafafa]
                                   border-2
                                   @error('username') border-red-500 @else border-[#37517e] @enderror
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
                    @error('username') <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div x-data="{ show: false }">
                    <label class="block text-xs font-semibold text-gray-700 mb-1">
                        Password
                    </label>

                    <div class="relative">
                        <span class="absolute inset-y-0 left-3 flex items-center text-gray-400 pointer-events-none">
                            <i data-lucide="lock" class="w-4 h-4"></i>
                        </span>

                        <input wire:model="password" :type="show ? 'text' : 'password'"
                            placeholder="Masukkan password.." class="peer w-full text-sm
                                   rounded-lg
                                   pl-9 pr-10 py-2.5
                                   bg-[#fafafa]
                                   border-2
                                   @error('password') border-red-500 @else border-[#37517e] @enderror
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

                        <button type="button" @click="show = !show"
                            class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-400 hover:text-[#37517e] focus:outline-none">

                            <i x-show="!show" data-lucide="eye" class="w-5 h-5"></i>
                            <i x-show="show" data-lucide="eye-closed" class="w-5 h-5" style="display: none;"></i>
                        </button>
                    </div>
                    @error('password') <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="w-full mt-2
                           bg-[#37517e] text-white
                           py-2.5 rounded-lg
                           font-semibold text-sm
                           hover:bg-[#2c4064]
                           transition duration-200
                           disabled:opacity-50 disabled:cursor-not-allowed">
                    <span wire:loading.remove>Login</span>
                    <span wire:loading>Memproses...</span>
                </button>

            </form>
        </div>

    </div>
</div>