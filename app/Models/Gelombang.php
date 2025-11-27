<?php
// app/Models/Gelombang.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Gelombang extends Model
{
    protected $table = 'gelombang';
    protected $fillable = ['nama', 'tahun', 'tgl_mulai', 'tgl_selesai', 'biaya_daftar'];

    protected $casts = [
        'tgl_mulai' => 'date',
        'tgl_selesai' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Carbon Accessors
    public function getTglMulaiAttribute($value)
    {
        return Carbon::parse($value);
    }

    public function getTglSelesaiAttribute($value)
    {
        return Carbon::parse($value);
    }

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
        return $this->hasMany(Pendaftar::class, 'gelombang_id');
    }
    }