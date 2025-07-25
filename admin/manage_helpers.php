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
    <title>Manage Helpers - HouseWorkHelper</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="bg-light">
    <?php include 'navbar.php'; ?>

    <div class="container mt-5">
        <h4 class="fw-bold text-primary"><i class="bi bi-person-lines-fill me-2"></i> Manage Helpers</h4>

        <?php
        // Handle verification
        if (isset($_GET['verify']) && is_numeric($_GET['verify'])) {
            $id = (int) $_GET['verify'];
            $conn->query("UPDATE helpers SET is_verified = 1 WHERE helper_id = $id");
            $conn->query("UPDATE documents SET verified_by_admin = 1 WHERE helper_id = $id");
            echo '<div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> Helper verified successfully!
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                  </div>';
        }

        // Handle delete
        if (isset($_POST['delete_id'])) {
            $id = (int) $_POST['delete_id'];
            $conn->query("DELETE FROM documents WHERE helper_id = $id");
            $conn->query("DELETE FROM helpers WHERE helper_id = $id");
            echo '<div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                    <i class="bi bi-trash-fill me-2"></i> Helper deleted successfully.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                  </div>';
        }

        $sql = "SELECT h.*, d.aadhaar_file, d.address_proof FROM helpers h 
                LEFT JOIN documents d ON h.helper_id = d.helper_id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0):
        ?>

        <div class="table-responsive mt-4">
            <table class="table table-bordered align-middle table-hover">
                <thead class="table-primary">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Location</th>
                        <th>Rate (₹)</th>
                        <th>Experience</th>
                        <th>Status</th>
                        <th>Documents</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['helper_id'] ?></td>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td><?= $row['category'] ?></td>
                        <td><?= htmlspecialchars($row['location']) ?></td>
                        <td><?= $row['hourly_rate'] ?></td>
                        <td><?= $row['experience'] ?> yrs</td>
                        <td>
                            <?= $row['is_verified']
                                ? '<span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Verified</span>'
                                : '<span class="badge bg-warning text-dark"><i class="bi bi-exclamation-triangle me-1"></i> Unverified</span>'
                            ?>
                        </td>
                        <td>
                            <a href="<?= $row['aadhaar_file'] ?>" target="_blank"
                                class="btn btn-sm btn-outline-info mb-1">
                                <i class="bi bi-file-person-fill me-1"></i> Aadhaar
                            </a><br>
                            <a href="<?= $row['address_proof'] ?>" target="_blank"
                                class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-file-earmark-text-fill me-1"></i> Address
                            </a>
                        </td>
                        <td>
                            <?php if (!$row['is_verified']): ?>
                            <a href="?verify=<?= $row['helper_id'] ?>" class="btn btn-sm btn-success mb-1">
                                <i class="bi bi-patch-check-fill me-1"></i> Verify
                            </a>
                            <?php endif; ?>
                            <a href="edit_helper.php?id=<?= $row['helper_id'] ?>" class="btn btn-sm btn-warning mb-1">
                                <i class="bi bi-pencil-square me-1"></i> Update
                            </a>
                            <!-- Delete Button triggers Modal -->
                            <button class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                data-bs-target="#deleteModal<?= $row['helper_id'] ?>">
                                <i class="bi bi-trash3-fill me-1"></i> Delete
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="deleteModal<?= $row['helper_id'] ?>" tabindex="-1"
                                aria-labelledby="deleteLabel<?= $row['helper_id'] ?>" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form method="POST" class="modal-content">
                                        <input type="hidden" name="delete_id" value="<?= $row['helper_id'] ?>">
                                        <div class="modal-header">
                                            <h5 class="modal-title text-danger"
                                                id="deleteLabel<?= $row['helper_id'] ?>">
                                                <i class="bi bi-exclamation-triangle-fill me-2"></i> Confirm Deletion
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            Are you sure you want to delete helper
                                            <strong><?= htmlspecialchars($row['name']) ?></strong>?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-danger">Yes, Delete</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <?php else: ?>
        <div class="alert alert-info mt-4">
            <i class="bi bi-info-circle-fill me-2"></i> No helpers found in the system.
        </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>