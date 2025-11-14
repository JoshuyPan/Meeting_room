USE meeting_rooms;

CREATE TABLE IF NOT EXISTS users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    name VARCHAR(100) NOT NULL,
    role ENUM('admin', 'user') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS rooms (
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

CREATE TABLE IF NOT EXISTS bookings (
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

-- PASSWORD: admin123
INSERT IGNORE INTO users (email, password, name, role) VALUES 
('admin@example.com', '$2y$10$nuH5Sa4EBCPCANKaRIx5h.7DkJpc.Inn/kn0dpi511v8RGLWSmHqa', 'Amministratore', 'admin');

INSERT IGNORE INTO rooms (name, description, capacity, amenities) VALUES 
('Sala Riunioni A', 'Sala al primo piano con proiettore e impianto audio', 10, 'Proiettore, Wi-Fi, Impianto Audio'),
('Sala Riunioni B', 'Sala al secondo piano con lavagna interattiva', 8, 'Lavagna Interattiva, Wi-Fi, Monitor'),
('Sala Conferenze', 'Sala grande per eventi e presentazioni', 50, 'Microfoni, Proiettore 4K, Wi-Fi, Impianto Audio Professionale'),
('Sala Brainstorming', 'Sala informale con divani e tavoli mobili', 6, 'Wi-Fi, TV, Lavagna a Fogli'),
('Sala Executive', 'Sala riunioni per dirigenti con arredamento di lusso', 12, 'Wi-Fi, Videoconferenza, Monitor 4K, Cucinetta');