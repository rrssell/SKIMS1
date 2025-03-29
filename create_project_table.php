<?php
include 'db_connection.php'; // Include the connection file

// SQL query to create the new project table
$sql = "CREATE TABLE IF NOT EXISTS project_list (
    project_id INT AUTO_INCREMENT PRIMARY KEY,
    project_name VARCHAR(255) NOT NULL,
    status ENUM('Running', 'Finished', 'Cancelled', 'Postponed') NOT NULL,
    host ENUM('SK', 'Barangay') NOT NULL,
    start_date DATE,
    end_date DATE,
    description TEXT
)";

if ($conn->query($sql) === TRUE) {
    echo "Table 'project_list' created successfully.";
} else {
    echo "Error creating table: " . $conn->error;
}

$conn->close();

$sql = "CREATE TABLE IF NOT EXISTS projects (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(30) NOT NULL,
    description TEXT,
    project_type VARCHAR(20),  // New column for project type
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";