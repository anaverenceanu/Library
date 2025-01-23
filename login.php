<?php
session_start();
require 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if the user exists
    $sql = "SELECT * FROM employees WHERE email = ?";
    // $sql = "SELECT * FROM members WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Verify hashed password
        if ($user['password'] == $password) {
            $_SESSION['user_id'] = $user['employee_id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['name'] = $user['full_name'];

            // Redirect based on role
            if ($user['role'] == 'admin') {
                header('Location: ./views/admin_dashboard.php');
            } elseif ($user['role'] == 'regular') {
                header('Location: ./views/employee_dashboard.php');
            } else {
                header('Location: ./views/dashboard.php');
            }
            exit();
        } else {
            $error_message = "Invalid email or password.";
        }
    } else {
        $error_message = "No user found with that email.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light d-flex align-items-center justify-content-center" style="height: 100vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="card shadow">
                    <div class="card-body">
                        <h3 class="card-title text-center mb-4">Login</h3>

                        <!-- Login Form -->
                        <form action="login.php" method="POST">
                            <!-- Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email" required>
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" required>
                            </div>

                            <!-- Submit Button -->
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Login</button>
                            </div>
                        </form>

                        <!-- Error Message -->
                        <?php if (!empty($error_message)) : ?>
                            <div class="alert alert-danger mt-3" role="alert">
                                <?= htmlspecialchars($error_message); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>