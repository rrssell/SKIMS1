<?php
include('db_connection.php');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);

    $userId = $input['tbl_user_id'] ?? null;
    $userType = $input['user_type'] ?? null;

    if (empty($userId) || empty($userType)) {
        echo json_encode(['success' => false, 'message' => 'User ID and User Type are required.']);
        exit();
    }

    try {
        $stmt = $conn->prepare("UPDATE tbl_user SET user_type = ? WHERE tbl_user_id = ?");
        $stmt->bind_param('si', $userType, $userId);

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                echo json_encode(['success' => true, 'message' => 'User updated successfully.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'No changes made.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update user.']);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
