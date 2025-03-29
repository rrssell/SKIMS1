<?php
include('db_connection.php');

// Fetch project names and IDs from the database
$query = "SELECT id, project_name FROM projects";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projects</title>
    <style>
        nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        nav ul li {
            margin: 10px 0;
        }

        #project-popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
            background: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            z-index: 1000;
            border-radius: 8px;
            width: 400px;
            max-width: 90%;
        }

        #popup-close {
            display: block;
            margin-top: 10px;
            padding: 5px 10px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        #popup-close:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <nav>
        <ul>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <li>
                    <a href="#" class="project-link" data-project-id="<?php echo $row['id']; ?>">
                        <?php echo $row['project_name']; ?>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </nav>

    <div id="project-popup">
        <h2 class="popup-title"></h2>
        <p class="popup-content"></p>
        <button id="popup-close">Close</button>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const links = document.querySelectorAll(".project-link");

            links.forEach(link => {
                link.addEventListener("click", function(e) {
                    e.preventDefault();
                    const projectId = this.getAttribute("data-project-id");

                    fetch(`getProjectDetails.php?id=${projectId}`)
                        .then(response => response.json())
                        .then(data => {
                            const popup = document.querySelector("#project-popup");
                            popup.querySelector(".popup-title").innerText = data.project_name || "Unknown Project";
                            popup.querySelector(".popup-content").innerText = data.description || "No description available.";
                            popup.style.display = "block";
                        })
                        .catch(error => {
                            console.error("Error fetching project details:", error);
                        });
                });
            });

            document.querySelector("#popup-close").addEventListener("click", function() {
                document.querySelector("#project-popup").style.display = "none";
            });
        });
    </script>
</body>

</html>