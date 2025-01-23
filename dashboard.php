<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require '../includes/db.php';
session_start();

// if (!isset($_SESSION['user_id'])) {
//     die("User ID is not set. Please log in first.");
// }

$member_id = $_SESSION['user_id'];
$message = "";

// Handle reservation requests
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['request_doc_id'])) {
    $doc_id = intval($_POST['request_doc_id']);
    $sql_check_request = "SELECT * FROM requests WHERE document_id = ? AND member_id = ?";
    $stmt_check_request = $conn->prepare($sql_check_request);

    if (!$stmt_check_request) {
        die("Error preparing SQL statement: " . $conn->error);
    }

    $stmt_check_request->bind_param("ii", $doc_id, $member_id);
    $stmt_check_request->execute();

    if ($stmt_check_request->get_result()->num_rows == 0) {
        $sql_request = "INSERT INTO requests (member_id, document_id, request_date) VALUES (?, ?, NOW())";
        $stmt_request = $conn->prepare($sql_request);

        if (!$stmt_request) {
            die("Error preparing SQL statement: " . $conn->error);
        }

        $stmt_request->bind_param("ii", $member_id, $doc_id);
        if ($stmt_request->execute()) {
            // Fetch document title for the confirmation alert
            $sql_doc = "SELECT title FROM documents WHERE document_id = ?";
            $stmt_doc = $conn->prepare($sql_doc);
            $stmt_doc->bind_param("i", $doc_id);
            $stmt_doc->execute();
            $doc_result = $stmt_doc->get_result()->fetch_assoc();
            $doc_title = htmlspecialchars($doc_result['title']);

            $message = "Document '$doc_title' has been successfully requested by user ID: $member_id.";
        } else {
            die("Error executing query: " . $stmt_request->error);
        }
    } else {
        $message = "You have already requested this document.";
    }
}

// Handle search query
$search_results = [];
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['keyword'])) {
    $keyword = htmlspecialchars($_GET['keyword']);
    $sql_search = "SELECT * FROM documents WHERE LOWER(title) LIKE ? OR LOWER(author_or_producer) LIKE ? OR LOWER(genre) LIKE ? OR LOWER(description) LIKE ?";
    $stmt_search = $conn->prepare($sql_search);

    if (!$stmt_search) {
        die("Error preparing SQL statement: " . $conn->error);
    }

    $searchTerm = '%' . strtolower($keyword) . '%';
    $stmt_search->bind_param("ssss", $searchTerm, $searchTerm, $searchTerm, $searchTerm);
    $stmt_search->execute();

    $search_results = $stmt_search->get_result();
}

// Fetch user-specific document requests
$sql_requests = "SELECT d.title, d.description, r.request_date 
                 FROM requests r 
                 INNER JOIN documents d ON r.document_id = d.document_id 
                 WHERE r.member_id = ?";
$stmt_requests = $conn->prepare($sql_requests);
$stmt_requests->bind_param("i", $member_id);
$stmt_requests->execute();
$requests = $stmt_requests->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Dashboard</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <script>
        // JavaScript function to show an alert after a successful document request
        function showAlert(message) {
            alert(message);
        }
    </script>
</head>

<body style="background-color: #d3d3d3; background-image: none;">
    <?php include('../templates/header.php'); ?>

    <main>
        <div class="container">
            <h1>Welcome!</h1>

            <!-- Search bar -->
            <section>
                <form action="dashboard.php" method="GET">
                    <input type="text" name="keyword" id="search_keyword" placeholder="Search by title, author, genre..." required>
                    <button type="submit" class="btn btn-dark me-2 w-25">Search</button>
                </form>
            </section>

            <!-- Display search results -->
            <section>
                <h2>Search Results</h2>
                <?php
                if (isset($_GET['keyword'])) {
                    if ($search_results->num_rows > 0) {
                        echo "<ul>";
                        while ($doc = $search_results->fetch_assoc()) {
                            echo "<li>
                                    <strong>" . htmlspecialchars($doc['title']) . "</strong> by " . htmlspecialchars($doc['author_or_producer']) . "
                                    <p>" . htmlspecialchars($doc['description']) . "</p>
                                    <form method='POST' action='dashboard.php'>
                                        <input type='hidden' name='request_doc_id' value='" . htmlspecialchars($doc['document_id']) . "'>
                                        <button type='submit' class='btn btn-dark'>Request Document</button>
                                    </form>
                                  </li>";
                        }
                        echo "</ul>";
                    } else {
                        echo "<p>No documents found matching your search criteria.</p>";
                    }
                }
                ?>
            </section>

            <!-- View requested documents -->
            <section>
                <h2>Your Document Requests</h2>
                <?php
                // Query to fetch all requests for the current member
                $sql_requests = "SELECT * FROM requests WHERE member_id = ?";
                $stmt_requests = $conn->prepare($sql_requests);

                if ($stmt_requests) {
                    $stmt_requests->bind_param("i", $member_id);
                    $stmt_requests->execute();
                    $result_requests = $stmt_requests->get_result();

                    if ($result_requests->num_rows > 0) {
                        echo "<ul>";
                        while ($request = $result_requests->fetch_assoc()) {
                            echo "<li>
                        <strong>Document ID: " . htmlspecialchars($request['document_id']) . "</strong> - Requested on: " . htmlspecialchars($request['request_date']) . "
                      </li>";
                        }
                        echo "</ul>";
                    } else {
                        echo "<p>You have not requested any documents.</p>";
                    }

                    // Close the statement after use
                    $stmt_requests->close();
                } else {
                    echo "<p>Error fetching requests: " . $conn->error . "</p>";
                }
                ?>
            </section>



            <!-- Display alert for reservation -->
            <?php if (!empty($message)): ?>
                <script>
                    showAlert(<?= json_encode($message) ?>);
                </script>
            <?php endif; ?>
        </div>
    </main>

    <?php include('../templates/footer.php'); ?>
</body>

</html>