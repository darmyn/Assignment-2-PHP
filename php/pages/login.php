<?php
// Include database connection code if needed

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = $_POST['password'];

    require_once('../scripts/db.php');

    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }

    $stmt = $db->prepare("SELECT id, username, password FROM users WHERE username = ?");
    
    if (!$stmt) {
        die("Error in statement preparation: " . $db->error);
    }

    $stmt->bind_param("s", $username);

    if (!$stmt->execute()) {
        die("Error in statement execution: " . $stmt->error);
    }

    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($userId, $dbUsername, $dbPassword);
        $stmt->fetch();

        if (password_verify($password, $dbPassword)) {
            session_start();
            $_SESSION['user_id'] = $userId;
            $_SESSION['username'] = $dbUsername;

            $stmt->close();
            $db->close();

            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Incorrect password. Please try again.";
        }
    } else {
        $error = "Username not found. Please check your username.";
    }

    $stmt->close();
    $db->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/style.css">

    <title>Login</title>
</head>
<body>
    <div class="container">
        <!-- Display error message if set -->
        <?php if (isset($error)): ?>
            <div class="error-message"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <!-- Login form -->
        <form class="form" action="login.php" method="post">
            <h2>Login</h2>
            <!-- Username input -->
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>
            
            <!-- Password input -->
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
            
            <!-- Login button -->
            <button type="submit">Login</button>
            
            <!-- Switch to signup form link -->
            <p class="switch-form">Don't have an account? <a href="signup.php">Sign up</a>.</p>
        </form>
    </div>
</body>
</html>