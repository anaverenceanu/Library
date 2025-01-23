<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require '../includes/db.php';
session_start();

// if (!isset($_SESSION['user_id'])) {
//     die("User ID is not set. Please log in first.");
// }

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['keyword'])) {
    $keyword = htmlspecialchars($_GET['keyword']);
    $sql = "SELECT * FROM documents WHERE LOWER(title) LIKE ? OR LOWER(author_or_producers) LIKE ? OR LOWER(genre) LIKE ? OR LOWER(description) LIKE ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Error preparing SQL statement: " . $conn->error);
    }

    $searchTerm = '%' . strtolower($keyword) . '%';
    $stmt->bind_param("ssss", $searchTerm, $searchTerm, $searchTerm, $searchTerm);

    if (!$stmt->execute()) {
        die("Error executing query: " . $stmt->error);
    }

    $results = $stmt->get_result();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>

<body>
    <?php include('../templates/header.php'); ?>

    <main>
        <div class="container">
            <h1>Search Results</h1>

            <!-- Display search results -->
            <?php if (isset($results) && $results->num_rows > 0): ?>
                <ul>
                    <?php while ($doc = $results->fetch_assoc()): ?>
                        <li>
                            <strong><?= htmlspecialchars($doc['title']) ?></strong>
                            <p><?= htmlspecialchars($doc['description']) ?></p>
                            <form method="POST" action="member_dashboard.php">
                                <input type="hidden" name="request_doc_id" value="<?= $doc['document_id'] ?>">
                                <button type="submit">Reserve Document</button>
                            </form>
                        </li>
                    <?php endwhile; ?>
                </ul>
            <?php else: ?>
                <p>No results found for "<?= htmlspecialchars($_GET['keyword']) ?>".</p>
            <?php endif; ?>
        </div>
    </main>
</body>

</html>