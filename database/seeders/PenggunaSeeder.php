<?php
// database/seeders/PenggunaSeeder.php

namespace Database\Seeders;

use App\Models\Pengguna;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PenggunaSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'nama' => 'Admin SPMB',
                'email' => 'admin@gmail.com',
                'hp' => '081234567890',
                'password_hash' => Hash::make('admin123'),
                'role' => 'admin',
                'aktif' => true,
            ],
            [
                'nama' => 'Verifikator Administrasi',
                'email' => 'verifikator@gmail.com',
                'hp' => '081234567891',
                'password_hash' => Hash::make('verifikator123'),
                'role' => 'verifikator_adm',
                'aktif' => true,
            ],
            [
                'nama' => 'Bagian Keuangan',
                'email' => 'keuangan@gmail.com',
                'hp' => '081234567892',
                'password_hash' => Hash::make('keuangan123'),
                'role' => 'keuangan',
                'aktif' => true,
            ],
            [
                'nama' => 'Kepala Sekolah',
                'email' => 'kepsek@gmail.com',
                'hp' => '081234567893',
                'password_hash' => Hash::make('kepsek123'),
                'role' => 'kepsek',
                'aktif' => true,
            ],
        ];

        foreach ($users as $user) {
            Pengguna::create($user);
        }
    }
}