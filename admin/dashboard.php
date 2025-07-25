<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - HouseWorkHelper</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body style="background-color: #f0f2f5;">

    <?php include 'navbar.php'; ?>

    <div class="container mt-5">
        <h3 class="fw-bold text-center text-dark">
            <i class="bi bi-speedometer2 me-2 text-primary"></i> Admin Dashboard
        </h3>

        <div class="row mt-1 g-4">
            <!-- Manage Users -->
            <div class="col-md-4">
                <div class="card shadow-sm border-5 border-dark bg-body-secondary">
                    <div class="card-body d-flex align-items-center">
                        <i class="bi bi-person-fill-gear text-dark fs-1 me-3"></i>
                        <div>
                            <h6 class="mb-0 fw-bold">Manage Users</h6>
                            <p class="text-muted mb-0">View and control user accounts</p>
                            <a href="manage_users.php" class="btn btn-sm btn-outline-dark mt-2">Go <i
                                    class="bi bi-arrow-right-short"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Manage Helpers -->
            <div class="col-md-4">
                <div class="card shadow-sm border-5 border-primary bg-primary-subtle">
                    <div class="card-body d-flex align-items-center">
                        <i class="bi bi-person-lines-fill text-primary fs-1 me-3"></i>
                        <div>
                            <h6 class="mb-0 fw-bold">Manage Helpers</h6>
                            <p class="text-muted mb-0">View, verify, update helpers</p>
                            <a href="manage_helpers.php" class="btn btn-sm btn-outline-primary mt-2">Go <i
                                    class="bi bi-arrow-right-short"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Add Helper -->
            <div class="col-md-4">
                <div class="card shadow-sm border-5 border-success bg-success-subtle">
                    <div class="card-body d-flex align-items-center">
                        <i class="bi bi-person-plus-fill text-success fs-1 me-3"></i>
                        <div>
                            <h6 class="mb-0 fw-bold">Add Helper</h6>
                            <p class="text-muted mb-0">Register new house helpers</p>
                            <a href="add_helper.php" class="btn btn-sm btn-outline-success mt-2">Go <i
                                    class="bi bi-arrow-right-short"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Manage Requests -->
            <div class="col-md-4">
                <div class="card shadow-sm border-5 border-warning bg-warning-subtle">
                    <div class="card-body d-flex align-items-center">
                        <i class="bi bi-journal-check text-warning fs-1 me-3"></i>
                        <div>
                            <h6 class="mb-0 fw-bold">Manage Requests</h6>
                            <p class="text-muted mb-0">Approve or reject booking requests</p>
                            <a href="manage_requests.php" class="btn btn-sm btn-outline-warning mt-2">Go <i
                                    class="bi bi-arrow-right-short"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- View Feedback -->
            <div class="col-md-4">
                <div class="card shadow-sm border-5 border-secondary bg-secondary-subtle">
                    <div class="card-body d-flex align-items-center">
                        <i class="bi bi-chat-dots-fill text-secondary fs-1 me-3"></i>
                        <div>
                            <h6 class="mb-0 fw-bold">View Feedback</h6>
                            <p class="text-muted mb-0">Read what users are saying</p>
                            <a href="view_feedback.php" class="btn btn-sm btn-outline-secondary mt-2">Go <i
                                    class="bi bi-arrow-right-short"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Logout -->
            <div class="col-md-4">
                <div class="card shadow-sm border-5 border-danger bg-danger-subtle">
                    <div class="card-body d-flex align-items-center">
                        <i class="bi bi-box-arrow-right text-danger fs-1 me-3"></i>
                        <div>
                            <h6 class="mb-0 fw-bold">Logout</h6>
                            <p class="text-muted mb-0">Securely exit the dashboard</p>
                            <a href="logout.php" class="btn btn-sm btn-outline-danger mt-2">Logout <i
                                    class="bi bi-box-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>