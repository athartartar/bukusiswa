<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class GuruController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nik' => 'required|unique:gurus,nik,' . $request->id . ',id_guru',
            'kodeguru' => 'required',
            'name' => 'required',
            'status' => 'required',
        ]);

        try {
            $guruData = DB::transaction(function () use ($request) {
                $formattedName = ucwords(strtolower($request->name));

                // 1. AMBIL NIK LAMA SEBELUM DI-UPDATE
                $guruLama = Guru::find($request->id);
                $oldNik = $guruLama ? $guruLama->nik : null;

                // 2. Simpan Data Guru
                $guru = Guru::updateOrCreate(
                    ['id_guru' => $request->id],
                    [
                        'nik' => $request->nik,
                        'kodeguru' => $request->kodeguru,
                        'namaguru' => $formattedName,
                        'status' => $request->status,
                    ]
                );

                // 3. Sinkronisasi dengan tabel User
                if ($guru->wasRecentlyCreated) {
                    // Buat baru jika ini guru baru
                    User::create([
                        'namalengkap' => $formattedName,
                        'username'    => $request->nik,
                        'password'    => Hash::make('guru123'),
                        'usertype'    => 'guru',
                        'status'      => 'aktif',
                    ]);
                } else {
                    // PENTING: Cari User menggunakan NIK LAMA
                    $user = User::where('username', $oldNik)->first();
                    if ($user) {
                        $user->update([
                            'username' => $request->nik, // Ganti username ke NIK baru
                            'namalengkap' => $formattedName
                        ]);
                    }
                }

                return $guru;
            });

            return response()->json([
                'success' => 'Data Guru berhasil disimpan!',
                'data' => [
                    'id'       => $guruData->id_guru ?? $guruData->id,
                    'nik'      => $guruData->nik,
                    'name'     => $guruData->namaguru,
                    'kodeguru' => $guruData->kodeguru,
                    'status'   => $guruData->status
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Gagal menyimpan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            DB::transaction(function () use ($id) {
                $guru = Guru::find($id);
                if ($guru) {
                    // Jadikan status user 'nonaktif' sebelum dihapus dari tabel guru
                    $user = User::where('username', $guru->nik)->first();
                    if ($user) {
                        $user->update(['status' => 'nonaktif']);
                    }

                    $guru->delete();
                }
            });

            return response()->json(['success' => 'Data Guru berhasil dihapus!']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal menghapus data: ' . $e->getMessage()], 500);
        }
    }
}
