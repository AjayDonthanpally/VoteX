<?php
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login_form.php");
    exit();
}

// Include DB config
require_once 'config.php';

// Fetch total votes (users who have voted)
$sqlVotes = "SELECT COUNT(*) AS total FROM tbl_users WHERE voted_for IS NOT NULL";
$resultVotes = $conn->query($sqlVotes);
$rowVotes = $resultVotes->fetch_assoc();
$totalVotes = $rowVotes['total'];

// Fetch total users (from voters table)
$sqlUsers = "SELECT COUNT(*) AS total FROM voters";
$resultUsers = $conn->query($sqlUsers);
$rowUsers = $resultUsers->fetch_assoc();
$totalUsers = $rowUsers['total'];

// Fetch pending votes (users who have not yet voted)
$sqlPending = "SELECT COUNT(*) AS total FROM tbl_users WHERE voted_for IS NULL";
$resultPending = $conn->query($sqlPending);
$rowPending = $resultPending->fetch_assoc();
$pendingVotes = $rowPending['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="icon" href="images/fevicon.png" type="image/png">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .sidebar {
            height: 100vh;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #343a40;
            padding-top: 20px;
        }
        .sidebar a {
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            display: block;
        }
        .sidebar a:hover {
            background-color: rgb(116, 132, 148);
        }
        .content {
            margin-left: 260px;
            padding: 20px;
        }
        .card {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h3 class="text-white text-center">Admin Panel</h3>
        <a href="admin_dashboard.php">Dashboard</a>
        <a href="manage_parties.php">Manage Parties</a>
        <a href="manage_votes.php">Manage Votes</a>
        <a href="manage_users.php">Manage Users</a>
        <a href="changePassword.php">Change Password</a>
        <a href="cpanel.php">View Results</a>
        <a href="logout.php">Logout</a>
    </div>

    <!-- Main Content -->
    <div class="content">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">Admin Dashboard</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="#">Welcome, <?php echo htmlspecialchars($_SESSION['admin_username']); ?></a>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="container mt-4">
            <div class="row">
                <div class="col-md-3">
                    <div class="card text-white bg-primary">
                        <div class="card-body">
                            <h5 class="card-title">Total Votes</h5>
                            <p class="card-text"><?php echo $totalVotes; ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-success">
                        <div class="card-body">
                            <h5 class="card-title">Total Users</h5>
                            <p class="card-text"><?php echo $totalUsers; ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-warning">
                        <div class="card-body">
                            <h5 class="card-title">Pending Votes</h5>
                            <p class="card-text"><?php echo $pendingVotes; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
