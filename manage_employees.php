<?php
session_start();
require '../includes/db.php';

$sql = "SELECT * FROM employees";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Employees</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php include('../templates/header.php'); ?>

    <main class="container py-4">
        <h1 class="text-center mb-4">All Employees</h1>

        <?php if ($result->num_rows > 0): ?>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Employee ID</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Password</th>
                            <th>Role</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($employee = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($employee['employee_id']); ?></td>
                                <td><?php echo htmlspecialchars($employee['full_name']); ?></td>
                                <td><?php echo htmlspecialchars($employee['email']); ?></td>
                                <td><?php echo htmlspecialchars($employee['password']); ?></td>
                                <td><?php echo htmlspecialchars($employee['role']); ?></td>
                                <td>
                                    <a href="delete_employee.php?id=<?php echo $employee['employee_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this employee?');">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-warning text-center" role="alert">
                No employees found in the database.
            </div>
        <?php endif; ?>
    </main>

    <?php include('../templates/footer.php'); ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>