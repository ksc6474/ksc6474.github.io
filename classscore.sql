CREATE DATABASE IF NOT EXISTS classscore CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE classscore;

CREATE TABLE IF NOT EXISTS tickets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_name VARCHAR(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
    ticket_type VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
    remarks VARCHAR(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
    child_counts VARCHAR(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
    adult_counts VARCHAR(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
    total_price INT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;