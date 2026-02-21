<?php

namespace App\Http\Controllers;

use App\Models\PlotWalas;
use Illuminate\Http\Request;

class PlotWalasController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'id_guru' => 'required',
            'id_kelas' => 'required|unique:plot_walas,id_kelas,' . $request->id . ',id_walas',
        ], [
            'id_kelas.unique' => 'Kelas ini sudah memiliki Wali Kelas!'
        ]);

        PlotWalas::updateOrCreate(
            ['id_walas' => $request->id],
            [
                'id_guru' => $request->id_guru,
                'id_kelas' => $request->id_kelas,
            ]
        );

        return response()->json(['success' => 'Data Wali Kelas berhasil disimpan!']);
    }

    public function destroy($id)
    {
        PlotWalas::destroy($id);
        return response()->json(['success' => 'Data Wali Kelas berhasil dihapus!']);
    }
}
