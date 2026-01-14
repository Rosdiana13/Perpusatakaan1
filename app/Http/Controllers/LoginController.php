<?php

namespace App\Http\Controllers;
// untuk mengambil inputan dari views
use Illuminate\Http\Request;
// Menghubungkan controller ke tabel log_in
use App\Models\Login;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $login = Login::where('username', $request->username)->first();

        if (!$login) {
            return back()->with('error', 'Username tidak ditemukan');
        }

        // password masih plaintext sesuai DB kamu
        if ($login->password != $request->password) {
            return back()->with('error', 'Password salah');
        }

        // simpan session
        Session::put('login_id', $login->id);

        if ($login->anggota_id) {
            Session::put('role', 'anggota');
            return redirect('/home');
        } else {
            Session::put('role', 'petugas');
            return redirect('/home');
        }
    }

    public function logout()
    {
        Session::flush();
        return redirect('/login');
    }
}
