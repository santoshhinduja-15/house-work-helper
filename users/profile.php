<?php
session_start();
include('../db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$success = '';
$errors = [];

// Fetch existing user data
$sql = "SELECT name, email, address FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $address = trim($_POST['address']);
    $password = trim($_POST['password']);

    if (empty($name) || empty($email)) {
        $errors[] = "Name and Email are required.";
    } else {
        if (!empty($password)) {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $update = $conn->prepare("UPDATE users SET name = ?, email = ?, address = ?, password = ? WHERE user_id = ?");
            $update->bind_param("ssssi", $name, $email, $address, $hashedPassword, $user_id);
        } else {
            $update = $conn->prepare("UPDATE users SET name = ?, email = ?, address = ? WHERE user_id = ?");
            $update->bind_param("sssi", $name, $email, $address, $user_id);
        }

        if ($update->execute()) {
            $success = "✅ Profile updated successfully.";
            $user['name'] = $name;
            $user['email'] = $email;
            $user['address'] = $address;
        } else {
            $errors[] = "❌ Failed to update profile. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
    <?php include('navbar.php'); ?>

    <div class="container mt-5">
        <h3 class="mb-4">Edit Profile</h3>

        <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <?php foreach ($errors as $err) echo "<div>$err</div>"; ?>
        </div>
        <?php elseif (!empty($success)): ?>
        <div class="alert alert-success"><?= $success ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Full Name</label>
                <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" class="form-control"
                    required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" class="form-control"
                    required>
            </div>

            <div class="mb-3">
                <label class="form-label">Address</label>
                <textarea name="address" class="form-control"><?= htmlspecialchars($user['address']) ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">New Password <small>(leave blank to keep current)</small></label>
                <div class="input-group">
                    <input type="password" name="password" id="password" class="form-control">
                    <button type="button" class="btn btn-outline-secondary" onclick="togglePassword()">👁</button>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Update Profile</button>
        </form>
    </div>

    <script>
    function togglePassword() {
        const input = document.getElementById('password');
        input.type = input.type === 'password' ? 'text' : 'password';
    }
    </script>
</body>

</html>