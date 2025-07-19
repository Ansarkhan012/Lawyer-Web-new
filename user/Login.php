<?php 
require_once '../config/config.php';
if (isset($_POST['login'])){
    $email=mysqli_real_escape_string($conn,$_POST['email']);
    $password=mysqli_real_escape_string($conn,$_POST['password']);

    $checkuser="SELECT * FROM `users` WHERE email='$email'";
	$checkuserresult=mysqli_query($conn,$checkuser);

    if (mysqli_num_rows($checkuserresult) ==1){
    $row=mysqli_fetch_assoc($checkuserresult);
    $verifyPassword=password_verify($password,$row["password"]);
	if($verifyPassword){
      session_start();
      
	  $_SESSION ['email']=$email;
	  $_SESSION ['role'] =$row['role'];
      $_SESSION ['isloggedin']=true;
	  $_SESSION ['user_id']=$row['id'];
	  
	  ['user_id'];
    if ($_SESSION['role']=="admin"){
      echo"<script>alert('Login Successfully As Admin')
	  location.href='../admin/index.php'</script>";
	}else{
		echo"<script>alert('Login Success')
		location.href='./index.php'
	</script>";
	}
	
	} else {
		echo"<script>alert('Incorrect Password')
</script>";
	}
	
		
	} else {
		echo"<script>alert('User Not Found')
	location.href='./signup.php'
</script>";
	}
	
}

?>


<!doctype html>
<html lang="en">
<head>
  <title>Lawyer Portal Login</title>
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <!-- Bootstrap CSS v5.3 -->
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
    rel="stylesheet"
    crossorigin="anonymous"
  />
  <style>
    body {
      background: #1f2937; 
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      font-family: 'Georgia', serif;
      color: #f8f9fa;
      margin: 0;
    }
    .login-card {
      background: #ffffff;
      color: #1f2937;
      padding: 3rem 2.5rem;
      border-radius: 12px;
      box-shadow: 0 8px 20px rgba(31, 41, 55, 0.25);
      width: 100%;
      max-width: 420px;
      border-top: 6px solid #bfa14a; 
    }
    .login-card .title {
      font-weight: 900;
      margin-bottom: 2rem;
      text-align: center;
      font-size: 2.1rem;
      letter-spacing: 4px;
      text-transform: uppercase;
      font-family: 'Palatino Linotype', 'Book Antiqua', Palatino, serif;
      color: #2c3e50;
    }
    label {
      font-weight: 600;
      font-size: 0.95rem;
      letter-spacing: 0.04em;
    }
    .form-control {
      border-radius: 6px;
      border: 1.5px solid #bfbfbf;
      transition: border-color 0.3s ease, box-shadow 0.3s ease;
      font-size: 1rem;
      padding: 0.5rem 0.75rem;
      font-family: 'Georgia', serif;
      color: #2c3e50;
    }
    .form-control::placeholder {
      color: #8b8b8b;
      font-style: italic;
    }
    .form-control:focus {
      border-color: #bfa14a;
      box-shadow: 0 0 8px rgba(191, 161, 74, 0.5);
      outline: none;
    }
    .form-check-label a {
      color: #bfa14a;
      text-decoration: none;
      font-weight: 600;
    }
    .form-check-label a:hover {
      text-decoration: underline;
    }
    .primary-btn {
      background-color: #2c3e50;
      border: none;
      color: #bfa14a;
      font-weight: 700;
      font-size: 1.15rem;
      padding: 0.75rem;
      border-radius: 8px;
      width: 100%;
      margin-top: 1.25rem;
      letter-spacing: 0.1em;
      transition: background-color 0.3s ease;
      font-family: 'Georgia', serif;
    }
    .primary-btn:hover {
      background-color: #1a252f;
      color: #f8f9fa;
    }
    p.signup-text {
      margin-top: 1rem;
      font-size: 0.9rem;
      text-align: center;
      color: #4a4a4a;
      font-style: italic;
    }
    p.signup-text a {
      color: #bfa14a;
      font-weight: 600;
      text-decoration: none;
    }
    p.signup-text a:hover {
      text-decoration: underline;
    }
  </style>
</head>

