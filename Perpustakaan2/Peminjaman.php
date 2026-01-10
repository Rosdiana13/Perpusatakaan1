<?php
class Peminjaman {
    private $conn;
    private $table = "peminjaman";

    public $error = ""; // property untuk menampung pesan error

    public function __construct($db){
        $this->conn = $db;
    }

    // Tambahkan $nama_petugas sebagai parameter wajib
    public function pinjamBuku($anggota_id, $buku_id, $jenis, $alamat_kirim='', $nama_petugas=''){
        if(!$anggota_id || !$buku_id || !$nama_petugas){
            $this->error = "Data tidak lengkap.";
            return false;
        }

        // 0. Cek stok buku
        $sqlStok = "SELECT stok FROM katalog_buku WHERE id = ?";
        $stmtStok = $this->conn->prepare($sqlStok);
        if(!$stmtStok){
            $this->error = "SQL Error (stok): " . $this->conn->error;
            return false;
        }
        $stmtStok->bind_param("s", $buku_id);
        $stmtStok->execute();
        $resultStok = $stmtStok->get_result();

        if($resultStok->num_rows === 0){
            $this->error = "Buku tidak ditemukan.";
            return false;
        }

        $buku = $resultStok->fetch_assoc();

        if($buku['stok'] <= 0){
            $this->error = "Buku sedang dipinjam / stok habis.";
            return false;
        }

        // 1. Generate ID peminjaman
        $peminjaman_id = vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex(random_bytes(16)), 4));
        
        $tanggal_pinjam = date('Y-m-d H:i:s');
        $tanggal_kembali = date('Y-m-d H:i:s', strtotime('+7 days'));

        // 2. Insert ke tabel peminjaman
        $sql = "INSERT INTO {$this->table} 
                (id, anggota_id, nama_petugas, tanggal_pinjam, tanggal_kembali, jenis_peminjaman, alamat_kirim, ongkir, is_aktive, created_at, created_by)
                VALUES (?, ?, ?, ?, ?, ?, ?, 'Ditanggung penerima', '1', NOW(), ?)";

        $stmt = $this->conn->prepare($sql);
        if(!$stmt){
            $this->error = "SQL Prepare Error: " . $this->conn->error;
            return false;
        }

        $stmt->bind_param(
            "ssssssss", 
            $peminjaman_id,
            $anggota_id,
            $nama_petugas,   // disimpan ke kolom nama_petugas
            $tanggal_pinjam,
            $tanggal_kembali,
            $jenis,
            $alamat_kirim,
            $nama_petugas    // disimpan ke created_by
        );

        if(!$stmt->execute()){
            $this->error = "SQL Execute Error: " . $stmt->error;
            return false;
        }

        // 3. Insert ke detail peminjaman
        $sqlDetail = "INSERT INTO detail_peminjaman (id, peminjaman_id, katalog_buku_id, jumlah)
                      VALUES (UUID(), ?, ?, 1)";
        $stmtDetail = $this->conn->prepare($sqlDetail);
        if(!$stmtDetail){
            $this->error = "SQL Detail Prepare Error: " . $this->conn->error;
            return false;
        }
        $stmtDetail->bind_param("ss", $peminjaman_id, $buku_id);
        if(!$stmtDetail->execute()){
            $this->error = "SQL Detail Execute Error: " . $stmtDetail->error;
            return false;
        }

        // 4. Kurangi stok buku
        $sqlKurangi = "UPDATE katalog_buku 
                       SET stok = stok - 1 
                       WHERE id = ? AND stok > 0";
        $stmtKurangi = $this->conn->prepare($sqlKurangi);
        if(!$stmtKurangi){
            $this->error = "SQL Kurangi Stok Prepare Error: " . $this->conn->error;
            return false;
        }
        $stmtKurangi->bind_param("s", $buku_id);
        $stmtKurangi->execute();

        if($stmtKurangi->affected_rows === 0){
            $this->error = "Gagal meminjam buku, stok habis.";
            return false;
        }

        return true; // sukses
    }
}
?>
