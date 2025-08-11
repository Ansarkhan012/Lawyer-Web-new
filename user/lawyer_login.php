<?php
session_start();
require_once '../config/config.php';

$errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Prepared statement
    $query = "SELECT * FROM lawyers WHERE email=? AND status='approved'";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 1) {
        $lawyer = mysqli_fetch_assoc($result);
        if (password_verify($password, $lawyer['password'])) {
            $_SESSION['lawyer_id'] = $lawyer['id'];
            $_SESSION['lawyer_name'] = $lawyer['name'];
            $_SESSION['role'] = 'lawyer';
            header("Location: ../lawyer/index.php");
            exit();
        } else {
            $errorMessage = 'Incorrect password.';
        }
    } else {
        $errorMessage = 'Email not found or not approved yet.';
    }
    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lawyer Login</title>
  <style>
    :root {
      --primary-color: #2c3e50;
      --secondary-color: #bfa14a;
      --error-color: #cc0000;
      --text-dark: #1f2937;
      --text-light: #f8f9fa;
      --bg-light: #ffffff;
      --border-color: #ccc;
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      background: #1f2937;
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      font-family: 'Georgia', serif;
      color: var(--text-light);
      padding: 20px;
    }

    .login-card {
      background: var(--bg-light);
      color: var(--text-dark);
      padding: 2rem;
      border-radius: 12px;
      box-shadow: 0 8px 20px rgba(31, 41, 55, 0.25);
      width: 100%;
      max-width: 400px;
      border-top: 6px solid var(--secondary-color);
      transition: all 0.3s ease;
    }

    .login-card .title {
      text-align: center;
      font-size: 1.8rem;
      margin-bottom: 1.5rem;
      color: var(--primary-color);
      font-weight: bold;
    }

    .form-label {
      display: block;
      margin-bottom: 0.5rem;
      font-weight: 600;
      font-size: 0.95rem;
    }

    .form-control {
      width: 100%;
      padding: 0.75rem;
      border: 1.5px solid var(--border-color);
      border-radius: 6px;
      margin-bottom: 1.25rem;
      font-family: 'Georgia', serif;
      font-size: 1rem;
      transition: border-color 0.3s;
    }

    .form-control:focus {
      border-color: var(--secondary-color);
      outline: none;
      box-shadow: 0 0 5px rgba(191, 161, 74, 0.6);
    }

    .form-check {
      display: flex;
      align-items: center;
      font-size: 0.9rem;
      margin-bottom: 1.5rem;
    }

    .form-check input {
      margin-right: 0.5rem;
      width: 16px;
      height: 16px;
    }

    .form-check-label a {
      color: var(--secondary-color);
      text-decoration: none;
      transition: color 0.3s;
    }

    .form-check-label a:hover {
      text-decoration: underline;
      color: darken(var(--secondary-color), 10%);
    }

    .primary-btn {
      background-color: var(--primary-color);
      color: var(--secondary-color);
      border: none;
      padding: 0.75rem;
      border-radius: 8px;
      width: 100%;
      font-size: 1.1rem;
      font-weight: bold;
      cursor: pointer;
      transition: all 0.3s;
    }

    .primary-btn:hover {
      background-color: #1a252f;
      color: var(--text-light);
    }

    .signup-text {
      text-align: center;
      font-size: 0.9rem;
      margin-top: 1.5rem;
      color: #666;
    }

    .signup-text a {
      color: var(--secondary-color);
      font-weight: 600;
      text-decoration: none;
    }

    .signup-text a:hover {
      text-decoration: underline;
    }

    .error-message {
      background-color: #ffe6e6;
      color: var(--error-color);
      padding: 0.75rem;
      border-radius: 6px;
      margin-bottom: 1.5rem;
      font-size: 0.95rem;
      text-align: center;
      animation: fadeIn 0.5s;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-10px); }
      to { opacity: 1; transform: translateY(0); }
    }

    /* Responsive adjustments */
    @media (max-width: 576px) {
      .login-card {
        padding: 1.5rem;
      }

      .login-card .title {
        font-size: 1.5rem;
        margin-bottom: 1.2rem;
      }

      .form-control {
        padding: 0.65rem;
        font-size: 0.95rem;
      }

      .primary-btn {
        padding: 0.65rem;
        font-size: 1rem;
      }
    }

    @media (max-width: 400px) {
      .login-card {
        padding: 1.25rem;
      }

      .login-card .title {
        font-size: 1.3rem;
      }

      .form-label {
        font-size: 0.9rem;
      }

      .form-check {
        font-size: 0.85rem;
      }

      .signup-text {
        font-size: 0.85rem;
      }
    }

    /* Password toggle */
    .password-container {
      position: relative;
    }

    .toggle-password {
      position: absolute;
      right: 10px;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
      color: var(--text-dark);
      opacity: 0.7;
    }

    .toggle-password:hover {
      opacity: 1;
    }
  </style>
</head>
<body>

  <div class="login-card">
    <h3 class="title">Lawyer Login</h3>

    <?php if (!empty($errorMessage)) : ?>
      <div class="error-message"><?php echo htmlspecialchars($errorMessage); ?></div>
    <?php endif; ?>

    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" novalidate>
      <label for="email" class="form-label">Email Address</label>
      <input type="email" name="email" id="email" class="form-control" placeholder="Enter email" required>

      <label for="password" class="form-label">Password</label>
      <div class="password-container">
        <input type="password" name="password" id="password" class="form-control" placeholder="Enter password" required>
      </div>

      <div class="form-check">
        <input class="form-check-input" type="checkbox" id="terms" required>
        <label class="form-check-label" for="terms">
          I accept the <a href="#">terms & conditions</a>
        </label>
      </div>

      <button type="submit" name="login" class="primary-btn">Login</button>

      <p class="signup-text">
        Don't have an account? <a href="./signup.php">Sign Up</a><br>
        <a href="./notUser.php" style="margin-top: 0.5rem; display: inline-block;">Forgot password?</a>
      </p>
    </form>
  </div>

  <script>
   

 
    document.querySelector('form').addEventListener('submit', function(e) {
      const termsChecked = document.getElementById('terms').checked;
      if (!termsChecked) {
        e.preventDefault();
        alert('Please accept the terms and conditions');
      }
    });

    // Auto-focus email field on page load
    window.addEventListener('DOMContentLoaded', () => {
      document.getElementById('email').focus();
    });
  </script>
</body>
</html>