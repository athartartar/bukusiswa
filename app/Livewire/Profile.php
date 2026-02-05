<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule as ValidationRule;

class Profile extends Component
{
    use WithFileUploads;

    public $isEditMode = false;
    public $passwordVerified = false;

    public $namalengkap;
    public $username;

    #[Rule('nullable|image|max:2048')]
    public $photo;

    // Password
    public $current_password;
    public $password;
    public $password_confirmation;

    #[Layout('components.layouts.app')]
    public function mount()
    {
        $user = Auth::user();
        $this->namalengkap = $user->namalengkap;
        $this->username = $user->username;
    }

    public function verifyOldPassword()
    {
        // Pastikan logic ini tidak mereset isEditMode
        $this->passwordVerified = false;

        if (empty($this->current_password)) {
            $this->addError('current_password', 'Password lama tidak boleh kosong.');
            return;
        }

        if (Hash::check($this->current_password, Auth::user()->password)) {
            $this->passwordVerified = true;
            $this->resetErrorBag('current_password');
        } else {
            $this->passwordVerified = false;
            $this->addError('current_password', 'Password lama salah.');
        }
    }

    public function cancelEdit()
    {
        $this->isEditMode = false;
        $this->reset(['current_password', 'password', 'password_confirmation', 'passwordVerified', 'photo']);
        $this->resetErrorBag();
    }

    public function updateProfile()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $this->validate([
            'namalengkap' => 'required|string|max:255',
        ]);

        if ($this->passwordVerified && $this->password) {
            $this->validate([
                'password' => 'required|min:8|confirmed',
            ]);
            $user->password = Hash::make($this->password);
        }

        if ($this->photo) {
            if ($user->foto) {
                Storage::disk('public')->delete($user->foto);
            }
            $user->foto = $this->photo->store('profile-photos', 'public');
        }

        $user->namalengkap = $this->namalengkap;
        $user->save();

        $this->cancelEdit();
        $this->dispatch('profile-updated');
        session()->flash('success', 'Profil berhasil diperbarui!');
    }

    public function render()
    {
        return view('livewire.profile');
    }
}
