<?php
session_start();
include 'config.php';

if (!isset($_SESSION['full_name'])) {
    header("Location: signin.php");
    exit();
}

$email = $_SESSION['email'] ?? '';
$sql = "SELECT name, email, phone, voterid, aadhaar FROM voters WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows == 1) {
    $user = $result->fetch_assoc();
} else {
    echo "Error: User not found.";
    exit();
}
$stmt->close();
$conn->close();

// Check for success message trigger
$successMsg = '';
if (isset($_GET['updated']) && $_GET['updated'] === 'true') {
    $successMsg = "Your data has been updated successfully.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>My Profile</title>
    <link rel="icon" href="images/fevicon.png" type="image/png">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            color: #fff;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        .container {
            width: 100%;
            max-width: 900px;
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            padding: 30px;
            color: #333;
            position: relative;
        }
        header {
            text-align: center;
            margin-bottom: 20px;
        }
        header h1 {
            font-size: 36px;
            color: #4B0082;
        }
        .profile-header {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 30px;
            background-color: #f0f0f0;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .profile-header img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 25px;
        }
        .profile-header div {
            flex: 1;
        }
        .profile-header h2 {
            font-size: 28px;
            margin: 0;
            font-weight: bold;
        }
        .profile-header p {
            font-size: 16px;
            color: #888;
            margin-top: 5px;
        }
        .profile-details {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }
        .profile-details div {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .profile-details h3 {
            font-size: 20px;
            color: #4B0082;
            margin-bottom: 15px;
        }
        .profile-details p {
            font-size: 16px;
            color: #555;
        }
        .back-btn {
            position: absolute;
            top: 20px;
            left: 20px;
            background-color: #4B0082;
            color: white;
            padding: 10px 20px;
            border-radius: 30px;
            text-decoration: none;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        .back-btn:hover {
            background-color: #3a0068;
        }
        footer {
            margin-top: 30px;
            text-align: center;
            padding: 15px;
            background-color: #333;
            color: white;
            border-radius: 0 0 15px 15px;
        }
        footer p {
            margin: 0;
            font-size: 14px;
        }
        input[type="text"], input[type="email"] {
            width: 100%;
            padding: 8px;
            font-size: 16px;
            margin-top: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .success-msg {
            color: green;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            padding: 15px;
            border-radius: 8px;
        }
        button {
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="container">
    <a href="home.php" class="back-btn">Back</a>

    <header>
        <h1>Voter Profile</h1>
    </header>

    <!-- Success message box -->
    <?php if ($successMsg): ?>
        <div class="success-msg"><?= htmlspecialchars($successMsg) ?></div>
    <?php endif; ?>

    <div class="profile-header">
        <img src="images/default-user.png" alt="User Avatar" />
        <div>
            <h2><?= htmlspecialchars($user['name']) ?></h2>
            <p><?= htmlspecialchars($user['email']) ?></p>
        </div>
    </div>

    <div class="profile-details">
        <div>
            <h3>Contact Info</h3>
            <p><strong>Phone:</strong> <?= htmlspecialchars($user['phone']) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
        </div>
        <div>
            <h3>Identification</h3>
            <p><strong>Voter ID:</strong> <?= htmlspecialchars($user['voterid']) ?></p>
            <p><strong>Aadhaar:</strong> <?= htmlspecialchars($user['aadhaar']) ?></p>
        </div>
    </div>

    <div style="text-align: center; margin-top: 20px;">
        <button id="editBtn" style="padding: 10px 20px; background-color: #4B0082; color: white; border: none; border-radius: 5px;">Edit Profile</button>
    </div>

    <form id="editForm" action="update_profile.php" method="POST" style="display: none; margin-top: 30px;">
        <div class="profile-details">
            <div>
                <h3>Edit Contact Info</h3>
                <p><strong>Phone:</strong><br><input type="text" name="phone" value="<?= htmlspecialchars($user['phone']) ?>" required></p>
                <p><strong>Email:</strong><br><input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" readonly></p>
            </div>
            <div>
                <h3>Edit Identification</h3>
                <p><strong>Voter ID:</strong><br><input type="text" name="voterid" value="<?= htmlspecialchars($user['voterid']) ?>" required></p>
                <p><strong>Aadhaar:</strong><br><input type="text" name="aadhaar" value="<?= htmlspecialchars($user['aadhaar']) ?>" required></p>
            </div>
        </div>
        <div style="text-align: center; margin-top: 20px;">
            <button type="submit" style="padding: 10px 20px; background-color: #2575fc; color: white; border: none; border-radius: 5px;">Save Changes</button>
        </div>
    </form>
</div>

<footer>
    <p>&copy; <?= date("Y") ?> Your Election Portal. All Rights Reserved.</p>
</footer>

<script>
    document.getElementById("editBtn").addEventListener("click", function () {
        document.getElementById("editForm").style.display = "block";
        this.style.display = "none";
    });

    <?php if ($successMsg): ?>
        alert("<?= addslashes($successMsg) ?>");
    <?php endif; ?>
</script>

</body>
</html>
