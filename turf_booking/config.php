<?php
$host = 'localhost';
$user = 'root';
$password = '';
$db_name = 'turf_booking_db';

$conn = mysqli_connect($host, $user, $password, $db_name);

if (!$conn) {
    die('Connection failed: ' . mysqli_connect_error());
}
?>
