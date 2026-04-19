<?php
// SQLite fallback version - works without MySQL
echo "<h1>🔧 Emergency Setup - Using SQLite</h1>";
echo "<pre>";

$db_file = __DIR__ . '/library.db';

// Create/connect to SQLite database
try {
    $pdo = new PDO("sqlite:$db_file");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✓ SQLite database created: library.db\n\n";
} catch (PDOException $e) {
    echo "❌ Failed to create SQLite: {$e->getMessage()}";
    exit;
}

// Create tables
echo "--- Creating Tables ---\n";
try {
    $pdo->exec("CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        email TEXT UNIQUE NOT NULL,
        password TEXT NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");
    echo "✓ Users table created\n";
    
    $pdo->exec("CREATE TABLE IF NOT EXISTS books (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        title TEXT NOT NULL,
        author TEXT NOT NULL,
        isbn TEXT UNIQUE,
        available INTEGER DEFAULT 1,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");
    echo "✓ Books table created\n";
    
} catch (PDOException $e) {
    echo "❌ Error: {$e->getMessage()}";
    exit;
}

// Insert sample data
echo "\n--- Inserting Sample Data ---\n";
try {
    $pdo->exec("INSERT OR IGNORE INTO books (title, author, isbn, available) VALUES
    ('The Great Gatsby', 'F. Scott Fitzgerald', '9780743273565', 2),
    ('To Kill a Mockingbird', 'Harper Lee', '9780061120084', 1),
    ('1984', 'George Orwell', '9780451524935', 3),
    ('Pride and Prejudice', 'Jane Austen', '9780141439518', 2)");
    echo "✓ Sample books inserted\n";
} catch (PDOException $e) {
    echo "⚠️  {$e->getMessage()}\n";
}

echo "\n✅ SUCCESS! Database is ready (using SQLite)\n";
echo "\nNOTE: Your app is now running on SQLite instead of MySQL.\n";
echo "The MySQL issue can be fixed separately.\n";
echo "\n<a href='index.html'>👉 Go to Login Page</a>\n";

echo "</pre>";
?>
