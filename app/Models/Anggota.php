<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    // Laravel diberi tahu bahwa model ini memakai tabel anggota
    protected $table = 'anggota';
    // Kolom primary key di tabel ini adalah id
    protected $primaryKey = 'id';
    // id bukan angka otomatis
    public $incrementing = false;
    // id bertipe teks (string)
    protected $keyType = 'string';
    // Berarti tabel anggota tidak memiliki kolom: created_at,updated_at
    public $timestamps = false;

    // Ini adalah daftar kolom yang boleh diisi lewat form.
    protected $fillable = [
        'id','nama','alamat','nohp','email','password'
    ];
}
