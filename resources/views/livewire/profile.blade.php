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
        window.location.reload();
    });
"
    class="gsap-card opacity-0 translate-y-10 bg-white text-[#37517e] p-4 md:p-8 rounded-2xl shadow-2xl mb-8 w-full overflow-hidden"
    id="profile-container">

    <form wire:submit="updateProfile">
        <x-slot name="header">Menu Profil</x-slot>

        <div class="relative mb-8 -mx-4 md:-mx-8 -mt-4 md:-mt-8">
            <div class="h-32 w-full bg-[#466291] opacity-80"></div>

            <div
                class="relative -mt-16 px-4 md:px-8 flex flex-col md:flex-row items-center md:items-end gap-4 md:gap-6 w-full z-10">

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

                    <label id="pfp-label" for="pfp-upload" x-show="isEditMode" x-transition
                        class="cursor-pointer absolute inset-0 flex items-center justify-center bg-black/40 rounded-full transition-opacity duration-300">
                        <i data-lucide="pencil" class="w-8 h-8 text-white fill-white"></i>
                        <input type="file" wire:model="photo" id="pfp-upload" class="hidden" accept="image/*">
                    </label>

                    <div
                        class="absolute bottom-2 right-2 w-7 h-7 bg-emerald-500 border-[5px] border-[#37517e] md:border-[#37517e] rounded-full">
                    </div>
                </div>

                <div class="w-full flex flex-col md:flex-row md:items-end md:justify-between gap-4 pb-2">

                    <div class="text-center md:text-left">
                        <div class="flex items-center justify-center md:justify-start gap-2">
                            <h2 id="display-name-header" class="text-2xl font-bold text-[#37517e]">
                                {{ Auth::user()->namalengkap ?? 'User' }}
                            </h2>

                            <button type="button" @click="isEditMode = !isEditMode"
                                class="md:hidden text-gray-400 hover:text-[#37517e] bg-gray-100/50 p-1.5 rounded-full transition-colors">
                                <i x-show="!isEditMode" data-lucide="pencil" class="w-4 h-4"></i>
                                <i x-show="isEditMode" data-lucide="pencil-off" class="w-4 h-4 text-red-500"></i>
                            </button>
                        </div>
                        <p class="text-[#37517e]/70 text-sm capitalize">{{ Auth::user()->usertype ?? 'Guest' }}</p>
                    </div>

                    <div class="hidden md:flex items-center gap-2">
                        <button id="edit-master-btn" type="button"
                            @click="if(isEditMode) { $wire.updateProfile() } else { isEditMode = true }"
                            wire:loading.attr="disabled" wire:loading.class="opacity-75 cursor-not-allowed"
                            :class="isEditMode ? 'bg-emerald-600 hover:bg-emerald-700' : 'bg-[#37517e] hover:bg-[#2a3f63]'"
                            class="text-white text-xs md:text-sm font-bold px-6 py-3 rounded-lg transition-all shadow-md transform hover:scale-105 whitespace-nowrap flex items-center gap-2">
                            <i data-lucide="user-cog" id="btn-icon" class="w-4 h-4"></i>
                            <span id="btn-text" x-text="isEditMode ? 'Simpan Perubahan' : 'Edit Profil User'"></span>
                            <span wire:loading wire:target="updateProfile" class="ml-2">...</span>
                        </button>
                        <button x-show="isEditMode" type="button" wire:click="cancelEdit" @click="isEditMode = false"
                            x-transition
                            class="bg-[#37517e] hover:bg-[#2a3f63] text-white text-xs md:text-sm font-bold px-6 py-3 rounded-lg transition-all shadow-md transform hover:scale-105 whitespace-nowrap flex items-center gap-2">
                            <span>Batal</span>
                        </button>
                    </div>

                </div>
            </div>
        </div>

        <div x-show="isEditMode" x-collapse x-transition
            class="bg-[#2d4268] rounded-2xl p-4 md:p-6 shadow-inner border border-[#415a8a] text-white mb-8">

            <div class="md:hidden flex justify-end gap-2 mb-4">
                <button type="button" wire:click="cancelEdit" @click="isEditMode = false"
                    class="text-xs bg-red-500/20 text-red-200 px-3 py-1 rounded border border-red-500/50">Batal</button>
                <button type="submit"
                    class="text-xs bg-emerald-500 text-white px-3 py-1 rounded font-bold shadow-lg">Simpan</button>
            </div>

            <div class="divide-y divide-white/10 space-y-2">

                <div class="py-1 first:pt-0">
                    <p class="text-[10px] md:text-[11px] uppercase font-black text-blue-200/50 tracking-[0.1em] mb-2">
                        Nama Lengkap</p>
                    <input type="text" wire:model="namalengkap"
                        class="bg-white/10 border-solid border-white/20 focus:ring-2 focus:ring-blue-400 edit-input w-full outline-none rounded-lg p-2 text-white font-medium transition-all
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

                <div id="password-section" class="pt-4">
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
                                    <i x-show="show" data-lucide="eye-closed" class="w-4 h-4"></i>
                                </button>
                            </div>
                            @if (!$passwordVerified)
                                <button type="button" wire:click.prevent="verifyOldPassword"
                                    class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg font-bold text-xs transition-colors shadow-lg">CEK</button>
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
                                        class="w-full bg-white/10 border border-white/20 focus:ring-2 focus:ring-emerald-400 outline-none rounded-lg p-2 pr-10 text-white font-medium transition-all placeholder-white/20 @error('password') !border-red-500 !ring-1 !ring-red-500 @enderror">
                                    <button type="button" @click="show = !show" wire:ignore
                                        class="absolute right-3 top-1/2 -translate-y-1/2 text-white/70 hover:text-white transition-colors outline-none">
                                        <i x-show="!show" data-lucide="eye" class="w-4 h-4"></i>
                                        <i x-show="show" data-lucide="eye-closed" class="w-4 h-4"></i>
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
                                        <i x-show="show" data-lucide="eye-closed" class="w-4 h-4"></i>
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
                        <p class="text-[10px] text-emerald-400 font-bold tracking-wide">{{ session('success') }}</p>
                    </div>
                @endif
            </div>
        </div>

        @php
            $score = Auth::user()->score_pelanggaran ?? 70;
            $maxScore = 100;

            // Logika Warna
            if ($score >= 75) {
                $statusColor = 'text-red-600';
                $statusText = 'BAHAYA';
                $barColor = 'text-red-500';
            } elseif ($score >= 50) {
                $statusColor = 'text-yellow-500';
                $statusText = 'WASPADA';
                $barColor = 'text-yellow-400';
            } else {
                $statusColor = 'text-emerald-500';
                $statusText = 'AMAN';
                $barColor = 'text-emerald-500';
            }

            $circumference = 126;
            $percent = min($score / $maxScore, 1);
            $dashOffset = $circumference - $circumference * $percent;
        @endphp

        <div class="mb-8 w-full">
            <div
                class="bg-white rounded-xl shadow-[0_3px_10px_rgb(0,0,0,0.1)] border border-gray-100 p-6 flex flex-col md:flex-row items-center gap-8 md:gap-12">

                <div
                    class="w-full md:w-1/2 flex flex-col items-center justify-center border-b md:border-b-0 md:border-r border-gray-100 pb-6 md:pb-0 md:pr-6">
                    <div class="relative w-48 h-24 overflow-hidden flex justify-center items-end">
                        <svg viewBox="0 0 100 55" class="w-full h-full">
                            <path d="M 10 50 A 40 40 0 0 1 90 50" fill="none" stroke="#e2e8f0" stroke-width="8"
                                stroke-linecap="round" />
                            <path d="M 10 50 A 40 40 0 0 1 90 50" fill="none"
                                class="{{ $barColor }} transition-all duration-1000 ease-out"
                                stroke="currentColor" stroke-width="8" stroke-linecap="round" stroke-dasharray="126"
                                stroke-dashoffset="{{ $dashOffset }}" />
                        </svg>
                        <div class="absolute bottom-0 flex flex-col items-center translate-y-1">
                            <span class="text-4xl font-black {{ $statusColor }}">{{ $score }}</span>
                        </div>
                    </div>
                    <div class="w-48 flex justify-between px-4 mt-2 text-[10px] text-gray-400 font-medium">
                        <span>0</span>
                        <span>100</span>
                    </div>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-2 mb-1">Poin Pelanggaran
                    </p>
                    <p class="text-sm font-black {{ $statusColor }}">{{ $statusText }}</p>

                </div>

                <div class="w-full md:w-1/2 flex flex-col justify-center">
                    <h4 class="text-[#37517e] font-bold text-sm mb-4 flex items-center gap-2">
                        <i data-lucide="info" class="w-4 h-4"></i>
                        Panduan Poin Siswa
                    </h4>
                    <div class="space-y-3">
                        <div class="flex items-start gap-3">
                            <div class="w-2 h-2 rounded-full bg-emerald-500 mt-1.5 shrink-0"></div>
                            <div>
                                <span class="text-xs font-bold text-gray-700">0 - 49 Poin (Aman)</span>
                                <p class="text-[10px] text-gray-400 leading-tight">Siswa berstatus aman.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="w-2 h-2 rounded-full bg-yellow-400 mt-1.5 shrink-0"></div>
                            <div>
                                <span class="text-xs font-bold text-gray-700">50 - 74 Poin (Waspada)</span>
                                <p class="text-[10px] text-gray-400 leading-tight">Perlu bimbingan konseling.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="w-2 h-2 rounded-full bg-red-500 mt-1.5 shrink-0"></div>
                            <div>
                                <span class="text-xs font-bold text-gray-700">75 - 100 Poin (Bahaya)</span>
                                <p class="text-[10px] text-gray-400 leading-tight">Potensi skorsing.</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </form>

    <div class="mt-3 flex justify-center md:justify-end">
        <button id="logoutButton"
            class="flex w-full md:w-auto items-center justify-center px-4 py-3 text-white bg-[#cc0000] hover:bg-[#800000] hover:text-red-200 rounded-lg transition-colors">
            <i data-lucide="log-out" class="w-5 h-5 mr-3"></i>
            <span class="font-medium">Logout</span>
        </button>
    </div>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
        @csrf
    </form>

</div>