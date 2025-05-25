<?php
require 'config.php';

$parties = ['BRS', 'INC', 'BJP', 'AIMIM', 'TJS', 'JANASENA', 'NOTA'];

$partyNames = [
  'BRS' => 'Bharat Rashtra Samithi',
  'INC' => 'Indian National Congress',
  'BJP' => 'Bharatiya Janata Party',
  'AIMIM' => 'All India Majlis-e-Ittehadul Muslimeen',
  'TJS' => 'Telangana Jana Samithi',
  'JANASENA' => 'Janasena Party',
  'NOTA' => 'NOTA'
];

$colors = [
  'BRS' => 'success',
  'INC' => 'primary',
  'BJP' => 'warning',
  'AIMIM' => 'danger',
  'TJS' => 'info',
  'JANASENA' => 'default',
  'NOTA' => 'secondary' // Corrected the syntax and added a fallback class
];

$votes = array_fill_keys($parties, 0);
$totalVotes = 0;

if ($conn) {
    $sql = "SELECT voted_for FROM tbl_users WHERE voted_for IS NOT NULL";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $vote = $row['voted_for'];
        if (isset($votes[$vote])) {
            $votes[$vote]++;
            $totalVotes++;
        }
    }
} else {
    echo "<div class='alert alert-danger'>Error connecting to database.</div>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Control Panel - Telangana Voting</title>
  <link rel="icon" href="images/fevicon.png" type="image/png">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <style>
    body {
      padding-top: 70px;
    }
    .headerFont {
      font-family: 'Ubuntu', sans-serif;
    }
    .progress {
      height: 25px;
    }
    .party-block {
      margin-bottom: 30px;
    }
    .counfor {
      font-size: 20px;
      display: flex;
      justify-content: space-between;
      margin-bottom: 5px;
    }
  </style>
</head>
<body>
  <div class="container">
    <nav class="navbar navbar-default navbar-fixed-top navbar-inverse">
      <div class="container">
        <div class="navbar-header">
          <a href="#" class="navbar-brand headerFont"><strong>eVoting</strong></a>
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#nav-collapse">
            <span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
          </button>
        </div>
      </div>
    </nav>

    <div class="row">
      <div class="col-sm-12" style="border:2px solid gray; padding: 20px;">
        <div class="page-header">
          <h2 class="headerFont">CONTROL PANEL</h2>
          <p>This is the live admin vote monitoring panel for Telangana Legislative Assembly Elections.</p>
        </div>

        <?php
        foreach ($parties as $party) {
            $count = $votes[$party];
            $percent = $totalVotes > 0 ? round(($count / $totalVotes) * 100, 2) : 0;
            $color = isset($colors[$party]) ? $colors[$party] : 'secondary'; // fallback class
            $name = $partyNames[$party];
            echo "
            <div class='party-block'>
              <div class='counfor'>
                <strong>{$name}</strong>
                <span>{$percent}%</span>
              </div>
              <div class='progress'>
                <div class='progress-bar progress-bar-{$color}' role='progressbar' style='width: {$percent}%;'>
                  {$count} votes
                </div>
              </div>
            </div>
            ";
        }

        echo "<hr><div class='text-primary'><h3><strong>Total Votes Cast:</strong> $totalVotes</h3></div>";
        ?>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
</body>
</html>
