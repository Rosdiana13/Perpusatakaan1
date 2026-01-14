<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPeminjaman extends Model
{
    //Laravel diberi tahu bahwa model ini memakai detail_peminjaman
    protected $table = 'detail_peminjaman';
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
        'peminjaman_id',
        'katalog_buku_id',
        'jumlah'
    ];

    // Setiap detail peminjaman terhubung ke satu buku.
    public function buku()
    {
        return $this->belongsTo(KatalogBuku::class, 'katalog_buku_id');
    }
}
