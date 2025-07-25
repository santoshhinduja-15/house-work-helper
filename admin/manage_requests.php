<?php
session_start();
include('../db.php');

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// Handle approve/cancel actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $booking_id = $_POST['booking_id'];
    $action = $_POST['action'];

    if ($action === 'approve') {
        $updateSql = "UPDATE bookings SET status = 'Confirmed' WHERE booking_id = ?";
    } elseif ($action === 'cancel') {
        $updateSql = "UPDATE bookings SET status = 'Cancelled' WHERE booking_id = ?";
    }

    $stmt = $conn->prepare($updateSql);
    $stmt->bind_param("i", $booking_id);
    $stmt->execute();
}

$result = $conn->query("
    SELECT b.booking_id, u.name AS user_name, h.name AS helper_name,
           b.booking_date, b.time_slot, b.payment_mode, b.status, b.address, b.created_at
    FROM bookings b
    JOIN users u ON b.user_id = u.user_id
    JOIN helpers h ON b.helper_id = h.helper_id
    ORDER BY b.created_at DESC
");
?>

<!DOCTYPE html>
<html>

<head>
    <title>Admin - Bookings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
    <?php include('navbar.php'); ?>
    <div class="container py-5">
        <h3 class="mb-4">📋 Manage Bookings</h3>

        <?php if ($result && $result->num_rows > 0): ?>
        <div class="table-responsive">
            <table class="table table-bordered align-middle text-center">
                <thead class="table-danger">
                    <tr>
                        <th>#</th>
                        <th>User</th>
                        <th>Helper</th>
                        <th>Date</th>
                        <th>Timeslot</th>
                        <th>Address</th>
                        <th>Payment</th>
                        <th>Status</th>
                        <th>Requested At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['booking_id'] ?></td>
                        <td><?= htmlspecialchars($row['user_name']) ?></td>
                        <td><?= htmlspecialchars($row['helper_name']) ?></td>
                        <td><?= $row['booking_date'] ?></td>
                        <td><?= $row['time_slot'] ?></td>
                        <td><?= htmlspecialchars($row['address']) ?></td>
                        <td><?= $row['payment_mode'] ?></td>
                        <td>
                            <span class="badge bg-<?= match ($row['status']) {
                                'Pending' => 'warning text-dark',
                                'Confirmed' => 'success',
                                'Cancelled' => 'danger',
                                default => 'secondary'
                            } ?>">
                                <?= $row['status'] ?>
                            </span>
                        </td>
                        <td><?= $row['created_at'] ?></td>
                        <td>
                            <?php if ($row['status'] === 'Pending'): ?>
                            <form method="POST" class="d-flex gap-1">
                                <input type="hidden" name="booking_id" value="<?= $row['booking_id'] ?>">
                                <button name="action" value="approve" class="btn btn-success btn-sm">Approve</button>
                                <button name="action" value="cancel" class="btn btn-danger btn-sm">Cancel</button>
                            </form>
                            <?php else: ?>
                            <em>N/A</em>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
        <div class="alert alert-info">No bookings found.</div>
        <?php endif; ?>
    </div>
</body>

</html>