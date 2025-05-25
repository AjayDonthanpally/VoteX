<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Telangana Political Parties</title>
  <link rel="icon" href="images/fevicon.png" type="image/png">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <style>
      .headerFont{
        font-family: 'Ubuntu', sans-serif;
        font-size: 24px;
      }

      .subFont{
        font-family: 'Raleway', sans-serif;
        font-size: 14px;
      }

      .normalFont{
        font-family: 'Roboto Condensed', sans-serif;
      }
    .party-symbol {
      width: 100px;
      height: 100px;
      cursor: pointer;
      margin: 10px;
      border: 2px solid #ccc;
      border-radius: 8px;
    }
    .candidate-info {
      display: none;
      margin-top: 20px;
      padding: 20px;
      border: 1px solid #ccc;
      border-radius: 8px;
      background-color: #f9f9f9;
    }
    .candidate-photo {
      width: 200px;
      height: 200px;
      margin-bottom: 10px;
    }
    .text-center {
      text-align: center;
    }
  </style>
</head>
<body>
 <div class="container">
    <nav class="navbar navbar-default navbar-fixed-top navbar-inverse" role="navigation">
      <div class="container">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#example-nav-collapse">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <div class="navbar-header">
          <a href="#" class="navbar-brand headerFont text-lg"><strong>Online Voting System</strong></a>
        </div>
    </nav>
<div class="container" style="padding-top: 60px;">
  <h2 class="text-center">Political Parties in Telangana</h2>
  <div class="row text-center">
    <img src="images/brs-symbol.png" class="party-symbol" alt="BRS" onclick="showInfo('brs')">
    <img src="images/congress-symbol.png" class="party-symbol" alt="Congress" onclick="showInfo('congress')">
    <img src="images/bjp-symbol.png" class="party-symbol" alt="BJP" onclick="showInfo('bjp')">
    <img src="images/aimim-symbol.png" class="party-symbol" alt="AIMIM" onclick="showInfo('aimim')">
    <img src="images/tjs-symbol.png" class="party-symbol" alt="TJS" onclick="showInfo('tjs')">
    <img src="images/janasena-symbol.png" class="party-symbol" alt="Janasena" onclick="showInfo('janasena')">
    <img src="images/nota-symbol.png" class="party-symbol" alt="NTA" onclick="showInfo('NTA')">
  </div>

  <div id="brs" class="candidate-info text-center">
    <img src="images/kcr.png" class="img img-thumbnail candidate-photo" alt="KCR">
    <h4>K. Chandrashekar Rao</h4>
    <p><strong>Party:</strong> Bharat Rashtra Samithi (BRS)</p>
    <p>Former Chief Minister of Telangana. Key figure in the Telangana statehood movement.</p>
  </div>

  <div id="congress" class="candidate-info text-center">
    <img src="images/revanth.png" class="img img-thumbnail candidate-photo" alt="Revanth Reddy">
    <h4>A. Revanth Reddy</h4>
    <p><strong>Party:</strong> Indian National Congress (INC)</p>
    <p>Current Chief Minister of Telangana. Focused on development and anti-corruption.</p>
  </div>

  <div id="bjp" class="candidate-info text-center">
    <img src="images/bandi.png" class="img img-thumbnail candidate-photo" alt="Bandi Sanjay Kumar">
    <h4>Bandi Sanjay Kumar</h4>
    <p><strong>Party:</strong> Bharatiya Janata Party (BJP)</p>
    <p>MP from Karimnagar. Leading BJP’s efforts in Telangana.</p>
  </div>

  <div id="aimim" class="candidate-info text-center">
    <img src="images/owaisi.png" class="img img-thumbnail candidate-photo" alt="Asaduddin Owaisi">
    <h4>Asaduddin Owaisi</h4>
    <p><strong>Party:</strong> AIMIM</p>
    <p>MP from Hyderabad. Known for advocacy of minority rights.</p>
  </div>

  <div id="tjs" class="candidate-info text-center">
    <img src="images/kodandaram.png" class="img img-thumbnail candidate-photo" alt="Kodandaram">
    <h4>M. Kodandaram</h4>
    <p><strong>Party:</strong> Telangana Jana Samithi (TJS)</p>
    <p>Academician turned politician. Active in Telangana activism.</p>
  </div>

  <div id="janasena" class="candidate-info text-center">
    <img src="images/pawan.png" class="img img-thumbnail candidate-photo" alt="Pawan Kalyan">
    <h4>Pawan Kalyan</h4>
    <p><strong>Party:</strong> Janasena Party</p>
    <p>Actor-turned-politician. Focused on youth and farmer issues.</p>
  </div>
</div>

<div id="NTA" class="candidate-info text-center">
    <img src="images/nota-symbol.png" class="img img-thumbnail candidate-photo" alt="NTA">
    <h4>NOTA</h4>
    <p><strong>Party:</strong> NOTA</p>
    <p>None of the above.</p>
  </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
  function showInfo(id) {
    $('.candidate-info').hide();
    $('#' + id).fadeIn();
  }
</script>

</body>
</html>
