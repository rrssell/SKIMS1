<?php
session_start();
$_SESSION['test'] = 'Test Session Value';
echo "Session set successfully.";
