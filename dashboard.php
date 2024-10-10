<?php
include('config/config.php');

// Fetch turfs data
$query = "SELECT * FROM turfs"; // Query to fetch all turfs
$result = mysqli_query($conn, $query); // Execute the query

// Check if the query returns rows
if (!$result) {
    die('Query failed: ' . mysqli_error($conn)); // Check for query execution errors
}

if (mysqli_num_rows($result) > 0) {
    // Carousel HTML
    echo '<div id="turfCarousel" class="carousel slide" data-bs-ride="carousel">';
    echo '<div class="carousel-inner">';

    $first = true; // For the first carousel item
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<div class="carousel-item ' . ($first ? 'active' : '') . '">';
        echo '<img src="assets/images/' . $row['image'] . '" class="d-block w-100" alt="' . $row['turf_name'] . '">';
        echo '<div class="carousel-caption d-none d-md-block">';
        echo '<h5>' . $row['turf_name'] . '</h5>';
        echo '<p>' . $row['description'] . '</p>';
        echo '<a href="turf_details.php?id=' . $row['turf_id'] . '" class="btn btn-primary">View Turf</a>';
        echo '</div></div>';
        $first = false; // Set to false after the first iteration
    }
    echo '</div>'; // Close carousel-inner

    echo '<button class="carousel-control-prev" type="button" data-bs-target="#turfCarousel" data-bs-slide="prev">';
    echo '<span class="carousel-control-prev-icon" aria-hidden="true"></span>';
    echo '</button>';
    echo '<button class="carousel-control-next" type="button" data-bs-target="#turfCarousel" data-bs-slide="next">';
    echo '<span class="carousel-control-next-icon" aria-hidden="true"></span>';
    echo '</button>';
    echo '</div>'; // Close turfCarousel
} else {
    echo "No turfs found."; // Message if no turfs are found
}

// Close the database connection (optional but recommended)
mysqli_close($conn);
?>
