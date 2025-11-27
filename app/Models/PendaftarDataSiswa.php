<?php
// app/Models/PendaftarDataSiswa.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PendaftarDataSiswa extends Model
{
    protected $table = 'pendaftar_data_siswa';
    protected $primaryKey = 'pendaftar_id';
    
    protected $fillable = [
        'pendaftar_id', 'nik', 'nish', 'nama', 'jk', 'tmp_lahir', 'tgl_lahir',
        'alamat', 'wilayah_id', 'lat', 'lng'
    ];

    protected $casts = [
        'tgl_lahir' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Carbon Accessors
    public function getTglLahirAttribute($value)
    {
        return $value ? Carbon::parse($value) : null;
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value);
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value);
    }

    // Relationships
    public function pendaftar()
    {
        return $this->belongsTo(Pendaftar::class, 'pendaftar_id');
    }

    public function wilayah()
    {
        return $this->belongsTo(Wilayah::class);
    }
}