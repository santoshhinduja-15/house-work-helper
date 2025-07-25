CREATE TABLE IF NOT EXISTS bookings (
    booking_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    helper_id INT,
    booking_date DATE,
    time_slot VARCHAR(50),
    address TEXT,
    payment_mode ENUM('Cash', 'Online') DEFAULT 'Cash',
    status ENUM('Pending', 'Confirmed', 'Completed', 'Cancelled') DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (helper_id) REFERENCES helpers(helper_id)
);
