<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
Schema::create('pendaftar', function (Blueprint $table) {
    $table->bigIncrements('id');
    $table->foreignId('user_id')->constrained('pengguna');
    $table->datetime('tanggal_daftar');
    $table->string('no_pendaftaran', 20)->unique();
    $table->foreignId('gelombang_id')->constrained('gelombang');
    $table->foreignId('jurusan_id')->constrained('jurusan');
    $table->enum('status', ['SUBMIT','ADM_PASS','ADM_REJECT','PAID'])->default('SUBMIT');
    $table->string('user_verifikasi_adm', 100)->nullable();
    $table->datetime('tgl_verifikasi_adm')->nullable();
    $table->string('user_verifikasi_payment', 100)->nullable();
    $table->datetime('tgl_verifikasi_payment')->nullable();
    $table->timestamps();
    
    $table->index('status');
});
    }

    public function down(): void
    {
        Schema::dropIfExists('pendaftar');
    }
};
