document.addEventListener("DOMContentLoaded", function() {
    const buttons = document.querySelectorAll('.details-btn');
    const popups = document.querySelectorAll('.popup-overlay');
    const closeButtons = document.querySelectorAll('.close-btn');

    // Loop through all buttons to add click event
    buttons.forEach((button, index) => {
        button.addEventListener('click', () => {
            const projectId = button.getAttribute('data-project-id');
            fetchProjectDetails(projectId, index);
        });
    });

    // Function to fetch project details
    function fetchProjectDetails(projectId, index) {
        fetch(`getProjectDetails.php?id=${encodeURIComponent(projectId)}`)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    console.error(data.error);
                    alert("Error: " + data.error);
                } else {
                    // Populate the popup with project details
                    const popupContent = popups[index].querySelector('.popup-content');
                    popupContent.innerHTML = `
                        <div class="popup-inner">
                            <div class="popup-details">
                                <h3>${data.project_name || "Unnamed Project"}</h3>
                                <p class="description"><strong>Description:</strong> ${data.description || "No description available"}</p>
                                <p class="status"><strong>Status:</strong> ${data.status || "N/A"}</p>
                                <p class="host"><strong>Host:</strong> ${data.host || "N/A"}</p>
                                <p class="dates"><strong>Start Date:</strong> ${data.start_date || "N/A"}<br><strong>End Date:</strong> ${data.end_date || "N/A"}</p>
                            </div>
                            <div class="popup-image-container">
                                <img src="${data.image || 'https://via.placeholder.com/400?text=No+Image+Available'}" alt="${data.project_name || 'Project Image'}" class="popup-image">
                            </div>
                        </div>
                    `;

                    // Show the popup
                    popups[index].style.display = 'flex';
                }
            })
            .catch(error => {
                console.error('Error fetching project details:', error);
                alert("Failed to load project details.");
            });
    }

    // Close the popup when close button is clicked
    closeButtons.forEach((closeButton, index) => {
        closeButton.addEventListener('click', () => {
            popups[index].style.display = 'none';
        });
    });

    // Close popup when clicking outside the content
    popups.forEach(popup => {
        popup.addEventListener('click', (e) => {
            if (e.target === popup) {
                popup.style.display = 'none';
            }
        });
    });
});