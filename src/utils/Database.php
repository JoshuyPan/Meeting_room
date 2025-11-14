<?php
require_once __DIR__ . '/../config/database.php';

class Database {
    private $connection;
    private static $instance = null;

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        try {
            $this->connection = new PDO(
                DatabaseConfig::getDSN(),
                DatabaseConfig::USER,
                DatabaseConfig::PASSWORD
            );
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            die("❌ Errore di connessione al database: " . $e->getMessage());
        }
    }

    public function getConnection() {
        return $this->connection;
    }

    public function execute($sql, $params = []) {
        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            die("❌ Errore query: " . $e->getMessage() . " - SQL: " . $sql);
        }
    }

    public function fetchAll($sql, $params = []) {
        $stmt = $this->execute($sql, $params);
        return $stmt->fetchAll();
    }

    public function fetchOne($sql, $params = []) {
        $stmt = $this->execute($sql, $params);
        return $stmt->fetch();
    }

    public function rowCount($sql, $params = []) {
        $stmt = $this->execute($sql, $params);
        return $stmt->rowCount();
    }

    public function lastInsertId() {
        return $this->connection->lastInsertId();
    }
}
?>