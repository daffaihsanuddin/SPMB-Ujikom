<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('jurusan', function (Blueprint $table) {
            $table->id(); // id INT AI
            $table->string('kode', 10)->unique(); // UQ
            $table->string('nama', 100);
            $table->integer('kuota')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jurusan');
    }
};
