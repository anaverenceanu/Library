<?php
session_start();
require '../includes/db.php';

// Fetch all loans with member and document details
$sql = "SELECT 
            loans.loan_id, 
            members.full_name AS member_name, 
            documents.title AS document_title, 
            loans.loan_date, 
            loans.return_date 
        FROM loans 
        INNER JOIN members ON loans.member_id = members.member_id 
        INNER JOIN documents ON loans.document_id = documents.document_id";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Loans</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php include('../templates/header.php'); ?>

    <main class="container py-4">
        <h1 class="text-center mb-4">Manage Loans</h1>

        <?php if ($result->num_rows > 0): ?>
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Loan ID</th>
                        <th>Member Name</th>
                        <th>Document Title</th>
                        <th>Loan Date</th>
                        <th>Return Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($loan = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($loan['loan_id']); ?></td>
                            <td><?php echo htmlspecialchars($loan['member_name']); ?></td>
                            <td><?php echo htmlspecialchars($loan['document_title']); ?></td>
                            <td><?php echo htmlspecialchars($loan['loan_date']); ?></td>
                            <td><?php echo htmlspecialchars($loan['return_date']); ?></td>
                            <td>
                                <a href="delete_loan.php?id=<?php echo $loan['loan_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to cancel this loan?');">Cancel</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-warning text-center" role="alert">
                No loans found in the database.
            </div>
        <?php endif; ?>
    </main>

    <?php include('../templates/footer.php'); ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>