<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('gurus', function (Blueprint $table) {
            // Sesuaikan primary key dengan gambar (id_guru)
            $table->id('id_guru');

            // Kolom sesuai gambar
            $table->string('nik')->unique(); // NIK biasanya unik
            $table->string('kodeguru');
            $table->string('namaguru');
            $table->string('status'); // Bisa diisi 'Aktif', 'Cuti', dll.

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gurus');
    }
};
