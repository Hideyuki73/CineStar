<?php
require_once '../config/db.php';
class User
{

    public function create($nickname, $email, $senha)
    {
        $sql = "INSERT INTO users (nickname,email,senha) VALUES (:nickname, :email, :senha)";
        $stmt = Database::getInstance()->prepare($sql);
        $stmt->bindParam(':nickname', $nickname);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senha);
        return $stmt->execute();
    }

    public function list()
    {
        $sql = "SELECT * FROM users";
        $stmt = Database::getInstance()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $sql = "SELECT * FROM users WHERE id = :id";
        $stmt = Database::getInstance()->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getByEmail($email)
    {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = Database::getInstance()->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $nickname, $email, $senha)
    {
        $sql = "UPDATE users SET nickname = :nickname, email = :email, senha = :senha WHERE id = :id";
        $stmt = Database::getInstance()->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nickname', $nickname);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senha);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function delete($id)
    {
        $sql = "DELETE FROM users WHERE id = :id";
        $stmt = Database::getInstance()->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->rowCount();
    }
}