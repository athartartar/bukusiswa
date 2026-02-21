<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggaran extends Model
{
    protected $table = 'pelanggarans';
    protected $primaryKey = 'id_pelanggaran';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = null;

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

    public function getBuktiFotoUrlAttribute()
    {
        if ($this->bukti_foto) {
            return asset('storage/' . $this->bukti_foto);
        }
        return null;
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'dicatat_oleh', 'username');
    }
}
