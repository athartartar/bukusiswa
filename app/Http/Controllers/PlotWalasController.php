<?php

namespace App\Http\Controllers;

use App\Models\PlotWalas;
use App\Models\Guru;
use App\Models\User;
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

        if ($request->filled('id')) {
            $oldPlot = PlotWalas::find($request->id);
            if ($oldPlot && $oldPlot->id_guru != $request->id_guru) {
                $oldGuru = Guru::find($oldPlot->id_guru);
                if ($oldGuru) {
                    User::where('username', $oldGuru->nik)->update(['usertype' => 'guru']);
                }
            }
        }

        PlotWalas::updateOrCreate(
            ['id_walas' => $request->id],
            [
                'id_guru' => $request->id_guru,
                'id_kelas' => $request->id_kelas,
            ]
        );

        $newGuru = Guru::find($request->id_guru);
        if ($newGuru) {
            User::where('username', $newGuru->nik)->update(['usertype' => 'walas']);
        }

        return response()->json(['success' => 'Data Wali Kelas berhasil disimpan!']);
    }

    public function destroy($id)
    {
        $plot = PlotWalas::find($id);
        
        if ($plot) {
            $guru = Guru::find($plot->id_guru);
            if ($guru) {
                User::where('username', $guru->nik)->update(['usertype' => 'guru']);
            }
            
            $plot->delete();
        }
        
        return response()->json(['success' => 'Data Wali Kelas berhasil dihapus!']);
    }
}