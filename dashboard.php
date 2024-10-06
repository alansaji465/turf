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
    <title>Dashboard</title>
    <link rel="stylesheet" href="assets/css/dashboard.css">
</head>
<body>
    <header>
        <nav>
            <a href="#" class="logo">D</a>
            <a href="logout.php" class="logout">Logout</a>
        </nav>
    </header>
    <main>
        <section class="hero">
            <h1>Welcome to your Dashboard</h1>
            <p>Manage your bookings and turfs with ease.</p>
        </section>
        <section class="content">
            <div class="booking-form">
                <h2>Booking Form</h2>
                <form>
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email">
                    <label for="phone">Phone:</label>
                    <input type="tel" id="phone" name="phone">
                    <button type="submit">Book Now</button>
                </form>
            </div>
            <div class="turf-display">
                <h2>Turf Display</h2>
                <div class="turf-grid">
                    <div class="turf-card">
                        <h3>Turf 1</h3>
                        <p> Description of Turf 1</p>
                    </div>
                    <div class="turf-card">
                        <h3>Turf 2</h3>
                        <p> Description of Turf 2</p>
                    </div>
                    <!-- Add more turf cards here -->
                </div>
            </div>
        </section>
    </main>
    <footer>
        <p>&copy; 2023 Dashboard. All rights reserved.</p>
        <a href="login.php">Login</a>
    </footer>

    <script src="script.js"></script>
</body>
</html>
