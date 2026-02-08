<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;

    // Nama tabel (optional jika sudah sesuai standar plural 'gurus', tapi biar aman kita tulis)
    protected $table = 'gurus';

    // PENTING: Kasih tau Laravel primary key nya ini, sesuai gambar
    protected $primaryKey = 'id_guru';

    protected $fillable = [
        'nik',
        'kodeguru',
        'namaguru',
        'status',
    ];
}
