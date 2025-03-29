<?php
include('../conn/conn.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();

    // Determine login method
    if (!empty($_POST['qr-code'])) {
        // QR Code Login
        $qrCode = $_POST['qr-code'];

        $stmt = $conn->prepare("SELECT `generated_code`, `first_name`, `last_name`, `tbl_user_id`, `user_type` FROM `tbl_user` WHERE `generated_code` = :generated_code");
        $stmt->bindParam(':generated_code', $qrCode);
        $stmt->execute();

        $accountExist = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($accountExist) {
            $_SESSION['user_id'] = $accountExist['tbl_user_id'];
            $_SESSION['user_type'] = $accountExist['user_type']; // Store user type in session

            // Debugging: Ensure sessions are set correctly
            error_log('Session User ID: ' . $_SESSION['user_id']);
            error_log('Session User Type: ' . $_SESSION['user_type']);

            // Redirect based on user type
            if ($accountExist['user_type'] === 'admin') {
                echo "
                <script>
                    alert('Welcome Admin!');
                    window.location.href = 'http://localhost/SKIMS1/index1.php';
                </script>
                ";
            } else {
                echo "
                <script>
                    alert('Login Successfully!');
                    window.location.href = 'http://localhost/SKIMS1/index.php';
                </script>
                ";
            }
        } else {
            echo "
            <script>
                alert('QR Code account doesn't exist!');
                window.location.href = 'http://localhost/qr-code-login-system/';
            </script>
            ";
        }
    } elseif (!empty($_POST['email']) && !empty($_POST['password'])) {
        // Email and Password Login
        $email = $_POST['email'];
        $password = $_POST['password'];

        $stmt = $conn->prepare("SELECT `tbl_user_id`, `password`, `first_name`, `last_name`, `user_type` FROM `tbl_user` WHERE `email` = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['tbl_user_id'];
            $_SESSION['user_type'] = $user['user_type']; // Store user type in session

            // Redirect based on user type
            if ($user['user_type'] === 'admin') {
                echo "
                <script>
                    alert('Welcome Admin!');
                    window.location.href = 'http://localhost/SKIMS1/index1.php';
                </script>
                ";
            } else {
                echo "
                <script>
                    alert('Login Successfully!');
                    window.location.href = 'http://localhost/SKIMS1/index.php';
                </script>
                ";
            }
        } else {
            echo "
            <script>
                alert('Invalid email or password!');
                window.location.href = 'http://localhost/qr-code-login-system/';
            </script>
            ";
        }
    } else {
        echo "
        <script>
            alert('Please provide QR code or email and password to login.');
            window.location.href = 'http://localhost/qr-code-login-system/';
        </script>
        ";
    }
}
