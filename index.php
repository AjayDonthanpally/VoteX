<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="icon" type="image/png" sizes="32x32" href="images/fevicon.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <style type="text/css">
        * { margin: 0; padding: 0; box-sizing: border-box; }
        .header {
            width: 100%;
            border-bottom: 2px solid #020b50;
            height: 70px;
            position: fixed;
            top: 0;
            background-color: #ffffff;
            z-index: 5;
            padding: 10px 150px;
        }
        .d_flex {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .footer {
            background-color: #020348;
            height: auto;
            bottom: 0;
            width: 100%;
            padding-top: 0.9rem;
            padding-bottom: 0.9rem;
            z-index: 5;
        }
        .footer p {
            text-align: center;
            color: white;
            margin: auto;
            padding: 0.5rem;
            font-size: 1rem;
        }
        .main_baner img {
            width: 100%;
            margin-top: 60px;
            height: 528px;
        }
        .btn_group a {
            text-decoration: none;
            background: #020348;
            padding: 10px 20px;
            border-radius: 3px;
            color: #fff;
            margin-left: 10px;
        }
        .btn_group a[style] {
            color: #fff !important;
        }
        .info-section {
            background-color: #f8f9fa;
            padding: 20px 30px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(2,3,70,0.1);
        }
        .info-section h3 {
            color: #020348;
            margin-bottom: 25px;
            font-weight: 700;
        }
        .info-section p, .info-section ul {
            font-size: 16px;
            color: #333;
            line-height: 1.6;
        }
        .info-section ul {
            list-style-type: disc;
            margin-left: 20px;
        }
        .step-circle {
            width: 60px;
            height: 60px;
            margin: 0 auto;
            background: #020348;
            color: white;
            font-size: 24px;
            font-weight: 700;
            line-height: 60px;
            border-radius: 50%;
            box-shadow: 0 0 10px rgba(2, 3, 70, 0.7);
            transition: background 0.3s ease;
        }
        .step-circle:hover {
            background: #0ec60e;
            box-shadow: 0 0 15px rgba(14, 198, 14, 0.8);
            cursor: default;
        }
        .row > .col-md-3 {
            padding-bottom: 30px;
            border-bottom: 4px solid #020348;
            position: relative;
        }
        .row > .col-md-3:not(:last-child)::after {
            content: "";
            position: absolute;
            top: 30px;
            right: 0;
            width: 100%;
            height: 4px;
            background: #020348;
            z-index: -1;
            transform: translateX(50%);
        }
        @media(max-width: 767px) {
            .row > .col-md-3:not(:last-child)::after {
                display: none;
            }
        }
        /* New styling for side-by-side info & video */
        .video-container {
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(2,3,70,0.2);
            overflow: hidden;
        }
    </style>
</head>
<body>
    <?php
// Include your DB config
include 'config.php';

// Fetch current leading party based on votes
$leadingParty = "No votes yet";

$sql = "SELECT voted_for, COUNT(*) as votes_count FROM tbl_users GROUP BY voted_for ORDER BY votes_count DESC LIMIT 1";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $partyName = htmlspecialchars($row['voted_for']);
    $votesCount = (int)$row['votes_count'];
    $leadingParty = "$partyName ($votesCount votes)";
}
echo $leadingParty;
?>

<div class="header">
    <div class="d_flex">
        <a href="index.php" class="navbar-brand headerFont text-lg">
            <img src="images/aaaa.png" height="50px" alt="Logo">
        </a>
        <div class="btn_group">
            <?php if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true): ?>
                <a href="vote.php">Click here for Online Voting</a>
                <a href="logout.php" style="background: red;">Logout</a>
            <?php else: ?>
                <a href="signin.php">Signin</a>
                <a href="signup.php">Signup</a>
            <?php endif; ?>
            <a href="admin.php" style="background: #0ec60e;">Admin</a>
        </div>
    </div>
</div>

<div class="main_baner">
    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block w-100" src="images/voter-slider2.jpg" alt="First slide">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="images/voter-helpline.jpg" alt="Second slide">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="images/voter_silde1.png" alt="Third slide">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="images/ECI.png" alt="Fourth slide">
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</div>

<div class="container" style="padding:50px;" id="aboutTab">
    <div class="row">
        <div class="col-sm-4 text-center">
            <img src="images/Nominee.png" width="100" height="100" alt="Vote Online" />
            <h2 style="font-size:28px;">VOTE ONLINE.</h2>
            <p><em>You Just Need Basic Details of Yours and We Will Let You Vote.</em></p>
        </div>
        <div class="col-sm-4 text-center">
            <img src="images/nominee.webp" width="100" height="100" alt="Nomination" />
            <a href="nomination1.php"><h2 style="color: black">Nomination</h2></a>
            <p><em>Admin's Control Panel allows you to manage nominations.</em></p>
        </div>
        <div class="col-sm-4 text-center">
            <img src="images/Stats.png" width="100" height="100" alt="Statistics" />
            <h2 style="font-size:28px;">Statistics</h2>
            <p><em>Graphical Data Representation of votes. Managed by Admin Panel.</em></p>
        </div>
    </div>
</div>

