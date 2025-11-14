<?php
require_once __DIR__ . '/../utils/Auth.php';
require_once __DIR__ . '/../models/User.php';

class AuthController {
    private $auth;
    private $userModel;

    public function __construct() {
        $this->auth = new Auth();
        $this->userModel = new User();
    }

    public function login() {
        $error = '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            
            if ($this->auth->login($email, $password)) {
                header('Location: /index.php');
                exit;
            } else {
                $error = 'Email o password non validi';
            }
        }
        
        include __DIR__ . '/../views/auth/login.php';
    }

    public function register() {
        $error = '';
        $success = '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';
            
            if (empty($name) || empty($email) || empty($password)) {
                $error = 'Tutti i campi sono obbligatori';
            } elseif ($password !== $confirm_password) {
                $error = 'Le password non coincidono';
            } elseif (strlen($password) < 6) {
                $error = 'La password deve essere di almeno 6 caratteri';
            } else {
                try {
                    $this->userModel->create($email, $password, $name);
                    $success = 'Registrazione completata! Ora puoi effettuare il login.';
                } catch (Exception $e) {
                    $error = $e->getMessage();
                }
            }
        }
        
        include __DIR__ . '/../views/auth/register.php';
    }

    public function logout() {
        $this->auth->logout();
        header('Location: /auth/login.php');
        exit;
    }
}
?>