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

        try {
            $plotData = \Illuminate\Support\Facades\DB::transaction(function () use ($request) {
                // Kembalikan status guru lama jika edit
                if ($request->filled('id')) {
                    $oldPlot = PlotWalas::find($request->id);
                    if ($oldPlot && $oldPlot->id_guru != $request->id_guru) {
                        $oldGuru = Guru::find($oldPlot->id_guru);
                        if ($oldGuru) {
                            User::where('username', $oldGuru->nik)->update(['usertype' => 'guru']);
                        }
                    }
                }

                // Simpan plotting baru
                $plot = PlotWalas::updateOrCreate(
                    ['id_walas' => $request->id],
                    [
                        'id_guru' => $request->id_guru,
                        'id_kelas' => $request->id_kelas,
                    ]
                );

                // Update status guru baru
                $newGuru = Guru::find($request->id_guru);
                if ($newGuru) {
                    User::where('username', $newGuru->nik)->update(['usertype' => 'walas']);
                }

                // CARI NAMA GURU DAN KODE KELAS UNTUK DITAMPILKAN DI TABEL JAVASCRIPT
                $namaGuru = $newGuru ? $newGuru->namaguru : '';
                $kelas = \App\Models\Kelas::find($request->id_kelas);
                $kodeKelas = $kelas ? $kelas->kode_kelas : '';

                // Kembalikan data utuh
                return [
                    'id' => $plot->id_walas ?? $plot->id,
                    'id_guru' => $plot->id_guru,
                    'id_kelas' => $plot->id_kelas,
                    'namaguru' => $namaGuru,
                    'kode_kelas' => $kodeKelas
                ];
            });

            return response()->json([
                'success' => 'Data Wali Kelas berhasil disimpan!',
                'data' => $plotData
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal menyimpan: ' . $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            \Illuminate\Support\Facades\DB::transaction(function () use ($id) {
                $plot = PlotWalas::find($id);
                if ($plot) {
                    $guru = Guru::find($plot->id_guru);
                    if ($guru) {
                        User::where('username', $guru->nik)->update(['usertype' => 'guru']);
                    }
                    $plot->delete();
                }
            });

            return response()->json(['success' => 'Data Wali Kelas berhasil dihapus!']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal menghapus data: ' . $e->getMessage()], 500);
        }
    }
}
