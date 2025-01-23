<?php
session_start();
require '../includes/db.php';

if (isset($_GET['document_id'])) {
    $document_id = $_GET['document_id'];
    $member_id = $_SESSION['user_id'];
    $request_date = date('Y-m-d');
    $status = 'pending';

    $sql = "INSERT INTO requests (member_id, document_id, request_date, status) 
            VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiss", $member_id, $document_id, $request_date, $status);

    if ($stmt->execute()) {
        // Redirect with a success message
        header("Location: dashboard.php?message=Request successfully placed.");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
} else {
    echo "Error: " . $stmt->error;
}
