<?php
session_start();
include('../db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$success = "";
$errors = [];

// Handle Review Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $helper_id = (int) $_POST['helper_id'];
    $rating = (int) $_POST['rating'];
    $comment = trim($_POST['comment']);

    if ($helper_id === 0 || $rating < 1 || $rating > 5 || empty($comment)) {
        $errors[] = "Please fill all fields correctly.";
    } else {
        $stmt = $conn->prepare("INSERT INTO reviews (user_id, helper_id, rating, comment) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiis", $user_id, $helper_id, $rating, $comment);
        if ($stmt->execute()) {
            $success = "✅ Review submitted successfully!";
        } else {
            $errors[] = "❌ Failed to submit review.";
        }
    }
}

// Fetch All Helpers for Dropdown
$helperOptions = "";
$res = $conn->query("SELECT helper_id, name FROM helpers ORDER BY name");
while ($row = $res->fetch_assoc()) {
    $helperOptions .= "<option value='{$row['helper_id']}'>" . htmlspecialchars($row['name']) . "</option>";
}

// Fetch User's Reviews
$reviews = [];
$stmt = $conn->prepare("
    SELECT r.rating, r.comment, r.created_at, h.name AS helper_name
    FROM reviews r
    JOIN helpers h ON r.helper_id = h.helper_id
    WHERE r.user_id = ?
    ORDER BY r.created_at DESC
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $reviews[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Review Helpers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
    <?php include('navbar.php'); ?>

    <div class="container py-5">
        <h3 class="mb-4">📝 Leave a Review</h3>

        <?php if (!empty($errors)): ?>
        <?php foreach ($errors as $error): ?>
        <div class="alert alert-danger alert-dismissible fade show"><?= htmlspecialchars($error) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endforeach; ?>
        <?php elseif ($success): ?>
        <div class="alert alert-success alert-dismissible fade show"><?= $success ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>

        <form method="POST" class="mb-5">
            <div class="mb-3">
                <label class="form-label">Select Helper</label>
                <select name="helper_id" class="form-select" required>
                    <option value="">-- Select Helper --</option>
                    <?= $helperOptions ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Rating (1 to 5)</label>
                <input type="number" name="rating" class="form-control" min="1" max="5" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Comment</label>
                <textarea name="comment" class="form-control" rows="4" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Submit Review</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>