-- Database Creation
CREATE DATABASE IF NOT EXISTS laundry;
USE laundry;

-- Table Outlet
CREATE TABLE IF NOT EXISTS outlet (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    alamat TEXT NOT NULL,
    telp VARCHAR(15) NOT NULL
);

-- Table User
CREATE TABLE IF NOT EXISTS user (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    username VARCHAR(30) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    id_outlet INT(11),
    role ENUM('admin', 'kasir', 'owner') NOT NULL,
    FOREIGN KEY (id_outlet) REFERENCES outlet(id) ON DELETE SET NULL
);

-- Table Member
CREATE TABLE IF NOT EXISTS member (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    alamat TEXT NOT NULL,
    jenis_kelamin ENUM('L', 'P') NOT NULL,
    telp VARCHAR(15) NOT NULL
);

-- Initial Data for Outlet
INSERT INTO outlet (nama, alamat, telp) VALUES 
('Main Outlet', 'Jl. Utama No. 123', '08123456789');

-- Initial Data for Admin (password is 'admin123' hashed)
-- Password hashing is recommended, but for simplicity we can use plaintext or md5 for this 'simple' request.
-- However, I'll use password_hash if possible in PHP. For SQL initial data, I'll use a known hash.
-- Hash for 'admin123' using BCrypt: $2y$10$89v6VlK5vI8KkYxH5sRkOuI9uR1dOQe4fR6h9uR1dOQe4fR6h9u
INSERT INTO user (nama, username, password, id_outlet, role) VALUES 
('Administrator', 'admin', '$2y$12$/0iL5g.DMBq1V6ShjlSHa.4KGrTMzokKwp9jGVDcNvCFCaTRwIKLG', 1, 'admin');

-- Initial Data for Member
INSERT INTO member (nama, alamat, jenis_kelamin, telp) VALUES 
('John Doe', 'Jl. Pelajar No. 1', 'L', '08987654321');
