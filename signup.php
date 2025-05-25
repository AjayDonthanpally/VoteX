<?php
session_start();
include 'config.php';

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name     = trim($_POST["name"]);
    $email    = trim($_POST["email"]);
    $phone    = trim($_POST["phone"]);
    $voterid  = trim($_POST["voterid"]);
    $aadhaar  = trim($_POST["aadhaar"]);
    $password = trim($_POST["password"]);
    $cpass    = trim($_POST["confirm_password"]);

    if ($password !== $cpass) {
        $errors[] = "Passwords do not match.";
    } else {
        $stmt = $conn->prepare("SELECT id FROM voters WHERE email = ? OR voterid = ?");
        $stmt->bind_param("ss", $email, $voterid);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $errors[] = "Email or Voter ID already registered.";
        } else {
            $stmt = $conn->prepare("INSERT INTO voters (name, email, phone, voterid, aadhaar, password) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $name, $email, $phone, $voterid, $aadhaar, $password);

            if ($stmt->execute()) {
                $_SESSION['full_name'] = $name;
                $_SESSION['email']     = $email;
                $_SESSION['voter_id']  = $voterid;
                $_SESSION['password']  = $password;
                $_SESSION['aadhar']    = $aadhaar;
                header("Location: home.php");
                exit;
            } else {
                $errors[] = "Error registering user.";
            }
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Signup - Online Voting System</title>
  <link rel="icon" href="images/fevicon.png" type="image/png"> 
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background: #e8eef7;
      font-family: Arial, sans-serif;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 40px 10px;
    }
    .signup-container {
      background: #bccbda;
      border-radius: 10px;
      box-shadow: 0 6px 15px rgba(0,0,0,0.1);
      max-width: 900px;
      width: 100%;
      display: flex;
      overflow: hidden;
    }
    .form-side {
      flex: 1 1 400px;
      padding: 40px 35px;
      background: #ffffff;
    }
    .form-side h2 {
      margin-bottom: 25px;
      font-weight: 700;
      color: #003366;
    }
    .form-group label {
      font-weight: 600;
    }
    .btn-primary {
      background-color: #003366;
      border: none;
      font-weight: 600;
      padding: 12px;
      width: 100%;
      border-radius: 5px;
    }
    .btn-primary:hover {
      background-color: #002244;
    }
    .video-side {
      flex: 1 1 400px;
      background: #5c8dbe;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 30px;
    }
    .video-side video {
      border-radius: 15px;
      max-width: 100%;
      height: auto;
      box-shadow: 0 8px 20px rgba(0,0,0,0.25);
    }
    .alert-danger p {
      margin: 0;
    }
    .login-link {
      display: block;
      margin-top: 15px;
      text-align: center;
      color: #3073b6;
      font-weight: 600;
    }
    .login-link:hover {
      text-decoration: underline;
    }
    @media (max-width: 768px) {
      .signup-container {
        flex-direction: column;
      }
      .video-side {
        order: -1;
        padding: 20px 30px 0 30px;
      }
      .form-side {
        padding: 30px 25px;
      }
    }
  </style>
</head>
<body>

<div class="signup-container shadow-sm">
  <div class="form-side">
    <h2>Voter Registration</h2>

    <?php if (!empty($errors)): ?>
      <div class="alert alert-danger" role="alert">
        <?php foreach ($errors as $e) echo "<p>$e</p>"; ?>
      </div>
    <?php endif; ?>

    <form method="POST" novalidate>
      <div class="form-group">
        <label for="name">Full Name</label>
        <input id="name" type="text" name="name" class="form-control" required />
      </div>
      <div class="form-group">
        <label for="email">Email address</label>
        <input id="email" type="email" name="email" class="form-control" required />
      </div>
      <div class="form-group">
        <label for="phone">Phone number</label>
        <input id="phone" type="text" name="phone" class="form-control" required />
      </div>
      <div class="form-group">
        <label for="voterid">Voter ID</label>
        <input id="voterid" type="text" name="voterid" class="form-control" required />
      </div>
      <div class="form-group">
        <label for="aadhaar">Aadhaar No</label>
        <input id="aadhaar" type="text" name="aadhaar" class="form-control" required />
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input id="password" type="password" name="password" class="form-control" required />
      </div>
      <div class="form-group">
        <label for="confirm_password">Confirm Password</label>
        <input id="confirm_password" type="password" name="confirm_password" class="form-control" required />
      </div>

      <button type="submit" class="btn btn-primary">Register</button>
      <a href="signin.php" class="login-link">Already registered? Login here</a>
    </form>
  </div>

  <div class="video-side">
    <video id="videoPlayer" autoplay muted playsinline></video>
  </div>
</div>

<script>
  const playlist = [
    "https://cdnl.iconscout.com/lottie/premium/thumb/man-creating-account-animation-download-in-lottie-json-gif-static-svg-file-formats--sign-up-form-add-pack-user-interface-animations-6716088.mp4",
    "https://cdnl.iconscout.com/lottie/premium/thumb/new-user-sign-up-animation-download-in-lottie-json-gif-static-svg-file-formats--creating-account-man-form-add-pack-interface-animations-6716093.mp4",
    "https://cdnl.iconscout.com/lottie/premium/thumb/online-registration-form-animation-download-in-lottie-json-gif-static-svg-file-formats--sign-up-form-add-pack-user-interface-animations-6716090.mp4",
    "https://cdnl.iconscout.com/lottie/premium/thumb/sign-up-animation-download-in-lottie-json-gif-static-svg-file-formats--form-add-account-login-successful-creating-pack-user-interface-animations-6716092.mp4",
    "https://cdnl.iconscout.com/lottie/premium/thumb/sign-up-form-animation-download-in-lottie-json-gif-static-svg-file-formats--man-creating-account-add-login-successful-pack-user-interface-animations-6716089.mp4",
    "https://cdnl.iconscout.com/lottie/premium/thumb/sign-up-login-animation-download-in-lottie-json-gif-static-svg-file-formats--user-create-account-log-pack-interface-animations-6716091.mp4"
  ];

  let currentIndex = 0;
  const video = document.getElementById("videoPlayer");

  function playNextVideo() {
    video.src = playlist[currentIndex];
    video.load();
    video.play();
    currentIndex = (currentIndex + 1) % playlist.length;
  }

  video.addEventListener("ended", playNextVideo);
  playNextVideo(); // Start with the first video
</script>

</body>
</html>
