<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Petugas extends Model
{
    //Laravel diberi tahu bahwa model ini memakai peminjaman
    protected $table = 'petugas';
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
        'id','nama','username','password'
    ];
}
