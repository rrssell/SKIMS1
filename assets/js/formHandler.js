document.addEventListener("DOMContentLoaded", function() {
    const inquiryForm = document.getElementById('inquiryForm');
    const successPopup = document.getElementById('successPopup');
    const closePopupBtn = document.getElementById('closePopup');

    // Handle form submission with AJAX
    inquiryForm.addEventListener('submit', function(event) {
        event.preventDefault();  // Prevent the form from reloading the page

        // Create FormData object
        const formData = new FormData(inquiryForm);

        // Send form data using AJAX (Fetch API)
        fetch('message.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())  // Parse JSON response
        .then(data => {
            if (data.status === 'success') {
                // Show success popup
                successPopup.style.display = 'block';
            } else {
                console.error('Error:', data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });

    // Close the popup when clicking the "Close" button
    closePopupBtn.addEventListener('click', function() {
        successPopup.style.display = 'none';
    });
});