<?php
    session_start();

    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/dashboard.css">
    <title>Dashboard</title>
</head>
<body>
    <!-- Main dashboard container -->
    <div class="dashboard">
        <!-- Sidebar section -->
        <div class="sidebar">
            <h2>Dashboard</h2>
            <a href="#" class="active">Home</a>
            <a href="#">Analytics</a>
            <a href="#">Reports</a>
            <a href="#">Settings</a>
            <a href="../scripts/logout.php">Logout</a>
        </div>
        <!-- Main content section -->
        <div class="main-content">
            <header>
                <h1>Welcome to the Dashboard</h1>
            </header>
            <!-- Card section -->
            <div class="card">
                <h2>Card Title</h2>
                <p>This is a sample card with some content.</p>
            </div>
            <div class="card">
                <h2>Another Card</h2>
                <p>This is another card with different content.</p>
            </div>
        </div>
    </div>
</body>
</html>