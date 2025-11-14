<?php
require_once __DIR__ . '/../utils/Database.php';

class User {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function create($email, $password, $name, $role = 'user') {
        if ($this->getByEmail($email)) {
            throw new Exception("Email già registrata");
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (email, password, name, role) VALUES (?, ?, ?, ?)";
        
        $this->db->execute($sql, [$email, $hashedPassword, $name, $role]);
        return $this->db->lastInsertId();
    }

    public function getByEmail($email) {
        return $this->db->fetchOne("SELECT * FROM users WHERE email = ?", [$email]);
    }

    public function getById($id) {
        return $this->db->fetchOne("SELECT * FROM users WHERE id = ?", [$id]);
    }

    public function getAll() {
        return $this->db->fetchAll("SELECT id, email, name, role, created_at FROM users ORDER BY name");
    }
}
?>