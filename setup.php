<?php
// Setup script for database
$host = '127.0.0.1';
$user = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create database
    $pdo->exec("CREATE DATABASE IF NOT EXISTS library_db");
    echo "Database created.<br>";

    // Select database
    $pdo->exec("USE library_db");

    // Create users table
    $pdo->exec("CREATE TABLE IF NOT EXISTS users (
        id INT PRIMARY KEY AUTO_INCREMENT,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(100) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
    echo "Users table created.<br>";

    // Create books table
    $pdo->exec("CREATE TABLE IF NOT EXISTS books (
        id INT PRIMARY KEY AUTO_INCREMENT,
        title VARCHAR(150) NOT NULL,
        author VARCHAR(100) NOT NULL,
        isbn VARCHAR(13) UNIQUE,
        available INT DEFAULT 1,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
    echo "Books table created.<br>";

    // Insert sample data
    $pdo->exec("INSERT IGNORE INTO books (title, author, isbn, available) VALUES
    ('The Great Gatsby', 'F. Scott Fitzgerald', '9780743273565', 2),
    ('To Kill a Mockingbird', 'Harper Lee', '9780061120084', 1),
    ('1984', 'George Orwell', '9780451524935', 3),
    ('Pride and Prejudice', 'Jane Austen', '9780141439518', 2)");
    echo "Sample books inserted.<br>";

    echo "Setup complete.";

} catch (PDOException $e) {
    die("Setup failed: " . $e->getMessage());
}
?>