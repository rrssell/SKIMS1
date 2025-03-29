<?php
session_start();
include 'db_connection.php'; // Include the connection file

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'User is not logged in.']);
    exit();
}

// Handle POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the user ID from the session
    $user_id = $_SESSION['user_id'];

    // Sanitize and escape input data
    $subject = $conn->real_escape_string($_POST['subject']);
    $message_content = $conn->real_escape_string($_POST['body']);

    // Insert data into the database
    $sql = "INSERT INTO messages (user_id, subject, message_content, created_at) 
            VALUES ('$user_id', '$subject', '$message_content', NOW())";

    // Execute the query and return JSON response
    if ($conn->query($sql) === TRUE) {
        echo json_encode(['status' => 'success', 'message' => 'Inquiry submitted successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error: ' . $conn->error]);
    }

    // Close the database connection
    $conn->close();
} else {
    // If the request is not POST
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
