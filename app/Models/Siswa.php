<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_siswa';

protected $fillable = [
        'nis',
        'namalengkap',
        'jeniskelamin',
        'kelas',
        'id_user'
    ];

    public function pelanggarans()
    {
        return $this->hasMany(Pelanggaran::class, 'id_siswa', 'id_siswa');
    }

    public function pembinaans()
    {
        return $this->hasMany(Pembinaan::class, 'id_siswa', 'id_siswa');
    }
}
