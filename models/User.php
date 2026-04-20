<?php
class User
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getUserByUsername($username)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getUserById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createUser($username, $password, $permissionLevel = 'User')
    {
        try {
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $this->pdo->prepare("INSERT INTO users (username, password_hash, permission_level, created_at) VALUES (?, ?, ?, NOW())");
            $stmt->execute([$username, $passwordHash, $permissionLevel]);
            return $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function userExists($username)
    {
        $user = $this->getUserByUsername($username);
        return $user !== false;
    }

    public function verifyPassword($username, $password)
    {
        $user = $this->getUserByUsername($username);
        if (!$user) {
            return false;
        }
        return password_verify($password, $user['password_hash']);
    }

    public function getAll()
    {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM users ORDER BY created_at DESC");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function makeAdmin($id)
    {
        try {
            $stmt = $this->pdo->prepare("UPDATE users SET permission_level = 'Admin' WHERE id = ?");
            $stmt->execute([$id]);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function removeAdmin($id)
    {
        try {
            $stmt = $this->pdo->prepare("UPDATE users SET permission_level = 'User' WHERE id = ?");
            $stmt->execute([$id]);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
}
?>