<?php
class Auth {

    private $conn;

    public function __construct($db){
        $this->conn = $db;
    }

    public function login($username, $password){

        /* =====================
           LOGIN ANGGOTA (HASH)
        ====================== */
        $stmt = $this->conn->prepare(
            "SELECT id, nama, password 
             FROM anggota 
             WHERE email = ? AND is_aktive = '1'"
        );
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows === 1){
            $user = $result->fetch_assoc();

            if(password_verify($password, $user['password'])){
                return [
                    'role'       => 'anggota',
                    'anggota_id' => $user['id'],
                    'nama'       => $user['nama']
                ];
            }
        }

        /* =====================
           LOGIN PETUGAS (POLOS)
        ====================== */
        $stmt = $this->conn->prepare(
            "SELECT id, nama, password 
             FROM petugas 
             WHERE username = ? AND is_aktive = '1'"
        );
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows === 1){
            $user = $result->fetch_assoc();

            //BUKAN password_verify
            if($password === $user['password']){
                return [
                    'role'        => 'petugas',
                    'petugas_id'  => $user['id'],
                    'nama'       => $user['nama']
                ];
            }
        }

        return false;
    }
}
