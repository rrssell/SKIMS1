<?php
session_start();
include('db_connection.php');

// Set the response header to JSON
header('Content-Type: application/json');

if (isset($_SESSION['user_id'])) {
    $user_id = intval($_SESSION['user_id']); // Ensure ID is an integer

    // Prepare the SQL query for a single user
    $query = "SELECT tbl_user_id, first_name, last_name, email, phone, address, user_type, profile_image FROM tbl_user WHERE tbl_user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id); // Bind ID as integer
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch user data
        $user = $result->fetch_assoc();
        // Construct absolute image path
        $profileImage = $user['profile_image'] ? 'http://localhost/SKIMS1/uploads/' . $user['profile_image'] : 'http://localhost/SKIMS1/uploads/default.jpg';
        // Add profile image to the response
        $user['profile_image'] = $profileImage;
        // Return user data
        echo json_encode(['success' => true, 'data' => $user]);
    } else {
        // Return an error if no user is found
        echo json_encode(["error" => "No user found"]);
    }
} else {
    // Return an error if user is not logged in
    echo json_encode(["error" => "User is not logged in"]);
}

$conn->close();
