<?php
require_once __DIR__ . '/../utils/Database.php';

class Booking {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function create($roomId, $userId, $title, $bookingDate, $startTime, $endTime, $participants, $notes) {
        if ($this->hasConflict($roomId, $bookingDate, $startTime, $endTime)) {
            throw new Exception('La sala è già prenotata in questo orario.');
        }

        $sql = "INSERT INTO bookings (room_id, user_id, title, booking_date, start_time, end_time, participants, notes) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        
        $this->db->execute($sql, [
            $roomId, $userId, $title, $bookingDate, $startTime, $endTime, $participants, $notes
        ]);
        
        return $this->db->lastInsertId();
    }

    public function hasConflict($roomId, $bookingDate, $startTime, $endTime, $excludeBookingId = null) {
        $sql = "SELECT COUNT(*) as count FROM bookings 
                WHERE room_id = ? 
                AND booking_date = ? 
                AND status = 'confirmed'
                AND ((start_time < ? AND end_time > ?) OR (start_time < ? AND end_time > ?) OR (start_time >= ? AND start_time < ?))";
        
        $params = [$roomId, $bookingDate, $endTime, $startTime, $endTime, $startTime, $startTime, $endTime];
        
        if ($excludeBookingId) {
            $sql .= " AND id != ?";
            $params[] = $excludeBookingId;
        }

        $result = $this->db->fetchOne($sql, $params);
        return $result['count'] > 0;
    }

    public function getByUser($userId) {
        $sql = "SELECT b.*, r.name as room_name 
                FROM bookings b 
                JOIN rooms r ON b.room_id = r.id 
                WHERE b.user_id = ? 
                ORDER BY b.booking_date DESC, b.start_time DESC";
        return $this->db->fetchAll($sql, [$userId]);
    }

    public function getAll() {
        $sql = "SELECT b.*, r.name as room_name, u.name as user_name 
                FROM bookings b 
                JOIN rooms r ON b.room_id = r.id 
                JOIN users u ON b.user_id = u.id 
                ORDER BY b.booking_date DESC, b.start_time DESC";
        return $this->db->fetchAll($sql);
    }

    public function cancel($bookingId, $userId) {
        $booking = $this->db->fetchOne("SELECT * FROM bookings WHERE id = ?", [$bookingId]);
        
        if (!$booking) {
            throw new Exception("Prenotazione non trovata");
        }

        if ($booking['user_id'] != $userId && !$this->isAdmin($userId)) {
            throw new Exception("Non hai i permessi per cancellare questa prenotazione");
        }

        $sql = "UPDATE bookings SET status = 'cancelled' WHERE id = ?";
        return $this->db->execute($sql, [$bookingId]);
    }

    private function isAdmin($userId) {
        $user = $this->db->fetchOne("SELECT role FROM users WHERE id = ?", [$userId]);
        return $user && $user['role'] === 'admin';
    }

    public function getByRoomAndDate($roomId, $date) {
        $sql = "SELECT * FROM bookings 
                WHERE room_id = ? AND booking_date = ? AND status = 'confirmed'
                ORDER BY start_time";
        return $this->db->fetchAll($sql, [$roomId, $date]);
    }
}
?>