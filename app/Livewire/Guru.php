<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Guru as GuruModel;

class Guru extends Component
{
    #[Layout('components.layouts.app')]
    public function render()
    {
        $gurus = GuruModel::select(
            'id_guru as id',
            'nik',      
            'kodeguru',
            'namaguru as name',
            'status'
        )->orderBy('id_guru', 'desc')->get();

        return view('livewire.guru', [
            'gurus' => $gurus
        ]);
    }
}
