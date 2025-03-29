<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login System with QR Code Scanner</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap');

        * {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            background-image: url("background.jpg");
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            height: 100vh;
        }

        .login-container,
        .registration-container {
            backdrop-filter: blur(120px);
            color: rgb(255, 255, 255);
            padding: 25px 40px;
            width: 500px;
            border: 2px solid;
            border-radius: 10px;
        }

        .switch-form-link {
            text-decoration: underline;
            cursor: pointer;
            color: rgb(100, 100, 250);
        }


        form {
            width: 100%;
            max-width: 400px;
            background: #ffffff;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            /* Optional shadow for better visibility */
            border-radius: 8px;
            /* Rounded corners */
        }

        form h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        form label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
        }

        form input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
        }

        form button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            border: none;
            color: white;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
        }

        form button:hover {
            background-color: #0056b3;
        }

        /* Optional: Style the divider between QR and Email login */
        hr {
            border: 0;
            height: 1px;
            background: #ddd;
            margin: 20px 0;
        }
    </style>
</head>

<body>

    <div class="main">

        <!-- Login Area -->
        <div class="login-container">
            <div class="login-form" id="loginForm">
                <h2 class="text-center">Welcome Back!</h2>
                <p class="text-center">Login through QR code scanner.</p>
                <video id="interactive" class="viewport" width="415">
            </div>
            <div class="qr-detected-container" style="display: none;">
                <form action="./endpoint/login.php" method="POST">
                    <h4 class="text-center">QR Code Detected!</h4>
                    <input type="hidden" id="detected-qr-code" name="qr-code">
                    <button type="submit" class="btn btn-dark form-control">Login</button>
                </form>
            </div>


            <form action="login.php" method="POST">


                <hr>

                <!-- Email and Password Login -->
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="Enter your email">

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="Enter your password">

                <button type="submit">Login</button>
            </form>

            <p class="mt-3">No Account? Register <span class="switch-form-link" onclick="showRegistrationForm()">Here.</span></p>
        </div>


    </div>

    <!-- Registration Area -->
    <div class="registration-container">
        <div class="registration-form" id="registrationForm">
            <h2 class="text-center">Registration Form</h2>
            <p class="text-center">Fill in your personal details.</p>
            <form action="./endpoint/add-user.php" method="POST">
                <div class="hide-registration-inputs">
                    <div class="form-group registration">
                        <label for="firstName">First Name:</label>
                        <input type="text" class="form-control" id="firstName" name="first_name" required>
                    </div>
                    <div class="form-group registration">
                        <label for="lastName">Last Name:</label>
                        <input type="text" class="form-control" id="lastName" name="last_name" required>
                    </div>
                    <div class="form-group registration">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group registration">
                        <label for="phone">Phone:</label>
                        <input type="tel" class="form-control" id="phone" name="phone" required>
                    </div>
                    <div class="form-group registration">
                        <label for="address">Address:</label>
                        <input type="text" class="form-control" id="address" name="address" required>
                    </div>
                    <div class="form-group registration">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="form-group registration">
                        <label for="confirmPassword">Confirm Password:</label>
                        <input type="password" class="form-control" id="confirmPassword" name="confirm_password" required>
                    </div>
                    <p>Already have a QR code account? Login <span class="switch-form-link" onclick="location.reload()">Here.</span></p>
                    <button type="button" class="btn btn-dark login-register form-control" onclick="generateQrCode()">Register and Generate QR Code</button>
                </div>

                <div class="qr-code-container text-center" style="display: none;">
                    <h3>Take a Picture of your QR Code and Login!</h3>
                    <input type="hidden" id="generatedCode" name="generated_code">
                    <div class="m-4" id="qrBox">
                        <img src="" id="qrImg">
                    </div>
                    <button type="submit" class="btn btn-dark">Back to Login Form.</button>
                </div>
            </form>
        </div>
    </div>

    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
    <!-- Instascan JS -->
    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>

    <script>
        const loginCon = document.querySelector('.login-container');
        const registrationCon = document.querySelector('.registration-container');
        const registrationForm = document.querySelector('.registration-form');
        const qrCodeContainer = document.querySelector('.qr-code-container');
        let scanner;

        registrationCon.style.display = "none";
        qrCodeContainer.style.display = "none";

        function showRegistrationForm() {
            registrationCon.style.display = "";
            loginCon.style.display = "none";
            scanner.stop();
        }

        function startScanner() {
            scanner = new Instascan.Scanner({
                video: document.getElementById('interactive')
            });

            scanner.addListener('scan', function(content) {
                $("#detected-qr-code").val(content);
                scanner.stop();
                document.querySelector(".qr-detected-container").style.display = '';
                document.querySelector(".viewport").style.display = 'none';
            });

            Instascan.Camera.getCameras()
                .then(function(cameras) {
                    if (cameras.length > 0) {
                        scanner.start(cameras[0]);
                    } else {
                        console.error('No cameras found.');
                        alert('No cameras found.');
                    }
                })
                .catch(function(err) {
                    console.error('Camera access error:', err);
                    alert('Camera access error: ' + err);
                });
        }

        function generateRandomCode(length) {
            const characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
            let randomString = '';

            for (let i = 0; i < length; i++) {
                const randomIndex = Math.floor(Math.random() * characters.length);
                randomString += characters.charAt(randomIndex);
            }

            return randomString;
        }

        function generateQrCode() {
            const registrationInputs = document.querySelector('.hide-registration-inputs');
            const h2 = document.querySelector('.registration-form > h2');
            const p = document.querySelector('.registration-form > p');
            const inputs = document.querySelectorAll('.registration input');
            const qrImg = document.getElementById('qrImg');
            const qrBox = document.getElementById('qrBox');

            registrationInputs.style.display = 'none';

            let text = generateRandomCode(10);
            $("#generatedCode").val(text);

            if (text === "") {
                alert("Please enter text to generate a QR code.");
                return;
            } else {
                const apiUrl = `https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=${encodeURIComponent(text)}`;

                // Generating image
                qrImg.src = apiUrl;
                qrBox.setAttribute("id", "qrBoxGenerated");
                qrCodeContainer.style.display = "";
                registrationCon.style.display = "";
                h2.style.display = "none";
                p.style.display = "none";
            }
        }

        // Ensure the scanner starts after the page loads
        document.addEventListener('DOMContentLoaded', startScanner);
    </script>
</body>

</html>