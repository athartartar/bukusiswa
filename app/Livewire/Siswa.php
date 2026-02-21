<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Siswa as SiswaModel;
use App\Models\Kelas; // Tambahkan ini untuk memanggil model Kelas

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

        // Ambil data kode_kelas dari tabel kelas yang statusnya Aktif
        $kelasOptions = Kelas::where('status', 'Aktif')
            ->orderBy('kode_kelas', 'asc')
            ->pluck('kode_kelas');

        return view('livewire.siswa', [
            'students' => $students,
            'kelasOptions' => $kelasOptions // Kirim data kelas ke file blade
        ]);
    }
}
