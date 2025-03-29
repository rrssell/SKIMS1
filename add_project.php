<?php
include('db_connection.php'); // Adjust the path if necessary

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve data from the form submission
    $project_name = $_POST['project_name'] ?? null;
    $status = $_POST['status'] ?? null;
    $host = $_POST['host'] ?? null;
    $start_date = $_POST['start_date'] ?? null;
    $end_date = $_POST['end_date'] ?? null;
    $description = $_POST['description'] ?? null;
    $project_type = $_POST['project_type'] ?? null;

    // Handle file upload
    $image = null; // Default to no image
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/';
        $image_name = basename($_FILES['image']['name']);
        $image_path = $upload_dir . $image_name;

        // Ensure the upload directory exists
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        // Move the uploaded file to the upload directory
        if (move_uploaded_file($_FILES['image']['tmp_name'], $image_path)) {
            $image = $image_path; // Store the image path to save in the database
        } else {
            echo "
            <script>
                alert('Failed to upload image.');
                window.location.href = 'index.php';
            </script>
            ";
            exit();
        }
    }

    // Validate required fields
    if (empty($project_name) || empty($status) || empty($host) || empty($start_date) || empty($end_date) || empty($description) || empty($project_type)) {
        echo "
        <script>
            alert('All fields are required.');
            window.location.href = 'index.php';
        </script>
        ";
        exit();
    }

    try {
        // Prepare the SQL query
        $stmt = $conn->prepare("INSERT INTO project_list (project_name, status, host, start_date, end_date, description, project_type, image, created_at) 
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())");
        $stmt->bind_param(
            "ssssssss",
            $project_name,
            $status,
            $host,
            $start_date,
            $end_date,
            $description,
            $project_type,
            $image
        );

        // Execute the query
        if ($stmt->execute()) {
            echo "
            <script>
                alert('Project added successfully.');
                window.location.href = 'index.php';
            </script>
            ";
        } else {
            echo "
            <script>
                alert('Failed to add project.');
                window.location.href = 'index.php';
            </script>
            ";
        }
    } catch (Exception $e) {
        echo "
        <script>
            alert('Error: " . $e->getMessage() . "');
            window.location.href = 'index.php';
        </script>
        ";
    }
} else {
    echo "
    <script>
        alert('Invalid request method.');
        window.location.href = 'index.php';
    </script>
    ";
}
