document.addEventListener("DOMContentLoaded", function() {
    const inquiryBtn = document.getElementById('inquiry-btn');
    const requestDocBtn = document.getElementById('request-doc-btn');

    const inquiryForm = document.getElementById('inquiry-form');
    const requestDocForm = document.getElementById('request-doc-form');

    // Show Inquiry Form, hide others
    inquiryBtn.addEventListener('click', () => {
        inquiryForm.style.display = 'block';
        requestDocForm.style.display = 'none';
    });

    // Show Request Document Form, hide others
    requestDocBtn.addEventListener('click', () => {
        requestDocForm.style.display = 'block';
        inquiryForm.style.display = 'none';
    });
});

