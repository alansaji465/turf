<?php
session_start(); 


if (!isset($_SESSION['username'])) {
    
    header("Location: index.php");
    exit;
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    session_unset();
    
    session_destroy();
    
    header("Location: index.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Logout</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <nav>
            <a href="#" class="logo">D</a>
            <a href="dashboard.php" class="back">Back to Dashboard</a>
        </nav>
    </header>

    <main>
        <section>
            <h2>Are you sure you want to log out?</h2>
            <form action="" method="POST">
                <button type="submit">Yes, log out</button>
                <a href="dashboard.php"><button type="button">Cancel</button></a>
            </form>
        </section>
    </main>

    <footer>
        <p>&copy; 2023 Dashboard. All rights reserved.</p>
    </footer>
</body>
</html>
