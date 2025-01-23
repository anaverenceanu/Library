<?php
session_start();
require '../includes/db.php';

$sql = "SELECT * FROM documents";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Documents</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php include('../templates/header.php'); ?>

    <main class="container py-4">
        <h1 class="text-center mb-4">All Documents</h1>

        <?php if ($result->num_rows > 0): ?>
            <div class="row row-cols-1 row-cols-md-3 g-4">
                <?php while ($doc = $result->fetch_assoc()): ?>
                    <div class="col">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($doc['title']); ?></h5>
                                <h6 class="card-subtitle mb-2 text-muted">By <?php echo htmlspecialchars($doc['author']); ?></h6>
                                <p class="card-text">
                                    <strong>Genre:</strong> <?php echo htmlspecialchars($doc['genre']); ?><br>
                                    <?php echo nl2br(htmlspecialchars($doc['description'])); ?>
                                </p>
                                <a href="delete_document.php?id=<?php echo $doc['document_id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this document?');">Delete</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-warning text-center" role="alert">
                No documents found in the database.
            </div>
        <?php endif; ?>
    </main>

    <?php include('../templates/footer.php'); ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>