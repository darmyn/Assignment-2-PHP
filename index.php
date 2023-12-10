<?php
session_start();

if (isset($_SESSION['user_id'])) {
    // User is logged in, redirect to the dashboard or wherever you want
    header("Location: php/pages/dashboard.php");
    exit();
} else {
    // User is not logged in, redirect to login page
    header("Location: php/pages/login.php");
    exit();
}
?>
