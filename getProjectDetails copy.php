<?php
include('db_connection.php');

// Set the response header to JSON
header('Content-Type: application/json');

if (isset($_GET['id'])) {
    $project_id = intval($_GET['id']); // Ensure ID is an integer

    // Prepare the SQL query
    $query = "SELECT id, project_name, description, status, host, start_date, end_date FROM project_list WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $project_id); // Bind ID as integer
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch and return project data
        echo json_encode($result->fetch_assoc());
    } else {
        // Return an error if no project is found
        echo json_encode(["error" => "No project found"]);
    }
} else {
    echo json_encode(["error" => "Invalid request"]);
}
