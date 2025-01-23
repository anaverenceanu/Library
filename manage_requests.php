<?php
session_start();
require '../includes/db.php';

// Fetch all requests with member and document details
$sql = "SELECT 
            requests.request_id, 
            members.full_name AS member_name, 
            documents.title AS document_title, 
            requests.request_date 
        FROM requests 
        INNER JOIN members ON requests.member_id = members.member_id 
        INNER JOIN documents ON requests.document_id = documents.document_id";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Requests</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php include('../templates/header.php'); ?>

    <main class="container py-4">
        <h1 class="text-center mb-4">Manage Requests</h1>

        <?php if ($result->num_rows > 0): ?>
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Request ID</th>
                        <th>Member Name</th>
                        <th>Document Title</th>
                        <th>Request Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($request = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($request['request_id']); ?></td>
                            <td><?php echo htmlspecialchars($request['member_name']); ?></td>
                            <td><?php echo htmlspecialchars($request['document_title']); ?></td>
                            <td><?php echo htmlspecialchars($request['request_date']); ?></td>
                            <td>
                                <a href="delete_request.php?id=<?php echo $request['request_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to cancel this request?');">Cancel</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-warning text-center" role="alert">
                No requests found in the database.
            </div>
        <?php endif; ?>
    </main>

    <?php include('../templates/footer.php'); ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>