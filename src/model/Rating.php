<?php
require_once '../config/db.php';

class Rating
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create($rating, $id_users, $id_movies)
    {
        $sql = "INSERT INTO rating (rating, id_users, id_movies) VALUES (:rating, :id_users, :id_movies)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':rating', $rating);
        $stmt->bindParam(':id_users', $id_users);
        $stmt->bindParam(':id_movies', $id_movies);
        return $stmt->execute();
    }

    public function list()
    {
        $sql = "SELECT id, rating FROM rating";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $sql = "SELECT * FROM rating WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $rating)
    {
        $sql = "UPDATE rating SET rating = :rating WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':rating', $rating);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function delete($id)
    {
        $sql = "DELETE FROM rating WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->rowCount();
    }
}