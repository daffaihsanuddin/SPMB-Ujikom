<?php
// database/seeders/MasterDataSeeder.php

namespace Database\Seeders;

use App\Models\Jurusan;
use App\Models\Gelombang;
use Illuminate\Database\Seeder;

class MasterDataSeeder extends Seeder
{
    public function run()
    {
        // Jurusan
        Jurusan::create(['kode' => 'RPL', 'nama' => 'Rekayasa Perangkat Lunak', 'kuota' => 90]);
        Jurusan::create(['kode' => 'ANM', 'nama' => 'Animasi', 'kuota' => 90]);
        Jurusan::create(['kode' => 'DKV', 'nama' => 'Desain Komunikasi Visual', 'kuota' => 90]);
        Jurusan::create(['kode' => 'AKT', 'nama' => 'Akuntasi', 'kuota' => 90]);
        Jurusan::create(['kode' => 'PMS', 'nama' => 'Pemasaran', 'kuota' => 90]);

        // Gelombang
        Gelombang::create([
            'nama' => 'Gelombang 1',
            'tahun' => 2026,
            'tgl_mulai' => '2026-01-01',
            'tgl_selesai' => '2026-03-31',
            'biaya_daftar' => 200000
        ]);
        
        Gelombang::create([
            'nama' => 'Gelombang 2', 
            'tahun' => 2026,
            'tgl_mulai' => '2026-04-01',
            'tgl_selesai' => '2026-06-30',
            'biaya_daftar' => 250000
        ]);
        Gelombang::create([
            'nama' => 'Gelombang 3', 
            'tahun' => 2026,
            'tgl_mulai' => '2026-07-01',
            'tgl_selesai' => '2026-09-30',
            'biaya_daftar' => 300000
        ]);
    }
}