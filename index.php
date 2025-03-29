<?php
include 'db_connection.php'; // Include database connection
session_start();

// Fetch SK and Barangay projects from the database for different categories
$categories = ['Education', 'Financial', 'Livelihood', 'Infrastructure'];

// Create arrays to store projects for each category
$projects = [];

// Fetch SK and Barangay projects for each category
foreach ($categories as $category) {
    // Example SQL queries for SK and Barangay projects
    $sk_sql = "SELECT id, project_name, status FROM project_list WHERE host = 'SK' AND project_name LIKE '%$category%'";
    $barangay_sql = "SELECT id, project_name, status FROM project_list WHERE host = 'Barangay' AND project_name LIKE '%$category%'";

    // Execute SK SQL query
    $sk_result = $conn->query($sk_sql);
    if ($sk_result->num_rows > 0) {
        while ($row = $sk_result->fetch_assoc()) {
            $projects[$category]['SK'][] = [
                'id' => $row['id'],
                'project_name' => $row['project_name'],
                'status' => $row['status'] // Include the status for styling
            ];
        }
    }

    // Execute Barangay SQL query
    $barangay_result = $conn->query($barangay_sql);
    if ($barangay_result->num_rows > 0) {
        while ($row = $barangay_result->fetch_assoc()) {
            $projects[$category]['Barangay'][] = [
                'id' => $row['id'],
                'project_name' => $row['project_name'],
                'status' => $row['status'] // Include the status for styling
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
    <script async type='module' src='https://interfaces.zapier.com/assets/web-components/zapier-interfaces/zapier-interfaces.esm.js'></script>
    <zapier-interfaces-chatbot-embed is-popup='true' chatbot-id='cm5mhlamv004enoiwlv053exj'></zapier-interfaces-chatbot-embed>
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
                            <?php foreach ($categories as $category): ?>
                                <li class="dropdown__item">
                                    <a href="#"><?php echo $category; ?></a>
                                    <ul class="dropdown__submenu">
                                        <!-- SK Projects -->
                                        <li class="dropdown__header">SK Projects</li>
                                        <?php if (!empty($projects[$category]['SK'])): ?>
                                            <?php foreach ($projects[$category]['SK'] as $sk_project): ?>
                                                <li>
                                                    <a href="#"
                                                        class="project-link"
                                                        data-project-id="<?php echo htmlspecialchars($sk_project['id'], ENT_QUOTES); ?>"
                                                        style="<?php echo ($sk_project['status'] === 'Finished') ? 'background-color: green; color: white;' : ''; ?>">
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
                                                    <a href="#"
                                                        class="project-link"
                                                        data-project-id="<?php echo htmlspecialchars($barangay_project['id'], ENT_QUOTES); ?>"
                                                        style="<?php echo ($barangay_project['status'] === 'Finished') ? 'background-color: green; color: white;' : ''; ?>">
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


                <i class="ri-close-line nav__close" id="nav-close"></i>
            </div>

            <!-- Profile Dropdown -->
            <li class="nav__item dropdown">
                <a href="#" class="nav__link nav__profile">Profile</a>
                <ul class="dropdown__menu">
                    <li>
                        <span id="user-fullname">John Doe</span> <!-- Full name dynamically loaded -->
                    </li>

                    <li>
                        <button id="request-btn" class="nav__link request-btn">Requests</button>
                    </li>

                    <li>
                        <button id="info-btn" class="nav__link info-btn">Information</button>
                    </li>
                </ul>
            </li>

            <li class="nav__item">
                <a href="http://localhost/SKIMS1/logout.php" class="nav__link">Logout</a>
            </li>

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
                    <p class="about__description">For more detailed updates, announcements, and additional information about our initiatives and activities,
                        we encourage you to visit and explore our official Facebook page.
                        You can find the latest news, event highlights, and important reminders conveniently posted there.
                        Simply click the link provided to access our Facebook page and stay connected with everything happening in our community.</p>
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


        <!--==================== ABOUT ====================-->
        <section class="about section" id="about">
            <div class="about__container container grid">
                <div class="about__data">
                    <h2 class="section__title about__title">Information <br> About Our Website</h2>
                    <p class="about__description"> This website is designed to serve as a helpful resource for the constituents of Tangos North,
                        providing them with easy access to a wide range of important information and updates about ongoing and upcoming projects in the area.
                        For your convenience. <br><br>We’ve included a <b>CHATBOT</b> feature located in the bottom left corner of the website.
                        Feel free to use this interactive tool to ask questions, get quick answers, or explore various features of the site.
                        <br><br> Project Indicator in the Navigation Bar is as follows2 :
                    </p>
                    <a href="#about" class="button">GREEN MEANS COMPLETED</a>
                </div>

                <div class="about__img">
                    <div class="about__img-overlay">
                        <img src="assets/img/about1.jpg" alt="" class="about__img-one">
                    </div>

                    <div class="about__img-overlay">
                        <img src="assets/img/about2.jpg" alt="" class="about__img-two">
                    </div>
                </div>
            </div>
        </section>

        <!--==================== HELP ====================-->
        <section class="video section" id="channel">
            <h2 class="section__title">Still Need Some Help?</h2>

            <div class="video__container container">
                <p class="video__description">For any additional support or inquiries regarding SK (Sangguniang Kabataan) and Barangay services, feel free to reach out to us using the contact details provided below. We're here to assist with your community concerns and ensure your needs are addressed efficiently.</p>

                <!-- Buttons for Inquiry, Chat, Call, and Request a Document -->
                <button id="inquiry-btn" class="help-btn">Inquiry</button>
                <button id="chat-btn" class="help-btn">Live Chat</button>
                <button id="call-btn" class="help-btn">Click to Call</button>
                <button id="request-doc-btn" class="help-btn">Request a Document</button>

                <!-- Inquiry Form (Initially hidden) -->

                <div id="inquiry-form" class="help-form" style="display: none;">
                    <button id="close-inquiry-form" class="close-btn">&times;</button>
                    <h3>Inquiry Form</h3>
                    <form action="message.php" method="POST">

                        <label for="subject">Subject:</label>
                        <input type="text" id="subject" name="subject" placeholder="Subject" required>

                        <label for="body">Message:</label>
                        <textarea id="body" name="body" placeholder="Message" required></textarea>

                        <button type="submit" class="help-btn">Submit Inquiry</button>
                    </form>
                </div>

                <!-- Request a Document Form -->
                <div id="request-doc-form" class="help-form" style="display:none;">
                    <!-- Close button -->
                    <span id="close-request-modal" class="close">&times;</span>
                    <h3>Request a Document</h3>
                    <form action="submit_document_request.php" method="POST">
                        <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($_SESSION['user_id'], ENT_QUOTES); ?>">

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

                        <button type="submit">Submit Request</button>
                    </form>
                </div>
        </section>

        <!--==================== OFFICIALS ====================-->
        <section class="discover section" id="discover">
            <!--==================== OFFICIALS ====================-->
            <section class="discover section" id="discover">
                <h2 class="section__title">Meet Our<br> SK Officials</h2>

                <div class="discover__container container swiper-container">
                    <div class="swiper-wrapper">
                        <!--==================== OFFICIAL 1 ====================-->
                        <div class="discover__card swiper-slide">
                            <img src="assets/img/mark.png" alt="" class="discover__img official-img" data-img="assets/img/official1.png">
                            <div class="discover__data">
                                <h2 class="discover__title">Mark Alfred Castro</h2>
                                <span class="discover__description">Chairman</span>
                            </div>
                        </div>

                        <!--==================== OFFICIAL 2 ====================-->
                        <div class="discover__card swiper-slide">
                            <img src="assets/img/Owenne.png" alt="" class="discover__img official-img" data-img="assets/img/Owenne.png">
                            <div class="discover__data">
                                <h2 class="discover__title">Owenne Garcia</h2>
                                <span class="discover__description">Treasurer</span>
                            </div>
                        </div>

                        <!--==================== OFFICIAL 3 ====================-->
                        <div class="discover__card swiper-slide">
                            <img src="assets/img/Zai.png" alt="" class="discover__img official-img" data-img="assets/img/Zai.png">
                            <div class="discover__data">
                                <h2 class="discover__title">Zairrus Coprado</h2>
                                <span class="discover__description">Treasurer</span>
                            </div>
                        </div>

                        <!--==================== OFFICIAL 4 ====================-->
                        <div class="discover__card swiper-slide">
                            <img src="assets/img/kim.png" alt="" class="discover__img official-img" data-img="assets/img/kim.png">
                            <div class="discover__data">
                                <h2 class="discover__title">Kimberly Tabilog</h2>
                                <span class="discover__description">Kagawad</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Popup Modal -->
            <div id="image-popup" class="modal" style="display: none;">
                <span id="close-popup" class="close">&times;</span>
                <img id="popup-image" src="" alt="Official Image" class="popup-image">
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

    <div id="info-modal" class="modal" style="display: none;">
        <div class="modal-content">
            <span id="close-info-modal" class="close">×</span>
            <h2>User Information</h2>

            <!-- Profile Picture Upload Section -->
            <form id="profile-upload-form" action="uploadProfilePicture.php" method="POST" enctype="multipart/form-data">
                <div class="profile-header">
                    <label for="profile-picture" id="profile-img-label">
                        <input type="file" name="profile-picture" id="profile-picture" accept="image/*" onchange="previewImage(event)">
                        <div id="profile-image-container">
                            <img id="profile-image" src="uploads/default.jpg" alt="Profile Image" style="max-width: 150px; border-radius: 50%;">
                        </div>
                    </label>
                </div>
                <button type="submit">Save Profile Picture</button>
            </form>

            <!-- User Information Table -->
            <table class="info-table">
                <tr>
                    <th>Full Name:</th>
                    <td id="info-fullname">Loading...</td>
                </tr>
                <tr>
                    <th>Email:</th>
                    <td id="info-email">Loading...</td>
                </tr>
                <tr>
                    <th>Phone:</th>
                    <td id="info-phone">Loading...</td>
                </tr>
                <tr>
                    <th>Address:</th>
                    <td id="info-address">Loading...</td>
                </tr>
                <tr>
                    <th>User Type:</th>
                    <td id="info-usertype">Loading...</td>
                </tr>
            </table>
        </div>
    </div>



    <div id="request-modal" class="modal" style="display: none;">
        <div class="modal-content">
            <span id="close-vrequest-modal" class="close">&times;</span>
            <h2>Your Document Requests</h2>
            <div class="table-container">
                <table id="request-table">
                    <thead>
                        <tr>
                            <th>Request ID</th>
                            <th>Document Type</th>
                            <th>Name</th>
                            <th>Address</th>
                            <th>Age</th>
                            <th>Purpose</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Rows will be dynamically populated -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function previewImage(event) {
            const file = event.target.files[0];
            const reader = new FileReader();

            reader.onload = function() {
                const image = document.getElementById('profile-image');
                image.src = reader.result; // Display the selected image
            };

            if (file) {
                reader.readAsDataURL(file); // Convert the file to a Data URL and display it
            }
        }
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const images = document.querySelectorAll(".official-img");
            const popup = document.getElementById("image-popup");
            const popupImage = document.getElementById("popup-image");
            const closePopup = document.getElementById("close-popup");

            // Add click event listener to each image
            images.forEach((img) => {
                img.addEventListener("click", function() {
                    const imageUrl = this.getAttribute("data-img"); // Get the image URL from data attribute
                    popupImage.src = imageUrl; // Set the popup image source
                    popup.style.display = "block"; // Show the popup
                });
            });

            // Close the popup when the close button is clicked
            closePopup.addEventListener("click", function() {
                popup.style.display = "none";
            });

            // Close the popup when clicking outside the image
            window.addEventListener("click", function(e) {
                if (e.target === popup) {
                    popup.style.display = "none";
                }
            });
        });
    </script>

    <script>
        // Open the modal
        document.getElementById('request-btn').addEventListener('click', function() {
            document.getElementById('request-doc-form').style.display = 'block';
        });

        // Close the modal
        document.getElementById('close-request-modal').addEventListener('click', function() {
            document.getElementById('request-doc-form').style.display = 'none';
        });

        // Close modal when clicking outside the modal
        window.addEventListener('click', function(event) {
            const modal = document.getElementById('request-doc-form');
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        });
    </script>

    <script>
        document.querySelectorAll('.cancel-btn').forEach(button => {
            button.addEventListener('click', function() {
                const requestId = this.dataset.id;
                if (confirm('Are you sure you want to cancel this request?')) {
                    cancelRequest(requestId);
                }
            });
        });
    </script>

    <script>
        function cancelRequest(requestId) {
            console.log("Canceling request with ID:", requestId); // Log the request_id

            fetch('cancel_document_request.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        request_id: requestId
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    console.log("Response from cancel request:", data); // Log the backend response
                    if (data.success) {
                        alert(data.message);
                        document.getElementById('request-btn').click(); // Refresh the modal
                    } else {
                        alert(data.message || 'Failed to cancel the request.');
                    }
                })
                .catch(error => {
                    console.error('Error canceling request:', error);
                    alert('Failed to cancel the request.');
                });
        }
    </script>

    <script>
        // Open the Request modal
        document.getElementById('request-btn').addEventListener('click', function() {
            const modal = document.getElementById('request-modal');
            modal.style.display = 'block';

            // Fetch document requests
            fetch('fetch_document_requests.php')
                .then(response => response.json())
                .then(data => {
                    const tableBody = document.querySelector('#request-table tbody');
                    tableBody.innerHTML = ''; // Clear previous rows

                    if (data.success && Array.isArray(data.data) && data.data.length > 0) {
                        data.data.forEach(request => {
                            const row = `
                            <tr>
                                <td>${request.request_id}</td> <!-- Ensure this matches your DB column name -->
                                <td>${request.document_type}</td>
                                <td>${request.name}</td>
                                <td>${request.address}</td>
                                <td>${request.age}</td>
                                <td>${request.purpose}</td>
                                <td>${request.status}</td>
                                <td>${request.created_at}</td>
                                <td><button class="cancel-btn" data-request-id="${request.request_id}">Cancel</button></td>
                            </tr>
                        `;
                            tableBody.innerHTML += row;
                        });

                        // Add event listeners to Cancel buttons
                        document.querySelectorAll('.cancel-btn').forEach(button => {
                            button.addEventListener('click', function() {
                                const requestId = this.getAttribute('data-request-id'); // Use getAttribute here
                                console.log('Cancel Request ID:', requestId); // Debugging

                                if (requestId && confirm('Are you sure you want to cancel this request?')) {
                                    cancelRequest(requestId);
                                }
                            });
                        });
                    } else {
                        tableBody.innerHTML = '<tr><td colspan="9">No document requests found.</td></tr>';
                    }
                })
                .catch(error => {
                    console.error('Error fetching document requests:', error);
                    alert('Failed to load document requests.');
                });
        });

        // Cancel a request
        function cancelRequest(requestId) {
            fetch('cancel_document_request.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        request_id: requestId
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        document.getElementById('request-btn').click(); // Refresh the modal
                    } else {
                        alert(data.message || 'Failed to cancel the request.');
                    }
                })
                .catch(error => {
                    console.error('Error canceling request:', error);
                    alert('Failed to cancel the request.');
                });
        }

        // Close the Request modal
        document.getElementById('close-vrequest-modal').addEventListener('click', function() {
            document.getElementById('request-modal').style.display = 'none';
        });

        // Close modal on outside click
        window.addEventListener('click', function(event) {
            const modal = document.getElementById('request-modal');
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        });
    </script>




    <script>
        // Fetch user profile information
        function loadUserProfile() {
            fetch('getUserProfile.php')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const user = data.data;
                        document.getElementById('user-fullname').textContent = `${user.first_name.toUpperCase()} ${user.last_name.toUpperCase()}`;
                        document.getElementById('info-fullname').textContent = `${user.first_name.toUpperCase()} ${user.last_name.toUpperCase()}`;
                        document.getElementById('info-email').textContent = user.email.toUpperCase();
                        document.getElementById('info-phone').textContent = user.phone.toUpperCase();
                        document.getElementById('info-address').textContent = user.address.toUpperCase();
                        document.getElementById('info-usertype').textContent = user.user_type.toUpperCase();
                        // Set image src with absolute path from server
                        document.getElementById('profile-image').src = user.profile_image;
                    } else {
                        alert(data.message || 'Failed to load user information.');
                    }
                })
                .catch(error => {
                    console.error('Error fetching user information:', error);
                });
        }

        document.addEventListener('DOMContentLoaded', loadUserProfile);
        // Open the Information Modal
        document.getElementById('info-btn').addEventListener('click', function() {
            const modal = document.getElementById('info-modal');
            modal.style.display = 'block';
        });

        // Close the Information Modal
        document.getElementById('close-info-modal').addEventListener('click', function() {
            document.getElementById('info-modal').style.display = 'none';
        });

        // Close the modal when clicking outside of it
        window.addEventListener('click', function(event) {
            const modal = document.getElementById('info-modal');
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        });

        // Load the profile on page load
        document.addEventListener('DOMContentLoaded', loadUserProfile);
    </script>


    <script>
        document.getElementById('profile-upload-form').addEventListener('submit', function(e) {
            e.preventDefault(); // Prevent default form submission
            const formData = new FormData(this);

            fetch('uploadProfilePicture.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Reload user profile to update the image
                        loadUserProfile();
                        alert('Profile picture updated successfully!');
                    } else {
                        alert(data.message || 'Failed to upload profile picture.');
                    }
                })
                .catch(error => {
                    console.error('Error uploading profile picture:', error);
                    alert('An error occurred while uploading.');
                });
        });

        // Existing preview function (assuming it exists)
        function previewImage(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('profile-image').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        }
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
                                popup.querySelector(".popup-content").innerHTML = `
                                <b>Description:</b> ${data.description || "No description available."}
                                <br><b>Status:</b> ${data.status || "N/A"}
                                <br><b>Host:</b> ${data.host || "N/A"}
                                <br><b>Start Date:</b> ${data.start_date || "N/A"}
                                <br><b>End Date:</b> ${data.end_date || "N/A"}
                                <br>
                                ${data.image ? `<img src="${data.image}" alt="Project Image" style="max-width: 100%; height: auto; border-radius: 8px;">` : "<i>No image available.</i>"}
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