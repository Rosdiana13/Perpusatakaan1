<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// Menghubungkan controller ke tabel Peminjaman
use App\Models\Peminjaman;
// Menghubungkan controller ke tabel DetailPeminjaman
use App\Models\DetailPeminjaman;
// Menghubungkan controller ke tabel KatalogBuku
use App\Models\KatalogBuku;
// Menghubungkan controller ke tabel login
use App\Models\Login; 
// Membuat id secara otomtasi
use Illuminate\Support\Str;
// Menghubungkan controller ke tabel Anggota
use App\Models\Anggota;
// memanggil Facade Database Laravel
use DB;
// Extends ini apa turnunan

class PeminjamanController extends Controller
{
    // Halaman detail pinjam
    public function detail($id)
    {
        $buku = KatalogBuku::findOrFail($id);
        return view('detail_pinjam', compact('buku'));
    }

    // Simpan peminjaman
    public function simpan(Request $request)
    {
        DB::beginTransaction();

        try {
            $login_id = session('login_id');

            $buku = KatalogBuku::findOrFail($request->buku_id);

            // validasi stok
            if ($request->jumlah > $buku->stok) {
                return back()->with('error', 'Stok buku tidak mencukupi');
            }

            $peminjaman_id = Str::uuid();

            // simpan ke tabel peminjaman
            Peminjaman::create([
                'id' => $peminjaman_id,
                'login_id' => $login_id,
                'tanggal_pinjam' => now(),
                'tanggal_kembali' => now()->addDays(7),
                'jenis_peminjaman' => $request->jenis_peminjaman,
                'alamat_kirim' => $request->alamat_kirim ?? '-',
                'ongkir' => 'Ditanggung penerima',
                'status' => 'dipinjam'
            ]);

            // simpan ke detail peminjaman
            DetailPeminjaman::create([
                'id' => Str::uuid(),
                'peminjaman_id' => $peminjaman_id,
                'katalog_buku_id' => $buku->id,
                'jumlah' => $request->jumlah
            ]);

            // update stok buku
            $buku->stok -= $request->jumlah;
            $buku->save();

            DB::commit();

            return redirect('/home')->with('success', 'Buku berhasil dipinjam');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal melakukan peminjaman');
        }
    }

    // Riwayat peminjaman user
    public function riwayat()
    {
        $login_id = session('login_id');

        $data = Peminjaman::with('detail.buku')
            ->where('login_id', $login_id)
            ->orderBy('tanggal_pinjam', 'desc')
            ->get();

        return view('riwayat_pinjam', compact('data'));
    }

    // List semua peminjaman
    public function index()
    {
        $login_id = session('login_id');   // ambil user yang login

        $peminjaman = Peminjaman::where('login_id', $login_id)
            ->with('detail.buku')
            ->orderBy('tanggal_pinjam', 'desc')
            ->get();

        return view('list_peminjaman', compact('peminjaman'));
    }

    // List peminjaman online (delivery)
    public function listOnline()
    {
        $peminjaman = Peminjaman::where('jenis_peminjaman', 'delivery')
            ->with(['detail.buku', 'login.anggota'])
            ->get();

        return view('list_online', compact('peminjaman'));
    }

    public function listAll()
    {
        $peminjaman = Peminjaman::where('status', 'dipinjam')
            ->with(['detail.buku', 'login.anggota'])
            ->orderBy('tanggal_pinjam', 'desc')
            ->get();

        return view('listAllPeminjaman', compact('peminjaman'));
    }

    public function offlineForm()
    {
        $anggota = Anggota::all();
        $buku = KatalogBuku::where('stok', '>', 0)->get();

        return view('pinjam_offline', compact('anggota','buku'));
    }

    public function simpanOffline(Request $request)
    {
        DB::beginTransaction();

        try {
            $request->validate([
                'anggota_id' => 'required',
                'buku_id' => 'required',
                'jumlah' => 'required|min:1'
            ]);

            $buku = KatalogBuku::findOrFail($request->buku_id);

            if ($request->jumlah > $buku->stok) {
                return back()->with('error','Stok tidak mencukupi');
            }

            // cari login_id anggota
            $login = Login::where('anggota_id', $request->anggota_id)->first();

            if (!$login) {
                return back()->with('error','Anggota belum punya akun login');
            }

            $peminjaman_id = Str::uuid();

            Peminjaman::create([
                'id' => $peminjaman_id,
                'login_id' => $login->id,
                'tanggal_pinjam' => now(),
                'tanggal_kembali' => now()->addDays(7),
                'jenis_peminjaman' => 'pickup',
                'alamat_kirim' => '-',
                'ongkir' => '0',
                'status' => 'dipinjam'
            ]);

            DetailPeminjaman::create([
                'id' => Str::uuid(),
                'peminjaman_id' => $peminjaman_id,
                'katalog_buku_id' => $buku->id,
                'jumlah' => $request->jumlah
            ]);

            $buku->stok -= $request->jumlah;
            $buku->save();

            DB::commit();
            return redirect('/pinjam-offline')->with('success','Peminjaman berhasil dicatat');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error','Gagal menyimpan');
        }
    }

    public function kembalikan($id)
    {
        DB::beginTransaction();

        try {
            $peminjaman = Peminjaman::with('detail.buku')->findOrFail($id);

            // Ambil tanggal sekarang
            $today = now();

            // Cek apakah terlambat
            if ($today->gt($peminjaman->tanggal_kembali)) {
                $peminjaman->status = 'terlambat';
            } else {
                $peminjaman->status = 'dikembalikan';
            }

            $peminjaman->save();

            // Kembalikan stok buku
            foreach ($peminjaman->detail as $d) {
                $buku = $d->buku;
                $buku->stok += $d->jumlah;
                $buku->save();
            }

            DB::commit();
            return back()->with('success','Buku berhasil dikembalikan');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error','Gagal mengembalikan buku');
        }
    }


}
