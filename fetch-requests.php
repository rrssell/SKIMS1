<?php
include('db_connection.php'); // Ensure conn.php is correctly included

header('Content-Type: application/json');

try {
    // Prepare the query
    $stmt = $conn->prepare("SELECT * FROM document_requests ORDER BY created_at DESC");

    // Execute the query
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // Fetch all rows into an array
    $requests = [];
    while ($row = $result->fetch_assoc()) {
        $requests[] = $row;
    }

    // Return the JSON response
    echo json_encode($requests);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
