<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    // Fungsi buat Simpan (Bisa Tambah Baru atau Edit)
    public function store(Request $request)
    {
        // 1. Validasi
        $request->validate([
            // Validasi NIK (abaikan ID sendiri saat edit)
            'nik' => 'required|unique:gurus,nik,' . $request->id . ',id_guru',
            'kodeguru' => 'required',
            // PERBAIKAN DISINI: Kita validasi input 'name' (karena dari Alpine dikirimnya 'name')
            'name' => 'required',
            'status' => 'required',
        ]);

        // Format nama jadi Huruf Besar Di Awal
        // Ambil dari $request->name (bukan namaguru)
        $formattedName = ucwords(strtolower($request->name));

        // 2. Simpan ke Database
        Guru::updateOrCreate(
            ['id_guru' => $request->id],
            [
                'nik' => $request->nik,
                'kodeguru' => $request->kodeguru,
                // Masukkan $formattedName ke kolom 'namaguru' database
                'namaguru' => $formattedName,
                'status' => $request->status,
            ]
        );

        // 3. Kirim balasan sukses
        return response()->json(['success' => 'Data Guru berhasil disimpan!']);
    }

    // Fungsi buat Hapus
    public function destroy($id)
    {
        Guru::destroy($id);
        return response()->json(['success' => 'Data Guru berhasil dihapus!']);
    }
}
