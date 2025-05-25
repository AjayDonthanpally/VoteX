<?php
session_start();
require_once 'config.php';

$successMsg = "";
$errorMsg = "";
$name = $email = $message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if (empty($name) || empty($email) || empty($message)) {
        $errorMsg = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorMsg = "Please enter a valid email address.";
    } else {
        if ($conn->connect_error) {
            $errorMsg = "Database connection failed: " . $conn->connect_error;
        } else {
            $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, message, submitted_at) VALUES (?, ?, ?, NOW())");
            if ($stmt === false) {
                $errorMsg = "Failed to prepare statement: " . htmlspecialchars($conn->error);
            } else {
                $stmt->bind_param("sss", $name, $email, $message);
                if ($stmt->execute()) {
                    $successMsg = "Thank you for contacting us. We will get back to you soon.";
                    $name = $email = $message = "";
                } else {
                    $errorMsg = "Failed to submit your message. Please try again later.";
                }
                $stmt->close();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Contact Us - Unique Identification Authority of India</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="icon" href="images/fevicon.png" type="image/png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <style>
        body {
            padding-top: 80px;
            background-color: #f4f6f9;
        }
        .contact-wrapper {
            max-width: 1000px;
            margin: auto;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(2,3,70,0.1);
            overflow: hidden;
        }
        .contact-row {
            display: flex;
            flex-wrap: wrap;
        }
        .video-col {
            flex: 1 1 50%;
            background-color: #f9f9f9;
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .video-col video {
            width: 100%;
            height: auto;
            border-radius: 8px;
            object-fit: cover;
        }
        .form-col {
            flex: 1 1 50%;
            padding: 30px;
        }
        .header-contact {
            text-align: center;
            color: #020348;
            font-weight: 700;
            margin-bottom: 20px;
        }
        .btn-primary {
            background-color: #020348;
            border-color: #020348;
        }
        .btn-primary:hover {
            background-color: #0ec60e;
            border-color: #0ec60e;
        }
        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
            color: #fff;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #545b62;
            color: #fff;
        }
        @media (max-width: 768px) {
            .video-col, .form-col {
                flex: 1 1 100%;
            }
        }
    </style>
</head>
<body>

<div class="contact-wrapper">
    <div class="contact-row">
        <!-- Left Side: Video -->
        <div class="video-col">
            <video autoplay muted loop playsinline>
                <source src="https://cdnl.iconscout.com/lottie/premium/thumb/contact-us-animation-download-in-lottie-json-gif-static-svg-file-formats--call-logo-communication-phone-support-nallow-pack-people-animations-7065033.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>

        <!-- Right Side: Form -->
        <div class="form-col">
            <h2 class="header-contact">Contact Us</h2>

            <?php if ($successMsg): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($successMsg); ?></div>
            <?php endif; ?>

            <?php if ($errorMsg): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($errorMsg); ?></div>
            <?php endif; ?>

            <form method="POST" action="contact.php" novalidate>
                <div class="form-group">
                    <label for="name">Name <span style="color:red">*</span></label>
                    <input type="text" name="name" id="name" class="form-control" value="<?php echo htmlspecialchars($name); ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email <span style="color:red">*</span></label>
                    <input type="email" name="email" id="email" class="form-control" value="<?php echo htmlspecialchars($email); ?>" required>
                </div>
                <div class="form-group">
                    <label for="message">Message <span style="color:red">*</span></label>
                    <textarea name="message" id="message" rows="5" class="form-control" required><?php echo htmlspecialchars($message); ?></textarea>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Send Message</button>
                <a href="index.php" class="btn btn-secondary btn-block mt-2">Back</a>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>

</body>
</html>
