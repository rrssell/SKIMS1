<?php
session_start();
include('db_connection.php'); // Database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile-picture'])) {
    $file = $_FILES['profile-picture'];
    $uploadDir = 'uploads/';  // Directory where images will be stored
    $uploadFile = $uploadDir . basename($file['name']);

    // Validate the file (optional)
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
    $fileExtension = pathinfo($uploadFile, PATHINFO_EXTENSION);

    if (in_array(strtolower($fileExtension), $allowedExtensions)) {
        // Move the uploaded file to the server
        if (move_uploaded_file($file['tmp_name'], $uploadFile)) {
            // Save the file path in the database
            $userId = $_SESSION['user_id']; // Assuming user is logged in
            $stmt = $conn->prepare("UPDATE tbl_user SET profile_image = ? WHERE tbl_user_id = ?");
            $stmt->bind_param('si', $uploadFile, $userId);
            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Profile picture updated successfully.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error updating profile picture.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to upload file.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid file type. Only JPG, JPEG, PNG, GIF allowed.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'No file uploaded.']);
}
