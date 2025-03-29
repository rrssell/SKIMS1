<?php
include('db_connection.php');

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$request_id = $data['request_id'] ?? null;
$status = $data['status'] ?? null;

if ($request_id && $status) {
    try {
        $stmt = $conn->prepare("UPDATE document_requests SET status = ? WHERE request_id = ?");
        $stmt->bind_param('si', $status, $request_id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'No rows updated.']);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid input data.']);
}
