<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggaran extends Model
{
    protected $table = 'pelanggarans';
    protected $primaryKey = 'id_pelanggaran';
    
    // Gunakan timestamps Laravel default
    const CREATED_AT = 'created_at';
    const UPDATED_AT = null; // Jika tidak ada updated_at
    
    protected $fillable = [
        'id_siswa',
        'tanggal',
        'jenis_pelanggaran',
        'poin',
        'keterangan',
        'bukti_foto',
        'dicatat_oleh'
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa', 'id_siswa');
    }
    
    /**
     * Accessor untuk URL foto bukti
     */
    public function getBuktiFotoUrlAttribute()
    {
        if ($this->bukti_foto) {
            return asset('storage/' . $this->bukti_foto);
        }
        return null;
    }
}

// ini modelsnya