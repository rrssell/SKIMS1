<?php
session_start();
session_unset();
session_destroy();
header('Location: http://localhost/SKIMS1/login/index.php#');
exit();
