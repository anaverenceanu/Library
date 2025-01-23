<?php
session_start();
require '../includes/db.php';

// if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
//     header('Location: login.php');
//     exit();
// }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Dashboard</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
</head>

<body style="background-color: #d3d3d3; background-image: none;">
    <?php include('../templates/header.php'); ?>

    <main class="container my-4">
        <h1 class="text-center pb-4">Employee Dashboard</h1>

        <div class="row g-4">
            <!-- Manage Members -->
            <div class="col-md-4">
                <a href="manage_members.php" class="text-decoration-none">
                    <div class="card text-bg-primary">
                        <div class="card-body text-center">
                            <h3>Manage Members</h3>
                            <p>Add, update, or remove members.</p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Manage Documents -->
            <div class="col-md-4">
                <a href="manage_documents.php" class="text-decoration-none">
                    <div class="card text-bg-success">
                        <div class="card-body text-center">
                            <h3>Manage Documents</h3>
                            <p>Manage books, films, games, and more.</p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Manage Loans -->
            <div class="col-md-4">
                <a href="manage_loans.php" class="text-decoration-none">
                    <div class="card text-bg-warning">
                        <div class="card-body text-center">
                            <h3>Manage Loans</h3>
                            <p>Track and manage loan transactions.</p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Manage Requests -->
            <div class="col-md-4">
                <a href="manage_requests.php" class="text-decoration-none">
                    <div class="card text-bg-info">
                        <div class="card-body text-center">
                            <h3>Manage Requests</h3>
                            <p>Approve or cancel document requests.</p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- View Reports -->
            <div class="col-md-4">
                <a href="view_reports.php" class="text-decoration-none">
                    <div class="card text-bg-danger">
                        <div class="card-body text-center">
                            <h3>View Reports</h3>
                            <p>Generate reports, loans, and documents.</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </main>

    <?php include('../templates/footer.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>