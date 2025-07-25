CREATE TABLE IF NOT EXISTS documents (
    doc_id INT AUTO_INCREMENT PRIMARY KEY,
    helper_id INT,
    aadhaar_file VARCHAR(255),
    address_proof VARCHAR(255),
    verified_by_admin BOOLEAN DEFAULT FALSE,
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (helper_id) REFERENCES helpers(helper_id)
);
