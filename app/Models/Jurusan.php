<?php
// app/Models/Jurusan.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Jurusan extends Model
{
    protected $table = 'jurusan';
    protected $fillable = ['kode', 'nama', 'kuota'];

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
        return $this->hasMany(Pendaftar::class);
    }
}