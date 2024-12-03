<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Turf Details</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f9f9f9;
        }
        .container {
            margin-top: 50px;
        }
        .turf-image {
            width: 100%;
            height: auto;
            border-radius: 10px;
        }
        .card {
            border: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }
        .card-body {
            padding: 30px;
        }
        .card h3 {
            font-weight: 700;
            color: #06560a;
        }
        .details-icon {
            color: #117215;
            font-size: 20px;
        }
        .price-tag {
            font-size: 22px;
            color: #117215;
            font-weight: 700;
        }
        .btn-book {
            background-color: #117215;
            color: white;
            padding: 12px 30px;
            font-size: 18px;
            border-radius: 50px;
            transition: 0.3s;
        }
        .btn-book:hover {
            background-color: #06560a;
            color: white;
        }
        .info-section {
            margin-top: 30px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-md-6">
            <img src="assets/img/turf-sample.jpg" alt="Turf Image" class="turf-image">
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h3>Turf Title</h3>
                    <p class="mb-4">This turf is located at [Location]. It's a great place for [Sport] with premium amenities.</p>

                    <div class="info-section">
                        <p><i class="fas fa-tag details-icon"></i> Price: <span class="price-tag">₹500/hour</span></p>
                        <p><i class="fas fa-map-marker-alt details-icon"></i> Location: [City, Area]</p>
                        <p><i class="fas fa-calendar details-icon"></i> Date Available: [Date]</p>
                    </div>

                    <div class="text-right">
                        <a href="booking.php?turf_id=[ID]" class="btn btn-book">Book Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
</body>
</html>
