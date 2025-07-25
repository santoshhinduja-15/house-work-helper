<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>HouseWorkHelper - Home</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/home.css">
</head>

<body>

    <!-- Bootstrap 5 Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm sticky-top">
        <div class="container">

            <!-- Brand -->
            <a class="navbar-brand d-flex align-items-center gap-2" href="dashboard.php">
                <img src="logo.png" alt="HouseWorkHelper Logo" width="40" height="40" class="rounded-circle">
                <span class="fw-bold fs-5">HouseWorkHelper</span>
            </a>

            <!-- Mobile Toggle Button -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navbar Links -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center gap-2 fw-semibold">

                    <!-- Home -->
                    <li class="nav-item fs-5">
                        <a class="nav-link" href="index.php">
                            <i class="bi bi-house-door-fill text-info me-1 align-middle"></i> Home
                        </a>
                    </li>

                    <!-- About -->
                    <li class="nav-item fs-5">
                        <a class="nav-link" href="users/about.php">
                            <i class="bi bi-info-circle-fill text-warning me-1 align-middle"></i> About
                        </a>
                    </li>

                    <!-- Dashboard -->
                    <li class="nav-item fs-5">
                        <a class="nav-link" href="users/dashboard.php">
                            <i class="bi bi-speedometer2 text-success me-1 align-middle"></i> Dashboard
                        </a>
                    </li>

                    <!-- Helpers -->
                    <li class="nav-item fs-5">
                        <a class="nav-link" href="users/view_helpers.php">
                            <i class="bi bi-calendar2-check-fill text-primary me-1 align-middle"></i> Helpers
                        </a>
                    </li>

                    <!-- Bookings Dropdown -->
                    <li class="nav-item dropdown fs-5">
                        <a class="nav-link dropdown-toggle" href="#" id="bookingsDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-journal-bookmark-fill text-light me-1 align-middle"></i> Bookings
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="bookingsDropdown">
                            <li><a class="dropdown-item" href="users/bookings.php">My Bookings</a></li>
                            <li><a class="dropdown-item" href="users/reviews.php">Write Review</a></li>
                            <li><a class="dropdown-item" href="users/all_reviews.php">All Reviews</a></li>
                        </ul>
                    </li>

                    <!-- Account Dropdown -->
                    <li class="nav-item dropdown fs-5">
                        <a class="nav-link dropdown-toggle" href="#" id="accountDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle text-white me-1 align-middle"></i> Account
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="accountDropdown">
                            <li><a class="dropdown-item" href="users/profile.php">Profile</a></li>
                            <li><a class="dropdown-item" href="users/logout.php">Logout</a></li>
                        </ul>
                    </li>

                </ul>
            </div>
        </div>
    </nav>


    <!-- Hero Section -->
    <section class="hero py-5">
        <div class="container text-center">
            <h1 class="display-5">Welcome to HouseWorkHelper <span class="emoji-wave">👋</span></h1>
            <p class="lead">Your one-stop solution for trusted and on-time home services.</p>
            <a href="users/book-service.php" class="btn btn-light btn-cta mt-3">
                <i class="bi bi-calendar2-check-fill me-1"></i> Book a Service
            </a>
        </div>
    </section>

    <!-- Features Section -->
    <section class="bg-white py-5">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-4 mb-4">
                    <div class="card p-4 h-100">
                        <div class="card-body">
                            <i class="bi bi-person-check-fill text-success card-icon"></i>
                            <h5 class="card-title mt-3">Verified Workers</h5>
                            <p class="text-muted">All workers are background-verified and reliable for your safety and
                                comfort.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card p-4 h-100">
                        <div class="card-body">
                            <i class="bi bi-clock-history text-warning card-icon"></i>
                            <h5 class="card-title mt-3">Flexible Scheduling</h5>
                            <p class="text-muted">Book services as per your time — early morning or evening, you decide.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card p-4 h-100">
                        <div class="card-body">
                            <i class="bi bi-star-fill text-primary card-icon"></i>
                            <h5 class="card-title mt-3">Top Rated Helpers</h5>
                            <p class="text-muted">Our helpers are rated 4.5+ by users across cleanliness, punctuality,
                                and attitude.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include('users/footer.html') ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>