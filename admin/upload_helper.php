<?php
include '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name      = $_POST['name'];
    $category  = $_POST['category'];
    $location  = $_POST['location'];
    $timeslot  = $_POST['timeslot'];
    $hourly    = $_POST['hourly_rate'];
    $exp       = $_POST['experience'];
    $aadhaarNo = $_POST['aadhaar_number'];

    // Upload directory
    $uploadDir = '../uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Upload files
    $profileImg     = $uploadDir . basename($_FILES['profile_image']['name']);
    $aadhaarFile    = $uploadDir . basename($_FILES['aadhaar_file']['name']);
    $addressProof   = $uploadDir . basename($_FILES['address_proof']['name']);

    move_uploaded_file($_FILES['profile_image']['tmp_name'], $profileImg);
    move_uploaded_file($_FILES['aadhaar_file']['tmp_name'], $aadhaarFile);
    move_uploaded_file($_FILES['address_proof']['tmp_name'], $addressProof);

    // Insert helper
    $stmt = $conn->prepare("INSERT INTO helpers (name, category, location, timeslot, hourly_rate, experience, aadhaar_number, profile_image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssdss", $name, $category, $location, $timeslot, $hourly, $exp, $aadhaarNo, $profileImg);
    $stmt->execute();
    $helper_id = $stmt->insert_id;
    $stmt->close();

    // Insert documents
    $stmt2 = $conn->prepare("INSERT INTO documents (helper_id, aadhaar_file, address_proof) VALUES (?, ?, ?)");
    $stmt2->bind_param("iss", $helper_id, $aadhaarFile, $addressProof);
    $stmt2->execute();
    $stmt2->close();

    $conn->close();

    header("Location: add_helper.php?success=1");
    exit();
}
?>