<?php

class Artist {
    private $conn;
    private $table = "artists";

    public function __construct($db) {
        $this->conn = $db;
    }

    // CREATE: Menambahkan artist
    public function create($artist_name, $country, $debut_year) {
        $sql = "INSERT INTO " . $this->table . "
                (artist_name, country, debut_year)
                VALUES (:name, :country, :year)";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':name' => $artist_name,
            ':country' => $country,
            ':year' => $debut_year
        ]);
    }

    // READ: Mengambil semua artist
    public function getAll() {
        $sql = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    // READ: Mengambil artist berdasarkan ID
    public function getById($id) {
        $sql = "SELECT * FROM " . $this->table .
               " WHERE id = :id";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);

        return $stmt->fetch();
    }

    // UPDATE: Mengubah data artist
    public function update($id, $artist_name, $country, $debut_year) {
        $sql = "UPDATE " . $this->table . "
                SET artist_name = :name,
                    country = :country,
                    debut_year = :year
                WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':id' => $id,
            ':name' => $artist_name,
            ':country' => $country,
            ':year' => $debut_year
        ]);
    }

    // DELETE: Menghapus artist
    public function delete($id) {
        $sql = "DELETE FROM " . $this->table .
               " WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([':id' => $id]);
    }
}
?>
