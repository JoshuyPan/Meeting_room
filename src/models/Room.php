<?php
require_once __DIR__ . '/../utils/Database.php';

class Room {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getAll() {
        return $this->db->fetchAll("SELECT * FROM rooms WHERE is_active = TRUE ORDER BY name");
    }

    public function getById($id) {
        return $this->db->fetchOne("SELECT * FROM rooms WHERE id = ? AND is_active = TRUE", [$id]);
    }

    public function create($name, $description, $capacity, $amenities, $createdBy) {
        $sql = "INSERT INTO rooms (name, description, capacity, amenities, created_by) VALUES (?, ?, ?, ?, ?)";
        $this->db->execute($sql, [$name, $description, $capacity, $amenities, $createdBy]);
        return $this->db->lastInsertId();
    }

    public function update($id, $name, $description, $capacity, $amenities) {
        $sql = "UPDATE rooms SET name = ?, description = ?, capacity = ?, amenities = ? WHERE id = ?";
        return $this->db->execute($sql, [$name, $description, $capacity, $amenities, $id]);
    }

    public function delete($id) {
        $sql = "UPDATE rooms SET is_active = FALSE WHERE id = ?";
        return $this->db->execute($sql, [$id]);
    }

    public function exists($id) {
        $room = $this->getById($id);
        return !empty($room);
    }
}
?>