<?php
// Connect to the database
include_once("config/config.php");

// Ensure TurfID is set and sanitized
if (isset($_GET['TurfID'])) {
    $TurfID = intval($_GET['TurfID']);  // Convert to integer for security

    // Query the database for turf details
    $turfQuery = "SELECT * FROM turfs WHERE turf_id = ?";
    $stmt = $conn->prepare($turfQuery);
    $stmt->bind_param("i", $TurfID);
    $stmt->execute();
    $turfResult = $stmt->get_result();

    if ($turfResult->num_rows > 0) {
        // Fetch the turf details
        $turfDetails = $turfResult->fetch_assoc();
    } else {
        // Redirect if the turf ID is invalid
        header("Location: dashboard.php");
        exit();
    }

    // Query the database for time slots
    $slotQuery = "SELECT slot_start, slot_end, is_available FROM time_slots WHERE turf_id = ?";
    $stmt = $conn->prepare($slotQuery);
    $stmt->bind_param("i", $TurfID);
    $stmt->execute();
    $slotResult = $stmt->get_result();

    if ($slotResult->num_rows > 0) {
        // Loop through and display available time slots
        while ($row = $slotResult->fetch_assoc()) {
            echo "Slot Start: " . $row['slot_start'] . " - Slot End: " . $row['slot_end'] . " - Available: " . ($row['is_available'] ? 'Yes' : 'No') . "<br>";
        }
    } else {
        echo "No available time slots for this turf.";
    }

} else {
    // If TurfID is not set, handle accordingly (e.g., redirect or show a message)
    echo "TurfID parameter is missing.";
}

    
    // Fetch images associated with the turf
    $image1 = $turfDetails['image'];
    $image2 = $turfDetails['image_2'];

    
    // Query the database for available slots for the selected turf
    $slotsQuery = "SELECT * FROM time_slots WHERE turf_id = ?";
    $stmt = $conn->prepare($slotsQuery);
    $stmt->bind_param("i", $TurfID);
    $stmt->execute();
    $slotsResult = $stmt->get_result();

    // Store available slots in an array
    $slots = [];
    if ($slotsResult->num_rows > 0) {
        while ($row = $slotsResult->fetch_assoc()) {
            $slots[] = $row; // Store slot details in an array
        }
    }

    // Query the database for already booked slots on the selected turf and date
    $bookedQuery = "SELECT b.id, b.booking_date, ts.slot_start, ts.slot_end 
                    FROM bookings b
                    JOIN time_slots ts ON b.time_slot_id = ts.id
                    WHERE b.turf_id = ? AND b.booking_date = ?";
    $selectedDate = date('Y-m-d');  // Example for the current date, modify as needed
    $stmt = $conn->prepare($bookedQuery);
    $stmt->bind_param("is", $TurfID, $selectedDate);  // Bind turf ID and date
    $stmt->execute();
    $bookedResult = $stmt->get_result();

    // Store booked time slots in an array
    $bookedSlots = [];
    while ($bookedRow = $bookedResult->fetch_assoc()) {
        // Storing the booked slots for comparison
        $bookedSlots[] = ['slot_start' => $bookedRow['slot_start'], 'slot_end' => $bookedRow['slot_end']];
    }

    // Function to check if a selected slot is booked (compare time ranges)
    function isSlotBooked($selectedSlotStart, $selectedSlotEnd, $bookedSlots) {
        foreach ($bookedSlots as $bookedSlot) {
            // Check if the selected slot overlaps with any booked slot
            if (($selectedSlotStart >= $bookedSlot['slot_start'] && $selectedSlotStart < $bookedSlot['slot_end']) || 
                ($selectedSlotEnd > $bookedSlot['slot_start'] && $selectedSlotEnd <= $bookedSlot['slot_end'])) {
                return true; // Slot is booked
            }
        }
        return false; // Slot is not booked
    }

    // Function to format the slot times as "5 AM to 6 AM"
    function formatSlotTime($slotTime, $duration) {
        // Get the start time in 12-hour format
        $startTime = date('g A', strtotime($slotTime)); // e.g., "5 AM"
        // Calculate the end time by adding the duration
        $endTime = date('g A', strtotime($slotTime) + ($duration * 60)); // e.g., "6 AM"
        return $startTime . " to " . $endTime; // e.g., "5 AM to 6 AM"
    }

    // Example: Check for a specific slot availability
    $selectedSlotStart = '10:00'; // Selected start time (from user input)
    $selectedSlotEnd = '11:00';   // Selected end time (from user input)

    if (isSlotBooked($selectedSlotStart, $selectedSlotEnd, $bookedSlots)) {
        echo "Sorry, this time slot is already booked.";
    } else {
        echo "This time slot is available for booking!";
    }
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($turfDetails['turf_name']); ?> - Turf Details</title>
    <link rel="stylesheet" href="assets/css/turf_details.css?v=1">
    <link rel="stylesheet" href="assets/css/common.css?v=1">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<!-- Hero Section -->
