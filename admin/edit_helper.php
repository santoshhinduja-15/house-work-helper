<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
include '../db.php';

$helper_id = $_GET['id'] ?? null;
if (!$helper_id || !is_numeric($helper_id)) die("Invalid helper ID.");

$stmt = $conn->prepare("SELECT h.*, d.aadhaar_file, d.address_proof FROM helpers h LEFT JOIN documents d ON h.helper_id = d.helper_id WHERE h.helper_id = ?");
$stmt->bind_param("i", $helper_id);
$stmt->execute();
$result = $stmt->get_result();
$helper = $result->fetch_assoc();
$stmt->close();

if (!$helper) die("Helper not found.");

$success = '';
$error = '';

// On form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $category = $_POST['category'];
    $location = $_POST['location'];
    $timeslot = $_POST['timeslot'];
    $hourly_rate = $_POST['hourly_rate'];
    $experience = $_POST['experience'];
    $aadhaar_number = $_POST['aadhaar_number'];

    $uploadDir = '../uploads/';
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

    // Handle profile image
    $profile_image = $helper['profile_image'];
    if (!empty($_FILES['profile_image']['name'])) {
        $profile_image = $uploadDir . basename($_FILES['profile_image']['name']);
        move_uploaded_file($_FILES['profile_image']['tmp_name'], $profile_image);
    }

    // Handle reuploads
    $aadhaar_file = $helper['aadhaar_file'];
    if (!empty($_FILES['aadhaar_file']['name'])) {
        $aadhaar_file = $uploadDir . basename($_FILES['aadhaar_file']['name']);
        move_uploaded_file($_FILES['aadhaar_file']['tmp_name'], $aadhaar_file);
    }

    $address_proof = $helper['address_proof'];
    if (!empty($_FILES['address_proof']['name'])) {
        $address_proof = $uploadDir . basename($_FILES['address_proof']['name']);
        move_uploaded_file($_FILES['address_proof']['tmp_name'], $address_proof);
    }

    // Update helpers
    $stmt = $conn->prepare("UPDATE helpers SET name=?, category=?, location=?, timeslot=?, hourly_rate=?, experience=?, aadhaar_number=?, profile_image=? WHERE helper_id=?");
    $stmt->bind_param("sssssdssi", $name, $category, $location, $timeslot, $hourly_rate, $experience, $aadhaar_number, $profile_image, $helper_id);
    $stmt->execute();
    $stmt->close();

    // Update documents
    $stmt2 = $conn->prepare("UPDATE documents SET aadhaar_file=?, address_proof=? WHERE helper_id=?");
    $stmt2->bind_param("ssi", $aadhaar_file, $address_proof, $helper_id);
    $stmt2->execute();
    $stmt2->close();

    $success = "Helper details updated successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Helper - HouseWorkHelper</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <script src="../js/update-helper-validation.js" defer></script>
</head>

<body class="bg-light">
    <?php include 'navbar.php'; ?>

    <div class="container mt-5">
        <h4 class="text-primary fw-bold"><i class="bi bi-pencil-fill me-2"></i> Edit Helper Details</h4>

        <?php if ($success): ?>
        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> <?= htmlspecialchars($success) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>

        <div id="alertBox" class="alert alert-danger d-none alert-dismissible fade show mt-3" role="alert">
            <div id="alertMessage"></div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>

        <form id="updateForm" method="POST" enctype="multipart/form-data" novalidate class="mt-4">
            <div class="mb-3"><label class="form-label">Full Name</label>
                <input type="text" name="name" value="<?= htmlspecialchars($helper['name']) ?>" class="form-control"
                    required>
            </div>

            <div class="mb-3"><label class="form-label">Category</label>
                <select name="category" class="form-select" required>
                    <option value="">-- Select --</option>
                    <option value="Maid" <?= $helper['category'] === 'Maid' ? 'selected' : '' ?>>Maid</option>
                    <option value="Cook" <?= $helper['category'] === 'Cook' ? 'selected' : '' ?>>Cook</option>
                    <option value="Babysitter" <?= $helper['category'] === 'Babysitter' ? 'selected' : '' ?>>Babysitter
                    </option>
                </select>
            </div>

            <div class="mb-3"><label class="form-label">Location</label>
                <input type="text" name="location" value="<?= htmlspecialchars($helper['location']) ?>"
                    class="form-control" required>
            </div>

            <div class="mb-3"><label class="form-label">Timeslot</label>
                <input type="text" name="timeslot" value="<?= htmlspecialchars($helper['timeslot']) ?>"
                    class="form-control" required>
            </div>

            <div class="mb-3"><label class="form-label">Hourly Rate</label>
                <input type="number" step="0.01" name="hourly_rate" value="<?= $helper['hourly_rate'] ?>"
                    class="form-control" required>
            </div>

            <div class="mb-3"><label class="form-label">Experience (Years)</label>
                <input type="number" name="experience" value="<?= $helper['experience'] ?>" class="form-control"
                    required>
            </div>

            <div class="mb-3"><label class="form-label">Aadhaar Number</label>
                <input type="text" name="aadhaar_number" value="<?= $helper['aadhaar_number'] ?>" class="form-control"
                    maxlength="20" required>
            </div>

            <div class="mb-3"><label class="form-label">Profile Image</label>
                <input type="file" name="profile_image" class="form-control" accept="image/*">
                <?php if ($helper['profile_image']): ?>
                <small class="text-muted">Current: <?= basename($helper['profile_image']) ?></small>
                <?php endif; ?>
            </div>

            <div class="mb-3"><label class="form-label">Aadhaar File</label>
                <input type="file" name="aadhaar_file" class="form-control" accept=".pdf,image/*">
                <?php if ($helper['aadhaar_file']): ?>
                <small class="text-muted">Current: <?= basename($helper['aadhaar_file']) ?></small>
                <?php endif; ?>
            </div>

            <div class="mb-3"><label class="form-label">Address Proof</label>
                <input type="file" name="address_proof" class="form-control" accept=".pdf,image/*">
                <?php if ($helper['address_proof']): ?>
                <small class="text-muted">Current: <?= basename($helper['address_proof']) ?></small>
                <?php endif; ?>
            </div>

            <div class="d-grid">
                <button type="button" class="btn btn-success" onclick="validateUpdateForm()">
                    <i class="bi bi-arrow-repeat me-1"></i> Update Helper
                </button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>