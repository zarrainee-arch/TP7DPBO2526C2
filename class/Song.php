
<?php

class Song {
    private $conn;
    private $table = "songs";

    public function __construct($db) {
        $this->conn = $db;
    }

    // CREATE: Menambahkan lagu
    public function create($title, $artist_id, $genre_id, $release_year, $duration) {
        $sql = "INSERT INTO " . $this->table . "
                (title, artist_id, genre_id, release_year, duration)
                VALUES (:title, :artist, :genre, :year, :duration)";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':title' => $title,
            ':artist' => $artist_id,
            ':genre' => $genre_id,
            ':year' => $release_year,
            ':duration' => $duration
        ]);
    }

    // READ: Menampilkan semua lagu beserta nama artist dan genre
    public function getAll() {
        $sql = "SELECT songs.*, 
                       artists.artist_name,
                       genres.genre_name
                FROM songs
                JOIN artists ON songs.artist_id = artists.id
                JOIN genres ON songs.genre_id = genres.id
                ORDER BY songs.id ASC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    // READ: Mencari lagu berdasarkan ID
    public function getById($id) {
        $sql = "SELECT * FROM " . $this->table .
               " WHERE id = :id";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);

        return $stmt->fetch();
    }

    // UPDATE: Mengubah data lagu
    public function update($id, $title, $artist_id, $genre_id, $release_year, $duration) {
        $sql = "UPDATE " . $this->table . "
                SET title = :title,
                    artist_id = :artist,
                    genre_id = :genre,
                    release_year = :year,
                    duration = :duration
                WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':id' => $id,
            ':title' => $title,
            ':artist' => $artist_id,
            ':genre' => $genre_id,
            ':year' => $release_year,
            ':duration' => $duration
        ]);
    }

    // DELETE: Menghapus lagu
    public function delete($id) {
        $sql = "DELETE FROM " . $this->table .
               " WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([':id' => $id]);
    }
}
?>
