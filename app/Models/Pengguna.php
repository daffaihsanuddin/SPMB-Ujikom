<?php
// app/Models/Pengguna.php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;

class Pengguna extends Authenticatable
{
    use Notifiable;

    protected $table = 'pengguna';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nama',
        'email',
        'hp',
        'password_hash',
        'role',
        'aktif',
    ];

    protected $hidden = [
        'password_hash',
        'remember_token',
    ];

    // Role checking methods
    public function isPendaftar()
    {
        return $this->role === 'pendaftar';
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isVerifikator()
    {
        return $this->role === 'verifikator_adm';
    }

    public function isKeuangan()
    {
        return $this->role === 'keuangan';
    }

    public function isKepsek()
    {
        return $this->role === 'kepsek';
    }

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