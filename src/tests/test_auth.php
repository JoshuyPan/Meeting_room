<?php
require_once __DIR__ . '/../utils/Auth.php';

session_start();

echo "=== TEST AUTHENTICATION ===\n";

$auth = new Auth();

if ($auth->login('admin@example.com', 'admin123')) {
    echo "✅ Login admin: OK\n";
    
    if ($auth->isLoggedIn()) {
        echo "✅ Sessione attiva: OK\n";
    }
    
    if ($auth->isAdmin()) {
        echo "✅ Ruolo admin: OK\n";
    }
    
    $user = $auth->getCurrentUser();
    if ($user) {
        echo "✅ Dati utente: OK (" . $user['email'] . ")\n";
    }
    
    $auth->logout();
    if (!$auth->isLoggedIn()) {
        echo "✅ Logout: OK\n";
    }
} else {
    echo "❌ Login admin: FALLITO\n";
}

echo "=== TEST AUTH COMPLETATI ===\n";
?>