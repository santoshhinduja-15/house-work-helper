<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
?>


<!-- Bootstrap 5 Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm sticky-top">
    <div class="container">

        <!-- Brand -->
        <a class="navbar-brand d-flex align-items-center gap-2" href="dashboard.php">
            <img src="../logo.png" alt="HouseWorkHelper Logo" width="40" height="40" class="rounded-circle">
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
                    <a class="nav-link" href="../index.php">
                        <i class="bi bi-house-door-fill text-info me-1 align-middle"></i> Home
                    </a>
                </li>

                <!-- About -->
                <li class="nav-item fs-5">
                    <a class="nav-link" href="about.php">
                        <i class="bi bi-info-circle-fill text-warning me-1 align-middle"></i> About
                    </a>
                </li>

                <!-- Dashboard -->
                <li class="nav-item fs-5">
                    <a class="nav-link" href="dashboard.php">
                        <i class="bi bi-speedometer2 text-success me-1 align-middle"></i> Dashboard
                    </a>
                </li>

                <!-- Helpers -->
                <li class="nav-item fs-5">
                    <a class="nav-link" href="view_helpers.php">
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
                        <li><a class="dropdown-item" href="bookings.php">My Bookings</a></li>
                        <li><a class="dropdown-item" href="reviews.php">Write Review</a></li>
                        <li><a class="dropdown-item" href="all_reviews.php">All Reviews</a></li>
                    </ul>
                </li>

                <!-- Account Dropdown -->
                <li class="nav-item dropdown fs-5">
                    <a class="nav-link dropdown-toggle" href="#" id="accountDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle text-white me-1 align-middle"></i> Account
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="accountDropdown">
                        <li><a class="dropdown-item" href="profile.php">Profile</a></li>
                        <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                    </ul>
                </li>

            </ul>
        </div>
    </div>
</nav>