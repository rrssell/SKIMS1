<?php
include 'db_connection.php'; // Include the connection file

$sql = "SELECT * FROM project_list";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>Project ID</th>
                <th>Project Name</th>
                <th>Status</th>
                <th>Host</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Description</th>
                <th>Project Type</th>
            </tr>";
    // Output each project row
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["project_id"] . "</td>
                <td>" . $row["project_name"] . "</td>
                <td>" . $row["status"] . "</td>
                <td>" . $row["host"] . "</td>
                <td>" . $row["start_date"] . "</td>
                <td>" . $row["end_date"] . "</td>
                <td>" . $row["description"] . "</td>
                <td>" . $row["project_type"] . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No projects found.";
}

$conn->close();
