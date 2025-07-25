<?php
session_start();
include('../db.php');

// 🔧 FIX: Use proper session structure
if (!isset($_SESSION['user']['user_id']) || !isset($_GET['helper_id'])) {
    header("Location: view_helpers.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$helper_id = (int) $_GET['helper_id'];
$errors = [];
$success = "";
$booking_pending = false;
$booking_confirmed = false;

// Fetch user address
$user_address = "";
$stmtUser = $conn->prepare("SELECT address FROM users WHERE user_id = ?");
$stmtUser->bind_param("i", $user_id);
$stmtUser->execute();
$userResult = $stmtUser->get_result();
if ($userRow = $userResult->fetch_assoc()) {
    $user_address = $userRow['address'];
}

// Fetch helper's timeslot
$default_timeslot = "";
$stmtHelper = $conn->prepare("SELECT timeslot FROM helpers WHERE helper_id = ?");
$stmtHelper->bind_param("i", $helper_id);
$stmtHelper->execute();
$helperResult = $stmtHelper->get_result();
if ($helperRow = $helperResult->fetch_assoc()) {
    $default_timeslot = $helperRow['timeslot'];
}

// If form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date = $_POST['booking_date'];
    $payment_mode = $_POST['payment_mode'];

    // Check if helper is already booked
    $checkSql = "SELECT * FROM bookings WHERE helper_id = ? AND booking_date = ? AND time_slot = ?";
    $stmt = $conn->prepare($checkSql);
    $stmt->bind_param("iss", $helper_id, $date, $default_timeslot);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $errors[] = "❌ Helper is already booked for this date and time.";
    } else {
        // Save booking with Pending status
        $insertSql = "INSERT INTO bookings (user_id, helper_id, booking_date, time_slot, address, payment_mode, status)
                      VALUES (?, ?, ?, ?, ?, ?, 'Pending')";
        $stmt = $conn->prepare($insertSql);
        $stmt->bind_param("iissss", $user_id, $helper_id, $date, $default_timeslot, $user_address, $payment_mode);
        if ($stmt->execute()) {
            $success = "✅ Booking request submitted. Please wait for admin confirmation.";
            $booking_pending = true;
        } else {
            $errors[] = "❌ Failed to book helper. Please try again.";
        }
    }
}

// Check current booking status (latest)
$checkConfirm = "SELECT status FROM bookings WHERE user_id = ? AND helper_id = ? ORDER BY created_at DESC LIMIT 1";
$stmt = $conn->prepare($checkConfirm);
$stmt->bind_param("ii", $user_id, $helper_id);
$stmt->execute();
$res = $stmt->get_result();
if ($resRow = $res->fetch_assoc()) {
    if ($resRow['status'] === 'Confirmed') {
        $booking_confirmed = true;
        $booking_pending = false;
    } elseif ($resRow['status'] === 'Pending') {
        $booking_pending = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Book Helper</title>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
    <?php include('navbar.php'); ?>

    <div class="container py-5">
        <h3 class="mb-4"><i class="bi bi-calendar-check"></i> Book Helper</h3>

        <!-- Booking Status Alerts -->
        <div id="booking-status-alert">
            <?php
            if (!empty($errors)) {
                foreach ($errors as $error) {
                    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">'
                       . htmlspecialchars($error) .
                       '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
                }
            } elseif ($booking_confirmed) {
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        🎉 Your booking has been <strong>confirmed by admin</strong>! The helper will reach on your scheduled date.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
            } elseif ($booking_pending) {
                echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                        ⏳ Your booking request is <strong>pending</strong>. Please wait for admin confirmation.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
            } elseif ($success) {
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">'
                    . htmlspecialchars($success) .
                    '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
            }
            ?>
        </div>

        <!-- Booking Form -->
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Select Date</label>
                <input type="date" name="booking_date" class="form-control" required min="<?= date('Y-m-d') ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Default Time Slot</label>
                <input type="text" class="form-control" value="<?= htmlspecialchars($default_timeslot) ?>" disabled>
            </div>

            <div class="mb-3">
                <label class="form-label">Service Address</label>
                <textarea class="form-control" rows="3" disabled><?= htmlspecialchars($user_address) ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Payment Mode</label>
                <select name="payment_mode" class="form-select" required>
                    <option value="Cash">Cash</option>
                    <option value="Online">Online</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success">Confirm Booking</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Auto-refresh status every 15 seconds -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    function hasAlertChanged(newHtml, currentHtml) {
        return newHtml.replace(/\s+/g, '') !== currentHtml.replace(/\s+/g, '');
    }

    setInterval(() => {
        fetch(window.location.href)
            .then(res => res.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newAlert = doc.querySelector("#booking-status-alert");
                const currentAlert = document.querySelector("#booking-status-alert");

                if (!newAlert || !currentAlert) return;

                const status = newAlert.innerText.includes("confirmed") ? "confirmed" :
                    newAlert.innerText.includes("pending") ? "pending" : "none";

                // Only update if the status has changed or the alert is not manually dismissed
                const previousStatus = sessionStorage.getItem("booking_alert_status") || "";
                const manuallyDismissed = sessionStorage.getItem("booking_alert_dismissed") === "true";

                if (status !== previousStatus || (!manuallyDismissed && hasAlertChanged(newAlert.innerHTML,
                        currentAlert.innerHTML))) {
                    currentAlert.innerHTML = newAlert.innerHTML;
                    sessionStorage.setItem("booking_alert_status", status);
                    sessionStorage.setItem("booking_alert_dismissed", "false");

                    // Re-bind dismiss handler
                    const closeBtn = currentAlert.querySelector(".btn-close");
                    if (closeBtn) {
                        closeBtn.addEventListener("click", () => {
                            sessionStorage.setItem("booking_alert_dismissed", "true");
                        });
                    }
                }
            });
    }, 5000);
    </script>

</body>

</html>