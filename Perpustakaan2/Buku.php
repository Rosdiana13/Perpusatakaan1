<?php
class Buku {

    private $conn;

    public function __construct($db){
        $this->conn = $db;
    }

    public function insert($data, $file){

        // ===== VALIDASI FILE =====
        if($file['image']['error'] !== 0){
            return false;
        }

        $folder = "uploads/buku/";

        if(!is_dir($folder)){
            mkdir($folder, 0777, true);
        }

        // ===== NAMA FILE =====
        $ext = pathinfo($file['image']['name'], PATHINFO_EXTENSION);
        $fileName = uniqid('buku_') . "." . $ext;
        $target = $folder . $fileName;

        if(!move_uploaded_file($file['image']['tmp_name'], $target)){
            return false;
        }

        // ===== INSERT DATABASE =====
        $sql = "
            INSERT INTO katalog_buku
            (
                id,
                judul,
                pengarang,
                penerbit,
                tahun,
                stok,
                image,
                created_at,
                created_by
            )
            VALUES
            (
                UUID(), ?, ?, ?, ?, ?, ?, NOW(), ?
            )
        ";

        $stmt = $this->conn->prepare($sql);
        if(!$stmt){
            die("SQL Error: " . $this->conn->error);
        }

        $stmt->bind_param(
            "ssssiss",
            $data['judul'],
            $data['pengarang'],
            $data['penerbit'],
            $data['tahun'],
            $data['stok'],
            $fileName,
            $data['created_by']
        );

        return $stmt->execute();
    }
    
}
