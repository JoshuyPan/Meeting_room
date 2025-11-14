# DOCUMENTO TECNICO - GESTIONE PRENOTAZIONI MEETING ROOM

## 1. ARCHITETTURA DEL SISTEMA

### 1.1 Stack Tecnologico
- **Frontend**: HTML5, CSS3, JavaScript vanilla, Bootstrap 5
- **Backend**: PHP 8.0 (senza framework)
- **Database**: MySQL 8.0
- **Web Server**: Nginx
- **Containerizzazione**: Docker + Docker Compose

### 1.2 Pattern Architetturale
Model-View-Controller (MVC) semplificato

## 2. SCHEMA DATABASE DETTAGLIATO

### 2.1 Tabella: users
```sql
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    name VARCHAR(100) NOT NULL,
    role ENUM('admin', 'user') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE rooms (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    capacity INT,
    amenities TEXT,
    is_active BOOLEAN DEFAULT TRUE,
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(id)
);

CREATE TABLE bookings (
    id INT PRIMARY KEY AUTO_INCREMENT,
    room_id INT NOT NULL,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    booking_date DATE NOT NULL,
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    participants INT DEFAULT 1,
    notes TEXT,
    status ENUM('confirmed', 'cancelled') DEFAULT 'confirmed',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (room_id) REFERENCES rooms(id),
    FOREIGN KEY (user_id) REFERENCES users(id),
    UNIQUE KEY unique_booking (room_id, booking_date, start_time)
);
```

