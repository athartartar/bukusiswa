<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;

class SiswaController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required|unique:siswas,nis,' . $request->id . ',id_siswa',
            'name' => 'required',
            'class' => 'required',
            'gender' => 'required',
        ]);
        $formattedName = ucwords(strtolower($request->name));
        Siswa::updateOrCreate(
            ['id_siswa' => $request->id],
            [
                'nis' => $request->nis,
                'namalengkap' => $formattedName, 
                'kelas' => $request->class,       
                'jeniskelamin' => $request->gender 
            ]
        );

        return response()->json(['success' => 'Data berhasil disimpan!']);
    }

    public function destroy($id)
    {
        Siswa::destroy($id);
        return response()->json(['success' => 'Data berhasil dihapus!']);
    }
}
