<?php
include('db_connection.php');

header('Content-Type: application/json');

try {
    // Fetch all document requests for the admin module
    $stmt = $conn->prepare("SELECT * FROM document_requests ORDER BY created_at DESC");
    $stmt->execute();
    $result = $stmt->get_result();

    $requests = [];
    while ($row = $result->fetch_assoc()) {
        $requests[] = $row;
    }

    echo json_encode($requests);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
