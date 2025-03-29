<?php
include('../conn/conn.php');

if (isset($_POST['first_name'], $_POST['last_name'], $_POST['email'], $_POST['phone'], $_POST['address'], $_POST['password'], $_POST['confirm_password'], $_POST['generated_code'])) {
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];
    $generatedCode = $_POST['generated_code'];

    // Check if passwords match
    if ($password !== $confirmPassword) {
        echo "
        <script>
            alert('Passwords do not match!');
            window.location.href = 'http://localhost/qr-code-login-system/';
        </script>
        ";
        exit();
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    try {
        // Check if the email already exists
        $stmt = $conn->prepare("SELECT `email` FROM `tbl_user` WHERE `email` = :email");
        $stmt->execute(['email' => $email]);

        $emailExist = $stmt->fetch(PDO::FETCH_ASSOC);

        if (empty($emailExist)) {
            $conn->beginTransaction();

            // Insert the new user into the database
            $insertStmt = $conn->prepare("INSERT INTO `tbl_user` (`first_name`, `last_name`, `email`, `phone`, `address`, `password`, `generated_code`) 
                                          VALUES (:first_name, :last_name, :email, :phone, :address, :password, :generated_code)");
            $insertStmt->bindParam('first_name', $firstName, PDO::PARAM_STR);
            $insertStmt->bindParam('last_name', $lastName, PDO::PARAM_STR);
            $insertStmt->bindParam('email', $email, PDO::PARAM_STR);
            $insertStmt->bindParam('phone', $phone, PDO::PARAM_STR);
            $insertStmt->bindParam('address', $address, PDO::PARAM_STR);
            $insertStmt->bindParam('password', $hashedPassword, PDO::PARAM_STR);
            $insertStmt->bindParam('generated_code', $generatedCode, PDO::PARAM_STR);

            $insertStmt->execute();

            $conn->commit();

            echo "
            <script>
                alert('Registered Successfully!');
                window.location.href = 'http://localhost/qr-code-login-system/';
            </script>
            ";
        } else {
            echo "
            <script>
                alert('Account with this email already exists!');
                window.location.href = 'http://localhost/qr-code-login-system/';
            </script>
            ";
        }
    } catch (PDOException $e) {
        $conn->rollBack();
        echo "Error: " . $e->getMessage();
    }
}
