<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
// Panggil Model Guru yang sudah dibuat di Tahap 2
use App\Models\Guru as GuruModel;

class Guru extends Component
{
    #[Layout('components.layouts.app')]
    public function render()
    {
        // Ambil data guru, kita alias-kan beberapa kolom biar enak dipanggil di JS nanti
        $gurus = GuruModel::select(
            'id_guru as id',        // id_guru jadi id
            'nik',                  // nik tetap nik
            'kodeguru',             // kodeguru tetap kodeguru
            'namaguru as name',     // namaguru jadi name (biar konsisten sama sorting JS)
            'status'                // status tetap status
        )->orderBy('id_guru', 'desc')->get();

        return view('livewire.guru', [
            'gurus' => $gurus
        ]);
    }
}
