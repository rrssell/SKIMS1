<?php
include('db_connection.php');
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$request_id = $data['request_id'] ?? null;

// Log the received request_id for debugging
file_put_contents('debug.log', "Received request_id: " . $request_id . PHP_EOL, FILE_APPEND);

if (!$request_id) {
    echo json_encode(['success' => false, 'message' => 'Request ID is missing.']);
    exit();
}

// Check if the request exists
$stmt = $conn->prepare("SELECT * FROM document_requests WHERE request_id = ?");
$stmt->bind_param("i", $request_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    file_put_contents('debug.log', "Request ID $request_id not found in database." . PHP_EOL, FILE_APPEND);
    echo json_encode(['success' => false, 'message' => 'Request not found.']);
    exit();
}

// Delete the request
$stmt = $conn->prepare("DELETE FROM document_requests WHERE request_id = ?");
$stmt->bind_param("i", $request_id);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Request canceled successfully.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to cancel the request.']);
}
