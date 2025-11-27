<?php
// app/Models/PendaftarDataOrtu.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PendaftarDataOrtu extends Model
{
    protected $table = 'pendaftar_data_ortu';
    protected $primaryKey = 'pendaftar_id';
    
    protected $fillable = [
        'pendaftar_id', 'nama_ayah', 'pekerjaan_ayah', 'hp_ayah',
        'nama_ibu', 'pekerjaan_ibu', 'hp_ibu', 'wali_nama', 'wali_hp'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Carbon Accessors
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value);
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value);
    }

    public function pendaftar()
    {
        return $this->belongsTo(Pendaftar::class, 'pendaftar_id');
    }
}