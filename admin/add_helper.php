<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

$success = isset($_GET['success']) && $_GET['success'] === '1';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add Helper - HouseWorkHelper</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <script src="../js/helper-validation.js" defer></script>
</head>

<body class="bg-dark text-light">

    <?php include 'navbar.php'; ?>

    <div class="container py-5">
        <div class="card bg-secondary-subtle text-dark shadow-lg">
            <div class="card-body p-4">
                <h3 class="fw-bold text-success mb-3">
                    <i class="bi bi-person-plus-fill me-2"></i> Add New Helper
                </h3>

                <!-- Success Alert -->
                <?php if ($success): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> Helper added successfully!
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php endif; ?>

                <!-- Error Alert -->
                <div id="alertBox" class="alert alert-danger d-none alert-dismissible fade show" role="alert">
                    <div id="alertMessage"></div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>

                <!-- Form Start -->
                <form id="helperForm" action="upload_helper.php" method="POST" enctype="multipart/form-data" novalidate>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Helper's full name"
                                required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Category</label>
                            <select name="category" class="form-select" required>
                                <option value="">-- Select --</option>
                                <option value="Maid">Maid</option>
                                <option value="Cook">Cook</option>
                                <option value="Babysitter">Babysitter</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Location</label>
                            <input type="text" name="location" class="form-control" placeholder="Area/City" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Timeslot</label>
                            <input type="text" name="timeslot" class="form-control" placeholder="Morning, Evening"
                                required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Hourly Rate (INR)</label>
                            <input type="number" step="0.01" name="hourly_rate" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Experience (Years)</label>
                            <input type="number" name="experience" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Aadhaar Number</label>
                            <input type="text" name="aadhaar_number" class="form-control" maxlength="20" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Profile Image</label>
                            <input type="file" name="profile_image" class="form-control" accept="image/*" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Aadhaar File (PDF/Image)</label>
                            <input type="file" name="aadhaar_file" class="form-control" accept=".pdf,image/*" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Address Proof</label>
                            <input type="file" name="address_proof" class="form-control" accept=".pdf,image/*" required>
                        </div>
                    </div>

                    <div class="mt-4 d-grid">
                        <button type="button" class="btn btn-success btn-lg" onclick="validateHelperForm()">
                            <i class="bi bi-check-circle me-2"></i> Submit Helper
                        </button>
                    </div>
                </form>
                <!-- Form End -->
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>