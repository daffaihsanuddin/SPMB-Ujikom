<?php
// app/Models/Pendaftar.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Pendaftar extends Model
{
    protected $table = 'pendaftar';
    
    protected $fillable = [
        'user_id', 'tanggal_daftar', 'no_pendaftaran', 'gelombang_id', 
        'jurusan_id', 'status', 'user_verifikasi_adm', 'tgl_verifikasi_adm',
        'user_verifikasi_payment', 'tgl_verifikasi_payment'
    ];

    protected $casts = [
        'tanggal_daftar' => 'datetime',
        'tgl_verifikasi_adm' => 'datetime',
        'tgl_verifikasi_payment' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Carbon Accessors
    public function getTanggalDaftarAttribute($value)
    {
        return Carbon::parse($value);
    }

    public function getTglVerifikasiAdmAttribute($value)
    {
        return $value ? Carbon::parse($value) : null;
    }

    public function getTglVerifikasiPaymentAttribute($value)
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
    public function user()
    {
        return $this->belongsTo(Pengguna::class, 'user_id');
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }

    public function gelombang()
    {
        return $this->belongsTo(Gelombang::class);
    }

    public function dataSiswa()
    {
        return $this->hasOne(PendaftarDataSiswa::class, 'pendaftar_id');
    }

    public function dataOrtu()
    {
        return $this->hasOne(PendaftarDataOrtu::class, 'pendaftar_id');
    }

    public function asalSekolah()
    {
        return $this->hasOne(PendaftarAsalSekolah::class, 'pendaftar_id');
    }

    public function berkas()
    {
        return $this->hasMany(PendaftarBerkas::class, 'pendaftar_id');
    }

    public function canEditVerification()
{
    // Tidak bisa edit jika status PAID
    if ($this->status === 'PAID') {
        return false;
    }
    
    // Tidak bisa edit jika sudah ada verifikasi pembayaran dan status LULUS
    if ($this->tgl_verifikasi_payment && $this->status === 'ADM_PASS') {
        return false;
    }
    
    // Tidak bisa edit jika verifikasi sudah lebih dari 7 hari
    if ($this->tgl_verifikasi_adm && $this->tgl_verifikasi_adm->diffInDays(now()) > 7) {
        return false;
    }
    
    return true;
}

public function getVerificationEditReason()
{
    if ($this->status === 'PAID') {
        return 'Pendaftar sudah melakukan pembayaran (Status: PAID).';
    }
    
    if ($this->tgl_verifikasi_payment && $this->status === 'ADM_PASS') {
        return 'Pembayaran pendaftar sudah diverifikasi keuangan.';
    }
    
    if ($this->tgl_verifikasi_adm && $this->tgl_verifikasi_adm->diffInDays(now()) > 7) {
        return 'Verifikasi sudah lebih dari 7 hari.';
    }
    
    return 'Verifikasi dapat diubah.';
}
}