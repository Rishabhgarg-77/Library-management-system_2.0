<?php
// Recommendations page - shows top available books
include __DIR__ . '/php/db_connect.php';
$recs = [];
try {
    $stmt = $pdo->query("SELECT * FROM books ORDER BY available DESC, created_at DESC LIMIT 6");
    $recs = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $error = $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recommendations</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header>
        <h1>Book Recommendations</h1>
        <nav><a href="dashboard.php">Dashboard</a></nav>
    </header>
    <main>
        <div id="recs">
            <?php if (!empty($error)): ?>
                <p>Error loading recommendations: <?php echo htmlspecialchars($error); ?></p>
            <?php elseif (empty($recs)): ?>
                <p>No recommendations available.</p>
            <?php else: ?>
                <?php foreach ($recs as $b): ?>
                    <div class="book-result">
                        <p><strong><a href="book.php?id=<?php echo (int)$b['id']; ?>"><?php echo htmlspecialchars($b['title']); ?></a></strong> by <?php echo htmlspecialchars($b['author']); ?></p>
                        <p>Available: <?php echo (int)$b['available']; ?></p>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </main>
    <script src="js/script.js"></script>
</body>
</html>
