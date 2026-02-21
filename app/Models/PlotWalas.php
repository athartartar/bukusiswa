<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlotWalas extends Model
{
    use HasFactory;

    protected $table = 'plot_walas';
    protected $primaryKey = 'id_walas';

    protected $fillable = [
        'id_guru',
        'id_kelas',
    ];

    // Relasi ke tabel gurus
    public function guru()
    {
        return $this->belongsTo(Guru::class, 'id_guru', 'id_guru');
    }

    // Relasi ke tabel kelas
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas', 'id_kelas');
    }
}
