<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('siswas', function (Blueprint $table) {
            $table->id('id_siswa'); // PK custom
            $table->string('nis')->unique();
            $table->string('namalengkap');
            $table->enum('jeniskelamin', ['L', 'P']);
            $table->string('kelas');

            // Foreign key ke users.id_user
            $table->unsignedBigInteger('id_user');

            $table->timestamps();

            $table->foreign('id_user')
                ->references('id_user')   // ini disesuaikan
                ->on('users')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('siswas');
    }
};
