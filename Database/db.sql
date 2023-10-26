CREATE DATABASE anchorzupdb;

USE anchorzupdb;

CREATE TABLE short_urls (
    id INT AUTO_INCREMENT PRIMARY KEY,
    short_url VARCHAR(255) NOT NULL,
    original_url TEXT NOT NULL,
    expiration_time TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);