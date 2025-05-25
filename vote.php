<?php
session_start();
include "config.php";

if (!isset($_SESSION['full_name'])) {
    header("Location: signin.php");
    exit();
}

$username = $_SESSION['full_name'];
$email = $_SESSION['email'];
$voter_id = $_SESSION['voter_id'];
$aadhar = $_SESSION['aadhar'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Cast Your Vote</title>
  <link rel="icon" href="images/fevicon.png" type="image/png">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <style>
    .party-symbol {
      width: 100px;
      height: 100px;
      cursor: pointer;
      margin: 10px;
      border: 2px solid #ccc;
      border-radius: 8px;
      object-fit: contain;
    }
    .candidate-info {
      display: none;
      margin-top: 20px;
      padding: 20px;
      border: 1px solid #ccc;
      border-radius: 8px;
      background-color: #f9f9f9;
    }
    .candidate-info img {
      margin-bottom: 10px;
      max-width: 100%;
      max-height: 150px;
    }
    .selected {
      border: 4px solid green;
      box-shadow: 0 0 10px green;
    }
    #captchaImage {
      display: block;
      width: auto;
      height: auto;
      max-width: 100%;
      max-height: 150px;
      margin-bottom: 10px;
      border: 1px solid #ccc;
      user-select: none;
    }
    .form-group {
      overflow: visible;
    }
  </style>
</head>
<body>

<div class="container">
  <nav class="navbar navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="home.php">eVoting</a>
  </nav>

  <div class="container" style="padding-top:100px;">
    <div class="row">
      <div class="col-md-12">
        <div class="page-header text-center">
          <h2>Telangana Legislative Assembly Elections</h2>
          <h4>Cast Your Vote</h4>
        </div>

        <form action="saveVote.php" method="POST">
          <input type="hidden" name="voterName" value="<?= htmlspecialchars($username) ?>">
          <input type="hidden" name="voterEmail" value="<?= htmlspecialchars($email) ?>">
          <input type="hidden" name="voterID" value="<?= htmlspecialchars($voter_id) ?>">
          <input type="hidden" name="aadhar" value="<?= htmlspecialchars($aadhar) ?>">

          <!-- CAPTCHA -->
          <div class="form-group">
            <label>Enter CAPTCHA:</label><br>
            <img src="captcha.php" alt="CAPTCHA" id="captchaImage">
            <a href="#" onclick="document.getElementById('captchaImage').src='captcha.php?'+Math.random(); return false;">🔄 Refresh</a><br><br>
            <input type="text" name="captcha_input" class="form-control" placeholder="Enter CAPTCHA" required>
          </div>

          <!-- Candidate Symbols -->
          <h4>Select Your Candidate:</h4>
          <div class="row text-center">
            <img src="images/brs-symbol.png" class="party-symbol" onclick="selectCandidate(event, 'brs', 'BRS')" alt="BRS">
            <img src="images/congress-symbol.png" class="party-symbol" onclick="selectCandidate(event, 'congress', 'INC')" alt="INC">
            <img src="images/bjp-symbol.png" class="party-symbol" onclick="selectCandidate(event, 'bjp', 'BJP')" alt="BJP">
            <img src="images/aimim-symbol.png" class="party-symbol" onclick="selectCandidate(event, 'aimim', 'AIMIM')" alt="AIMIM">
            <img src="images/tjs-symbol.png" class="party-symbol" onclick="selectCandidate(event, 'tjs', 'TJS')" alt="TJS">
            <img src="images/janasena-symbol.png" class="party-symbol" onclick="selectCandidate(event, 'janasena', 'JANASENA')" alt="JANASENA">
            <img src="images/nota-symbol.png" class="party-symbol" onclick="selectCandidate(event, 'NTA', 'NOTA')" alt="NOTA">
          </div>

          <input type="hidden" name="selectedCandidate" id="selectedCandidate" required>

          <!-- Candidate details with images -->
          <div id="brs" class="candidate-info text-center">
            <img src="images/kcr.png" alt="KCR">
            <h5>K. Chandrashekar Rao (BRS)</h5>
          </div>
          <div id="congress" class="candidate-info text-center">
            <img src="images/revanth.png" alt="Revanth Reddy">
            <h5>Revanth Reddy (INC)</h5>
          </div>
          <div id="bjp" class="candidate-info text-center">
            <img src="images/bandi.png" alt="Bandi Sanjay Kumar">
            <h5>Bandi Sanjay Kumar (BJP)</h5>
          </div>
          <div id="aimim" class="candidate-info text-center">
            <img src="images/owaisi.png" alt="Asaduddin Owaisi">
            <h5>Asaduddin Owaisi (AIMIM)</h5>
          </div>
          <div id="tjs" class="candidate-info text-center">
            <img src="images/kodandaram.png" alt="Kodandaram">
            <h5>Kodandaram (TJS)</h5>
          </div>
          <div id="janasena" class="candidate-info text-center">
            <img src="images/pawan.png" alt="Pawan Kalyan">
            <h5>Pawan Kalyan (JANASENA)</h5>
          </div>

          <div id="NTA" class="candidate-info text-center">
          <img src="images/nota-symbol.png" class="img img-thumbnail candidate-photo" alt="NTA">
           <h4>NOTA</h4>
           <p><strong>Party:</strong> NOTA</p>
           <p>None of the above.</p>
           </div>

          <br>
          <div class="text-center">
            <button type="submit" class="btn btn-success">Submit Vote</button>
            <button type="button" class="btn btn-secondary" onclick="resetSelection()">Reset</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- JavaScript -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  function selectCandidate(event, id, party) {
    $('.party-symbol').removeClass('selected');
    $(event.target).addClass('selected');
    $('.candidate-info').hide();
    $('#' + id).fadeIn();
    $('#selectedCandidate').val(party);
  }

  function resetSelection() {
    $('.party-symbol').removeClass('selected');
    $('.candidate-info').hide();
    $('#selectedCandidate').val('');
  }
</script>
</body>
</html>
