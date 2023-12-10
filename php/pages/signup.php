<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('../scripts/db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = $_POST['password'];

    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $checkStmt = $db->prepare("SELECT id FROM users WHERE username = ?");
    $checkStmt->bind_param("s", $username);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        $error = "That username is already taken. Please choose a different one.";
    } else {
        $checkStmt->close();

        $insertStmt = $db->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $insertStmt->bind_param("ss", $username, $password_hash);

        if ($insertStmt->execute()) {
            $_SESSION['user_id'] = $db->insert_id;
            $insertStmt->close();
            $db->close();
            header("Location: welcome.php");
            exit();
        } else {
            error_log("Error in insert statement execution: " . $insertStmt->error);
            $error = "An error occurred during registration. Please try again.";
        }
    }

    $checkStmt->close();
    $db->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/style.css">

    <title>Sign Up</title>
</head>
<body>
    <div class="container">
        <!-- Display error message if set -->
        <?php if (isset($error)): ?>
            <div class="error-message"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <!-- Sign Up form -->
        <form class="form" action="signup.php" method="post">
            <h2>Sign Up</h2>
            
            <!-- Username input -->
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>
            
            <!-- Password input -->
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
            
            <!-- Sign Up button -->
            <button type="submit">Sign Up</button>
            
            <!-- Switch to login form link -->
            <p class="switch-form">Already have an account? <a href="login.php">Login</a>.</p>
        </form>
    </div>
</body>
</html>
