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
        $this->usertype = $user->usertype ?? 'guest';

        // Jika usertype siswa, ambil id_siswa mereka
        if ($this->usertype === 'siswa') {
            $siswa = SiswaModel::where('id_user', $user->id_user)->first();
            if ($siswa) {
                $this->currentSiswaId = $siswa->id_siswa;
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

        $user = Auth::user();
        $dicatatOleh = $user->namalengkap ?? $user->name ?? 'admin';

        PelanggaranModel::create([
            'id_siswa' => $this->id_siswa,
            'tanggal' => $this->tanggal,
            'jenis_pelanggaran' => $this->jenis_pelanggaran,
            'poin' => $this->poin,
            'keterangan' => $this->keterangan,
            'dicatat_oleh' => $dicatatOleh,
        ]);

        session()->flash('success', 'Pelanggaran berhasil ditambahkan');

        $this->reset([
            'id_siswa',
            'tanggal',
            'jenis_pelanggaran',
            'poin',
            'keterangan',
        ]);
    }

    public function render()
    {
        $user = Auth::user();
        $usertype = $user->usertype ?? 'guest';

        if ($usertype === 'siswa') {
            $siswa = SiswaModel::where('id_user', $user->id)->first();
        // Membersihkan spasi dan memaksa huruf kecil agar validasi akurat
        $usertype = strtolower(trim($user->usertype ?? 'guest'));

        $data = [];
        $students = [];

        // 1. JIKA USER ADALAH SISWA
        if ($usertype === 'siswa') {
            // Cari data siswa berdasarkan ID User yang login
            $siswa = SiswaModel::where('id_user', $user->id_user)->first();

            if ($siswa) {
                $data = PelanggaranModel::query()
                    ->select(
                        'pelanggarans.*',
                        'siswas.namalengkap as nama_siswa',
                        'siswas.kelas',
                        \DB::raw('COALESCE(users.namalengkap, pelanggarans.dicatat_oleh) as nama_pencatat')
                    )
                    ->join('siswas', 'pelanggarans.id_siswa', '=', 'siswas.id_siswa')
                    ->leftJoin('users', \DB::raw('users.namalengkap COLLATE utf8mb4_unicode_ci'), '=', \DB::raw('pelanggarans.dicatat_oleh COLLATE utf8mb4_unicode_ci'))
                    ->where('pelanggarans.id_siswa', $siswa->id_siswa)
                    ->where('pelanggarans.id_siswa', $siswa->id_siswa) // <--- PENTING: Filter ID Siswa
                    ->orderBy('id_pelanggaran', 'desc')
                    ->get()
                    ->map(function ($item) {
                        $item->dicatat_oleh = $item->nama_pencatat;
                        return $item;
                    });

                $students = collect([
                    (object) [
                        'id' => $siswa->id_siswa,
                        'name' => $siswa->namalengkap,
                        'class' => $siswa->kelas,
                        'nis' => $siswa->nis,
                        'total_poin' => PelanggaranModel::where('id_siswa', $siswa->id_siswa)->sum('poin'),
                    ]
                ]);
            } else {
                $students = collect([]);
                // Jika akun tipe siswa tapi datanya belum ada di tabel 'siswas'
                $data = collect([]);
                $students = collect([]);
            }
        } else {
        }
        // 2. JIKA USER ADALAH ADMIN / GURU / WALAS
        else {
            $data = PelanggaranModel::join('siswas', 'pelanggarans.id_siswa', '=', 'siswas.id_siswa')
                ->leftJoin('users', \DB::raw('users.namalengkap COLLATE utf8mb4_unicode_ci'), '=', \DB::raw('pelanggarans.dicatat_oleh COLLATE utf8mb4_unicode_ci'))
                ->select(
                    'pelanggarans.*',
                    'siswas.namalengkap as nama_siswa',
                    'siswas.kelas',
                    \DB::raw('COALESCE(users.namalengkap, pelanggarans.dicatat_oleh) as nama_pencatat')
                )
                ->orderBy('id_pelanggaran', 'desc')
                ->get()
                ->map(function ($item) {
                    $item->dicatat_oleh = $item->nama_pencatat;
                    return $item;
                });

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
            'currentSiswaId' => $this->currentSiswaId,
        ]);
    }
}
