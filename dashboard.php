<?php
include('config/config.php');

// Fetch location filter value if set
$location = isset($_GET['location']) ? $_GET['location'] : '';

// Query for turfs based on filter, or fetch all turfs if no filter
if ($location) {
    $query = "SELECT * FROM turfs WHERE location = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $location);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
} else {
    $query = "SELECT * FROM turfs";
    $result = mysqli_query($conn, $query);
}

// Fetch distinct locations for filter dropdown
$location_query = "SELECT DISTINCT location FROM turfs";
$location_result = mysqli_query($conn, $location_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Turf Booking Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="assets/css/dashboard.css?v=3.3" rel="stylesheet">
    <link href="assets/css/common.css?v=1" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>

<header>
    <div class="container header-container">
        <h1 class="logo">Turf Dashboard</h1>
        <nav>
            <a href="login.php">Login</a>
            <a href="signup.php" class="signup-btn">Sign Up</a>
        </nav>
    </div>
</header>

<!-- Full-Screen Carousel Section -->
<section class="carousel-section">
    <div id="turfCarousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <?php
            $carousel_query = "SELECT * FROM turfs LIMIT 5";
            $carousel_result = mysqli_query($conn, $carousel_query);
            $first = true;
            while ($row = mysqli_fetch_assoc($carousel_result)) {
                echo '<div class="carousel-item ' . ($first ? 'active' : '') . '">';
                echo '<img src="' . $row['image'] . '" class="d-block w-100 carousel-img" alt="' . $row['turf_name'] . '">';
                echo '<div class="carousel-caption d-none d-md-block">';
                echo '<h5>' . htmlspecialchars($row['turf_name']) . '</h5>';
                echo '<h6>' . htmlspecialchars($row['location']) . '</h6>';
                echo '<a href="turf_details.php?id=' . $row['turf_id'] . '" class="btn btn-primary">View Turf</a>';
                echo '</div></div>';
                $first = false;
            }
            ?>
        </div>
        <a class="carousel-control-prev" href="#turfCarousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#turfCarousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</section>

<!-- Filter and Turf Listings Section -->
<section class="turf-listings">
    <div class="container text-center">
        <form method="get" action="dashboard.php" class="filter-form">
            <label for="location">Filter by Location:</label>
            <select name="location" id="location" class="form-control">
                <option value="">All Locations</option>
                <?php
                while ($row = mysqli_fetch_assoc($location_result)) {
                    $selected = ($row['location'] === $location) ? 'selected' : '';
                    echo '<option value="' . htmlspecialchars($row['location']) . '" ' . $selected . '>' . htmlspecialchars($row['location']) . '</option>';
                }
                ?>
            </select>
            <button type="submit" class="btn btn-primary mt-2">Apply Filter</button>
        </form>

        <div class="row turf-grid mt-4">
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) { ?>
                    <div class="col-md-4 col-sm-6 mb-4">
                        <div class="card turf-card">
                            <img src="<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['turf_name']) ?>" class="card-img-top">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($row['turf_name']) ?></h5>
                                <p class="card-text"><?= htmlspecialchars($row['description']) ?></p>
                                <a href="turf_details.php?TurfID=<?= $row['turf_id'] ?>" class="btn btn-primary">View Details</a>

                            </div>
                        </div>
                    </div>
                <?php }
            } else {
                echo '<p class="text-center">No turfs available for this location.</p>';
            }
            ?>
        </div>
    </div>
</section>

<footer>
    <p>&copy; 2024 Turf Booking. All Rights Reserved.</p>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<?php mysqli_close($conn); ?>

</body>
</html>
