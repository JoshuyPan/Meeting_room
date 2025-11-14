<?php
echo "<h1>✅ Docker funziona correttamente!</h1>";
echo "<p>Se vedi questo messaggio, Docker è configurato bene.</p>";

try {
    $pdo = new PDO(
        'mysql:host=db;dbname=meeting_rooms', 
        'app_user', 
        'app_password'
    );
    echo "<p style='color: green;'>✅ Connessione al database riuscita!</p>";
    
    $stmt = $pdo->query("SELECT 1");
    echo "<p style='color: green;'>✅ Query al database funzionante!</p>";
    
} catch (PDOException $e) {
    echo "<p style='color: red;'>❌ Errore database: " . $e->getMessage() . "</p>";
}

echo "<h2>Informazioni PHP</h2>";
echo "<p>PHP Version: " . phpversion() . "</p>";
echo "<p>Server: " . $_SERVER['SERVER_SOFTWARE'] . "</p>";
?>