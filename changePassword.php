<?php
session_start();

// Include database configuration
require_once 'config.php';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        // --- Option 1: Store plain password (NOT RECOMMENDED) ---
        $stored_password = $new_password;

        // --- Option 2: Use MD5 hash (slightly better, still NOT secure) ---
        // $stored_password = md5($new_password);

        // Update in the database
        $stmt = $conn->prepare("UPDATE admins SET password = ? WHERE username = ?");
        $stmt->bind_param("ss", $stored_password, $username);

        if ($stmt->execute()) {
            $success = "Password changed successfully!";
        } else {
            $error = "Error updating password.";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Change Password</title>
  <link rel="icon" href="images/fevicon.png" type="image/png">
  <link href="css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background: #f4f6f9;
      font-family: Arial, sans-serif;
      padding-top: 80px;
    }
    .container {
      max-width: 400px;
      margin: auto;
      background: #fff;
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    h2 {
      text-align: center;
      margin-bottom: 20px;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Change Password</h2>
    <?php if (!empty($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
    <?php if (!empty($success)) echo "<div class='alert alert-success'>$success</div>"; ?>

    <form method="POST" action="">
      <div class="form-group">
        <label for="username">Username</label>
        <input required type="text" name="username" class="form-control" placeholder="Enter your username" />
      </div>
      <div class="form-group">
        <label for="new_password">New Password</label>
        <input required type="password" name="new_password" class="form-control" placeholder="New password" />
      </div>
      <div class="form-group">
        <label for="confirm_password">Confirm New Password</label>
        <input required type="password" name="confirm_password" class="form-control" placeholder="Confirm new password" />
      </div>
      <button type="submit" class="btn btn-primary btn-block mt-3">Change Password</button>
    </form>
    <div class="text-center mt-3">
  <a href="admin_login.php" class="btn btn-secondary">Back to Login</a>
</div>
  </div>
</body>
</html>
