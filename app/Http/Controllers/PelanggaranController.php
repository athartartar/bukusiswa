<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelanggaran;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PelanggaranController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'id_siswa' => 'required|exists:siswas,id_siswa',
            'jenis_pelanggaran' => 'required|string',
            'poin' => 'required|integer',
            'keterangan' => 'nullable|string',
            'bukti_foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        // Simpan namalengkap dari tabel users
        $dicatatOleh = 'guest';

        if (Auth::check()) {
            $user = Auth::user();
            // Prioritaskan namalengkap, fallback ke name/username/email
            $dicatatOleh = $user->namalengkap ?? $user->name ?? $user->username ?? $user->email ?? 'admin';
        }

        $data = [
            'id_siswa' => $request->id_siswa,
            'tanggal' => now()->format('Y-m-d'),
            'jenis_pelanggaran' => $request->jenis_pelanggaran,
            'poin' => $request->poin,
            'keterangan' => $request->keterangan,
            'dicatat_oleh' => $dicatatOleh,
        ];

        if ($request->hasFile('bukti_foto')) {
            $file = $request->file('bukti_foto');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('bukti', $fileName, 'public');
            $data['bukti_foto'] = $path;
        }

        $pelanggaran = Pelanggaran::create($data);

        $this->updateTotalPoin($request->id_siswa);

        return response()->json([
            'success' => true,
            'message' => 'Pelanggaran berhasil disimpan',
            'data' => $pelanggaran
        ], 201);
    }

    public function riwayat($id_siswa)
    {
        $user = Auth::user();

        if ($user && $user->usertype === 'siswa') {
            $siswa = Siswa::where('id_user', $user->id)->first();

            // Ambil siswa berdasarkan user
            $siswa = Siswa::where('id_user', $user->id_user)->first();
            
            // Jika bukan siswa ini, return kosong atau error
            if (!$siswa || $siswa->id_siswa != $id_siswa) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda hanya bisa melihat riwayat sendiri'
                ], 403);
            }
        }

        $riwayat = Pelanggaran::where('pelanggarans.id_siswa', $id_siswa)
            ->leftJoin('users', \DB::raw('users.namalengkap COLLATE utf8mb4_unicode_ci'), '=', \DB::raw('pelanggarans.dicatat_oleh COLLATE utf8mb4_unicode_ci'))
            ->select(
                'pelanggarans.*',
                \DB::raw('COALESCE(users.namalengkap, pelanggarans.dicatat_oleh) as nama_pencatat')
            )
            ->orderBy('pelanggarans.created_at', 'desc')
            ->get()
            ->map(function ($item) use ($user) {
                $item->dicatat_oleh = $item->nama_pencatat;

                $item->can_delete = false;

                if ($user) {
                    if ($user->usertype === 'admin') {
                        $item->can_delete = true;
                    } else {
                        $userNama = $user->namalengkap ?? $user->name ?? $user->username ?? $user->email;
                        if ($item->dicatat_oleh === $userNama) {
                            $item->can_delete = true;
                        }
                    }
                }

                return $item;
            });

        return response()->json($riwayat);
    }

    private function updateTotalPoin($id_siswa)
    {
        try {
            $siswa = Siswa::where('id_siswa', $id_siswa)->first();

            if ($siswa) {
                $totalPoin = Pelanggaran::where('id_siswa', $id_siswa)->sum('poin');

                if (isset($siswa->total_poin) || array_key_exists('total_poin', $siswa->getAttributes())) {
                    $siswa->update(['total_poin' => $totalPoin]);
                }
            }
        } catch (\Exception $e) {
            \Log::info('Total poin tidak diupdate: ' . $e->getMessage());
        }
    }

    public function destroy($id_pelanggaran)
    {
        $pelanggaran = Pelanggaran::where('id_pelanggaran', $id_pelanggaran)->firstOrFail();

        $user = Auth::user();
        $canDelete = false;

        if ($user) {
            if ($user->usertype === 'admin') {
                $canDelete = true;
            } else {
                $userNama = $user->namalengkap ?? $user->name ?? $user->username ?? $user->email;
                if ($pelanggaran->dicatat_oleh === $userNama) {
                    $canDelete = true;
                }
            }
        }

        if (!$canDelete) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki izin untuk menghapus pelanggaran ini'
            ], 403);
        }

        if ($pelanggaran->bukti_foto) {
            Storage::disk('public')->delete($pelanggaran->bukti_foto);
        }

        $id_siswa = $pelanggaran->id_siswa;
        $pelanggaran->delete();

        $this->updateTotalPoin($id_siswa);

        return response()->json([
            'success' => true,
            'message' => 'Pelanggaran berhasil dihapus'
        ]);
    }
}