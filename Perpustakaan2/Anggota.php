<?php
class Anggota {

    private $conn;
    private $table = "anggota";

    public function __construct($db){
        $this->conn = $db;
    }

    public function register($data){

        // 1️⃣ cek email
        $cek = $this->conn->prepare(
            "SELECT id FROM {$this->table} WHERE email = ?"
        );
        $cek->bind_param("s", $data['email']);
        $cek->execute();
        $cek->store_result();

        if($cek->num_rows > 0){
            return [
                'status' => false,
                'message' => 'Email sudah terdaftar'
            ];
        }

        // 2️⃣ insert anggota
        $sql = "INSERT INTO {$this->table}
                (id, nama, alamat, nohp, email, password, is_aktive, created_at)
                VALUES (UUID(), ?, ?, ?, ?, ?, '1', NOW())";

        $stmt = $this->conn->prepare($sql);

        $password = password_hash($data['password'], PASSWORD_DEFAULT);

        $stmt->bind_param(
            "sssss",
            $data['nama'],
            $data['alamat'],
            $data['nohp'],
            $data['email'],
            $password
        );

        if($stmt->execute()){
            return [
                'status' => true,
                'message' => 'Registrasi berhasil, silakan login'
            ];
        }

        return [
            'status' => false,
            'message' => 'Registrasi gagal'
        ];
    }
}
