<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Livewire\Attributes\Layout;

class Login extends Component
{
    public $username = '';
    public $password = '';

    // UBAH BARIS INI:
    // Dari 'components.layouts.app' (yang ada sidebar)
    // Menjadi 'components.layouts.guest' (yang polos khusus login)
    #[Layout('components.layouts.guest')]
    public function render()
    {
        // Pastikan file view ini sudah kamu pindahkan ke folder livewire/auth ya
        // Jika masih di folder components, sesuaikan jalurnya.
        return view('livewire.auth.login');
    }

    public function login()
    {
        $this->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('username', $this->username)->first();

        if ($user && $user->status == 'nonaktif') {
            $this->addError('username', 'Akun Anda dinonaktifkan.');
            return;
        }

        if (Auth::attempt(['username' => $this->username, 'password' => $this->password])) {
            session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        $this->addError('username', 'Username atau password salah.');
    }
}
