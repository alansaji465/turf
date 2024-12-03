<?php
// Connect to database
include_once("config/config.php");

// Get TurfID from URL parameter
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
} else {
    // Redirect to dashboard if TurfID is not set
    header("Location: dashboard.php");
    exit();
}

$image1 = $turfDetails['image'];
$image2 = $turfDetails['image_2'];

$slotsQuery = "SELECT * FROM time_slots";
$slotsResult = $conn->query($slotsQuery);

// Check if there are any slots available
$slots = [];
if ($slotsResult->num_rows > 0) {
    while ($row = $slotsResult->fetch_assoc()) {
        $slots[] = $row; // Store slot details in an array
    }
}

// Query the database for already booked slots on the selected turf
$bookedQuery = "SELECT b.id, b.booking_date, ts.slot_start, ts.slot_end 
                FROM bookings b
                JOIN time_slots ts ON b.time_slot_id = ts.id
                WHERE b.turf_id = ? AND b.booking_date = ?";


$stmt = $conn->prepare($bookedQuery);
$stmt->bind_param("is", $turfID, $selectedDate);  // Bind turf ID and date
$stmt->execute();
$bookedResult = $stmt->get_result();

// Store booked time slots in an array
$bookedSlots = [];
while ($bookedRow = $bookedResult->fetch_assoc()) {
    $bookedSlots[] = $bookedRow['booking_time'];  // Store the booked times
}

// Function to check if a slot is booked
function isSlotBooked($slotTime, $bookedSlots) {
    return in_array($slotTime, $bookedSlots); // Returns true if slot is booked
}

// Function to format the slot times as "5 AM to 6 AM"
function formatSlotTime($slotTime, $duration) {
    // Get the start time in 12-hour format
    $startTime = date('g A', strtotime($slotTime)); // e.g., "5 AM"
    // Calculate the end time by adding the duration
    $endTime = date('g A', strtotime($slotTime) + ($duration * 60)); // e.g., "6 AM"
    return $startTime . " to " . $endTime; // e.g., "5 AM to 6 AM"
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
                        <p class="card-text">5 AM - 12 AM</p> <!-- Fixed time range display -->
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
                    <!-- Display Calendar Grid -->
                    <div class="calendar-container">
                        <div class="calendar-header">
                            <button id="prevMonth" class="btn btn-secondary">&lt;</button>
                            <span id="calendarMonth" class="calendar-month"></span>
                            <button id="nextMonth" class="btn btn-secondary">&gt;</button>
                        </div>
                        <!-- Calendar Div (This will be populated dynamically) -->
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
                    // Display time slots from the database
                    foreach ($slots as $slot) {
                        $formattedSlot = formatSlotTime($slot['slot_time'], $slot['duration']);
                        // Check if the slot is booked
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
        <button type="submit" class="btn btn-success btn-lg" style="margin-top: 20px">Book Now</button>
    </div>
</section>

<!-- Hidden Input for Time Slot (Updated) -->
<input type="hidden" name="time_slot">


<script>
    let currentMonth = new Date().getMonth();
    let currentYear = new Date().getFullYear();

    const months = [
        "January", "February", "March", "April", "May", "June", 
        "July", "August", "September", "October", "November", "December"
    ];

    function generateCalendar(month, year) {
        const calendar = document.getElementById("calendar");
        calendar.innerHTML = "";
        const daysInMonth = new Date(year, month + 1, 0).getDate();
        const firstDay = new Date(year, month).getDay();
        const currentDate = new Date().getDate();

        // Display month and year
        document.getElementById("calendarMonth").textContent = months[month] + " " + year;

        // Create day headers (Sun, Mon, Tue, etc.)
        const header = document.createElement("div");
        header.classList.add("calendar-header-row");
        ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"].forEach(day => {
            const dayHeader = document.createElement("span");
            dayHeader.classList.add("calendar-day-header");
            dayHeader.textContent = day;
            header.appendChild(dayHeader);
        });
        calendar.appendChild(header);

        // Create calendar days
        const daysRow = document.createElement("div");
        daysRow.classList.add("calendar-days-row");

        // Add empty cells before the first day of the month
        for (let i = 0; i < firstDay; i++) {
            daysRow.appendChild(document.createElement("span"));
        }

        // Add days of the month
        for (let i = 1; i <= daysInMonth; i++) {
            const dayCell = document.createElement("span");
            dayCell.classList.add("calendar-day");
            dayCell.textContent = i;

            if (i === currentDate && month === new Date().getMonth() && year === new Date().getFullYear()) {
                dayCell.classList.add("current-day");
            }

            // Select day on click
            dayCell.addEventListener("click", function() {
                const selectedDate = `${year}-${month + 1}-${i}`;
                document.getElementById("date").value = selectedDate;
                updateAvailableSlots(selectedDate);  // Update available time slots for the selected date
            });

            daysRow.appendChild(dayCell);
        }

        calendar.appendChild(daysRow);
    }

    // Navigate to previous and next months
    document.getElementById("prevMonth").addEventListener("click", function() {
        currentMonth--;
        if (currentMonth < 0) {
            currentMonth = 11;
            currentYear--;
        }
        generateCalendar(currentMonth, currentYear);
    });

    document.getElementById("nextMonth").addEventListener("click", function() {
        currentMonth++;
        if (currentMonth > 11) {
            currentMonth = 0;
            currentYear++;
        }
        generateCalendar(currentMonth, currentYear);
    });

    // Initialize calendar
    generateCalendar(currentMonth, currentYear);

    function updateAvailableSlots(selectedDate) {
        $.ajax({
            url: "getBookedSlots.php",
            method: "POST",
            data: { selectedDate: selectedDate },
            success: function(response) {
                const bookedSlots = JSON.parse(response);
                document.querySelectorAll('.time-slot').forEach(function(slot) {
                    const slotTime = slot.getAttribute('data-slot');
                    if (bookedSlots.includes(slotTime)) {
                        slot.classList.add('booked');
                        slot.classList.remove('available');
                    } else {
                        slot.classList.add('available');
                        slot.classList.remove('booked');
                    }
                });
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Bind the click events for available time slots after DOM is loaded
        document.querySelectorAll('.time-slot.available').forEach(function(slot) {
            slot.addEventListener('click', function() {
                document.querySelector('input[name="time_slot"]').value = this.getAttribute('data-slot');
            });
        });
    });
</script>

</body>
</html>
