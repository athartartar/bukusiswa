<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Pelanggaran as PelanggaranModel;
use App\Models\Siswa as SiswaModel;
use Illuminate\Support\Facades\Auth;

class Pelanggaran extends Component
{
    #[Layout('components.layouts.app')]

    public $id_siswa;
    public $tanggal;
    public $jenis_pelanggaran;
    public $poin;
    public $keterangan;
    public $bukti_foto;

    // User info
    public $usertype;
    public $currentSiswaId = null;

    public function mount()
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();
        // Pastikan usertype selalu huruf kecil agar pengecekan tidak gagal
        $this->usertype = strtolower(trim($user->usertype ?? 'guest'));

        // Jika usertype siswa, ambil id_siswa mereka
        if ($this->usertype === 'siswa') {
            $siswa = SiswaModel::where('id_user', $user->id_user)->first();
            if ($siswa) {
                $this->currentSiswaId = $siswa->id_siswa;
                // Opsional: Langsung set form id_siswa ke id dia sendiri
                $this->id_siswa = $siswa->id_siswa;
            }
        }
    }

    public function simpan()
    {
        $this->validate([
            'id_siswa' => 'required',
            'tanggal' => 'required',
            'jenis_pelanggaran' => 'required',
            'poin' => 'required|numeric',
        ]);

        PelanggaranModel::create([
            'id_siswa' => $this->id_siswa,
            'tanggal' => $this->tanggal,
            'jenis_pelanggaran' => $this->jenis_pelanggaran,
            'poin' => $this->poin,
            'keterangan' => $this->keterangan,
            'dicatat_oleh' => Auth::user()->namalengkap ?? Auth::user()->username ?? 'admin'
        ]);

        session()->flash('success', 'Pelanggaran berhasil ditambahkan');

        $this->reset([
            'id_siswa',
            'tanggal',
            'jenis_pelanggaran',
            'poin',
            'keterangan'
        ]);
    }

    public function render()
    {
        $user = Auth::user();
        // Membersihkan spasi dan memaksa huruf kecil agar validasi akurat
        $usertype = strtolower(trim($user->usertype ?? 'guest'));

        $data = [];
        $students = [];

        // 1. JIKA USER ADALAH SISWA
        if ($usertype === 'siswa') {
            // Gunakan $user->id
            $siswa = SiswaModel::where('id_user', $user->id_user)->first();

            if ($siswa) {
                $data = PelanggaranModel::query()
                    ->select(
                        'pelanggarans.*',
                        'siswas.namalengkap as nama_siswa',
                        'siswas.kelas'
                    )
                    ->join('siswas', 'pelanggarans.id_siswa', '=', 'siswas.id_siswa')
                    ->where('pelanggarans.id_siswa', $siswa->id_siswa) // Pastikan filter ID Siswa jalan
                    ->orderBy('id_pelanggaran', 'desc')
                    ->get();

                // Dropdown hanya berisi diri sendiri
                $students = collect([
                    (object)[
                        'id' => $siswa->id_siswa,
                        'name' => $siswa->namalengkap,
                        'class' => $siswa->kelas,
                        'nis' => $siswa->nis,
                        'total_poin' => PelanggaranModel::where('id_siswa', $siswa->id_siswa)->sum('poin')
                    ]
                ]);
            } else {
                // User login sebagai siswa, tapi datanya tidak ada di tabel siswas
                $data = collect([]);
                $students = collect([]);
            }
        }
        // 2. JIKA USER ADALAH ADMIN / GURU
        else {
            $data = PelanggaranModel::join('siswas', 'pelanggarans.id_siswa', '=', 'siswas.id_siswa')
                ->select(
                    'pelanggarans.*',
                    'siswas.namalengkap as nama_siswa',
                    'siswas.kelas'
                )
                ->orderBy('id_pelanggaran', 'desc')
                ->get();

            $students = SiswaModel::select('id_siswa as id', 'namalengkap as name', 'kelas as class', 'nis')
                ->orderBy('namalengkap')
                ->get()
                ->map(function ($student) {
                    $student->total_poin = PelanggaranModel::where('id_siswa', $student->id)->sum('poin');
                    return $student;
                });
        }

        return view('livewire.pelanggaran', [
            'data' => $data,
            'students' => $students,
            'usertype' => $usertype,
            'currentSiswaId' => $this->currentSiswaId
        ]);
    }
}
