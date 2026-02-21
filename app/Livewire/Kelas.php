<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Kelas as KelasModel;

class Kelas extends Component
{
    #[Layout('components.layouts.app')]
    public function render()
    {
        $kelases = KelasModel::select(
            'id_kelas as id',
            'kode_kelas',      
            'status'
        )->orderBy('id_kelas', 'desc')->get();

        return view('livewire.kelas', [
            'kelases' => $kelases
        ]);
    }
}