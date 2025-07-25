<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
include '../db.php';

$admin = $_SESSION['user'];
$success = $error = '';
$oldProfile = $admin['profile_pic'] ?? '';

// === Handle Profile Update ===
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $uploadDir = '../uploads/';
    $newProfile = $oldProfile;

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    if (!empty($_FILES['profile_pic']['name'])) {
        $newProfile = $uploadDir . basename($_FILES['profile_pic']['name']);
        move_uploaded_file($_FILES['profile_pic']['tmp_name'], $newProfile);
    }

    $stmt = $conn->prepare("UPDATE users SET name=?, phone=?, profile_pic=? WHERE user_id=?");
    $stmt->bind_param("sssi", $name, $phone, $newProfile, $admin['user_id']);

    if ($stmt->execute()) {
        $_SESSION['user']['name'] = $name;
        $_SESSION['user']['phone'] = $phone;
        $_SESSION['user']['profile_pic'] = $newProfile;
        $success = "Profile updated successfully.";
    } else {
        $error = "Failed to update profile.";
    }
    $stmt->close();
}

// === Handle Password Change ===
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_password'])) {
    $current = $_POST['current_password'];
    $newpass = $_POST['new_password'];

    if (password_verify($current, $admin['password'])) {
        if ($current === $newpass) {
            $error = "New password cannot be the same as current password.";
        } else {
            $hash = password_hash($newpass, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE users SET password=? WHERE user_id=?");
            $stmt->bind_param("si", $hash, $admin['user_id']);
            if ($stmt->execute()) {
                $success = "Password changed successfully.";
            } else {
                $error = "Password change failed.";
            }
            $stmt->close();
        }
    } else {
        $error = "Current password is incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Profile</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <script>
    function togglePassword(id, iconId) {
        const field = document.getElementById(id);
        const icon = document.getElementById(iconId);
        if (field.type === "password") {
            field.type = "text";
            icon.classList.replace('bi-eye-slash-fill', 'bi-eye-fill');
        } else {
            field.type = "password";
            icon.classList.replace('bi-eye-fill', 'bi-eye-slash-fill');
        }
    }
    </script>

    <style>
    .card {
        background-color: #ffffff;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }
    </style>

</head>

<body style="background-color: #1f1f1f;">
    <?php include 'navbar.php'; ?>

    <div class="container py-5">
        <h4 class="fw-bold text-primary mb-2"><i class="bi bi-person-badge-fill me-2"></i> Admin Profile</h4>

        <?php if ($success): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle-fill me-2"></i><?= $success ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php elseif ($error): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="bi bi-exclamation-circle-fill me-2"></i><?= $error ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>

        <div class="row g-4">
            <!-- Profile Update -->
            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white">
                        <i class="bi bi-pencil-square me-2"></i>Update Profile
                    </div>
                    <div class="card-body">
                        <form method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="update_profile" value="1">

                            <div class="mb-3">
                                <label class="form-label">Full Name</label>
                                <input type="text" name="name" class="form-control"
                                    value="<?= htmlspecialchars($admin['name']) ?>" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Phone</label>
                                <input type="text" name="phone" class="form-control"
                                    value="<?= htmlspecialchars($admin['phone']) ?>" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Profile Picture</label>
                                <input type="file" name="profile_pic" class="form-control" accept="image/*">
                                <?php if ($oldProfile && file_exists($oldProfile)): ?>
                                <div class="mt-2">
                                    <img src="<?= $oldProfile ?>" alt="Profile" class="rounded border" width="80"
                                        height="80">
                                    <small class="text-muted d-block mt-1">Current: <?= basename($oldProfile) ?></small>
                                </div>
                                <?php endif; ?>
                            </div>

                            <button type="submit" class="btn btn-primary w-100"><i class="bi bi-save me-1"></i> Update
                                Profile</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Password Change -->
            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-warning text-dark">
                        <i class="bi bi-shield-lock-fill me-2"></i>Change Password
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <input type="hidden" name="change_password" value="1">

                            <div class="mb-3">
                                <label class="form-label">Current Password</label>
                                <div class="input-group">
                                    <input type="password" name="current_password" id="currentPass" class="form-control"
                                        required>
                                    <button type="button" class="btn btn-outline-secondary"
                                        onclick="togglePassword('currentPass','icon1')">
                                        <i id="icon1" class="bi bi-eye-slash-fill"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">New Password</label>
                                <div class="input-group">
                                    <input type="password" name="new_password" id="newPass" class="form-control"
                                        required>
                                    <button type="button" class="btn btn-outline-secondary"
                                        onclick="togglePassword('newPass','icon2')">
                                        <i id="icon2" class="bi bi-eye-slash-fill"></i>
                                    </button>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-warning w-100"><i class="bi bi-lock-fill me-1"></i>
                                Change Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>


</html>