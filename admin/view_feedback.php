<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

include '../db.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>View Feedback - HouseWorkHelper</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap + Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
    body {
        background-color: #f8f9fa;
    }

    .card-custom {
        background-color: #fff;
        border-left: 6px solid #0d6efd;
        box-shadow: 0 0 12px rgba(0, 0, 0, 0.05);
    }

    .table th,
    .table td {
        vertical-align: middle;
    }

    .text-muted small {
        font-size: 0.85rem;
    }
    </style>
</head>

<body>

    <?php include 'navbar.php'; ?>

    <div class="container py-5">
        <div class="mb-4">
            <h4 class="fw-bold text-primary"><i class="bi bi-chat-dots-fill me-2"></i> User Feedback</h4>
            <p class="text-muted">Here’s what users are saying about their experience with helpers.</p>
        </div>

        <?php
        $sql = "SELECT r.*, u.name AS user_name, h.name AS helper_name 
                FROM reviews r 
                JOIN users u ON r.user_id = u.user_id 
                JOIN helpers h ON r.helper_id = h.helper_id 
                ORDER BY r.created_at DESC";

        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0): ?>
        <div class="card card-custom p-3">
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle">
                    <thead class="table-primary">
                        <tr>
                            <th>User</th>
                            <th>Helper</th>
                            <th>Rating</th>
                            <th>Comment</th>
                            <th>Submitted At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['user_name']) ?></td>
                            <td><?= htmlspecialchars($row['helper_name']) ?></td>
                            <td>
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                <i
                                    class="bi <?= $i <= $row['rating'] ? 'bi-star-fill text-warning' : 'bi-star text-muted' ?>"></i>
                                <?php endfor; ?>
                                <span class="text-muted small">(<?= $row['rating'] ?>/5)</span>
                            </td>
                            <td><?= nl2br(htmlspecialchars($row['comment'])) ?></td>
                            <td><?= date('d M Y, h:i A', strtotime($row['created_at'])) ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php else: ?>
        <div class="alert alert-info mt-4" role="alert">
            <i class="bi bi-info-circle-fill me-2"></i> No feedback submitted yet.
        </div>
        <?php endif; ?>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>