<?php
include('db_connection.php'); // Include your database connection file

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the raw POST data and decode JSON
    $input = json_decode(file_get_contents('php://input'), true);

    // Extract the data from the JSON input
    $project_id = $input['id'] ?? null;
    $project_name = $input['project_name'] ?? null;
    $status = $input['status'] ?? null;
    $host = $input['host'] ?? null;
    $start_date = $input['start_date'] ?? null;
    $end_date = $input['end_date'] ?? null;
    $description = $input['description'] ?? null;
    $project_type = $input['project_type'] ?? null;

    // Handle image upload (if applicable)
    $imagePath = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imageTmpPath = $_FILES['image']['tmp_name'];
        $imageName = basename($_FILES['image']['name']);
        $uploadDir = 'uploads/'; // Directory to store uploaded images

        // Ensure the uploads directory exists
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Secure the file name and construct the upload path
        $imagePath = $uploadDir . time() . "_" . preg_replace("/[^a-zA-Z0-9\.\-_]/", "", $imageName);

        // Move the uploaded file to the destination
        if (!move_uploaded_file($imageTmpPath, $imagePath)) {
            echo json_encode(['success' => false, 'message' => 'Failed to upload the image.']);
            exit();
        }
    }

    // Validate required fields
    if (empty($project_id) || empty($project_name) || empty($status) || empty($host) || empty($start_date) || empty($end_date) || empty($description) || empty($project_type)) {
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
        exit();
    }

    try {
        // Prepare the SQL query
        $query = "UPDATE project_list 
                  SET project_name = ?, status = ?, host = ?, start_date = ?, end_date = ?, description = ?, project_type = ?";

        // Include the image column if a new image is provided
        if ($imagePath) {
            $query .= ", image = ?";
        }

        $query .= " WHERE id = ?";

        $stmt = $conn->prepare($query);

        // Bind parameters
        if ($imagePath) {
            $stmt->bind_param("ssssssssi", $project_name, $status, $host, $start_date, $end_date, $description, $project_type, $imagePath, $project_id);
        } else {
            $stmt->bind_param("sssssssi", $project_name, $status, $host, $start_date, $end_date, $description, $project_type, $project_id);
        }

        // Execute the query
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Project updated successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update the project.']);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
