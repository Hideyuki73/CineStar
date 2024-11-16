<?php
require_once '../config/db.php';

class Movie
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create($nome, $descricao, $rating, $id_users)
    {
        $sql = "INSERT INTO movies (nome, descricao, rating, id_users) VALUES (:nome, :descricao, :rating, :id_users)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':rating', $rating);
        $stmt->bindParam(':id_users', $id_users);
        return $stmt->execute();
    }

    public function list()
    {
        $sql = "SELECT id, nome, descricao, rating FROM movies";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $sql = "SELECT * FROM movies WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $nome, $descricao, $rating, $id_users)
    {
        $sql = "UPDATE movies SET nome = :nome, descricao = :descricao, rating = :rating, id_users = :id_users WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':rating', $rating);
        $stmt->bindParam(':id_users', $id_users);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function delete($id)
    {
        $sql = "DELETE FROM movies WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->rowCount();
    }
}