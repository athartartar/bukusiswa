<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    // Kasih tau Laravel primary key nya ini
    protected $primaryKey = 'id_siswa';

    protected $fillable = [
        'nis',
        'namalengkap',
        'jeniskelamin',
        'kelas',
    ];
}
