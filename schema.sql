CREATE DATABASE IF NOT EXISTS ticket_booking;

USE ticket_booking;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL
);

CREATE TABLE tickets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    type ENUM('bus', 'train', 'airplane') NOT NULL,
    from_location VARCHAR(100) NOT NULL,
    to_location VARCHAR(100) NOT NULL,
    date DATE NOT NULL,
    time TIME NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    available_seats INT NOT NULL
);

CREATE TABLE bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    ticket_id INT NOT NULL,
    booking_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('pending', 'confirmed', 'cancelled') DEFAULT 'pending',
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (ticket_id) REFERENCES tickets(id)
);

-- Insert sample data
INSERT INTO users (username, password, email) VALUES
('user1', '$2y$10$examplehashedpassword', 'user1@example.com'),
('user2', '$2y$10$examplehashedpassword', 'user2@example.com');

INSERT INTO tickets (type, from_location, to_location, date, time, price, available_seats) VALUES
('bus', 'City A', 'City B', '2023-12-01', '08:00:00', 50.00, 20),
('train', 'City A', 'City C', '2023-12-02', '10:00:00', 75.00, 15),
('airplane', 'City A', 'City D', '2023-12-03', '14:00:00', 200.00, 10);
