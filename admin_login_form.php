<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Admin Login</title>
  <link rel="icon" href="images/fevicon.png" type="image/png">
  <link href="css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background: #f4f6f9;
      font-family: Arial, sans-serif;
      padding-top: 80px;
    }
    .login-container {
      max-width: 400px;
      margin: auto;
      background: #fff;
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    h2 {
      margin-bottom: 30px;
      text-align: center;
    }
    .forgot-password {
      display: block;
      margin-top: 15px;
      text-align: center;
    }
  </style>
</head>
<body>
  <div class="login-container">
    <h2>Admin Login</h2>
    <form action="admin_login.php" method="POST">
      <div class="form-group">
        <label for="username">Username</label>
        <input required type="text" id="username" name="username" class="form-control" placeholder="Enter username" />
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input required type="password" id="password" name="password" class="form-control" placeholder="Enter password" />
      </div>
      <button type="submit" class="btn btn-primary btn-block mt-3">Login</button>
      <a class="forgot-password" href="changepassword.php">Forgot Password?</a>
    </form>
  </div>
</body>
</html>
