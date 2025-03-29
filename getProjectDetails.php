<?php
include('db_connection.php');

// Set the response header to JSON
header('Content-Type: application/json');

if (isset($_GET['id'])) {
    $project_id = intval($_GET['id']); // Ensure ID is an integer

    // Prepare the SQL query for a single project
    $query = "SELECT id, project_name, description, status, host, start_date, end_date, image FROM project_list WHERE id = ?";
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
    // Fetch all projects
    $query = "SELECT id, project_name, description, status, host, start_date, end_date, image FROM project_list";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $projects = [];
        while ($row = $result->fetch_assoc()) {
            $projects[] = $row;
        }
        // Return all projects
        echo json_encode($projects);
    } else {
        // Return an error if no projects are found
        echo json_encode(["error" => "No projects found"]);
    }
}
