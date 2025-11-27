<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pendaftar_berkas', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('pendaftar_id');

            $table->enum('jenis', [
                'IJAZAH',
                'RAPOR',
                'KIP',
                'KKS',
                'AKTA',
                'KK',
                'LAINNYA'
            ]);

            $table->string('nama_file', 255);
            $table->string('url', 255);
            $table->integer('ukuran_kb')->nullable();

            // status validasi
            $table->tinyInteger('valid')->default(0); 
            // 0 = belum diperiksa, 1 = valid, 2 = ditolak (opsional kalau ingin)

            $table->string('catatan', 255)->nullable();

            $table->timestamps();

            // FK
            $table->foreign('pendaftar_id')
                  ->references('id')
                  ->on('pendaftar')
                  ->cascadeOnDelete();

            // INDEX
            $table->index(['pendaftar_id', 'jenis']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pendaftar_berkas');
    }
};
