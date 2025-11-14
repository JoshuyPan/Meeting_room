<?php
require_once __DIR__ . '/../utils/Auth.php';
require_once __DIR__ . '/../models/Booking.php';
require_once __DIR__ . '/../models/Room.php';

class BookingController {
    private $auth;
    private $bookingModel;
    private $roomModel;

    public function __construct() {
        $this->auth = new Auth();
        $this->bookingModel = new Booking();
        $this->roomModel = new Room();
    }

    public function index() {
        $this->auth->requireLogin();
        $user = $this->auth->getCurrentUser();
        $bookings = $this->bookingModel->getByUser($user['id']);
        include __DIR__ . '/../views/bookings/index.php';
    }

    public function adminIndex() {
        $this->auth->requireAdmin();
        $bookings = $this->bookingModel->getAll();
        include __DIR__ . '/../views/bookings/admin.php';
    }

    public function create() {
        $this->auth->requireLogin();
        $error = '';
        $success = '';
        
        $rooms = $this->roomModel->getAll();
        $user = $this->auth->getCurrentUser();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $roomId = intval($_POST['room_id'] ?? 0);
            $title = trim($_POST['title'] ?? '');
            $bookingDate = $_POST['booking_date'] ?? '';
            $startTime = $_POST['start_time'] ?? '';
            $endTime = $_POST['end_time'] ?? '';
            $participants = intval($_POST['participants'] ?? 1);
            $notes = trim($_POST['notes'] ?? '');
            
            if (empty($title) || empty($bookingDate) || empty($startTime) || empty($endTime)) {
                $error = 'Tutti i campi obbligatori devono essere compilati';
            } elseif (!$this->roomModel->exists($roomId)) {
                $error = 'Sala non valida';
            } elseif (strtotime($bookingDate) < strtotime(date('Y-m-d'))) {
                $error = 'Non puoi prenotare per date passate';
            } else {
                try {
                    $this->bookingModel->create(
                        $roomId, 
                        $user['id'], 
                        $title, 
                        $bookingDate, 
                        $startTime, 
                        $endTime, 
                        $participants, 
                        $notes
                    );
                    $success = 'Prenotazione creata con successo!';
                } catch (Exception $e) {
                    $error = $e->getMessage();
                }
            }
        }
        
        include __DIR__ . '/../views/bookings/create.php';
    }

    public function cancel($id) {
        $this->auth->requireLogin();
        $user = $this->auth->getCurrentUser();
        
        try {
            $this->bookingModel->cancel($id, $user['id']);
            $_SESSION['success'] = 'Prenotazione cancellata con successo!';
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
        }
        
        header('Location: /bookings/index.php');
        exit;
    }

    public function checkAvailability() {
        $this->auth->requireLogin();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $roomId = intval($_POST['room_id'] ?? 0);
            $date = $_POST['date'] ?? '';
            $startTime = $_POST['start_time'] ?? '';
            $endTime = $_POST['end_time'] ?? '';
            
            header('Content-Type: application/json');
            
            if (empty($roomId) || empty($date) || empty($startTime) || empty($endTime)) {
                echo json_encode(['available' => false, 'message' => 'Dati insufficienti']);
                exit;
            }
            
            try {
                $available = !$this->bookingModel->hasConflict($roomId, $date, $startTime, $endTime);
                echo json_encode([
                    'available' => $available,
                    'message' => $available ? 'Sala disponibile' : 'Sala già prenotata in questo orario'
                ]);
            } catch (Exception $e) {
                echo json_encode(['available' => false, 'message' => $e->getMessage()]);
            }
        }
        exit;
    }
}
?>