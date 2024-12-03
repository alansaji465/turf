<?php
include_once("config/config.php");

if (isset($_POST['selectedDate'])) {
    $selectedDate = $_POST['selectedDate'];

    // Query to get booked slots for the selected date
    $bookedQuery = "SELECT booking_time FROM bookings WHERE booking_date = ?";
    $stmt = $conn->prepare($bookedQuery);
    $stmt->bind_param("s", $selectedDate);
    $stmt->execute();
    $result = $stmt->get_result();

    $bookedSlots = [];
    while ($row = $result->fetch_assoc()) {
        $bookedSlots[] = $row['booking_time'];
    }

    // Return booked slots as JSON
    echo json_encode($bookedSlots);
}
?>
