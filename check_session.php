<?php
session_start();
if (isset($_SESSION['test'])) {
    echo "Session Value: " . $_SESSION['test'];
} else {
    echo "Session not set.";
}
