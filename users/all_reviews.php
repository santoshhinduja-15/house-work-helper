<?php
session_start();
include('../db.php');

// Fetch all reviews with user name and helper name
$sql = "SELECT r.*, u.name AS user_name, h.name AS helper_name 
        FROM reviews r
        JOIN users u ON r.user_id = u.user_id
        JOIN helpers h ON r.helper_id = h.helper_id
        ORDER BY r.created_at DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>All Reviews</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
    .review-card {
        border-left: 5px solid #198754;
        background-color: #f8f9fa;
        margin-bottom: 20px;
    }

    .star {
        color: gold;
        font-size: 1.2rem;
    }
    </style>
</head>

<body>
    <?php include('navbar.php'); ?>

    <div class="container py-5">
        <h2 class="mb-4 text-success"><i class="bi bi-chat-square-quote"></i> All Reviews</h2>

        <?php if ($result->num_rows > 0): ?>
        <?php while($row = $result->fetch_assoc()): ?>
        <div class="card review-card shadow-sm">
            <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($row['helper_name']) ?></h5>
                <h6 class="card-subtitle mb-2 text-muted">By: <?= htmlspecialchars($row['user_name']) ?> on
                    <?= date("d M Y", strtotime($row['created_at'])) ?></h6>

                <!-- Display star rating -->
                <p class="mb-1">
                    <?php for ($i = 0; $i < $row['rating']; $i++) echo '<span class="star">&#9733;</span>'; ?>
                    <?php for ($i = $row['rating']; $i < 5; $i++) echo '<span class="star text-secondary">&#9733;</span>'; ?>
                </p>

                <p class="card-text"><?= nl2br(htmlspecialchars($row['comment'])) ?></p>
            </div>
        </div>
        <?php endwhile; ?>
        <?php else: ?>
        <div class="alert alert-info">No reviews found.</div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>