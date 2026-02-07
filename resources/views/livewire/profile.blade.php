<div wire:ignore.self x-data="{
    isEditMode: @entangle('isEditMode'),
    newPass: '',
    confirmPass: '',

    get passwordsMatch() {
        if (this.newPass === '' || this.confirmPass === '') return null;
        return this.newPass === this.confirmPass;
    }
}"
    @profile-updated.window="
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 2000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        }
    });

    Toast.fire({
        icon: 'success',
        title: 'Profil berhasil diperbarui!'
    }).then(() => {
        // Refresh halaman setelah toast selesai (opsional)
        window.location.reload();
    });
"
    class="gsap-card opacity-0 translate-y-10 bg-white text-white p-4 md:p-8 rounded-2xl shadow-2xl mb-8 w-full overflow-hidden"
    id="profile-container">

    <form wire:submit="updateProfile">
        <x-slot name="header">Menu Profil</x-slot>

        <div class="relative mb-32 md:mb-24 -mx-4 md:-mx-8 -mt-4 md:-mt-8">
            <div class="h-32 w-full bg-[#466291] opacity-80"></div>

            <div
                class="absolute -bottom-24 md:-bottom-16 left-1/2 md:left-8 -translate-x-1/2 md:translate-x-0 flex flex-col md:flex-row items-center md:items-end gap-4 md:gap-6 w-full md:w-auto px-4 md:px-8">
                <div class="relative shrink-0 group">
                    @if ($photo)
                        <img id="profile-preview" src="{{ $photo->temporaryUrl() }}"
                            class="w-32 h-32 rounded-full border-[8px] border-[#37517e] md:border-[#37517e] bg-gray-600 object-cover shadow-lg transition-filter duration-300">
                    @else
                        <img id="profile-preview"
                            src="{{ Auth::user()->foto ? asset('storage/' . Auth::user()->foto) : 'https://images.pexels.com/photos/2876486/pexels-photo-2876486.png?auto=compress&cs=tinysrgb&dpr=1&w=500' }}"
                            alt="Profile"
                            class="w-32 h-32 rounded-full border-[8px] border-[#37517e] md:border-[#37517e] bg-gray-600 object-cover shadow-lg transition-filter duration-300">
                    @endif
                    <label id="pfp-label" for="pfp-upload"
                        :class="isEditMode ? 'group-hover:opacity-100 cursor-pointer pointer-events-auto' :
                            'pointer-events-none'"
                        class="absolute inset-0 flex items-center justify-center bg-black/40 rounded-full opacity-0 transition-opacity duration-300">

                        <i data-lucide="pencil" class="w-8 h-8 text-white fill-white"></i>
                        <input type="file" wire:model="photo" id="pfp-upload" class="hidden" accept="image/*">
                    </label>

                    <div
                        class="absolute bottom-2 right-2 w-7 h-7 bg-emerald-500 border-[5px] border-[#37517e] md:border-[#37517e] rounded-full">
                    </div>
                </div>

                <div class="pb-2 text-center md:text-left">
                    <h2 id="display-name-header" class="text-2xl font-bold text-[#37517e]">
                        {{ Auth::user()->namalengkap ?? 'User' }}</h2>
                    <p class="text-[#37517e]/70 text-sm capitalize">{{ Auth::user()->usertype ?? 'Guest' }}</p>
                </div>
            </div>
            <div
                class="absolute -bottom-36 md:-bottom-12 left-1/2 md:left-auto md:right-8 -translate-x-1/2 md:translate-x-0 flex flex-row items-center gap-2">
                <button id="edit-master-btn" type="button"
                    @click="if(isEditMode) { $wire.updateProfile() } else { isEditMode = true }"
                    wire:loading.attr="disabled" wire:loading.class="opacity-75 cursor-not-allowed"
                    :class="isEditMode ? 'bg-emerald-600 hover:bg-emerald-700' : 'bg-[#37517e] hover:bg-[#2a3f63]'"
                    class="text-white text-xs md:text-sm font-bold px-6 py-3 rounded-lg transition-all shadow-md transform hover:scale-105 whitespace-nowrap flex items-center gap-2">
                    <i data-lucide="user-cog" id="btn-icon" class="w-4 h-4"></i>
                    <span id="btn-text" x-text="isEditMode ? 'Simpan Perubahan' : 'Edit Profil User'"></span>
                    <span wire:loading wire:target="updateProfile" class="ml-2">...</span>
                </button>
                <button x-show="isEditMode" type="button" wire:click="cancelEdit" x-transition
                    class="bg-[#37517e] hover:bg-[#2a3f63] text-white text-xs md:text-sm font-bold px-6 py-3 rounded-lg transition-all shadow-md transform hover:scale-105 whitespace-nowrap flex items-center gap-2">
                    <span>Batal</span>
                </button>
            </div>
        </div>
        <div class="bg-[#2d4268] rounded-2xl p-4 md:p-6 mt-20 md:mt-6 shadow-inner border border-[#415a8a]">
            <div class="divide-y divide-white/10 space-y-2">

                <div class="py-1 first:pt-0">
                    <p class="text-[10px] md:text-[11px] uppercase font-black text-blue-200/50 tracking-[0.1em] mb-2">
                        Nama Lengkap</p>
                    <input type="text" wire:model="namalengkap" :readonly="!isEditMode"
                        :class="isEditMode ? 'bg-white/10 border-solid border-white/20 focus:ring-2 focus:ring-blue-400' :
                            'border-none pointer-events-none'"
                        class="edit-input w-full bg-transparent outline-none rounded-lg p-2 text-white font-medium transition-all
                        @error('namalengkap') !border-red-500 !ring-1 !ring-red-500 @enderror">

                    @error('namalengkap')
                        <p class="text-[10px] mt-1 text-red-400 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <div class="py-1">
                    <p class="text-[10px] md:text-[11px] uppercase font-black text-blue-200/50 tracking-[0.1em] mb-2">
                        Username</p>
                    <input type="text" wire:model="username" readonly
                        class="edit-input w-full bg-transparent border-none outline-none pointer-events-none rounded-lg p-2 text-white/50 font-medium transition-all">
                </div>

                {{-- SECTION PASSWORD --}}
                <div id="password-section" x-show="isEditMode" x-transition class="pt-4">

                    <h3 class="text-emerald-400 font-bold text-sm mb-3 flex items-center gap-2">
                        <i data-lucide="lock" class="w-4 h-4"></i>
                        Ganti Password (Opsional)
                    </h3>

                    <div class="py-1" x-data="{ show: false }">
                        <p
                            class="text-[10px] md:text-[11px] uppercase font-black text-blue-200/50 tracking-[0.1em] mb-2">
                            Password Lama</p>

                        <div class="relative flex gap-2">
                            <div class="relative w-full">
                                <input :type="show ? 'text' : 'password'" wire:model="current_password"
                                    @if ($passwordVerified) readonly @endif
                                    placeholder="Masukan password lama"
                                    class="w-full bg-white/10 border border-white/20 focus:ring-2 focus:ring-emerald-400 outline-none rounded-lg p-2 pr-10 text-white font-medium transition-all placeholder-white/20 
                                    @if ($passwordVerified) border-emerald-500 text-emerald-300 @endif
                                    @error('current_password') !border-red-500 !text-red-300 !ring-1 !ring-red-500 @enderror">

                                <button type="button" @click="show = !show" wire:ignore
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-white/70 hover:text-white transition-colors outline-none">
                                    <i x-show="!show" data-lucide="eye" class="w-4 h-4"></i>
                                    <i x-show="show" data-lucide="eye-off" class="w-4 h-4"></i>
                                </button>
                            </div>

                            @if (!$passwordVerified)
                                <button type="button" wire:click.prevent="verifyOldPassword"
                                    class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg font-bold text-xs transition-colors shadow-lg">
                                    CEK
                                </button>
                            @else
                                <div
                                    class="bg-emerald-500/20 border border-emerald-500 text-emerald-400 px-4 py-2 rounded-lg flex items-center justify-center">
                                    <i data-lucide="check" class="w-4 h-4"></i>
                                </div>
                            @endif
                        </div>
                        @error('current_password')
                            <p class="text-[10px] mt-1 text-red-400 font-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    @if ($passwordVerified)
                        <div class="mt-4 space-y-2 border-t border-white/5 pt-2" x-transition.opacity>

                            <div class="py-1" x-data="{ show: false }">
                                <p
                                    class="text-[10px] md:text-[11px] uppercase font-black text-blue-200/50 tracking-[0.1em] mb-2">
                                    Password Baru</p>
                                <div class="relative">
                                    <input :type="show ? 'text' : 'password'" wire:model="password" x-model="newPass"
                                        placeholder="Password baru"
                                        class="w-full bg-white/10 border border-white/20 focus:ring-2 focus:ring-emerald-400 outline-none rounded-lg p-2 pr-10 text-white font-medium transition-all placeholder-white/20
                                    @error('password') !border-red-500 !ring-1 !ring-red-500 @enderror">

                                    <button type="button" @click="show = !show" wire:ignore
                                        class="absolute right-3 top-1/2 -translate-y-1/2 text-white/70 hover:text-white transition-colors outline-none">
                                        <i x-show="!show" data-lucide="eye" class="w-4 h-4"></i>
                                        <i x-show="show" data-lucide="eye-off" class="w-4 h-4"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <p class="text-[10px] mt-1 text-red-400 font-bold">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="py-1" x-data="{ show: false }">
                                <p
                                    class="text-[10px] md:text-[11px] uppercase font-black text-blue-200/50 tracking-[0.1em] mb-2">
                                    Ulangi Password Baru</p>
                                <div class="relative">
                                    <input :type="show ? 'text' : 'password'" wire:model="password_confirmation"
                                        x-model="confirmPass" placeholder="Ulangi password baru"
                                        :class="passwordsMatch === false ? '!border-red-500 focus:ring-red-500' : (
                                            passwordsMatch === true ? '!border-emerald-500 focus:ring-emerald-500' :
                                            'border-white/20 focus:ring-emerald-400')"
                                        class="w-full bg-white/10 border outline-none rounded-lg p-2 pr-10 text-white font-medium transition-all placeholder-white/20">

                                    <button type="button" @click="show = !show" wire:ignore
                                        class="absolute right-3 top-1/2 -translate-y-1/2 text-white/70 hover:text-white transition-colors outline-none">
                                        <i x-show="!show" data-lucide="eye" class="w-4 h-4"></i>
                                        <i x-show="show" data-lucide="eye-off" class="w-4 h-4"></i>
                                    </button>
                                </div>

                                <p x-show="passwordsMatch === true"
                                    class="text-[10px] mt-1 text-emerald-400 font-bold">Password baru cocok!</p>
                                <p x-show="passwordsMatch === false" class="text-[10px] mt-1 text-red-400 font-bold">
                                    Password baru tidak sama!</p>
                            </div>
                        </div>
                    @endif

                </div>
                @if (session('success'))
                    <div class="pt-2 text-center" x-transition>
                        <p class="text-[10px] text-emerald-400 font-bold tracking-wide">
                            {{ session('success') }}
                        </p>
                    </div>
                @endif
            </div>
        </div>

    </form>

    <div class="mt-3 flex justify-center md:justify-start">
        <button id="logoutButton"
            class="flex w-full md:w-auto items-center px-4 py-3 text-white bg-[#cc0000] hover:bg-[#800000] hover:text-red-200 rounded-lg transition-colors">
            <i data-lucide="log-out" class="w-5 h-5 mr-3"></i>
            <span class="font-medium">Logout</span>
        </button>
    </div>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
        @csrf
    </form>

</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
