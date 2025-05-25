<?php
session_start();
include 'config.php';

// Check if form submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Fetch POST data safely
    $name = trim($_POST["voterName"] ?? '');
    $email = trim($_POST["voterEmail"] ?? '');
    $voterID = trim($_POST["voterID"] ?? '');
    $aadhar = trim($_POST["aadhar"] ?? '');
    $selection = trim($_POST["selectedCandidate"] ?? '');
    $captcha_input = trim($_POST["captcha_input"] ?? '');

    // Verify CAPTCHA
    if (empty($_SESSION['captcha']) || strcasecmp($_SESSION['captcha'], $captcha_input) != 0) {
        echo "<h3 style='color:red;'>CAPTCHA verification failed. Please <a href='vote.php'>try again</a>.</h3>";
        exit();
    }

    // Clear CAPTCHA session to prevent reuse
    unset($_SESSION['captcha']);

    // Check required fields
    if (empty($name) || empty($email) || empty($voterID) || empty($selection)) {
        echo "<h3 style='color:red;'>Missing required information. Please <a href='vote.php'>try again</a>.</h3>";
        exit();
    }

    // Check if voter has already voted
    $check_sql = "SELECT COUNT(*) AS vote_count FROM tbl_users WHERE voter_id = ?";
    $stmt_check = $conn->prepare($check_sql);
    $stmt_check->bind_param("s", $voterID);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();
    $row = $result_check->fetch_assoc();

    if ($row['vote_count'] > 0) {
        echo "<div style='text-align: center; margin-top: 50px; font-family: Arial, sans-serif;'>";
        echo "<img src='images/warning.png' width='70' height='70' alt='Warning Icon'>";
        echo "<h2 style='color: #d9534f;'>Voting Already Completed</h2>";
        echo "<p style='font-size: 16px; color: #555;'>Our records show that you have already cast your vote. Each voter is allowed to vote only once to ensure fairness and integrity.</p>";
        echo "<a href='index.php' style='display: inline-block; margin-top: 20px; padding: 10px 20px; background-color: #0275d8; color: white; text-decoration: none; border-radius: 4px;'>Return to Home</a>";
        echo "</div>";
        $stmt_check->close();
        $conn->close();
        exit();
    }

    $stmt_check->close();

    // Insert vote into database
    $sql = "INSERT INTO tbl_users (full_name, email, voter_id, aadhar, voted_for) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $name, $email, $voterID, $aadhar, $selection);

    if ($stmt->execute()) {
        echo "<div style='text-align:center; margin-top: 50px; font-family: Arial, sans-serif;'>";
        echo "<img src='images/success.png' width='70' height='70' alt='Success'>";
        echo "<h3 style='color:green;'>You have successfully voted for <strong>" . htmlspecialchars($selection) . "</strong>.</h3>";
        echo "<a href='index.php' style='display: inline-block; margin-top: 20px; padding: 10px 20px; background-color: #5cb85c; color: white; text-decoration: none; border-radius: 4px;'>Finish</a>";
        echo "</div>";
    } else {
        echo "<div style='text-align:center; margin-top: 50px; font-family: Arial, sans-serif;'>";
        echo "<img src='images/error.png' width='70' height='70' alt='Error'>";
        echo "<h3 style='color:red;'>Sorry, there was an issue saving your vote. Please try again.</h3>";
        echo "<a href='vote.php' style='display: inline-block; margin-top: 20px; padding: 10px 20px; background-color: #d9534f; color: white; text-decoration: none; border-radius: 4px;'>Try Again</a>";
        echo "</div>";
    }

    $stmt->close();
    $conn->close();
} else {
    // Invalid request method
    header("Location: vote.php");
    exit();
}
?>
