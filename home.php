<?php
session_start();

if (!isset($_SESSION['full_name'])) {
    header("Location: signin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Welcome - National eVoting Portal</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="icon" href="images/fevicon.png" type="image/png">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />

  <style>
    body {
      font-family: "Roboto", sans-serif;
      background-color: #f1f1f1;
      padding-top: 70px;
    }
    .navbar {
      background-color: #00274d;
    }
    .navbar-brand {
      font-weight: bold;
      color: #ffc107 !important;
    }
    .hero-section {
      background-color: #003366;
      color: white;
      padding: 40px 0;
      text-align: center;
    }
    .card {
      border: none;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    footer {
      background-color: #00274d;
      color: #ccc;
      text-align: center;
      padding: 15px 0;
      margin-top: 180px;
    }

    .main-row {
      display: flex;
      justify-content: center;
      gap: 30px;
      margin-top: 40px;
      flex-wrap: wrap;
    }

    .left-panel {
      flex: 1 1 400px;
      max-width: 600px;
    }

    .right-panel {
      flex: 1 1 300px;
      max-width: 400px;
      background: white;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      padding: 20px;
      text-align: center;
    }

    .video-container {
      position: relative;
      padding-bottom: 56.25%;
      height: 0;
    }

    .video-container video {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      border-radius: 8px;
    }

    #notification-icon, #contact-icon {
      position: fixed;
      bottom: 30px;
      width: 48px;
      height: 48px;
      font-size: 28px;
      color: #fff;
      border-radius: 50%;
      display: flex;
      justify-content: center;
      align-items: center;
      cursor: pointer;
      box-shadow: 0 4px 8px rgba(0,0,0,0.2);
      z-index: 1100;
      user-select: none;
    }

    #notification-icon.not-voted {
      right: 30px;
      background-color: #dc3545;
    }
    #notification-icon.voted {
      right: 30px;
      background-color: #ffc107;
      color: #00274d;
    }

    #contact-icon {
      left: 30px;
      background-color: #17a2b8;
    }

    #notification-message, #contact-message {
      position: fixed;
      background: white;
      border-radius: 10px;
      padding: 15px 20px;
      width: 320px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.15);
      display: none;
      z-index: 1100;
      font-weight: 500;
      color: #333;
    }

    #notification-message {
      bottom: 90px;
      right: 30px;
    }

    #contact-message {
      bottom: 90px;
      left: 30px;
      border: 2px solid #17a2b8;
    }

    .close-msg {
      position: absolute;
      top: 5px;
      right: 10px;
      background: transparent;
      border: none;
      font-size: 18px;
      cursor: pointer;
      color: #888;
    }

    .close-msg:hover {
      color: #444;
    }

    .vote-float {
      position: fixed;
      font-size: 32px;
      z-index: 1050;
      pointer-events: none;
      transition: transform 1s ease-in-out, opacity 1s ease-in-out;
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
  <div class="container">
    <a class="navbar-brand" href="#">National eVoting Portal</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ml-auto align-items-center">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle btn btn-outline-light mr-2" href="#" id="userDropdown" role="button" data-toggle="dropdown">
            👤 <?= htmlspecialchars($_SESSION['full_name']) ?>
          </a>
          <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item" href="profile.php">View Profile</a>
          </div>
        </li>
        <li class="nav-item">
          <a href="logout.php" class="btn btn-danger">Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<?php if (isset($_SESSION['has_voted']) && $_SESSION['has_voted']): ?>
  <div id="notification-icon" class="voted" title="Thank you for voting!">✔️</div>
  <div id="notification-message" class="voted">
    <button class="close-msg" aria-label="Close">&times;</button>
    <p>Thank you for completing your vote!</p>
  </div>
<?php else: ?>
  <div id="notification-icon" class="not-voted" title="You have a pending vote!">⚠️</div>
  <div id="notification-message" class="not-voted">
    <button class="close-msg" aria-label="Close">&times;</button>
    <p><strong>Reminder:</strong> You haven't voted yet! Please cast your vote now.</p>
    <a href="vote.php" class="btn btn-primary btn-block">🗳️ Vote Now</a>
  </div>
<?php endif; ?>

<!-- Contact Us Floating Message -->
<div id="contact-icon" title="Need Help? Contact Us">📞</div>
<div id="contact-message">
  <button class="close-msg" aria-label="Close">&times;</button>
  <p><strong>Need assistance?</strong> Our support team is here to help.</p>
  <a href="contact.php" class="btn btn-info btn-block">Contact Us</a>
</div>

<!-- Hero Section -->
<section class="hero-section">
  <div class="container">
    <h1>Welcome, <?= htmlspecialchars($_SESSION['full_name']) ?>!</h1>
    <p>Secure access to your national voting platform</p>
  </div>
</section>

<!-- Main Content -->
<div class="container main-row">
  <div class="left-panel">
    <div class="card p-4 text-center bg-white">
      <h3>User Information</h3>
      <p><strong>Full Name:</strong> <?= htmlspecialchars($_SESSION['full_name']) ?></p>
      <p><strong>Email:</strong> <?= htmlspecialchars($_SESSION['email']) ?></p>
      <a href="vote.php" class="btn btn-primary btn-block">🗳️ Cast Your Vote</a>
    </div>
  </div>

  <div class="right-panel">
    <div class="video-container">
      <video autoplay muted loop playsinline>
        <source src="https://cdnl.iconscout.com/lottie/premium/thumb/digital-voting-animated-icon-download-in-lottie-json-gif-static-svg-file-formats--e-electronic-online-customer-survey-pack-miscellaneous-icons-9802872.mp4" type="video/mp4" />
        Your browser does not support the video tag.
      </video>
    </div>
  </div>
</div>

<footer>
  <div class="container">
    &copy; <?= date("Y") ?> National Electoral Commission. All rights reserved.
  </div>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
  document.querySelector("a.btn-primary").addEventListener("click", function (event) {
    event.preventDefault();
    const voteButton = event.currentTarget;
    const buttonRect = voteButton.getBoundingClientRect();
    const videoPanel = document.querySelector('.right-panel');
    const boxRect = videoPanel.getBoundingClientRect();

    const voteFloat = document.createElement("div");
    voteFloat.classList.add("vote-float");
    voteFloat.textContent = "🗳️";
    document.body.appendChild(voteFloat);

    voteFloat.style.left = buttonRect.left + buttonRect.width / 2 + "px";
    voteFloat.style.top = buttonRect.top + buttonRect.height / 2 + "px";
    voteFloat.style.opacity = "1";
    voteFloat.style.transform = "translate(0, 0) scale(1)";

    const translateX = boxRect.left + boxRect.width / 2 - (buttonRect.left + buttonRect.width / 2);
    const translateY = boxRect.top + boxRect.height / 2 - (buttonRect.top + buttonRect.height / 2);

    requestAnimationFrame(() => {
      voteFloat.style.transform = `translate(${translateX}px, ${translateY}px) scale(0.5)`;
      voteFloat.style.opacity = "0.5";
    });

    voteFloat.addEventListener("transitionend", () => {
      voteFloat.remove();
      window.location.href = voteButton.href;
    }, { once: true });
  });

  // Notification toggles
  document.getElementById('notification-icon')?.addEventListener('click', () => {
    const msg = document.getElementById('notification-message');
    msg.style.display = msg.style.display === 'block' ? 'none' : 'block';
  });

  document.querySelector('#notification-message .close-msg')?.addEventListener('click', () => {
    document.getElementById('notification-message').style.display = 'none';
  });

  // Contact Us toggles
  document.getElementById('contact-icon')?.addEventListener('click', () => {
    const msg = document.getElementById('contact-message');
    msg.style.display = msg.style.display === 'block' ? 'none' : 'block';
  });

  document.querySelector('#contact-message .close-msg')?.addEventListener('click', () => {
    document.getElementById('contact-message').style.display = 'none';
  });
</script>
</body>
</html>
