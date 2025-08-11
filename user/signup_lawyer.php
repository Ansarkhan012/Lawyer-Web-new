<?php
require_once '../config/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name            = $_POST["name"];
    $email           = $_POST["email"];
    $password        = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $phone           = $_POST["phone"];
    $cnic            = $_POST["cnic"];
    $specialization  = $_POST["specialization"];
    $experience      = $_POST["experience"];

    $profileImageName = $_FILES["profile_image"]["name"];
    $licenseFileName  = $_FILES["license"]["name"];

    $targetProfilePath = "../uploads/profile_images/" . basename($profileImageName);
    $targetLicensePath = "../uploads/licenses/" . basename($licenseFileName);

    if (!is_dir("../uploads/profile_images")) mkdir("../uploads/profile_images", 0777, true);
    if (!is_dir("../uploads/licenses")) mkdir("../uploads/licenses", 0777, true);

    if (
        move_uploaded_file($_FILES["profile_image"]["tmp_name"], $targetProfilePath) &&
        move_uploaded_file($_FILES["license"]["tmp_name"], $targetLicensePath)
    ) {
        $sql = "INSERT INTO lawyers (name, email, password, phone, cnic, specialization, experience, license_file, profile_image, status)
                VALUES ('$name', '$email', '$password', '$phone', '$cnic', '$specialization', '$experience', '$licenseFileName', '$profileImageName', 'pending')";

        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Signup submitted successfully! Please wait for admin approval.');</script>";
        } else {
            echo "Database Error: " . mysqli_error($conn);
        }
    } else {
        echo "<script>alert('Failed to upload files! Try again');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Lawyer Signup</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: #1f2937;
      color: #f8f9fa;
      font-family: 'Georgia', serif;
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      padding: 20px;
    }
    .signup-container {
      background: #ffffff;
      color: #1f2937;
      padding: 2rem;
      border-radius: 12px;
      box-shadow: 0 8px 20px rgba(31, 41, 55, 0.25);
      border-top: 6px solid #bfa14a;
      max-width: 650px;
      width: 100%;
    }
    h2 {
      color: #2c3e50;
      font-weight: 900;
      text-align: center;
      margin-bottom: 1.5rem;
    }
    label {
      font-weight: 600;
      margin-top: 1rem;
    }
    input, select {
      border: 1px solid #ccc;
      border-radius: 8px;
      padding: 10px;
      font-size: 1rem;
      width: 100%;
    }
    input:focus {
      border-color: #bfa14a;
      box-shadow: 0 0 5px rgba(191,161,74,0.5);
      outline: none;
    }
    button {
      margin-top: 1.5rem;
      background-color: #2c3e50;
      border: none;
      color: #bfa14a;
      font-weight: bold;
      padding: 0.75rem 1.25rem;
      border-radius: 8px;
      transition: all 0.3s ease;
      width: 100%;
    }
    button:hover {
      background-color: #1a252f;
      color: #f8f9fa;
    }
    a {
      color: #bfa14a;
      text-decoration: none;
    }
    a:hover {
      text-decoration: underline;
    }
    @media (max-width: 576px) {
      .signup-container {
        padding: 1.5rem;
      }
    }
  </style>
</head>
<body>

<div class="signup-container">
  <h2>Join as a Lawyer</h2>
  <form method="POST" enctype="multipart/form-data">
    <label>Full Name</label>
    <input type="text" name="name" required>

    <label>Email</label>
    <input type="email" name="email" required>

    <label>Password</label>
    <input type="password" name="password" required>

    <label>Phone</label>
    <input type="text" name="phone" required minlength="11">

    <label>CNIC</label>
    <input type="text" name="cnic" required minlength="11">

    <label>Specialization</label>
    <input type="text" name="specialization" required>

    <label>Experience (Years)</label>
    <input type="number" name="experience" required>

    <label>Profile Image</label>
    <input type="file" name="profile_image" accept=".jpg,.jpeg,.png" required>

    <label>Upload License (PDF/Image)</label>
    <input type="file" name="license" accept=".pdf,.jpg,.jpeg,.png" required>

    <button type="submit">Submit Application</button>
    
    <p class="mt-3 text-center">Already have an Account? <a href="lawyer_login.php">Login</a></p>
  </form>
</div>

</body>
</html>
