<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            // 1. Primary Key kustom (id_user)
            $table->id('id_user');

            // 2. Data Diri
            $table->string('namalengkap');
            $table->string('username')->unique(); // Kita pakai username buat login
            $table->string('password');

            // 3. Tipe User & Foto
            $table->enum('usertype', ['guru', 'walas', 'bk', 'siswa', 'ortu', 'guruwali']);
            $table->string('foto')->nullable();

            // 4. Status Akun
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');

            $table->rememberToken();
            $table->timestamps();
        });

        // Tabel sessions (Wajib di Laravel 12)
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('sessions');
    }
};
