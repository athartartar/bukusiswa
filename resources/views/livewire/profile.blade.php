<div class="gsap-card opacity-0 translate-y-10 bg-white text-white p-4 md:p-8 rounded-2xl shadow-2xl mb-8 w-full" id="profile-container">
    <x-slot name="header">Profile</x-slot>
    <div class="relative mb-32 md:mb-24"> 
        <div class="h-32 w-full bg-[#466291] rounded-t-xl opacity-80"></div>
        
        <div class="absolute -bottom-24 md:-bottom-16 left-1/2 md:left-8 -translate-x-1/2 md:translate-x-0 flex flex-col md:flex-row items-center md:items-end gap-4 md:gap-6 w-full md:w-auto">
            <div class="relative shrink-0 group">
                <img id="profile-preview" src="https://images.pexels.com/photos/2876486/pexels-photo-2876486.png?auto=compress&cs=tinysrgb&dpr=1&w=500" 
                     alt="Profile" 
                     class="w-32 h-32 rounded-full border-[8px] border-[#37517e] md:border-[#37517e] bg-gray-600 object-cover shadow-lg transition-filter duration-300">
                
                <label for="pfp-upload" class="absolute inset-0 flex items-center justify-center bg-black/40 rounded-full opacity-0 group-hover:opacity-100 cursor-pointer transition-opacity duration-300">
                    <i data-lucide="pencil" class="w-8 h-8 text-white"></i>
                    <input type="file" id="pfp-upload" class="hidden" accept="image/*" onchange="previewImage(event)">
                </label>

                <div class="absolute bottom-2 right-2 w-7 h-7 bg-emerald-500 border-[5px] border-[#37517e] md:border-[#37517e] rounded-full"></div>
            </div>
            
            <div class="pb-2 text-center md:text-left"> 
                <h2 id="display-name-header" class="text-2xl font-bold text-[#37517e]">Athartartar</h2>
                <p class="text-[#37517e]/70 text-sm">User Personal Settings</p>
            </div>
        </div>

        <div class="absolute -bottom-36 md:-bottom-12 left-1/2 md:left-auto md:right-0 -translate-x-1/2 md:translate-x-0">
            <button id="edit-master-btn" onclick="toggleEditMode()" class="bg-[#37517e] hover:bg-[#2a3f63] text-white text-xs md:text-sm font-bold px-8 py-3 rounded-lg transition-all shadow-md transform hover:scale-105 whitespace-nowrap flex items-center gap-2">
                <i data-lucide="user-cog" id="btn-icon" class="w-4 h-4"></i>
                <span id="btn-text">Edit User Profile</span>
            </button>
        </div>
    </div>

    <div class="bg-[#2d4268] rounded-2xl p-4 md:p-6 mt-20 md:mt-6 shadow-inner border border-[#415a8a]">
        <div class="divide-y divide-white/10 space-y-2">
            
            <div class="py-1 first:pt-0">
                <p class="text-[10px] md:text-[11px] uppercase font-black text-blue-200/50 tracking-[0.1em] mb-2">Display Name</p>
                <input type="text" value="Athartartar" readonly class="edit-input w-full bg-transparent border-none focus:ring-2 focus:ring-blue-400 rounded-lg p-2 text-white font-medium transition-all outline-none">
            </div>

            <div class="py-1">
                <p class="text-[10px] md:text-[11px] uppercase font-black text-blue-200/50 tracking-[0.1em] mb-2">Username</p>
                <input type="text" value="japzlure" readonly class="edit-input w-full bg-transparent border-none focus:ring-2 focus:ring-blue-400 rounded-lg p-2 text-white font-medium transition-all outline-none">
            </div>

            <div class="py-1">
                <p class="text-[10px] md:text-[11px] uppercase font-black text-blue-200/50 tracking-[0.1em] mb-2">Email</p>
                <input type="email" value="japzlure@gmail.com" readonly class="edit-input w-full bg-transparent border-none focus:ring-2 focus:ring-blue-400 rounded-lg p-2 text-white font-medium transition-all outline-none">
            </div>

            <div class="py-1 last:pb-0">
                <p class="text-[10px] md:text-[11px] uppercase font-black text-blue-200/50 tracking-[0.1em] mb-2">Phone Number</p>
                <input type="text" value="+62 812 3456 6025" readonly class="edit-input w-full bg-transparent border-none focus:ring-2 focus:ring-blue-400 rounded-lg p-2 text-white font-medium transition-all outline-none">
            </div>

        </div>
    </div>
</div>

<script>
    let isEditMode = false;

    function toggleEditMode() {
        isEditMode = !isEditMode;
        const btn = document.getElementById('edit-master-btn');
        const btnText = document.getElementById('btn-text');
        const inputs = document.querySelectorAll('.edit-input');
        
        if (isEditMode) {
            // Mode Edit Aktif
            btn.classList.replace('bg-[#37517e]', 'bg-emerald-600');
            btn.classList.add('hover:bg-emerald-700');
            btnText.innerText = 'Save Changes';
            
            inputs.forEach(input => {
                input.readOnly = false;
                input.classList.add('bg-white/10', 'border-solid', 'border-white/20');
                input.classList.remove('border-none');
            });
        } else {
            // Kembali ke Mode View (Simpan)
            btn.classList.replace('bg-emerald-600', 'bg-[#37517e]');
            btn.classList.remove('hover:bg-emerald-700');
            btnText.innerText = 'Edit User Profile';
            
            inputs.forEach(input => {
                input.readOnly = true;
                input.classList.remove('bg-white/10', 'border-white/20');
                input.classList.add('border-none');
            });
            
            // Contoh update header nama secara statis
            document.getElementById('display-name-header').innerText = inputs[0].value;
            alert('Changes saved! (Static Preview Only)');
        }
    }

    // Fungsi Preview Image
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function(){
            const output = document.getElementById('profile-preview');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>