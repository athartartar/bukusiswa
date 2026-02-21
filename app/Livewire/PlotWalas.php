<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\PlotWalas as PlotWalasModel;
use App\Models\Guru;
use App\Models\Kelas;

class PlotWalas extends Component
{
    #[Layout('components.layouts.app')]
    public function render()
    {
        // Ambil data plotting beserta relasinya
        $plots = PlotWalasModel::with(['guru', 'kelas'])
            ->orderBy('id_walas', 'desc')
            ->get()
            ->map(function ($plot) {
                return [
                    'id' => $plot->id_walas,
                    'id_guru' => $plot->id_guru,
                    'id_kelas' => $plot->id_kelas,
                    'namaguru' => $plot->guru->namaguru ?? 'Guru Dihapus',
                    'kode_kelas' => $plot->kelas->kode_kelas ?? 'Kelas Dihapus',
                ];
            });

        // Ambil list guru & kelas untuk dropdown (Hanya yang Aktif)
        $gurus = Guru::where('status', 'Aktif')->select('id_guru', 'namaguru')->orderBy('namaguru', 'asc')->get();
        $kelases = Kelas::where('status', 'Aktif')->select('id_kelas', 'kode_kelas')->orderBy('kode_kelas', 'asc')->get();

        return view('livewire.plot-walas', [
            'plots' => $plots,
            'gurus' => $gurus,
            'kelases' => $kelases
        ]);
    }
}
