<?php
require_once __DIR__ . '/../utils/Auth.php';
require_once __DIR__ . '/../models/Room.php';

class RoomController {
    private $auth;
    private $roomModel;

    public function __construct() {
        $this->auth = new Auth();
        $this->roomModel = new Room();
    }

    public function index() {
        $this->auth->requireLogin();
        $rooms = $this->roomModel->getAll();
        include __DIR__ . '/../views/rooms/index.php';
    }

    public function adminIndex() {
        $this->auth->requireAdmin();
        $rooms = $this->roomModel->getAll();
        include __DIR__ . '/../views/rooms/admin.php';
    }

    public function create() {
        $this->auth->requireAdmin();
        $error = '';
        $success = '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $capacity = intval($_POST['capacity'] ?? 0);
            $amenities = trim($_POST['amenities'] ?? '');
            
            if (empty($name) || $capacity <= 0) {
                $error = 'Nome e capacità sono obbligatori';
            } else {
                try {
                    $user = $this->auth->getCurrentUser();
                    $this->roomModel->create($name, $description, $capacity, $amenities, $user['id']);
                    $success = 'Sala creata con successo!';
                } catch (Exception $e) {
                    $error = $e->getMessage();
                }
            }
        }
        
        include __DIR__ . '/../views/rooms/create.php';
    }

    public function edit($id) {
        $this->auth->requireAdmin();
        $error = '';
        $success = '';
        
        $room = $this->roomModel->getById($id);
        if (!$room) {
            header('Location: /rooms/admin.php');
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $capacity = intval($_POST['capacity'] ?? 0);
            $amenities = trim($_POST['amenities'] ?? '');
            
            if (empty($name) || $capacity <= 0) {
                $error = 'Nome e capacità sono obbligatori';
            } else {
                try {
                    $this->roomModel->update($id, $name, $description, $capacity, $amenities);
                    $success = 'Sala aggiornata con successo!';
                    $room = $this->roomModel->getById($id);
                } catch (Exception $e) {
                    $error = $e->getMessage();
                }
            }
        }
        
        include __DIR__ . '/../views/rooms/edit.php';
    }

    public function delete($id) {
        $this->auth->requireAdmin();
        
        try {
            $this->roomModel->delete($id);
            $_SESSION['success'] = 'Sala eliminata con successo!';
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
        }
        
        header('Location: /rooms/admin.php');
        exit;
    }
}
?>