<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Siswa as SiswaModel;

class Siswa extends Component
{
    #[Layout('components.layouts.app')]
    public function render()
    {
        $students = SiswaModel::select(
            'id_siswa as id',
            'nis',
            'namalengkap as name',
            'kelas as class',
            'jeniskelamin as gender'
        )->orderBy('id_siswa', 'desc')->get();

        return view('livewire.siswa', [
            'students' => $students
        ]);
    }
}
