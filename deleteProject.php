<?php
include('db_connection.php'); // Ensure this points to your database connection file

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the JSON input
    $input = json_decode(file_get_contents('php://input'), true);

    // Retrieve and validate the project ID
    $project_id = $input['id'] ?? null;

    if (empty($project_id)) {
        echo json_encode(['success' => false, 'message' => 'Project ID is required.']);
        exit();
    }

    try {
        // Prepare the SQL query to delete the project
        $stmt = $conn->prepare("DELETE FROM project_list WHERE id = ?");
        $stmt->bind_param('i', $project_id);

        // Execute the query
        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                echo json_encode(['success' => true, 'message' => 'Project deleted successfully.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Project not found.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete project.']);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
