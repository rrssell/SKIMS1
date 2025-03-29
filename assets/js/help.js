document.addEventListener("DOMContentLoaded", function() {
    const inquiryBtn = document.getElementById('inquiry-btn');
    const chatBtn = document.getElementById('chat-btn');
    const callBtn = document.getElementById('call-btn');

    const inquiryForm = document.getElementById('form-container');
    const chatPopup = document.getElementById('chat-popup');
    const callPopup = document.getElementById('call-popup');

    // Show the inquiry form when the Inquiry button is clicked
    inquiryBtn.addEventListener('click', () => {
        inquiryForm.style.display = 'block';
        chatPopup.style.display = 'none';
        callPopup.style.display = 'none';
    });

    // Show the chat popup when the Chat button is clicked
    chatBtn.addEventListener('click', () => {
        chatPopup.style.display = 'block';
        inquiryForm.style.display = 'none';
        callPopup.style.display = 'none';
    });

    // Show the call popup when the Call button is clicked
    callBtn.addEventListener('click', () => {
        callPopup.style.display = 'block';
        inquiryForm.style.display = 'none';
        chatPopup.style.display = 'none';
    });
});