<body>
  <div class="login-card shadow">
	<svg fill=" #bfa14a" height="80px" width="80px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 511.994 511.994" xml:space="preserve" stroke=" #bfa14a" transform="rotate(-45)"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke="#CCCCCC" stroke-width="3.0719640000000004"></g><g id="SVGRepo_iconCarrier"> <g> <path d="M343.936,239.982v45.372l-3.171,4.229c-5.49,7.319-6.358,16.95-2.266,25.133c4.091,8.184,12.317,13.267,21.466,13.267h96 c9.149,0,17.375-5.083,21.466-13.267c4.092-8.183,3.224-17.813-2.266-25.133l-3.2-4.268V146.663l3.2-4.267 c5.49-7.319,6.358-16.95,2.266-25.133c-4.091-8.184-12.317-13.267-21.466-13.267h-96c-9.149,0-17.375,5.083-21.466,13.267 c-4.092,8.183-3.224,17.813,2.266,25.133l3.171,4.229v45.357H213.829c-2.772-4.774-7.928-8-13.835-8H33.046 c-15.838,0-29.472,10.768-32.418,25.604c-1.888,9.507,0.53,19.223,6.633,26.657c6.125,7.461,15.14,11.739,24.733,11.739h168 c5.906,0,11.063-3.226,13.835-8H343.936z M352.809,124.419c1.385-2.769,4.06-4.422,7.155-4.422h96c3.096,0,5.771,1.653,7.155,4.422 c1.384,2.77,1.102,5.901-0.756,8.378l-2.4,3.2h-59.999c-4.418,0-8,3.582-8,8s3.582,8,8,8h55.999v127.985h-55.999 c-4.418,0-8,3.582-8,8s3.582,8,8,8h59.999l2.4,3.2c1.857,2.477,2.14,5.608,0.755,8.378c-1.385,2.769-4.06,4.422-7.155,4.422h-96 c-3.096,0-5.771-1.653-7.155-4.422c-1.384-2.77-1.102-5.901,0.756-8.378l2.4-3.2h11.973c4.418,0,8-3.582,8-8s-3.582-8-8-8h-8.002 V151.997h8.002c4.418,0,8-3.582,8-8s-3.582-8-8-8h-11.973l-2.4-3.2C351.707,130.32,351.425,127.188,352.809,124.419z M343.936,223.982H215.994v-16h127.942V223.982z M31.994,231.982c-4.786,0-9.293-2.147-12.367-5.892 c-3.097-3.772-4.271-8.527-3.306-13.388c1.44-7.252,8.63-12.721,16.725-12.721h166.948v32H31.994z"></path> <path d="M487.994,359.997h-160c-13.233,0-24,10.767-24,24v15c0,4.963,4.038,9,9,9h190c4.962,0,9-4.037,9-9v-15 C511.994,370.764,501.227,359.997,487.994,359.997z M495.994,391.997h-176v-8c0-4.411,3.589-8,8-8h160c4.411,0,8,3.589,8,8V391.997 z"></path> </g> </g></svg>
    <h3 class="title">Login</h3>
    <form action="#" method="post" novalidate>
      <div class="mb-4">
        <label for="email" class="form-label">Email Address</label>
        <input
          type="email"
          class="form-control"
          id="email"
          name="email"
          placeholder="Email"
          required
        />
      </div>

      <div class="mb-4">
        <label for="password" class="form-label">Password</label>
        <input
          type="password"
          class="form-control"
          id="password"
          name="password"
          placeholder="Password"
          required
        />
      </div>

      <div class="form-check mb-4">
        <input
          class="form-check-input"
          type="checkbox"
          id="terms"
          required
        />
        <label class="form-check-label" for="terms">
          I accept the <a href="#">terms & conditions</a>
        </label>
      </div>

      <button type="submit" name="login" class="primary-btn">Sign In</button>

      <p class="signup-text">
        Don't have an account? <a href="./signup.php">Sign Up</a>
      </p>
    </form>
  </div>

  <!-- Bootstrap JS -->
  <script
    src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    crossorigin="anonymous"
  ></script>
  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
    crossorigin="anonymous"
  ></script>
</body>
</html>

                   

