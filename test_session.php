<?php
session_start();
if (isset($_SESSION['user_id'])) {
    echo 'User ID: ' . $_SESSION['user_id'] . '<br>';
    echo 'User Type: ' . $_SESSION['user_type'];
} else {
    echo 'No session data found.';
}
