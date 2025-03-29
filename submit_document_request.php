<?php
session_start();
include('db_connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the user ID from session or POST
    $user_id = $_SESSION['user_id'] ?? $_POST['user_id'] ?? null;

    // Validate user ID
    if (!$user_id) {
        echo "
        <script>
            alert('User ID is missing. Please log in again.');
            window.location.href = 'login/index.php';
        </script>";
        exit();
    }

    // Retrieve form data
    $document_type = $_POST['document_type'] ?? null;
    $name = $_POST['name'] ?? null;
    $address = $_POST['address'] ?? null;
    $age = $_POST['age'] ?? null;
    $purpose = $_POST['purpose'] ?? null;
    $representative_name = $_POST['representative_name'] ?? null;

    // Ensure all required fields are filled
    if (!$document_type || !$name || !$address || !$age || !$purpose) {
        echo "
        <script>
            alert('All fields except Representative Name are required.');
            window.history.back();
        </script>";
        exit();
    }

    try {
        // Prepare the SQL query
        $stmt = $conn->prepare("
            INSERT INTO document_requests (user_id, document_type, name, address, age, purpose, representative_name, status, created_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, 'Pending', NOW())
        ");
        $stmt->bind_param('isssiss', $user_id, $document_type, $name, $address, $age, $purpose, $representative_name);

        // Execute the query
        if ($stmt->execute()) {
            echo "
            <script>
                alert('Document request submitted successfully.');
                window.location.href = 'index.php';
            </script>";
        } else {
            throw new Exception($stmt->error);
        }
    } catch (Exception $e) {
        // Handle errors
        echo "
        <script>
            alert('Failed to submit the document request. Error: " . $e->getMessage() . "');
            window.location.href = 'index.php';
        </script>";
    }
} else {
    // Handle invalid request method
    echo "
    <script>
        alert('Invalid request method.');
        window.location.href = 'index.php';
    </script>";
    exit();
}
