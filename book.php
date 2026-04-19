<?php
// Simple book detail page
session_start();
include __DIR__ . '/php/db_connect.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    http_response_code(400);
    echo "<p>Invalid book id.</p>";
    exit;
}

try {
    $stmt = $pdo->prepare('SELECT * FROM books WHERE id = ?');
    $stmt->execute([$id]);
    $book = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $book = null;
    $error = $e->getMessage();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Details</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header>
        <h1>Book Details</h1>
        <nav><a href="recommendations.php">Back to Recommendations</a></nav>
    </header>
    <main>
        <div id="book-details">
            <?php if (!empty($error)): ?>
                <p>Error: <?php echo htmlspecialchars($error); ?></p>
            <?php elseif (!$book): ?>
                <p>Book not found.</p>
            <?php else: ?>
                <h2><?php echo htmlspecialchars($book['title']); ?></h2>
                <p><strong>Author:</strong> <?php echo htmlspecialchars($book['author']); ?></p>
                <p><strong>ISBN:</strong> <?php echo htmlspecialchars($book['isbn']); ?></p>
                <p><strong>Available:</strong> <?php echo (int)$book['available']; ?></p>
                <p><strong>Added:</strong> <?php echo htmlspecialchars($book['created_at']); ?></p>

                <?php
                // Look for content files in /books
                $booksDir = __DIR__ . '/books';
                $candidates = [
                    $booksDir . '/' . $id . '.pdf',
                    $booksDir . '/' . $id . '.txt',
                    $booksDir . '/' . $book['isbn'] . '.pdf',
                    $booksDir . '/' . $book['isbn'] . '.txt'
                ];
                $found = null;
                foreach ($candidates as $f) {
                    if (file_exists($f)) { $found = $f; break; }
                }

                if ($found):
                    $ext = strtolower(pathinfo($found, PATHINFO_EXTENSION));
                    echo "<h3>Read Book</h3>";
                    if ($ext === 'pdf') {
                        $url = 'books/' . basename($found);
                        echo "<embed src=\"" . htmlspecialchars($url) . "\" type=\"application/pdf\" width=\"100%\" height=\"800px\">";
                    } else {
                        echo "<pre style='white-space:pre-wrap;background:#f5f5f5;padding:1rem;border-radius:6px;color:#000;'>";
                        echo htmlspecialchars(file_get_contents($found));
                        echo "</pre>";
                    }
                else:
                    // No content found — uploads are disabled
                    echo "<p>No readable content uploaded for this book.</p>";
                    echo "<p>Uploads are disabled on this site for security reasons.</p>";
                endif;
                ?>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>
