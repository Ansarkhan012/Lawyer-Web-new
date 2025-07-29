<?php
session_start();
require_once '../config/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

  
    $query = "SELECT * FROM lawyers WHERE email='$email' AND status='approved'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $lawyer = mysqli_fetch_assoc($result);

 
        if (password_verify($password, $lawyer['password'])) {
            $_SESSION['lawyer_id'] = $lawyer['id'];
            $_SESSION['lawyer_name'] = $lawyer['name'];

            header("Location: ../lawyer/index.php");
            exit();
        } else {
            echo "<p class='error'> Incorrect password.</p>";
            echo "<a href='lawyer_login.php'>Try again</a>";
        }
    } else {
        echo "<p class='error'> Email not found or not approved yet.</p>";
        echo "<a href='lawyer_login.php'>Try again</a>";
    }
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Lawyer Login</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f4f4f4;
      padding: 50px;
    }

    .login-box {
      background: white;
      padding: 30px;
      max-width: 400px;
      margin: auto;
      box-shadow: 0 0 10px rgba(0,0,0,0.2);
      border-radius: 10px;
    }

    h2 {
      text-align: center;
      margin-bottom: 25px;
    }

    input[type="email"],
    input[type="password"] {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    button {
      width: 100%;
      padding: 10px;
      background: #007bff;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    button:hover {
      background: #0056b3;
    }

    .error {
      color: red;
      text-align: center;
      margin-bottom: 15px;
    }
  </style>
</head>
<body>

  <div class="login-box">
    <h2>Lawyer Login</h2>
    <form action="#" method="POST">
      <label for="email">Email</label>
      <input type="email" name="email" id="email" required>

      <label for="password">Password</label>
      <input type="password" name="password" id="password" required>

      <button type="submit">Login</button>
    </form>
  </div>

</body>
</html>
