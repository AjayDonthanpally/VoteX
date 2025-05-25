<?php
session_start();
include 'config.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email    = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    $stmt = $conn->prepare("SELECT * FROM voters WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        $_SESSION['full_name'] = $user['name'];
        $_SESSION['email']     = $user['email'];
        $_SESSION['voter_id']  = $user['voterid'];
        $_SESSION['password']  = $user['password'];
        $_SESSION['aadhar']    = $user['aadhaar'];
        header("Location: home.php");
        exit;
    } else {
        $error = "Invalid credentials!";
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Login - Online Voting System</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="icon" href="images/fevicon.png" type="image/png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background-color: #f0f4f8;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      font-family: 'Segoe UI', sans-serif;
    }

    .container-box {
      display: flex;
      max-width: 900px;
      width: 100%;
      background: #ffffff;
      border-radius: 12px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
      overflow: hidden;
    }

    .login-form-side {
      flex: 1;
      padding: 40px;
    }

    .video-side {
      flex: 1;
      background-color: #3498db;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 30px;
    }

    .video-side video {
      max-width: 100%;
      border-radius: 12px;
      box-shadow: 0 6px 12px rgba(0,0,0,0.2);
    }

    h2 {
      color: #2c3e50;
      font-weight: 600;
      margin-bottom: 25px;
    }

    .form-control {
      border-radius: 8px;
      padding: 10px;
    }

    .btn-login {
      background-color: #3498db;
      color: white;
      font-weight: 600;
      border-radius: 8px;
      padding: 10px;
      width: 100%;
    }

    .btn-login:hover {
      background-color: #2980b9;
    }

    .form-footer {
      margin-top: 15px;
      text-align: center;
    }

    .alert {
      font-size: 14px;
    }

    @media (max-width: 768px) {
      .container-box {
        flex-direction: column;
      }

      .video-side {
        order: -1;
        padding: 20px;
      }

      .login-form-side {
        padding: 30px 20px;
      }
    }
  </style>
</head>
<body>

<div class="container-box">
  <div class="login-form-side">
    <h2 class="text-center">Voter Login</h2>

    <?php if ($error): ?>
      <div class="alert alert-danger text-center"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
      <div class="mb-3">
        <label for="email" class="form-label">Email address</label>
        <input type="email" class="form-control" id="email" name="email" required autofocus>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" required>
        <div class="text-end">
          <a href="reset_password.php" style="font-size: 14px;">Forgot password?</a>
        </div>
      </div>
      <button type="submit" class="btn btn-login">Login</button>
      <div class="form-footer">
        <a href="signup.php">New user? Register here</a>
      </div>
    </form>
  </div>

  <div class="video-side">
    <video id="loginVideo" autoplay muted playsinline></video>
  </div>
</div>

<script>
  const videoElement = document.getElementById('loginVideo');
  const sources = [
 "https://cdnl.iconscout.com/lottie/premium/thumb/signin-14028046-11286261.mp4" ,
 "https://cdnl.iconscout.com/lottie/premium/thumb/boy-using-laptop-to-sign-into-an-account-animation-download-in-lottie-json-gif-static-svg-file-formats--signing-signin-and-registration-pack-user-interface-animations-9822917.mp4",
 "https://cdnl.iconscout.com/lottie/premium/thumb/sign-in-animation-download-lottie-json-gif-static-svg-file-formats--login-enter-log-cyber-protection-account-nallow-pack-miscellaneous-animations-7035839.mp4",
 "https://cdnl.iconscout.com/lottie/premium/thumb/login-animation-download-in-lottie-json-gif-static-svg-file-formats--sign-profile-password-account-access-scooby-illustrations-pack-miscellaneous-animations-5455225.mp4",
 "https://cdnl.iconscout.com/lottie/premium/thumb/sign-in-animated-icon-download-lottie-json-gif-static-svg-file-formats--signin-text-button-animation-login-pack-user-interface-icons-6597694.mp4"
  ];

  let currentIndex = 0;

  function playNextVideo() {
    videoElement.src = sources[currentIndex];
    videoElement.load();
    videoElement.play();
    currentIndex = (currentIndex + 1) % sources.length;
  }

  videoElement.addEventListener('ended', playNextVideo);
  playNextVideo();
</script>

</body>
</html>