<section class="hero-section" style="background-image: url('<?php echo $image1; ?>');">
    <div class="overlay">
        <div class="container text-center">
            <h1 class="hero-title"><?php echo htmlspecialchars($turfDetails['turf_name']); ?></h1>
            <p class="hero-location"><?php echo htmlspecialchars($turfDetails['location']); ?></p>
        </div>
    </div>
</section>

<!-- Turf Info Section -->
<section class="turf-info">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="carousel slide" data-ride="carousel" id="turfCarousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="<?php echo $image1; ?>" class="d-block w-100" alt="Turf Image 1">
                        </div>
                        <div class="carousel-item">
                            <img src="<?php echo $image2; ?>" class="d-block w-100" alt="Turf Image 2">
                        </div>
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
            </div>
            <div class="col-lg-6">
                <h3 class="section-title">Turf Details</h3>
                <p class="description"><?php echo nl2br(htmlspecialchars($turfDetails['description'])); ?></p>
                <div class="info-cards">
                    <div class="card">
                        <h5 class="card-title">Price</h5>
                        <p class="card-text">₹<?php echo htmlspecialchars($turfDetails['price']); ?> per Hour</p>
                    </div>
                    <div class="card">
                        <h5 class="card-title">Available Slots</h5>
                        <p class="card-text">5 AM - 12 AM</p>
                    </div>
                    <div class="card">
                        <h5 class="card-title">Amenities</h5>
                        <p class="card-text"><?php echo htmlspecialchars($turfDetails['amenities']); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Booking Form Section -->
<section class="turf-info">
    <div class="container">
        <div class="row">
            <!-- Left Column (Calendar View) -->
            <div class="col-lg-6">
                <h3 class="section-title">Select Date</h3>
                <div class="calendar-view">
                    <div class="calendar-container">
                        <div class="calendar-header">
                            <button id="prevMonth" class="btn btn-secondary">&lt;</button>
                            <span id="calendarMonth" class="calendar-month"></span>
                            <button id="nextMonth" class="btn btn-secondary">&gt;</button>
                        </div>
                        <div id="calendar" class="calendar"></div>
                    </div>
                </div>
            </div>

            <!-- Date Input (Hidden) -->
            <input type="hidden" id="date" name="date" />

            <!-- Right Column (Time Slots Grid) -->
            <div class="col-lg-6">
                <h3 class="section-title">Available Slots</h3>
                <div class="time-slot-grid">
                    <?php
                    foreach ($slots as $slot) {
                        $formattedSlot = formatSlotTime($slot['slot_time'], $slot['duration']);
                        if (!isSlotBooked($slot['slot_time'], $bookedSlots)) {
                            echo "<div class='time-slot available' data-slot='" . htmlspecialchars($slot['slot_time']) . "'>" . htmlspecialchars($formattedSlot) . "</div>";
                        } else {
                            echo "<div class='time-slot booked'>" . htmlspecialchars($formattedSlot) . "</div>";
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Submit Button -->
    <div class="d-flex justify-content-center">
        <button type="submit" class="btn btn-success btn-lg">Book Now</button>
    </div>
</section>

<!-- Scripts -->
<script>
$(document).ready(function() {
    // Calendar interaction
    const currentDate = new Date();
    let selectedDate = currentDate.toISOString().split("T")[0];

    function renderCalendar() {
        const calendar = $("#calendar");
        const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        const currentMonth = currentDate.getMonth();
        const currentYear = currentDate.getFullYear();
        const firstDay = new Date(currentYear, currentMonth, 1);
        const lastDay = new Date(currentYear, currentMonth + 1, 0);
        const firstWeekday = firstDay.getDay();
        const lastDate = lastDay.getDate();

        let day = 1;
        let html = "<table class='table'>";
        html += "<thead><tr>";
        for (let i = 0; i < 7; i++) {
            html += "<th>" + ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"][i] + "</th>";
        }
        html += "</tr></thead><tbody><tr>";

        // Empty cells before the first day of the month
        for (let i = 0; i < firstWeekday; i++) {
            html += "<td></td>";
        }

        // Render the days of the month
        for (let i = firstWeekday; i < 7; i++) {
            if (day <= lastDate) {
                html += `<td><button class="btn btn-calendar" data-date="${currentYear}-${currentMonth + 1}-${day}">${day}</button></td>`;
                day++;
            }
        }

        html += "</tr></tbody></table>";
        calendar.html(html);
        $("#calendarMonth").text(monthNames[currentMonth] + " " + currentYear);
    }

    renderCalendar();

    // Date selection handler
    $("#calendar").on("click", ".btn-calendar", function() {
        selectedDate = $(this).data("date");
        $("#date").val(selectedDate); // Update the hidden input value
    });

    // Time slot selection
    $(".time-slot").on("click", function() {
        const slotTime = $(this).data("slot");
        console.log("Selected Slot:", slotTime);
    });
});
</script>

</body>
</html>
