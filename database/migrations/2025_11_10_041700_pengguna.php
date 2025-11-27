<?php
// database/migrations/2024_01_01_000001_create_pengguna_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pengguna', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('hp')->nullable();
            $table->string('password_hash');
            $table->enum('role', ['pendaftar','admin','verifikator_adm','keuangan','kepsek']);
            $table->boolean('aktif')->default(false);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pengguna');
    }
};