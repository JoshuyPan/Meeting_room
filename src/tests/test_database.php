<?php
require_once __DIR__ . '/../utils/Database.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Room.php';
require_once __DIR__ . '/../models/Booking.php';

header('Content-Type: text/plain');
echo "=== TEST DATABASE CONNECTION ===\n";

try {
    $db = Database::getInstance();
    echo "✅ Connessione database: OK\n";
    
    // Test Users
    $userModel = new User();
    $users = $userModel->getAll();
    echo "✅ Lettura utenti: " . count($users) . " trovati\n";
    
    $roomModel = new Room();
    $rooms = $roomModel->getAll();
    echo "✅ Lettura sale: " . count($rooms) . " trovati\n";
    
    $bookingModel = new Booking();
    $bookings = $bookingModel->getAll();
    echo "✅ Lettura prenotazioni: " . count($bookings) . " trovate\n";
    
    if (!empty($users) && !empty($rooms)) {
        $testDate = date('Y-m-d', strtotime('+1 day'));
        try {
            $bookingId = $bookingModel->create(
                $rooms[0]['id'],
                $users[0]['id'],
                'Test Booking',
                $testDate,
                '10:00:00',
                '11:00:00',
                2,
                'Test automatico'
            );
            echo "✅ Creazione prenotazione: OK (ID: $bookingId)\n";
            
            $bookingModel->cancel($bookingId, $users[0]['id']);
            echo "✅ Cancellazione prenotazione: OK\n";
        } catch (Exception $e) {
            echo "⚠️ Creazione prenotazione: " . $e->getMessage() . "\n";
        }
    }
    
    echo "=== TUTTI I TEST COMPLETATI ===\n";
    
} catch (Exception $e) {
    echo "❌ Errore: " . $e->getMessage() . "\n";
}
?>