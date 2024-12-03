<?php
require('config/config.php');

$message = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hashing the password

    // Optional: Add confirmation password check
    if ($_POST['password'] !== $_POST['confirm_password']) {
        $message = "Passwords do not match!";
    } else {
        $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
        
        if (mysqli_query($conn, $sql)) {
            // Redirect to login page after 2 seconds
            echo "<script>
                    setTimeout(function() {
                        window.location.href = 'login.php';
                    }, 3000);
                  </script>";
            $message = "Signup successful! Redirecting to login page... <img src='assets/loading.gif' />";
        } else {
            $message = "Error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Turf Booking</title>
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
                <a href="login.php">Login</a>
            </nav>
        </div>
    </header>

    <section class="form-container">
        <form action="" method="post" class="form"> <!-- Action is empty to submit to the same file -->
            <h2>Create Your Account</h2>
            <?php if ($message) echo "<p>$message</p>"; ?> <!-- Displaying messages -->
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            <button type="submit" class="cta-button">Sign Up</button>
            <p>Already have an account? <a href="login.php">Login here</a></p>
        </form>
    </section>

    <footer>
        <p>&copy; 2024 Turf Booking. All rights reserved.</p>
    </footer>
</body>
</html>
