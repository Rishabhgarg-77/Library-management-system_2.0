<?php
session_start();
$name = $_SESSION['name'] ?? null;
if (!$name) {
    header('Location: index.html');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header>
        <h1>Dashboard</h1>
        <nav>
            <a href="search_books.html">Search Books</a>
            <a href="recommendations.php">Recommendations</a>
            <a href="php/logout.php">Logout</a>
        </nav>
    </header>
    <?php
    include __DIR__ . '/php/db_connect.php';

    // Show recent and top available books.
    try {
        $topStmt = $pdo->query('SELECT id, title, author, available FROM books ORDER BY available DESC, created_at DESC LIMIT 8');
        $topBooks = $topStmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        $topBooks = [];
        $topError = $e->getMessage();
    }
    ?>
    <main>
        <p>Welcome, <?php echo htmlspecialchars($name); ?>!</p>

        <section>
            <h2>Add a New Book</h2>
            <form action="php/upload_book.php" method="POST">
                <input type="text" name="title" placeholder="Book Title" required>
                <input type="text" name="author" placeholder="Author" required>
                <input type="text" name="isbn" placeholder="ISBN (optional)">
                <input type="number" name="available" min="0" value="1" required>
                <button type="submit">Add Book</button>
            </form>
        </section>

        <section>
            <h2>Top Available Books</h2>
            <?php if (!empty($topError)): ?>
                <p>Error loading books: <?php echo htmlspecialchars($topError); ?></p>
            <?php elseif (empty($topBooks)): ?>
                <p>No books available right now.</p>
            <?php else: ?>
                <ul>
                    <?php foreach ($topBooks as $book): ?>
                        <li><?php echo htmlspecialchars($book['title']); ?> by <?php echo htmlspecialchars($book['author']); ?> (<?php echo (int)$book['available']; ?> available)</li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </section>
    </main>
    <script src="js/script.js"></script>
</body>
</html>
