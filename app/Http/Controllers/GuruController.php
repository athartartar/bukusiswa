<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use Illuminate\Http\Request;

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

        Guru::updateOrCreate(
            ['id_guru' => $request->id],
            [
                'nik' => $request->nik,
                'kodeguru' => $request->kodeguru,
                'namaguru' => $formattedName,
                'status' => $request->status,
            ]
        );

        return response()->json(['success' => 'Data Guru berhasil disimpan!']);
    }

    public function destroy($id)
    {
        Guru::destroy($id);
        return response()->json(['success' => 'Data Guru berhasil dihapus!']);
    }
}
