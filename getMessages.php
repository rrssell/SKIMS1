<?php
include('db_connection.php');

// Set response type
header('Content-Type: application/json');

// Fetch all messages
$query = "SELECT message_id, subject FROM messages";
$result = $conn->query($query);

if ($result && $result->num_rows > 0) {
    $messages = [];
    while ($row = $result->fetch_assoc()) {
        $messages[] = $row;
    }
    echo json_encode($messages);
} else {
    echo json_encode([]); // Return an empty array if no messages are found
}
