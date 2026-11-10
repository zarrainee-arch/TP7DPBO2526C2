
<?php

class Genre {
    private $conn;
    private $table = "genres";

    public function __construct($db) {
        $this->conn = $db;
    }

    // CREATE
    public function create($genre_name, $description) {
        $sql = "INSERT INTO " . $this->table . "
                (genre_name, description)
                VALUES (:name, :description)";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':name' => $genre_name,
            ':description' => $description
        ]);
    }

    // READ: Semua genre
    public function getAll() {
        $sql = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    // READ: Genre berdasarkan ID
    public function getById($id) {
        $sql = "SELECT * FROM " . $this->table .
               " WHERE id = :id";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);

        return $stmt->fetch();
    }

    // UPDATE
    public function update($id, $genre_name, $description) {
        $sql = "UPDATE " . $this->table . "
                SET genre_name = :name,
                    description = :description
                WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':id' => $id,
            ':name' => $genre_name,
            ':description' => $description
        ]);
    }

    // DELETE
    public function delete($id) {
        $sql = "DELETE FROM " . $this->table .
               " WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([':id' => $id]);
    }
}
?>
