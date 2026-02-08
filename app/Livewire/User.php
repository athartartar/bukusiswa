<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\User as UserModel;

class User extends Component
{
    #[Layout('components.layouts.app')]
    public function render()
    {
        $users = UserModel::select(
            'id_user as id',
            'namalengkap',
            'username',
            'usertype',
            'foto',
            'status',
            'created_at'
        )
        ->orderBy('id_user','desc')
        ->get();

        return view('livewire.user', [
            'users' => $users
        ]);
    }
}
