<?php
include 'db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = htmlspecialchars($_POST['name']);
    $email    = htmlspecialchars($_POST['email']);
    $phone    = htmlspecialchars($_POST['phone']);
    $address  = htmlspecialchars($_POST['address']);
    $role     = $_POST['role'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (name, email, phone, password, address, role) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $name, $email, $phone, $password, $address, $role);

    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        header("Location: login.php");
        exit();
    } else {
        $error = "Something went wrong. Please try again.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Sign Up - HouseWorkHelper</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Custom CSS (optional if needed) -->
    <link rel="stylesheet" href="css/signup.css">

    <!-- JS Validation -->
    <script src="js/validation.js" defer></script>
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

                <div class="card shadow-lg border-0">
                    <div class="card-body p-4">

                        <div class="text-center mb-3">
                            <h4 class="text-primary fw-bold">
                                <i class="bi bi-house-heart-fill me-1"></i> HouseWorkHelper Sign Up
                            </h4>
                        </div>

                        <!-- Alert for Errors -->
                        <div id="errorAlert" class="alert alert-danger alert-dismissible fade show d-none" role="alert">
                            <div id="errorMsg"></div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>

                        <form id="signupForm" novalidate>

                            <div class="mb-3">
                                <label class="form-label"><i class="bi bi-person-fill me-2"></i>Full Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Enter full name"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label"><i class="bi bi-envelope-fill me-2"></i>Email</label>
                                <input type="email" name="email" class="form-control" placeholder="example@mail.com"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label"><i class="bi bi-telephone-fill me-2"></i>Phone</label>
                                <input type="tel" name="phone" class="form-control" placeholder="10-digit number"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label"><i class="bi bi-geo-alt-fill me-2"></i>Address</label>
                                <textarea name="address" class="form-control" placeholder="Your full address"
                                    required></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label"><i class="bi bi-lock-fill me-2"></i>Password</label>
                                <div class="input-group">
                                    <input type="password" name="password" id="passwordField" class="form-control"
                                        placeholder="At least 6 characters" required>
                                    <button type="button" class="btn btn-outline-secondary" onclick="togglePassword()">
                                        <i class="bi bi-eye-slash-fill" id="toggleIcon"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label"><i class="bi bi-person-badge-fill me-2"></i>Role</label>
                                <select name="role" class="form-select" required>
                                    <option value="user">User</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </div>

                            <div class="d-grid">
                                <button type="button" class="btn btn-primary" onclick="validateForm()">
                                    <i class="bi bi-person-plus-fill me-1"></i> Create Account
                                </button>
                            </div>

                            <div class="text-center mt-3">
                                <i class="bi bi-box-arrow-in-right me-1"></i>
                                Already have an account? <a href="login.php">Login here</a>
                            </div>

                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <?php include 'users/footer.html'?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>

<?php
// ✅ PHP Logic: insert into DB only if JS-validated
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  include 'db.php';

  $name     = htmlspecialchars($_POST['name']);
  $email    = htmlspecialchars($_POST['email']);
  $phone    = htmlspecialchars($_POST['phone']);
  $address  = htmlspecialchars($_POST['address']);
  $role     = $_POST['role'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

  $sql = "INSERT INTO users (name, email, phone, password, address, role) VALUES (?, ?, ?, ?, ?, ?)";
  $stmt = $conn->prepare($sql);  $stmt->bind_param("ssssss", $name, $email, $phone, $password, $address, $role);
  $stmt->execute();
  $stmt->close();
  $conn->close();
}
?>