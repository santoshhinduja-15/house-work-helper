<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

include('../db.php');

// Handle filters, sort, pagination
$category = $_GET['category'] ?? '';
$location = $_GET['location'] ?? '';
$sort = $_GET['sort'] ?? '';
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$limit = 6;
$offset = ($page - 1) * $limit;

$where = "WHERE 1";
if (!empty($category)) {
    $where .= " AND category = '" . mysqli_real_escape_string($conn, $category) . "'";
}
if (!empty($location)) {
    $where .= " AND location LIKE '%" . mysqli_real_escape_string($conn, $location) . "%'";
}

$orderBy = "";
switch ($sort) {
    case 'exp_asc':
        $orderBy = "ORDER BY experience ASC";
        break;
    case 'exp_desc':
        $orderBy = "ORDER BY experience DESC";
        break;
    case 'rate_asc':
        $orderBy = "ORDER BY hourly_rate ASC";
        break;
    case 'rate_desc':
        $orderBy = "ORDER BY hourly_rate DESC";
        break;
    default:
        $orderBy = "ORDER BY helper_id DESC";
}

// Get total count
$totalSql = "SELECT COUNT(*) as total FROM helpers $where";
$totalRes = mysqli_query($conn, $totalSql);
$totalRow = mysqli_fetch_assoc($totalRes);
$totalHelpers = $totalRow['total'];
$totalPages = ceil($totalHelpers / $limit);

// Get filtered results
$sql = "SELECT * FROM helpers $where $orderBy LIMIT $limit OFFSET $offset";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Available Helpers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
    body {
        background-color: #f8f9fa;
    }

    .card {
        border-radius: 12px;
        transition: all 0.3s ease;
        height: 100%;
        padding-top: 80px;
        position: relative;
    }

    .card:hover {
        transform: scale(1.02);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    .profile-img {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border-radius: 50%;
        border: 3px solid #ddd;
        margin: -70px auto 10px;
        background-color: white;
        display: block;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .badge-verified {
        background-color: #198754;
    }

    .badge-unverified {
        background-color: #dc3545;
    }
    </style>
</head>

<body>

    <?php include('navbar.php'); ?>

    <div class="container py-5">
        <h2 class="text-center mb-4">🏠 Available House Helpers</h2>

        <!-- Filters -->
        <form method="GET" class="row g-3 mb-4">
            <div class="col-md-3">
                <select name="category" class="form-select">
                    <option value="">All Categories</option>
                    <option value="Maid" <?= $category === 'Maid' ? 'selected' : '' ?>>Maid</option>
                    <option value="Cook" <?= $category === 'Cook' ? 'selected' : '' ?>>Cook</option>
                    <option value="Babysitter" <?= $category === 'Babysitter' ? 'selected' : '' ?>>Babysitter</option>
                </select>
            </div>
            <div class="col-md-3">
                <input type="text" name="location" class="form-control" placeholder="Search by location"
                    value="<?= htmlspecialchars($location) ?>">
            </div>
            <div class="col-md-3">
                <select name="sort" class="form-select">
                    <option value="">Sort By</option>
                    <option value="exp_asc" <?= $sort === 'exp_asc' ? 'selected' : '' ?>>Experience (Low to High)
                    </option>
                    <option value="exp_desc" <?= $sort === 'exp_desc' ? 'selected' : '' ?>>Experience (High to Low)
                    </option>
                    <option value="rate_asc" <?= $sort === 'rate_asc' ? 'selected' : '' ?>>Hourly Rate (Low to High)
                    </option>
                    <option value="rate_desc" <?= $sort === 'rate_desc' ? 'selected' : '' ?>>Hourly Rate (High to Low)
                    </option>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary w-100">Apply Filters</button>
            </div>
        </form>

        <!-- Helpers -->
        <div class="row">
            <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <div class="col-md-4 mb-4">
                <div class="card shadow">
                    <?php if (!empty($row['profile_image'])): ?>
                    <img src="../uploads/<?= htmlspecialchars($row['profile_image']); ?>" alt="Helper Image"
                        class="profile-img">
                    <?php else: ?>
                    <img src="../assets/default-profile.jpg" alt="No Image" class="profile-img">
                    <?php endif; ?>
                    <div class="card-body d-flex flex-column text-center">
                        <h5 class="card-title"><?= htmlspecialchars($row['name']); ?></h5>
                        <p>
                            <span class="badge bg-secondary"><?= htmlspecialchars($row['category']); ?></span>
                            <?= $row['is_verified'] ? '<span class="badge badge-verified">✅ Verified</span>' : '<span class="badge badge-unverified">❌ Not Verified</span>' ?>
                        </p>
                        <p class="text-start">
                            <strong>Experience:</strong> <?= $row['experience']; ?> years<br>
                            <strong>Location:</strong> <?= htmlspecialchars($row['location']); ?><br>
                            <strong>Timeslot:</strong> <?= htmlspecialchars($row['timeslot']); ?><br>
                            <strong>Hourly Rate:</strong> ₹<?= $row['hourly_rate']; ?><br>
                            <small><i>Joined: <?= date('d M Y', strtotime($row['created_at'])); ?></i></small>
                        </p>
                        <a href="book-service.php?helper_id=<?= urlencode($row['helper_id']); ?>"
                            class="btn btn-success mt-auto w-100">Book Now</a>

                    </div>
                </div>
            </div>
            <?php endwhile; ?>
            <?php else: ?>
            <div class="col-12">
                <div class="alert alert-warning text-center">No helpers match your criteria.</div>
            </div>
            <?php endif; ?>
        </div>

        <!-- Pagination -->
        <nav class="mt-4">
            <ul class="pagination justify-content-center">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?= $page == $i ? 'active' : '' ?>">
                    <a class="page-link"
                        href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>"><?= $i ?></a>
                </li>
                <?php endfor; ?>
            </ul>
        </nav>
    </div>

    <?php include('footer.html'); ?>

</body>

</html>