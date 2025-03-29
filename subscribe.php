<?php
$servername = "localhost";
$username = "root";
$password = "bagets101";
$dbname = "project_dashboard";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = $conn->real_escape_string($_POST['email']);

     $sql = "INSERT INTO subscribe (email) VALUES ('$email')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error: ' . $conn->error]);
    }

    // Close the database connection
    $conn->close();
} else {
    // If the request is not POST
    echo json_encode(['status' => 'error', 'message' => 'No POST data received.']);
}
