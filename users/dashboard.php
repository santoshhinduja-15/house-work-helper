<?php
include 'auth.php';
include '../db.php';

$user_id = $_SESSION['user_id'];
$query = "SELECT name FROM users WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($name);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Dashboard | HouseWorkHelper</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="../css/dashboard.css">
</head>

<body>

    <?php include 'navbar.php'; ?>

    <div class="container py-5">
        <div class="text-center mb-5">
            <h2 class="fw-bold">
                Welcome, <?= htmlspecialchars($name) ?> <span class="emoji-wave">👋</span>
            </h2>
            <p class="text-white fs-5">What would you like to do today?</p>
        </div>

        <div class="row g-4 justify-content-center">
            <div class="col-md-4 col-sm-6">
                <div class="card p-4 text-center h-100 border border-5 border-primary">
                    <div class="mb-3">
                        <i class="bi bi-calendar2-plus-fill fs-1 text-primary"></i>
                    </div>
                    <h5 class="text-dark">Book a Service</h5>
                    <p class="text-muted">Choose from multiple categories of trusted house help.</p>
                    <a href="book-service.php" class="btn btn-outline-primary btn-custom">Book Now</a>
                </div>
            </div>

            <div class="col-md-4 col-sm-6">
                <div class="card p-4 text-center h-100 border border-5 border-success">
                    <div class="mb-3">
                        <i class="bi bi-clipboard-data-fill fs-1 text-success"></i>
                    </div>
                    <h5 class="text-dark">My Bookings</h5>
                    <p class="text-muted">View and manage your current and past bookings.</p>
                    <a href="view_helpers.php" class="btn btn-outline-success btn-custom">View Bookings</a>
                </div>
            </div>

            <div class="col-md-4 col-sm-6">
                <div class="card p-4 text-center h-100 border border-5 border-warning">
                    <div class="mb-3">
                        <i class="bi bi-person-lines-fill fs-1 text-warning"></i>
                    </div>
                    <h5 class="text-dark">Edit Profile</h5>
                    <p class="text-muted">Update your personal details and preferences.</p>
                    <a href="profile.php" class="btn btn-outline-warning text-dark btn-custom">Edit Profile</a>
                </div>
            </div>
        </div>
    </div>
    <footer class="footer text-center py-4">
        <div class="container">
            &copy; <?= date("Y") ?> HouseWorkHelper. All Rights Reserved.
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>