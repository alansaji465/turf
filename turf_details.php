<?php
include('config/config.php');

if (!isset($_GET['id'])) {
    echo 'Invalid Turf ID.';
    exit;
}

$turf_id = $_GET['id'];
$stmt = $clink->prepare('SELECT * FROM turfs WHERE id = :id');
$stmt->bindParam(':id', $turf_id);
$stmt->execute();
$turf = $stmt->fetch();

if (!$turf) {
    echo 'Turf not found.';
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $turf['name']; ?> - Turf Details</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1><?php echo $turf['name']; ?></h1>
        <img src="assets/images/<?php echo $turf['image']; ?>" alt="<?php echo $turf['name']; ?>" class="img-fluid">
        <p><?php echo $turf['description']; ?></p>
        <p>Location: <?php echo $turf['location']; ?></p>
        <a href="booking.php?id=<?php echo $turf['id']; ?>" class="btn btn-primary">Book Now</a>
    </div>
</body>
</html>
