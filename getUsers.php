<?php
include('db_connection.php');

// Set response type
header('Content-Type: application/json');

// Fetch all users
$query = "SELECT tbl_user_id, email, first_name, last_name, phone, address, user_type FROM tbl_user";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $users = [];
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
    echo json_encode($users);
} else {
    echo json_encode([]);
}
