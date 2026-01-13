# Web Peminjaman Buku Perpustakaan (Laravel)
Project ini merupakan web berbasis Laravel yang digunakan untuk mengelola data buku, 
data member, serta transaksi peminjaman buku pada perpustakaan. 
Sistem dikembangkan menggunakan arsitektur MVC (Model–View–Controller) dan database MySQL.

**Tech Stack**
- Bahasa pemrograman: PHP
- Framework: Laravel12
- Database: MySQL 
- Frontend: Blade Template, Html, Boostrap5
- Arsitektur: MVC (Model View Controller)

**Struktur Project**
1. Models
   Models yang mengatur/mengelola tabel dan relasi antar tabel.
   Tabel yang digunakan disini:
   - Anggota, digunakan untuk menyimpan data pengguna perpustakaan.
   - DetailPeminjaman, menyimpan daftar buku dan jumlahnya dalam setiap transaksi peminjaman.
   - KatalogBuku, untuk menyimpan data semua buku di perpustakaan.
   - Login, menyimpan dan mengelola data akun login untuk anggota dan petugas perpustakaan.
   - Peminjaman, dipakai untuk mencatat setiap transaksi peminjaman buku.
   - Petugas, dipakai untuk menyimpan data petugas perpustakaan.
3. Views
   Berisikan tampilan antarmuka.
   Berikut Views:
   - template.blade.php, digunakan sebagai layout utama website.
   - Home, digunakan untuk anggota/pemijam buku untuk pesan secara online, dan juga sebagai pemantauan untuk petugas jika buku sudah berhasil diinput.
   - list_peminjaman, untuk pemantauan anggota/peminjam buku apa saja yang sudah sedang dipinjam olehnya.
   - list_online, untuk pemantauan petugas buku apa saja yang akan dipinjam secara online.
   - listAllPeminjaman, untuk pemantauan petugas untuk melihat semua buku yang sedang di pinjam.
   - detail_pinjam, untuk anggota/peminjam bisa input jenis pinjamannya, ambil ditempat atau diantar.
   - registrasi, untuk anggota/peminjam yang belum punya akun.
   - login, untuk anggota/peminjam maupun untuk petugas.
5. Controllers
   - AnggotaController, untuk mendaftarkan anggota baru sekaligus membuatkan akun login mereka
   - KatalogBukuController, untuk dipakai untuk mengelola data buku di perpustakaan, khususnya menambah buku baru ke katalog.
   - LoginController, untuk mengelola proses login dan logout user.
   - PeminjamanController, mengatur proses pinjam buku, baik online maupun offline, serta menampilkan data peminjaman.
  
**Struktur Database dan Relasi**
Database ini dipakai untuk mengelola sistem perpustakaan, yang mencakup:
- Data anggota
- Data petugas
- Login
- Katalog buku
- Transaksi peminjaman
- Detail buku yang dipinjam

## Struktur Tabel Database

| Tabel                 | Fungsi                                       |
| --------------------- | -------------------------------------------- |
| **anggota**           | Menyimpan data orang yang meminjam buku      |
| **petugas**           | Menyimpan data petugas perpustakaan          |
| **log_in**            | Menyimpan akun login untuk anggota & petugas |
| **katalog_buku**      | Menyimpan daftar buku perpustakaan           |
| **peminjaman**        | Menyimpan transaksi peminjaman               |
| **detail_peminjaman** | Menyimpan daftar buku dalam satu peminjaman  |

## Jenis Relasi
| Dari                             | Ke          | Relasi |
| -------------------------------- | ----------- | ------ |
| anggota → log_in                 | One to One  |        |
| petugas → log_in                 | One to One  |        |
| log_in → peminjaman              | One to Many |        |
| peminjaman → detail_peminjaman   | One to Many |        |
| katalog_buku → detail_peminjaman | One to Many |        |


