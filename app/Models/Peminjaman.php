<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    //Laravel diberi tahu bahwa model ini memakai peminjaman
    protected $table = 'peminjaman';
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
        'login_id',
        'tanggal_pinjam',
        'tanggal_kembali',
        'jenis_peminjaman',
        'alamat_kirim',
        'ongkir',
        'status'
    ];

    // 1 transaksi peminjaman punya banyak buku (banyak detail).
    public function detail()
    {
        return $this->hasMany(DetailPeminjaman::class, 'peminjaman_id');
    }

    // 1 transaksi peminjaman dilakukan oleh 1 akun login.
    public function login()
    {
        return $this->belongsTo(Login::class, 'login_id');
    }

    // hasmany artinya satu data memiliki banyak data.
}
