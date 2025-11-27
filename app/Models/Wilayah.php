<?php
// app/Models/Wilayah.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Wilayah extends Model
{
    protected $table = 'wilayah';
    protected $fillable = ['provinsi', 'kabupaten', 'kecamatan', 'kelurahan', 'kodepos'];

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
}