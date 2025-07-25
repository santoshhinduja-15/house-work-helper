<?php
session_start();
include('../db.php');

// Redirect if not logged in
if (!isset($_SESSION['user']['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user']['user_id'];

// Fetch user bookings
$sql = "SELECT b.*, h.name AS helper_name
        FROM bookings b
        JOIN helpers h ON b.helper_id = h.helper_id
        WHERE b.user_id = ?
        ORDER BY b.created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Your Bookings - HouseWorkHelper</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>

    <?php include('navbar.php'); ?>

    <div class="container py-5">
        <h3 class="mb-4"><i class="bi bi-list-check"></i> Your Bookings</h3>

        <?php if ($result->num_rows > 0): ?>
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Helper</th>
                        <th>Date</th>
                        <th>Time Slot</th>
                        <th>Address</th>
                        <th>Payment</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td><?= htmlspecialchars($row['helper_name']) ?></td>
                        <td><?= htmlspecialchars($row['booking_date']) ?></td>
                        <td><?= htmlspecialchars($row['time_slot']) ?></td>
                        <td><?= htmlspecialchars($row['address']) ?></td>
                        <td><?= htmlspecialchars($row['payment_mode']) ?></td>
                        <td>
                            <?php
                        $status = $row['status'];
                        $badgeClass = match ($status) {
                            'Confirmed' => 'success',
                            'Pending' => 'warning',
                            'Cancelled' => 'danger',
                            default => 'secondary'
                        };
                        ?>
                            <span class="badge bg-<?= $badgeClass ?>"><?= $status ?></span>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
        <div class="alert alert-info">
            <i class="bi bi-info-circle"></i> You have no bookings yet.
        </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>