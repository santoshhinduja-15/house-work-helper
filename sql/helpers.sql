CREATE TABLE IF NOT EXISTS helpers (
    helper_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    category ENUM('Maid', 'Cook', 'Babysitter') NOT NULL,
    location VARCHAR(100),
    timeslot VARCHAR(50),
    hourly_rate DECIMAL(6,2),
    experience INT,
    aadhaar_number VARCHAR(20) UNIQUE,
    is_verified BOOLEAN DEFAULT FALSE,
    profile_image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
