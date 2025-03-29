<?php
include('db_connection.php');

header('Content-Type: application/json');

// Fetch the message details
$data = json_decode(file_get_contents('php://input'), true);
$message_id = $data['message_id'] ?? null;

if ($message_id) {
    $stmt = $conn->prepare("SELECT subject, message_content FROM messages WHERE message_id = ?");
    $stmt->bind_param('i', $message_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $message = $result->fetch_assoc();
        echo json_encode(['success' => true, 'subject' => $message['subject'], 'message_content' => $message['message_content']]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Message not found.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid message ID.']);
}
