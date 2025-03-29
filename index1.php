<?php
include 'db_connection.php'; // Include database connection

// Fetch SK and Barangay projects from the database for different categories
$categories = ['Education', 'Financial', 'Livelihood', 'Infrastructure'];

// Create arrays to store projects for each category
$projects = [];

// Fetch SK and Barangay projects for each category
foreach ($categories as $category) {
    // Example SQL queries for SK and Barangay projects
    $sk_sql = "SELECT id, project_name FROM project_list WHERE host = 'SK' AND status = 'Running' AND project_name LIKE '%$category%'";
    $barangay_sql = "SELECT id, project_name FROM project_list WHERE host = 'Barangay' AND status = 'Running' AND project_name LIKE '%$category%'";

    // Execute SK SQL query
    $sk_result = $conn->query($sk_sql);
    if ($sk_result->num_rows > 0) {
        while ($row = $sk_result->fetch_assoc()) {
            $projects[$category]['SK'][] = [
                'id' => $row['id'],
                'project_name' => $row['project_name']
            ];
        }
    }

    // Execute Barangay SQL query
    $barangay_result = $conn->query($barangay_sql);
    if ($barangay_result->num_rows > 0) {
        while ($row = $barangay_result->fetch_assoc()) {
            $projects[$category]['Barangay'][] = [
                'id' => $row['id'],
                'project_name' => $row['project_name']
            ];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" href="assets/img/favicon.png" type="image/png">

    <!--=============== REMIXICONS ===============-->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">

    <!--=============== SWIPER CSS ===============-->
    <link rel="stylesheet" href="assets/css/swiper-bundle.min.css">

    <!--=============== CSS ===============-->
    <link rel="stylesheet" href="assets/css/styles.css">

    <title>SKIMS</title>
</head>

<body>
    <script src="assets/js/popup.js"></script>
    <script src="assets/js/help.js"></script>
    <script src="assets/js/forms.js"></script>
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/tl_PH/sdk.js#xfbml=1&version=v20.0" nonce="rcnxnYMD"></script>
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v21.0"></script>
    <header class="header" id="header">
        <nav class="nav container">
            <a href="#" class="nav__logo">Tangos North</a>

            <div class="nav__menu" id="nav-menu">
                <ul class="nav__list">
                    <li class="nav__item">
                        <a href="#about" class="nav__link">Feed</a>
                    </li>

                    <!-- Projects dropdown menu -->
                    <li class="nav__item dropdown">
                        <a href="#" class="nav__link nav__projects">Projects</a>
                        <ul class="dropdown__menu">
                            <!-- Loop through categories -->
                            <?php foreach ($categories as $category): ?>
                                <li class="dropdown__item">
                                    <a href="#"><?php echo htmlspecialchars($category, ENT_QUOTES); ?></a>
                                    <ul class="dropdown__submenu">
                                        <!-- SK Projects -->
                                        <li class="dropdown__header">SK Projects</li>
                                        <?php if (!empty($projects[$category]['SK'])): ?>
                                            <?php foreach ($projects[$category]['SK'] as $sk_project): ?>
                                                <li>
                                                    <a href="#" class="project-link" data-project-id="<?php echo htmlspecialchars($sk_project['id'], ENT_QUOTES); ?>">
                                                        <?php echo htmlspecialchars($sk_project['project_name'], ENT_QUOTES); ?>
                                                    </a>
                                                </li>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <li><a href="#">No projects</a></li>
                                        <?php endif; ?>

                                        <li class="dropdown__divider"></li> <!-- Divider -->

                                        <!-- Barangay Projects -->
                                        <li class="dropdown__header">Barangay Projects</li>
                                        <?php if (!empty($projects[$category]['Barangay'])): ?>
                                            <?php foreach ($projects[$category]['Barangay'] as $barangay_project): ?>
                                                <li>
                                                    <a href="#" class="project-link" data-project-id="<?php echo htmlspecialchars($barangay_project['id'], ENT_QUOTES); ?>">
                                                        <?php echo htmlspecialchars($barangay_project['project_name'], ENT_QUOTES); ?>
                                                    </a>
                                                </li>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <li><a href="#">No projects</a></li>
                                        <?php endif; ?>
                                    </ul>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </li>

                    <li class="nav__item">
                        <a href="#channel" class="nav__link">Channels</a>
                    </li>
                    <li class="nav__item">
                        <a href="#discover" class="nav__link">Contact</a>
                    </li>
                </ul>

                <!-- Pop-Up for Project Details -->
                <div id="project-popup" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); padding: 20px; background: white; box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);">
                    <h2 class="popup-title"></h2>
                    <p class="popup-content"></p>
                    <button id="popup-close">Close</button>
                </div>

                <!-- Dark Mode Toggle -->
                <div class="nav__dark">
                    <span class="change-theme-name">Dark mode</span>
                    <i class="ri-moon-line change-theme" id="theme-button"></i>
                </div>

                <i class="ri-close-line nav__close" id="nav-close"></i>
            </div>

            <!-- Logout Button -->
            <li class="nav__item">
                <a href="http://localhost/SKIMS1/logout.php" class="nav__link">Logout</a>
            </li>

            </ul>
            </div>

            <div class="nav__toggle" id="nav-toggle">
                <i class="ri-function-line"></i>
            </div>
        </nav>
    </header>

    <main class="main">
        <!--==================== HOME ====================-->
        <section class="home" id="home">
            <img src="assets/img/background.jpg" alt="" class="home__img">

            <div class="home__container container grid">
                <div class="home__data">
                    <span class="home__data-subtitle">Look for Information</span>
                    <h1 class="home__data-title">Sanggunihang Kabataan <br> ng <b>Tangos North</b></h1>
                    <a href="#" class="button">Explore</a>

                </div>

                <div class="home__social">
                    <a href="https://www.facebook.com/SKTANGOSNRORTH" target="_blank" class="home__social-link">
                        <i class="ri-facebook-box-fill"></i>
                    </a>
                    <a href="https://www.instagram.com/" target="_blank" class="home__social-link">
                        <i class="ri-instagram-fill"></i>
                    </a>
                    <a href="https://twitter.com/" target="_blank" class="home__social-link">
                        <i class="ri-twitter-fill"></i>
                    </a>
                </div>

                <div class="home__info">
                    <div>
                        <span class="home__info-title">Browse for Projects</span>
                        <a href="#discover" class="button button--flex button--link home__info-button">
                            More <i class="ri-arrow-right-line"></i>
                        </a>
                    </div>

                    <div class="home__info-overlay">
                        <img src="assets/img/home2.jpg" alt="" class="home__info-img">
                    </div>
                </div>
            </div>
        </section>

        <!--==================== ABOUT ====================-->
        <section class="about section" id="about">
            <div class="about__container container">
                <!-- Text and button above the Facebook embeds -->
                <div class="about__header">
                    <h2 class="about__description">More Information</h2>
                    <p class="about__description">You can browse our Facebook Page here for Additional Information and Updates.</p>
                    <a target="_blank" href="https://www.facebook.com/SKTANGOSNRORTH" class="button">Follow us!</a>
                </div>

                <!-- Flex container for Facebook embeds -->
                <div class="fb-embed-container">
                    <!-- SK Tangos North Facebook Page Embed -->
                    <div class="fb-capsule">
                        <div class="fb-page" data-href="https://www.facebook.com/SKTANGOSNRORTH" data-tabs="timeline" data-width="500" data-height="" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true">
                            <blockquote cite="https://www.facebook.com/SKTANGOSNRORTH" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/SKTANGOSNRORTH">SK - Tangos North</a></blockquote>
                        </div>
                    </div>

                    <!-- New Facebook Profile Embed -->
                    <div class="fb-capsule">
                        <div class="fb-page" data-href="https://www.facebook.com/profile.php?id=100067844354194" data-tabs="timeline" data-width="500" data-height="" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true">
                            <blockquote cite="https://www.facebook.com/profile.php?id=100067844354194" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/profile.php?id=100067844354194">New Facebook Profile</a></blockquote>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <!--==================== EXPERIENCE ====================-->
        <section class="experience section">
            <h2 class="section__title">With Our ChatBot <br> We Will Serve You</h2>
            <img src="assets\img\chatbot.jpg" alt="ChatBot Image" id="chatbot-image">
        </section>

        <!--==================== HELP ====================-->
        <section class="video section" id="channel">
            <h2 class="section__title">Still Need Some Help?</h2>

            <div class="video__container container">
                <p class="video__description"><b>For any additional support or inquiries regarding SK (Sangguniang Kabataan) and Barangay services, feel free to reach out to us using the contact details provided below. We're here to assist with your community concerns and ensure your needs are addressed efficiently.</b></p>

                <!-- Buttons for Inquiry, Chat, Call, and Request a Document -->
                <button id="add-project-btn" class="help-btn">Add Project</button>
                <button id="manage-projects-btn" class="help-btn">Manage Projects</button>
                <button id="manage-users-btn" class="help-btn">Manage Users</button>
                <button id="view-requests-btn" class="help-btn">View Document Requests</button>
                <button id="inquiries-btn" class="help-btn">Inquiries</button>

                <!-- Inquiry Form (Initially hidden) -->

                <div id="inquiry-form" class="help-form" style="display: none;">
                    <button id="close-inquiry-form" class="close-btn">&times;</button>
                    <h3>Inquiry Form</h3>
                    <form action="message.php" method="POST">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" placeholder="Email" required>

                        <label for="subject">Subject:</label>
                        <input type="text" id="subject" name="subject" placeholder="Subject" required>

                        <label for="body">Message:</label>
                        <textarea id="body" name="body" placeholder="Message" required></textarea>

                        <button type="submit" class="help-btn">Submit Inquiry</button>
                    </form>
                </div>

                <div id="request-doc-form" class="help-form" style="display: none;">
                    <button id="close-request-doc-form" class="close-btn">&times;</button>
                    <h3>Request a Document</h3>
                    <form action="submit_document_request.php" method="POST">
                        <label for="document-type">Document Type:</label>
                        <select id="document-type" name="document_type" required>
                            <option value="">Select Document Type</option>
                            <option value="Certificate of Indigency">Certificate of Indigency</option>
                            <option value="Certificate of Residency">Certificate of Residency</option>
                            <option value="Barangay Certificate">Barangay Certificate</option>
                        </select>

                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" placeholder="Your Name" required>

                        <label for="address">Address:</label>
                        <input type="text" id="address" name="address" placeholder="Your Address" required>

                        <label for="age">Age:</label>
                        <input type="number" id="age" name="age" placeholder="Your Age" required>

                        <label for="purpose">Purpose:</label>
                        <input type="text" id="purpose" name="purpose" placeholder="Purpose of Request" required>

                        <label for="representative-name">Representative Name (optional):</label>
                        <input type="text" id="representative-name" name="representative_name" placeholder="Representative Name">

                        <button type="submit" class="help-btn">Submit Request</button>
                    </form>
                </div>
        </section>
        <!--==================== OFFICIALS ====================-->
        <section class="discover section" id="discover">
            <h2 class="section__title">Meet Our<br> SK Officials</h2>

            <div class="discover__container container swiper-container">
                <div class="swiper-wrapper">
                    <!--==================== DISCOVER 1 ====================-->
                    <div class="discover__card swiper-slide">
                        <img src="assets/img/mark.png" alt="" class="discover__img">
                        <div class="discover__data">
                            <h2 class="discover__title">Mark Alfred Castro</h2>
                            <span class="discover__description">Chairman</span>
                        </div>
                    </div>

                    <!--==================== DISCOVER 2 ====================-->
                    <div class="discover__card swiper-slide">
                        <img src="assets/img/Owenne.png" alt="" class="discover__img">
                        <div class="discover__data">
                            <h2 class="discover__title">Owenne Garcia</h2>
                            <span class="discover__description">Treasurer</span>
                        </div>
                    </div>

                    <!--==================== DISCOVER 3 ====================-->
                    <div class="discover__card swiper-slide">
                        <img src="assets/img/Zai.png" alt="" class="discover__img">
                        <div class="discover__data">
                            <h2 class="discover__title">Zairrus Coprado</h2>
                            <span class="discover__description">Treasurer</span>
                        </div>
                    </div>

                    <!--==================== DISCOVER 4 ====================-->
                    <div class="discover__card swiper-slide">
                        <img src="assets/img/kim.png" alt="" class="discover__img">
                        <div class="discover__data">
                            <h2 class="discover__title">Kimberly Tabilog</h2>
                            <span class="discover__description">Kagawad</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!--==================== SUBSCRIBE ====================-->
        <section class="subscribe section">
            <div class="subscribe__bg">
                <div class="subscribe__container container">
                    <h2 class="section__title subscribe__title">Stay<br>Updated</h2>
                    <p class="subscribe__description">Subscribe to our newsletter and get a
                        Barangay Updates.
                    </p>

                    <form action="" class="subscribe__form">
                        <input type="email" type="email" placeholder="Enter email" class="subscribe__input">

                        <button class="button">
                            Subscribe
                        </button>
                    </form>
                </div>
            </div>
        </section>

    </main>

    <!--==================== FOOTER ====================-->
    <footer class="footer section">
        <div class="footer__container container grid">
            <div class="footer__content grid">
                <div class="footer__data">
                    <h3 class="footer__title">SKIMS</h3>
                    <p class="footer__description">Mobile App <br> designed
                        by <br> BSIT Students.
                    </p>
                    <div>
                        <a href="https://www.facebook.com/" target="_blank" class="footer__social">
                            <i class="ri-facebook-box-fill"></i>
                        </a>
                        <a href="https://twitter.com/" target="_blank" class="footer__social">
                            <i class="ri-twitter-fill"></i>
                        </a>
                        <a href="https://www.instagram.com/" target="_blank" class="footer__social">
                            <i class="ri-instagram-fill"></i>
                        </a>
                        <a href="https://www.youtube.com/" target="_blank" class="footer__social">
                            <i class="ri-youtube-fill"></i>
                        </a>
                    </div>
                </div>

                <div class="footer__data">
                    <h3 class="footer__subtitle">About</h3>
                    <ul>
                        <li class="footer__item">
                            <a href="" class="footer__link">About Us</a>
                        </li>
                        <li class="footer__item">
                            <a href="" class="footer__link">Features</a>
                        </li>
                        <li class="footer__item">
                            <a href="" class="footer__link">News</a>
                        </li>
                    </ul>
                </div>

                <div class="footer__data">
                    <h3 class="footer__subtitle">Projects</h3>
                    <ul>
                        <li class="footer__item">
                            <a href="" class="footer__link">Teams</a>
                        </li>
                        <li class="footer__item">
                            <a href="" class="footer__link">Status</a>
                        </li>
                        <li class="footer__item">
                            <a href="" class="footer__link">Register</a>
                        </li>
                    </ul>
                </div>

                <div class="footer__data">
                    <h3 class="footer__subtitle">Support</h3>
                    <ul>
                        <li class="footer__item">
                            <a href="" class="footer__link">FAQs</a>
                        </li>
                        <li class="footer__item">
                            <a href="" class="footer__link">Support Center</a>
                        </li>
                        <li class="footer__item">
                            <a href="" class="footer__link">Contact Us</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="footer__rights">
                <p class="footer__copy">&#169; 2024 BSIT-NS-3A. All rigths reserved.</p>
                <div class="footer__terms">
                    <a href="#" class="footer__terms-link">Terms & Agreements</a>
                    <a href="#" class="footer__terms-link">Privacy Policy</a>
                </div>
            </div>
        </div>
    </footer>

    <!--========== SCROLL UP ==========-->
    <a href="#" class="scrollup" id="scroll-up">
        <i class="ri-arrow-up-line scrollup__icon"></i>
    </a>

    <!--=============== SCROLL REVEAL===============-->
    <script src="assets/js/scrollreveal.min.js"></script>

    <!--=============== SWIPER JS ===============-->
    <script src="assets/js/swiper-bundle.min.js"></script>

    <!--=============== MAIN JS ===============-->
    <script src="assets/js/main.js"></script>

    <div id="project-popup">
        <h2 class="popup-title"></h2>
        <p class="popup-content"></p>
        <button id="popup-close">Close</button>
    </div>

    <div id="document-requests-modal" class="modal" style="display: none;">
        <div class="modal-content">
            <span id="close-modal" class="close">&times;</span>
            <h2>Document Requests</h2>
            <table border="1" cellpadding="10" cellspacing="0">
                <thead>
                    <tr>
                        <th>Request ID</th>
                        <th>User ID</th>
                        <th>Document Type</th>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Age</th>
                        <th>Purpose</th>
                        <th>Representative Name</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="requests-table-body"></tbody>
            </table>
        </div>
    </div>


    <div id="add-project-modal" class="modal" style="display: none;">
        <div class="modal-content">
            <span id="close-add-project" class="close">&times;</span>
            <h2>Add Project</h2>
            <form id="add-project-form" action="add_project.php" method="POST" enctype="multipart/form-data">
                <label for="project_name">Project Name:</label>
                <input type="text" id="project_name" name="project_name" placeholder="Enter project name" required>

                <label for="description">Description:</label>
                <textarea id="description" name="description" placeholder="Enter project description" required></textarea>

                <label for="status">Status:</label>
                <select id="status" name="status" required>
                    <option value="Running">Running</option>
                    <option value="Completed">Completed</option>
                    <option value="Pending">Pending</option>
                </select>

                <label for="host">Host:</label>
                <select id="host" name="host" required>
                    <option value="SK">SK</option>
                    <option value="Barangay">Barangay</option>
                </select>

                <label for="start_date">Start Date:</label>
                <input type="date" id="start_date" name="start_date" required>

                <label for="end_date">End Date:</label>
                <input type="date" id="end_date" name="end_date" required>

                <label for="project_type">Project Type:</label>
                <select id="project_type" name="project_type" required>
                    <option value="Education">Education</option>
                    <option value="Infrastructure">Infrastructure</option>
                    <option value="Financial">Financial</option>
                    <option value="Other">Other</option>
                </select>

                <label for="image">Upload Image:</label>
                <input type="file" id="image" name="image" accept="image/*" required>

                <button type="submit" class="btn btn-primary">Add Project</button>
            </form>
        </div>
    </div>


    <div id="manage-projects-modal" class="modal" style="display: none;">
        <div class="modal-content">
            <span id="close-manage-projects" class="close">&times;</span>
            <h2>Manage Projects</h2>
            <table id="projects-table" border="1" cellpadding="10" cellspacing="0">
                <thead>
                    <tr>
                        <th>Project ID</th>
                        <th>Project Name</th>
                        <th>Status</th>
                        <th>Host</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Description</th>
                        <th>Project Type</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="projects-table-body">
                    <!-- Rows dynamically generated -->
                </tbody>
            </table>
        </div>
    </div>

    <div id="manage-users-modal" class="modal" style="display: none;">
        <div class="modal-content">
            <span id="close-manage-users" class="close">&times;</span>
            <h2>Manage Users</h2>
            <table id="users-table" border="1" cellpadding="10" cellspacing="0">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Email</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>User Type</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="users-table-body">
                    <!-- User rows dynamically generated -->
                </tbody>
            </table>
        </div>
    </div>

    <div id="inquiry-modal" class="modal" style="display: none;">
        <div class="modal-content">
            <span id="close-inquiry-modal" class="close">&times;</span>
            <h2>Messages</h2>
            <table id="messages-table" border="1" cellpadding="10" cellspacing="0">
                <thead>
                    <tr>
                        <th>Message ID</th>
                        <th>Subject</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="messages-table-body">
                    <!-- Rows will be dynamically populated -->
                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.getElementById('view-messages-btn').addEventListener('click', function() {
            const modal = document.getElementById('messages-modal');
            modal.style.display = 'block';

            // Fetch messages
            fetch('getMessages.php')
                .then(response => response.json())
                .then(data => {
                    const tableBody = document.querySelector('#messages-table tbody');
                    tableBody.innerHTML = ''; // Clear previous rows

                    if (data.length > 0) {
                        data.forEach(message => {
                            const row = `
                        <tr>
                            <td>${message.subject}</td>
                            <td><button class="view-details-btn" data-message-id="${message.message_id}">View Details</button></td>
                        </tr>
                    `;
                            tableBody.innerHTML += row;
                        });

                        // Add event listeners to view buttons
                        document.querySelectorAll('.view-details-btn').forEach(button => {
                            button.addEventListener('click', function() {
                                const messageId = this.dataset.messageId;
                                fetchMessageDetails(messageId);
                            });
                        });
                    } else {
                        tableBody.innerHTML = '<tr><td colspan="2">No messages found.</td></tr>';
                    }
                })
                .catch(error => {
                    console.error('Error fetching messages:', error);
                    alert('Failed to load messages.');
                });
        });

        // Fetch message details
        function fetchMessageDetails(messageId) {
            fetch('getMessageDetails.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        message_id: messageId
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(`Subject: ${data.subject}\nMessage: ${data.message_content}`);
                    } else {
                        alert(data.message || 'Failed to load message details.');
                    }
                })
                .catch(error => {
                    console.error('Error fetching message details:', error);
                    alert('Failed to fetch message details.');
                });
        }
    </script>

    <script>
        // Open the Inquiry Modal
        document.getElementById('inquiries-btn').addEventListener('click', function() {
            const modal = document.getElementById('inquiry-modal');
            modal.style.display = 'block';
            fetchMessagesTable(); // Fetch and populate the messages table
        });

        // Fetch and Populate Messages Table
        function fetchMessagesTable() {
            fetch('getMessages.php')
                .then(response => response.json())
                .then(data => {
                    const tableBody = document.getElementById('messages-table-body');
                    tableBody.innerHTML = ''; // Clear existing rows

                    if (Array.isArray(data) && data.length > 0) {
                        data.forEach(message => {
                            const row = `
                        <tr>
                            <td>${message.message_id}</td>
                            <td>${message.subject}</td>
                            <td>
                                <button class="view-message-btn" data-message-id="${message.message_id}">View</button>
                            </td>
                        </tr>
                    `;
                            tableBody.innerHTML += row;
                        });
                    } else {
                        tableBody.innerHTML = '<tr><td colspan="3">No messages found.</td></tr>';
                    }
                })
                .catch(error => {
                    console.error('Error fetching messages:', error);
                    alert('Failed to load messages.');
                });
        }

        // Handle View Message Button
        document.getElementById('messages-table-body').addEventListener('click', function(event) {
            if (event.target.classList.contains('view-message-btn')) {
                const messageId = event.target.dataset.messageId;

                fetch('getMessageDetails.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            message_id: messageId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert(`Message Content: ${data.message_content}`);
                        } else {
                            alert(data.message || 'Failed to load message.');
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching message details:', error);
                        alert('Failed to load message details.');
                    });
            }
        });

        // Close the Inquiry Modal
        document.getElementById('close-inquiry-modal').addEventListener('click', function() {
            document.getElementById('inquiry-modal').style.display = 'none';
        });

        // Close modal on outside click
        window.addEventListener('click', function(event) {
            const modal = document.getElementById('inquiry-modal');
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        });
    </script>

    <script>
        // Open the Manage Users modal
        document.getElementById('manage-users-btn').addEventListener('click', function() {
            const modal = document.getElementById('manage-users-modal');
            modal.style.display = 'block';
            fetchUsersTable(); // Fetch and populate the users table
        });

        // Fetch and Populate the Users Table
        function fetchUsersTable() {
            fetch('getUsers.php')
                .then(response => response.json())
                .then(data => {
                    const tableBody = document.getElementById('users-table-body');
                    tableBody.innerHTML = ''; // Clear existing rows

                    if (Array.isArray(data) && data.length > 0) {
                        data.forEach(user => {
                            const row = `
                        <tr>
                            <td>${user.tbl_user_id}</td>
                            <td>${user.email}</td>
                            <td>${user.first_name}</td>
                            <td>${user.last_name}</td>
                            <td>${user.phone}</td>
                            <td>${user.address}</td>
                            <td>
                                <select data-user-id="${user.tbl_user_id}" class="editable-field" data-field="user_type">
                                    <option value="user" ${user.user_type === 'user' ? 'selected' : ''}>User</option>
                                    <option value="admin" ${user.user_type === 'admin' ? 'selected' : ''}>Admin</option>
                                </select>
                            </td>
                            <td>
                                <button class="save-user-btn" data-user-id="${user.tbl_user_id}">Save</button>
                            </td>
                        </tr>
                    `;
                            tableBody.innerHTML += row;
                        });
                    } else {
                        tableBody.innerHTML = '<tr><td colspan="8">No users found.</td></tr>';
                    }
                })
                .catch(error => {
                    console.error('Error fetching users:', error);
                    alert('Failed to load users.');
                });
        }

        // Save Updated User Details
        document.getElementById('users-table-body').addEventListener('click', function(event) {
            if (event.target.classList.contains('save-user-btn')) {
                const userId = event.target.dataset.userId;
                const userTypeField = document.querySelector(`.editable-field[data-user-id="${userId}"]`);
                const userType = userTypeField.value;

                fetch('updateUser.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            tbl_user_id: userId,
                            user_type: userType
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('User updated successfully.');
                            fetchUsersTable(); // Refresh the users table
                        } else {
                            alert(data.message || 'Failed to update user.');
                        }
                    })
                    .catch(error => {
                        console.error('Error updating user:', error);
                        alert('Failed to update user.');
                    });
            }
        });

        // Close the Manage Users modal
        document.getElementById('close-manage-users').addEventListener('click', function() {
            document.getElementById('manage-users-modal').style.display = 'none';
        });

        // Close modal on outside click
        window.addEventListener('click', function(event) {
            const modal = document.getElementById('manage-users-modal');
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        });
    </script>

    <script>
        // Open the Manage Projects modal and fetch project details
        document.getElementById('manage-projects-btn').addEventListener('click', function() {
            const modal = document.getElementById('manage-projects-modal');
            modal.style.display = 'block';
            refreshProjectsTable();
        });

        // Refresh the projects table
        function refreshProjectsTable() {
            fetch('getProjectDetails.php')
                .then(response => response.json())
                .then(data => {
                    const tableBody = document.getElementById('projects-table-body');
                    tableBody.innerHTML = ''; // Clear previous rows

                    if (Array.isArray(data) && data.length > 0) {
                        data.forEach(project => {
                            const row = `
                            <tr>
                                <td>${project.id}</td>
                                <td><input type="text" value="${project.project_name}" data-project-id="${project.id}" class="editable-field" data-field="project_name"></td>
                                <td>
                                    <select data-project-id="${project.id}" class="editable-field" data-field="status">
                                        <option value="Running" ${project.status === 'Running' ? 'selected' : ''}>Running</option>
                                        <option value="Completed" ${project.status === 'Completed' ? 'selected' : ''}>Completed</option>
                                        <option value="Pending" ${project.status === 'Pending' ? 'selected' : ''}>Pending</option>
                                    </select>
                                </td>
                                <td>
                                    <select data-project-id="${project.id}" class="editable-field" data-field="host">
                                        <option value="SK" ${project.host === 'SK' ? 'selected' : ''}>SK</option>
                                        <option value="Barangay" ${project.host === 'Barangay' ? 'selected' : ''}>Barangay</option>
                                    </select>
                                </td>
                                <td><input type="date" value="${project.start_date}" data-project-id="${project.id}" class="editable-field" data-field="start_date"></td>
                                <td><input type="date" value="${project.end_date}" data-project-id="${project.id}" class="editable-field" data-field="end_date"></td>
                                <td><textarea data-project-id="${project.id}" class="editable-field" data-field="description">${project.description}</textarea></td>
                                <td>
                                    <select data-project-id="${project.id}" class="editable-field" data-field="project_type">
                                        <option value="Education" ${project.project_type === 'Education' ? 'selected' : ''}>Education</option>
                                        <option value="Financial" ${project.project_type === 'Financial' ? 'selected' : ''}>Financial</option>
                                        <option value="Livelihood" ${project.project_type === 'Livelihood' ? 'selected' : ''}>Livelihood</option>
                                        <option value="Infrastructure" ${project.project_type === 'Infrastructure' ? 'selected' : ''}>Infrastructure</option>
                                    </select>
                                </td>
                                <td>
                                    ${project.image ? `<img src="${project.image}" alt="Project Image" style="max-width: 100px; height: auto; border-radius: 4px;">` : 'No image available'}
                                </td>
                                <td>
                                    <button class="save-btn" data-project-id="${project.id}">Save</button>
                                    <button class="delete-btn" data-project-id="${project.id}">Delete</button>
                                </td>
                            </tr>
                        `;
                            tableBody.innerHTML += row;
                        });
                    } else {
                        tableBody.innerHTML = '<tr><td colspan="10">No projects found.</td></tr>';
                    }
                })
                .catch(error => {
                    console.error('Error fetching project details:', error);
                    alert('Failed to load project details.');
                });
        }

        // Save Project Details
        document.getElementById('projects-table-body').addEventListener('click', function(event) {
            if (event.target.classList.contains('save-btn')) {
                const projectId = event.target.dataset.projectId;
                const fields = document.querySelectorAll(`.editable-field[data-project-id="${projectId}"]`);
                const projectData = {};

                fields.forEach(field => {
                    const fieldName = field.dataset.field;
                    projectData[fieldName] = field.value;
                });

                fetch('updateProject.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            id: projectId,
                            ...projectData
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Project updated successfully.');
                            refreshProjectsTable(); // Refresh the table after save
                        } else {
                            alert(data.message || 'Failed to update project.');
                        }
                    })
                    .catch(error => {
                        console.error('Error updating project:', error);
                        alert('Failed to update project.');
                    });
            }
        });

        // Delete Project
        document.getElementById('projects-table-body').addEventListener('click', function(event) {
            if (event.target.classList.contains('delete-btn')) {
                const projectId = event.target.dataset.projectId;

                if (confirm('Are you sure you want to delete this project?')) {
                    fetch('deleteProject.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                id: projectId
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert('Project deleted successfully.');
                                refreshProjectsTable(); // Refresh the table after deletion
                            } else {
                                alert(data.message || 'Failed to delete project.');
                            }
                        })
                        .catch(error => {
                            console.error('Error deleting project:', error);
                            alert('Failed to delete project.');
                        });
                }
            }
        });

        // Close the Manage Projects modal
        document.getElementById('close-manage-projects').addEventListener('click', function() {
            document.getElementById('manage-projects-modal').style.display = 'none';
        });

        // Close modal on outside click
        window.addEventListener('click', function(event) {
            const modal = document.getElementById('manage-projects-modal');
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        });
    </script>




    <script>
        // Open the Add Project modal
        document.getElementById('add-project-btn').addEventListener('click', function() {
            document.getElementById('add-project-modal').style.display = 'block';
        });

        // Close the Add Project modal
        document.getElementById('close-add-project').addEventListener('click', function() {
            document.getElementById('add-project-modal').style.display = 'none';
        });

        // Close modal when clicking outside the modal content
        window.addEventListener('click', function(event) {
            const modal = document.getElementById('add-project-modal');
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        });
    </script>

    <script>
        document.getElementById('view-requests-btn').addEventListener('click', function() {
            const modal = document.getElementById('document-requests-modal');
            modal.style.display = 'block';

            // Fetch document requests from the admin-specific endpoint
            fetch('fetch_document_requests_admin.php')
                .then(response => response.json())
                .then(data => {
                    const tableBody = document.getElementById('requests-table-body');
                    tableBody.innerHTML = ''; // Clear previous rows

                    if (data.length > 0) {
                        data.forEach(request => {
                            const row = `
                        <tr>
                            <td>${request.request_id}</td>
                            <td>${request.user_id}</td>
                            <td>${request.document_type}</td>
                            <td>${request.name}</td>
                            <td>${request.address}</td>
                            <td>${request.age}</td>
                            <td>${request.purpose}</td>
                            <td>${request.representative_name || 'N/A'}</td>
                            <td>
                                <select class="status-dropdown" data-request-id="${request.request_id}">
                                    <option value="Pending" ${request.status === 'Pending' ? 'selected' : ''}>Pending</option>
                                    <option value="Denied" ${request.status === 'Denied' ? 'selected' : ''}>Denied</option>
                                    <option value="To Claim" ${request.status === 'To Claim' ? 'selected' : ''}>To Claim</option>
                                </select>
                            </td>
                            <td>
                                <button class="save-status-btn" data-request-id="${request.request_id}">Save</button>
                            </td>
                        </tr>
                    `;
                            tableBody.innerHTML += row;
                        });

                        // Add event listeners to save buttons
                        document.querySelectorAll('.save-status-btn').forEach(button => {
                            button.addEventListener('click', function() {
                                const requestId = this.dataset.requestId;
                                const dropdown = document.querySelector(`.status-dropdown[data-request-id="${requestId}"]`);
                                const newStatus = dropdown.value;

                                updateRequestStatus(requestId, newStatus);
                            });
                        });
                    } else {
                        tableBody.innerHTML = '<tr><td colspan="10">No document requests found.</td></tr>';
                    }
                })
                .catch(error => {
                    console.error('Error fetching document requests:', error);
                    alert('Failed to load document requests.');
                });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const links = document.querySelectorAll(".project-link");
            const popup = document.getElementById("project-popup");

            links.forEach(link => {
                link.addEventListener("click", function(e) {
                    e.preventDefault();
                    const projectId = this.getAttribute("data-project-id");
                    console.log("Clicked project ID:", projectId); // Debugging log

                    // Fetch project details
                    fetch(`getProjectDetails.php?id=${encodeURIComponent(projectId)}`)
                        .then(response => response.json())
                        .then(data => {
                            console.log("Fetched data:", data); // Debugging log

                            // Check if the response has an error
                            if (data.error) {
                                alert(data.error);
                            } else {
                                // Populate the pop-up with fetched data
                                popup.querySelector(".popup-title").innerText = data.project_name || "Unknown Project";
                                popup.querySelector(".popup-content").innerText =
                                    `Description: ${data.description || "No description available."}
                                Status: ${data.status || "N/A"}
                                Host: ${data.host || "N/A"}
                                Start Date: ${data.start_date || "N/A"}
                                End Date: ${data.end_date || "N/A"}`;
                                popup.style.display = "block";
                            }
                        })
                        .catch(error => {
                            console.error("Error fetching project details:", error);
                            alert("Failed to load project details. Please try again later.");
                        });
                });
            });

            // Close pop-up
            document.getElementById("popup-close").addEventListener("click", function() {
                popup.style.display = "none";
            });
        });
    </script>

    <script>
        document.getElementById('close-inquiry-form').addEventListener('click', function() {
            document.getElementById('inquiry-form').style.display = 'none';
        });

        document.getElementById('close-request-doc-form').addEventListener('click', function() {
            document.getElementById('request-doc-form').style.display = 'none';
        });
    </script>

</body>

</html>

<?php $conn->close(); // Close the database connection 
?>