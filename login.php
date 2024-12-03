<?php
require('config/config.php');
session_start();

$message = ""; // Initialize an empty message variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email); // "s" specifies the type (string)
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the user exists
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            header("Location: dashboard.php");
            exit(); // Ensure script stops executing after redirect
        } else {
            $message = "Invalid login credentials!"; // Invalid password
        }
    } else {
        $message = "Invalid login credentials!"; // Invalid email
    }
    
    // Close the statement
    $stmt->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Turf Booking</title>
    <link rel="stylesheet" href="assets/css/style.css?v=1.0">
    <link rel="stylesheet" href="assets/css/common.css?v=1.0">
    <link rel="stylesheet" href="assets/css/login-signup.css?v=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <div class="container">
            <h1 class="logo">Turf Booking</h1>
            <nav>
                <a href="signup.php" class="signup-btn">Sign Up</a>
                <a href="faculty_login.php" class="faculty-btn">Faculty Login</a>
            </nav>
        </div>
    </header>

    <section class="form-container">
        <form action="" method="post" class="form">
            <h2>Login to Your Account</h2>
            <?php if ($message) echo "<p>$message</p>"; ?>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="cta-button">Login</button>
            <p>Don't have an account? <a href="signup.php">Sign up here</a></p>
        </form>
    </section>

    <footer>
        <p>&copy; 2024 Turf Booking. All rights reserved.</p>
    </footer>
</body>
</html>

