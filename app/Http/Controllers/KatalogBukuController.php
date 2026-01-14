<?php

namespace App\Http\Controllers;
// Ini dipakai untuk mengambil data yang dikirim user dari form atau URL.
use Illuminate\Http\Request;
// Menghubungkan controller ke tabel KatalogBuku.
use App\Models\KatalogBuku;
// Digunakan untuk membuat teks acak / UUID, misalnya:
use Illuminate\Support\Str;

class KatalogBukuController extends Controller
{
    // tampilkan form input buku
    public function create()
    {
        return view('katalog_input');
    }

    // simpan data buku
    public function store(Request $request)
    {
        $request->validate([
            'judul'     => 'required',
            'pengarang' => 'required',
            'penerbit'  => 'required',
            'tahun'     => 'required|digits:4',
            'stok'      => 'required|numeric',
            'image'     => 'required|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        // upload gambar
        $file = $request->file('image');
        $namaFile = time().'_'.$file->getClientOriginalName();
        $file->move(public_path('uploads'), $namaFile);

        // simpan ke database
        KatalogBuku::create([
            'id'        => Str::uuid(),
            'judul'     => $request->judul,
            'pengarang' => $request->pengarang,
            'penerbit'  => $request->penerbit,
            'tahun'     => $request->tahun,
            'stok'      => $request->stok,
            'image'     => $namaFile
        ]);

        return redirect('/katalog/input')->with('success', 'Buku berhasil disimpan');
    }
}
