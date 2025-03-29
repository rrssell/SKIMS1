document.addEventListener("DOMContentLoaded", function () {
    const links = document.querySelectorAll(".project-link");
    const popup = document.getElementById("project-popup");

    if (!popup) {
        console.error("Popup element (#project-popup) is missing in the DOM.");
        return;
    }

    if (links.length === 0) {
        console.warn("No project links (.project-link) found in the DOM.");
        return;
    }

    links.forEach(link => {
        link.addEventListener("click", function (e) {
            e.preventDefault();
            const projectId = this.getAttribute("data-project-id");
            if (!projectId) {
                console.error("Project link is missing a data-project-id attribute.");
                return;
            }

            console.log("Fetching details for project ID:", projectId); // Debugging log

            fetch(`getProjectDetails.php?id=${encodeURIComponent(projectId)}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log("Project data received:", data); // Debugging log

                    if (data.error) {
                        alert(data.error);
                    } else {
                        popup.querySelector(".popup-title").innerText = data.project_name || "Unknown Project";
                        popup.querySelector(".popup-content").innerHTML = `
                            <p><strong>Description:</strong> ${data.description || "No description available."}</p>
                            <p><strong>Status:</strong> ${data.status || "N/A"}</p>
                            <p><strong>Host:</strong> ${data.host || "N/A"}</p>
                            <p><strong>Start Date:</strong> ${data.start_date || "N/A"}</p>
                            <p><strong>End Date:</strong> ${data.end_date || "N/A"}</p>
                        `;
                        popup.style.display = "block";
                    }
                })
                .catch(error => {
                    console.error("Error fetching project details:", error);
                    alert("Failed to load project details. Please try again later.");
                });
        });
    });

    document.getElementById("popup-close")?.addEventListener("click", function () {
        popup.style.display = "none";
    });
});
