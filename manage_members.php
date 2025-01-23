<?php
session_start();
require '../includes/db.php';

$sql = "SELECT * FROM members";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Members</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php include('../templates/header.php'); ?>

    <main class="container py-4">
        <h1 class="text-center mb-4">All Members</h1>

        <?php if ($result->num_rows > 0): ?>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Member ID</th>
                            <th>Full Name</th>
                            <th>Address</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Password</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($member = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($member['member_id']); ?></td>
                                <td><?php echo htmlspecialchars($member['full_name']); ?></td>
                                <td><?php echo htmlspecialchars($member['address']); ?></td>
                                <td><?php echo htmlspecialchars($member['phone']); ?></td>
                                <td><?php echo htmlspecialchars($member['email']); ?></td>
                                <td><?php echo htmlspecialchars($member['password']); ?></td>
                                <td>
                                    <a href="delete_member.php?id=<?php echo $member['member_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this member?');">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-warning text-center" role="alert">
                No members found in the database.
            </div>
        <?php endif; ?>
    </main>

    <?php include('../templates/footer.php'); ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>