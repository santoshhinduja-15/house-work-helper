<?php
session_start();
include 'db.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = $_POST['email'];
    $password = $_POST['password'];
    $role     = $_POST['role'];

    $sql = "SELECT * FROM users WHERE email = ? AND role = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $role);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user;
            $_SESSION['user_id'] = $user['user_id'];

            if ($role === 'admin') {
                header("Location: admin/dashboard.php");
            } elseif ($role === 'user') {
                header("Location: index.php"); // ✅ user redirected to homepage
            } else {
                $error = "Invalid role.";
            }
            exit();
        } else {
            $error = "Incorrect password.";
        }
    } else {
        $error = "No account found with this email and role.";
    }
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Login - HouseWorkHelper</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/login.css">
    <script src="js/login-validation.js" defer></script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm sticky-top">
        <div class="container">
            <!-- Logo and Brand -->
            <a class="navbar-brand d-flex align-items-center" href="index.php">
                <img src="logo.png" alt="HouseWorkHelper Logo" width="40" height="40" class="me-2">
                <span class="fw-bold fs-5 text-white">HouseWorkHelper</span>
            </a>

            <!-- Mobile Toggle Button -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Menu Links -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto fw-semibold">

                    <!-- About always visible -->
                    <li class="nav-item">
                        <a class="nav-link text-white fs-5" href="index.php">
                            <i class="bi bi-house-door-fill text-light me-1"></i> Home
                        </a>
                    </li>


                    <li class="nav-item">
                        <a class="nav-link text-white fs-5" href="users/about.php">
                            <i class="bi bi-info-circle-fill text-info me-1"></i> About
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-white fs-5" href="login.php">
                            <i class="bi bi-box-arrow-in-right text-warning me-1"></i> Login
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-white fs-5" href="signup.php">
                            <i class="bi bi-person-plus-fill text-success me-1"></i> Sign Up
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow border-0">
                    <div class="card-body p-4">
                        <h4 class="text-primary text-center fw-bold mb-3">
                            <i class="bi bi-person-circle me-1"></i> Login
                        </h4>

                        <?php if (!empty($error)): ?>
                        <div class="alert alert-danger alert-dismissible fade show">
                            <?= htmlspecialchars($error) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        <?php endif; ?>

                        <div id="clientError" class="alert alert-danger d-none alert-dismissible fade show">
                            <div id="clientMsg"></div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>

                        <form id="loginForm" method="POST" novalidate>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" required
                                    placeholder="you@example.com" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <div class="input-group">
                                    <input type="password" name="password" id="passwordField" class="form-control"
                                        required />
                                    <button type="button" class="btn btn-outline-secondary" onclick="togglePassword()">
                                        <i class="bi bi-eye-slash-fill" id="toggleIcon"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Role</label>
                                <select name="role" class="form-select" required>
                                    <option value="user">User</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </div>
                            <div class="d-grid">
                                <button type="button" onclick="validateLoginForm()" class="btn btn-primary">
                                    <i class="bi bi-box-arrow-in-right me-1"></i> Login
                                </button>
                            </div>
                        </form>

                        <div class="text-center mt-3">
                            Don't have an account? <a href="signup.php">Sign up</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php include 'users/footer.html'?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>