<?php
$servername = "localhost";
$username = "root";
$password = "bagets101";
$dbname = "project_dashboard";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the project ID from the request
$project_id = $_GET['id'];

// Fetch the project details from project_details table
$sql = "SELECT * FROM project_details WHERE project_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $project_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $project_details = $result->fetch_assoc();
    echo json_encode($project_details);
} else {
    echo json_encode(['error' => 'Project details not found']);
}

$stmt->close();
$conn->close();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $project_name = $_POST['project_name'];
    $status = $_POST['status'];
    $host = $_POST['host'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $description = $_POST['description'];

    // Prepare SQL statement to insert data
    $sql = "INSERT INTO projects (project_name, status, host, start_date, end_date, description)
            VALUES ('$project_name', '$status', '$host', '$start_date', '$end_date', '$description')";

    if ($conn->query($sql) === TRUE) {
        echo "New project created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!-- HTML form to insert new project -->
<form method="post" action="projects.php">
    <label for="project_name">Project Name:</label>
    <input type="text" id="project_name" name="project_name" required><br><br>

    <label for="status">Status:</label>
    <select id="status" name="status">
        <option value="Running">Running</option>
        <option value="Finished">Finished</option>
        <option value="Cancelled">Cancelled</option>
        <option value="Postponed">Postponed</option>
    </select><br><br>

    <label for="host">Host:</label>
    <select id="host" name="host">
        <option value="SK">SK</option>
        <option value="Barangay">Barangay</option>
    </select><br><br>

    <label for="start_date">Start Date:</label>
    <input type="date" id="start_date" name="start_date"><br><br>

    <label for="end_date">End Date:</label>
    <input type="date" id="end_date" name="end_date"><br><br>

    <label for="description">Description:</label>
    <textarea id="description" name="description"></textarea><br><br>

    <input type="submit" value="Submit">
</form>