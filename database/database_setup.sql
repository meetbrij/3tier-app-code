-- database_setup.sql

-- Create database
CREATE DATABASE IF NOT EXISTS appdb;
USE appdb;

-- Create messages table
CREATE TABLE IF NOT EXISTS messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    message VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert some initial data
INSERT INTO messages (message) VALUES 
('Hello from the database!'),
('Welcome to our three-tier architecture demo'),
('This is a simple example showing frontend, backend, and database');