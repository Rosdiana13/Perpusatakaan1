<?php
class katalog_buku {
    private $conn;
    private $table = "katalog_buku";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Ambil semua buku aktif
    public function getAllBuku() {
        $sql = "SELECT * FROM " . $this->table . " WHERE is_aktive='1'";
        $result = $this->conn->query($sql);

        $data = [];
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $data[] = $row;
            }
        }
        return $data;
    }

    public function getBukuById($id){
        $sql = "SELECT * FROM " . $this->table . " WHERE id=? AND is_aktive='1'";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

}
?>
