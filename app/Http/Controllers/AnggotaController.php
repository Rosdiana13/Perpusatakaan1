<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// Digunakan untuk menjalankan transaksi database (beginTransaction, commit, rollback).
use Illuminate\Support\Facades\DB;
// Digunakan untuk membuat teks acak / UUID, misalnya:
use Illuminate\Support\Str;
// Menghubungkan controller ke tabel anggota
use App\Models\Anggota;
// Menghubungkan controller ke tabel Login
use App\Models\Login;

class AnggotaController extends Controller
{
    /**
     * Tampilkan halaman registrasi
     */
    public function create()
    {
        return view('registrasi'); // registrasi.php
    }

    /**
     * Proses simpan data registrasi
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'nohp' => 'required',
            'email' => 'required|email|unique:anggota,email',
            'password' => 'required|min:5|confirmed'
        ]);

        DB::beginTransaction();

        try {
            $anggota_id = Str::uuid();
            $login_id   = Str::uuid();

            // Simpan ke tabel anggota
            Anggota::create([
                'id' => $anggota_id,
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'nohp' => $request->nohp,
                'email' => $request->email,
                'password' => $request->password
            ]);

            // Simpan ke tabel log_in
            Login::create([
                'id' => $login_id,
                'username' => $request->email,
                'password' => $request->password,
                'anggota_id' => $anggota_id,
                'petugas_id' => null
            ]);

            // Jika sukse
            DB::commit();

            return redirect('/login')
                ->with('success', 'Registrasi berhasil! Silakan login.');

        } catch (\Exception $e) {
            // Jika gagal
            DB::rollBack();

            return back()->with('error', 'Registrasi gagal. Silakan coba lagi.');
        }
    }
}
