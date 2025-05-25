<?php
session_start();
include 'config.php';

// Simple admin authentication - customize as needed
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    // Redirect to admin login or home if not admin
    header("Location: admin_login.php");
    exit();
}

// Fetch votes
$sql = "SELECT full_name, email, voter_id, aadhar, voted_for, vote_time FROM tbl_users ORDER BY vote_time DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Admin Panel - Votes</title>
<link rel="icon" href="images/fevicon.png" type="image/png">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" />
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Admin Panel - Votes Summary</h2>
    <a href="logout.php" class="btn btn-danger mb-3">Logout</a>
    
    <?php if ($result->num_rows > 0): ?>
    <table class="table table-striped table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>Voter Name</th>
                <th>Email</th>
                <th>Voter ID</th>
                <th>Aadhaar</th>
                <th>Voted For</th>
                <th>Time</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['full_name']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= htmlspecialchars($row['voter_id']) ?></td>
                <td><?= htmlspecialchars($row['aadhar']) ?></td>
                <td><?= htmlspecialchars($row['voted_for']) ?></td>
                <td><?= htmlspecialchars($row['vote_time']) ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <?php else: ?>
        <div class="alert alert-info">No votes recorded yet.</div>
    <?php endif; ?>
</div>
</body>
</html>

<?php $conn->close(); ?>
