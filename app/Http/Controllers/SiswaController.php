<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    // Fungsi buat Simpan (Bisa Tambah Baru atau Edit)
    public function store(Request $request)
    {
        // 1. Validasi dulu biar datanya bener
        $request->validate([
            // Cek NIS harus unik, tapi kalau lagi Edit (punya ID), abaikan ID dia sendiri
            'nis' => 'required|unique:siswas,nis,' . $request->id . ',id_siswa',
            'name' => 'required',
            'class' => 'required',
            'gender' => 'required',
        ]);
        $formattedName = ucwords(strtolower($request->name));
        // 2. Simpan ke Database
        // updateOrCreate: Kalau ID ada dia update, kalau gada dia bikin baru
        Siswa::updateOrCreate(
            ['id_siswa' => $request->id],
            [
                'nis' => $request->nis,
                'namalengkap' => $formattedName,   // Mapping: name -> namalengkap
                'kelas' => $request->class,        // Mapping: class -> kelas
                'jeniskelamin' => $request->gender // Mapping: gender -> jeniskelamin
            ]
        );

        // 3. Kirim balasan sukses ke Alpine
        return response()->json(['success' => 'Data berhasil disimpan!']);
    }

    // Fungsi buat Hapus
    public function destroy($id)
    {
        Siswa::destroy($id);
        return response()->json(['success' => 'Data berhasil dihapus!']);
    }
}
