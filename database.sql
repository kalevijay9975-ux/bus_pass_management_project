CREATE DATABASE IF NOT EXISTS bus_pass_db
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE bus_pass_db;

CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS bus_passes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    passenger_name VARCHAR(150) NOT NULL,
    email VARCHAR(150) NOT NULL,
    phone VARCHAR(30) NOT NULL,
    route VARCHAR(200) NOT NULL,
    pass_type VARCHAR(50) NOT NULL,
    valid_until DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Password is generated using PHP password_hash().
-- Default login: admin / admin123
INSERT INTO admins (username, password)
VALUES ('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llCzF5kVfK0t0J6qfZ7yW')
ON DUPLICATE KEY UPDATE username = username;
