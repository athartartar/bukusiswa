<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('plot_walas', function (Blueprint $table) {
            $table->id('id_walas');
            $table->unsignedBigInteger('id_guru');
            // Satu kelas hanya boleh punya 1 wali kelas, makanya kita kasih unique()
            $table->unsignedBigInteger('id_kelas')->unique();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('plot_walas');
    }
};
