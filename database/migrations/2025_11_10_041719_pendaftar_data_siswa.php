<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pendaftar_data_siswa', function (Blueprint $table) {
            $table->unsignedBigInteger('pendaftar_id')->primary();

            $table->string('nik', 20)->nullable();
            $table->string('nisn', 20)->nullable();
            $table->string('nama', 120);
            $table->enum('jk', ['L','P']);

            $table->string('tmp_lahir', 60);
            $table->date('tgl_lahir');

            $table->text('alamat')->nullable();

            $table->unsignedBigInteger('wilayah_id')->nullable();

            $table->decimal('lat', 10, 7)->nullable();
            $table->decimal('lng', 10, 7)->nullable();

            $table->timestamps();

            // FK
            $table->foreign('pendaftar_id')->references('id')->on('pendaftar')->cascadeOnDelete();
            $table->foreign('wilayah_id')->references('id')->on('wilayah');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pendaftar_data_siswa');
    }
};
