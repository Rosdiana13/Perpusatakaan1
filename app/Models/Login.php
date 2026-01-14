<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Login extends Model
{
    //Laravel diberi tahu bahwa model ini memakai log_in
    protected $table = 'log_in';
    //Kolom primary key di tabel ini adalah id
    protected $primaryKey = 'id';
    // ID bukan auto-increment
    public $incrementing = false;
    // tapi ID berupa teks (string)
    protected $keyType = 'string';
    // Tabel ini tidak punya created_at dan updated_at.
    public $timestamps = false;
    // Ini adalah daftar kolom yang boleh diisi lewat form.
    protected $fillable = [
        'id',
        'username',
        'password',
        'anggota_id',
        'petugas_id'
    ];

    // Artinya: akun login ini milik 1 anggota
    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'anggota_id');
    }

    // Artinya: akun login ini milik 1 petugas
    public function petugas()
    {
        return $this->belongsTo(Petugas::class, 'petugas_id');
    }

    // Belongsto artinya model ini dimiliki oleh mode lain
}
