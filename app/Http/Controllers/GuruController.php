<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\User;
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

        $formattedName = ucwords(strtolower($request->name));

        $guru = Guru::updateOrCreate(
            ['id_guru' => $request->id],
            [
                'nik' => $request->nik,
                'kodeguru' => $request->kodeguru,
                'namaguru' => $formattedName,
                'status' => $request->status,
            ]
        );

        if ($guru->wasRecentlyCreated) {
            User::create([
                'namalengkap' => $formattedName,
                'username'    => $request->nik,
                'password'    => Hash::make('guru123'),
                'usertype'    => 'guru',
                'status'      => 'aktif',
            ]);
        } else {
            $user = User::where('username', $request->nik)->first();
            if ($user) {
                $user->update([
                    'namalengkap' => $formattedName
                ]);
            }
        }

        return response()->json(['success' => 'Data Guru berhasil disimpan!']);
    }

    public function destroy($id)
    {
        $guru = Guru::find($id);
        if ($guru) {
            User::where('username', $guru->nik)->delete();
            $guru->delete();
        }
        
        return response()->json(['success' => 'Data Guru berhasil dihapus!']);
    }
}