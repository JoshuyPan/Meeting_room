<?php

class DatabaseConfig {
    const HOST = 'db'; 
    const DBNAME = 'meeting_rooms';
    const USER = 'app_user';
    const PASSWORD = 'app_password';
    const CHARSET = 'utf8mb4';
    
    public static function getDSN() {
        return "mysql:host=" . self::HOST . ";dbname=" . self::DBNAME . ";charset=" . self::CHARSET;
    }
}

?>