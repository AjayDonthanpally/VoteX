<?php
session_start();
include 'config.php';

if (!isset($_SESSION['email'])) {
    header("Location: signin.php");
    exit();
}

$email = $_SESSION['email'];
$phone = $_POST['phone'] ?? '';
$voterid = $_POST['voterid'] ?? '';
$aadhaar = $_POST['aadhaar'] ?? '';

// Basic validation (optional: add regex or more validation)
if (!$phone || !$voterid || !$aadhaar) {
    echo "All fields are required.";
    exit();
}

$sql = "UPDATE voters SET phone = ?, voterid = ?, aadhaar = ? WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $phone, $voterid, $aadhaar, $email);

if ($stmt->execute()) {
header("Location: profile.php?updated=true");
    exit();
} else {
    echo "Error updating profile: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