<!-- Info & Video Section with Side-by-Side Layout -->
<div class="container my-5">
  <div class="row align-items-center">
    <!-- Info Left Side -->
    <div class="col-md-6 mb-4 mb-md-0">
      <div class="info-section p-4 rounded shadow-sm bg-light">
        <h3 style="color:#020348; font-weight:700;">Why Vote Online?</h3>
        <p>Online voting offers a convenient and secure way to cast your vote from anywhere, saving you time and effort.</p>
        <p><strong>Eligibility Criteria:</strong></p>
        <ul>
          <li>You must be a registered voter in the constituency.</li>
          <li>You should be at least 18 years old.</li>
          <li>You need to provide valid identification details to verify your identity.</li>
        </ul>
        <p><strong>Security Measures:</strong></p>
        <ul>
          <li>All votes are encrypted and securely transmitted to ensure privacy.</li>
          <li>Multi-factor authentication is used to prevent unauthorized access.</li>
          <li>The system undergoes regular audits to maintain integrity and transparency.</li>
        </ul>
        <p>If you have any questions or need assistance, please contact our <a href="contact.php">support team</a>.</p>
      </div>
    </div>

    <!-- Video Right Side -->
    <div class="col-md-6">
      <div class="video-container rounded shadow-sm overflow-hidden">
        <video id="videoPlayer" controls muted preload="none" playsinline width="100%" style="border-radius: 8px;">
            <source id="videoSource" src="" type="video/mp4" />
            Your browser does not support the video tag.
        </video>
      </div>
    </div>
  </div>
</div>

<!-- Current Leading Party Section -->
<div class="container my-5">
    <h3 class="text-center mb-4" style="color:#020348; font-weight:700;">Current Leading Party</h3>
    <div class="row justify-content-center">
        <div class="col-md-6 text-center">
            <div style="border: 2px solid #020348; padding: 20px; border-radius: 10px; box-shadow: 0 4px 12px rgba(2,3,70,0.3); background-color: #f1f1f1;">
                <h4 style="color: #0ec60e; font-weight: bold;">
                    <?php echo $leadingParty; ?>
                </h4>
                <p style="font-size: 16px; color: #333;">This party currently has the highest number of votes in real time.</p>
            </div>
        </div>
    </div>
</div>

<!-- How It Works Timeline Section -->
<div class="container my-5">
    <h3 class="text-center mb-4" style="color:#020348; font-weight:700;">How It Works</h3>
    <div class="row">
        <div class="col-md-3 text-center">
            <div class="step-circle">1</div>
            <h5 class="mt-3">Register</h5>
            <p>Create your voter profile using your unique ID and basic information.</p>
        </div>
        <div class="col-md-3 text-center">
            <div class="step-circle">2</div>
            <h5 class="mt-3">Verify</h5>
            <p>Verify your identity with OTP or biometric authentication for security.</p>
        </div>
        <div class="col-md-3 text-center">
            <div class="step-circle">3</div>
            <h5 class="mt-3">Choose Candidate</h5>
            <p>Browse the list of nominees and select your preferred candidate.</p>
        </div>
        <div class="col-md-3 text-center">
            <div class="step-circle">4</div>
            <h5 class="mt-3">Cast Vote</h5>
            <p>Submit your vote securely. You’ll receive confirmation immediately.</p>
        </div>
    </div>
</div>

<!-- Footer -->
<div class="footer">
    <p>Copyright © 2025 Unique Identification Authority of India All Rights Reserved</p>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>

<script>
    const playlist = [
"https://cdnl.iconscout.com/lottie/premium/thumb/man-creating-account-animation-download-in-lottie-json-gif-static-svg-file-formats--sign-up-form-add-pack-user-interface-animations-6716088.mp4",       
        "https://cdnl.iconscout.com/lottie/premium/thumb/sign-up-login-animation-download-in-lottie-json-gif-static-svg-file-formats--user-create-account-log-pack-interface-animations-6716091.mp4",
        "https://cdnl.iconscout.com/lottie/premium/thumb/sign-in-animation-download-lottie-json-gif-static-svg-file-formats--login-enter-log-cyber-protection-account-nallow-pack-miscellaneous-animations-7035839.mp4",
        "https://cdnl.iconscout.com/lottie/premium/thumb/login-animation-download-in-lottie-json-gif-static-svg-file-formats--sign-profile-password-account-access-scooby-illustrations-pack-miscellaneous-animations-5455225.mp4",
        "https://cdnl.iconscout.com/lottie/premium/thumb/girl-is-voting-online-animation-download-in-lottie-json-gif-static-svg-file-formats--dropping-vote-election-and-day-pack-politics-animations-8424618.mp4",
        "https://cdnl.iconscout.com/lottie/premium/thumb/online-voting-12847029-10486922.mp4",
        "https://cdnl.iconscout.com/lottie/premium/thumb/boy-and-a-girl-are-voting-animation-download-in-lottie-json-gif-static-svg-file-formats--online-election-vote-day-pack-politics-animations-8424611.mp4",
        "https://cdnl.iconscout.com/lottie/premium/thumb/account-verified-animated-icon-download-in-lottie-json-gif-static-svg-file-formats--user-profile-approved-interaction-assets-pack-miscellaneous-icons-9975033.mp4"

    ];

    let currentIndex = 0;
    const videoPlayer = document.getElementById('videoPlayer');
    const videoSource = document.getElementById('videoSource');

    function loadVideo(index) {
        videoSource.src = playlist[index];
        videoPlayer.load();
        videoPlayer.play();
    }

    videoPlayer.addEventListener('ended', () => {
        currentIndex = (currentIndex + 1) % playlist.length;
        loadVideo(currentIndex);
    });

    // Initialize first video on page load
    loadVideo(currentIndex);
</script>

</body>
</html>
