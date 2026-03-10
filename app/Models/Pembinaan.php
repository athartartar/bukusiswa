<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembinaan extends Model
{
    protected $table = 'pembinaans';
    protected $primaryKey = 'id_pembinaan';

    protected $fillable = [
        'id_siswa',
        'tanggal',
        'dibina_oleh',
        'tindakan',
        'feedback',
        'pengurangan_poin'
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa', 'id_siswa');
    }

    public function pembina()
    {
        return $this->belongsTo(User::class, 'dibina_oleh', 'username');
    }
}