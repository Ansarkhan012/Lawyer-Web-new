
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

    // Upload paths
    $profileImageName = $_FILES["profile_image"]["name"];
    $licenseFileName  = $_FILES["license"]["name"];

    $targetProfilePath = "../uploads/profile_images/" . basename($profileImageName);
    $targetLicensePath = "../uploads/licenses/" . basename($licenseFileName);

    // Create folders if they don't exist
    if (!is_dir("../uploads/profile_images")) mkdir("../uploads/profile_images", 0777, true);
    if (!is_dir("../uploads/licenses")) mkdir("../uploads/licenses", 0777, true);

    // Move files to destination
    if (
        move_uploaded_file($_FILES["profile_image"]["tmp_name"], $targetProfilePath) &&
        move_uploaded_file($_FILES["license"]["tmp_name"], $targetLicensePath)
    ) {
        $sql = "INSERT INTO lawyers (name, email, password, phone, cnic, specialization, experience, license_file, profile_image, status)
                VALUES ('$name', '$email', '$password', '$phone', '$cnic', '$specialization', '$experience', '$licenseFileName', '$profileImageName', 'pending')";

        if (mysqli_query($conn, $sql)) {
            echo "<script>
            alert('Signup submitted successfully! Please wait for admin approval.');
            </script>";
        } else {
            echo "Database Error: " . mysqli_error($conn);
        }
    } else {
        echo "<script>
        alert('Failed to File Upload! Try again');
        </script>";
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Lawyer Signup</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f0f4f7;
      margin: 0;
      padding: 0;
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
    }

    .signup-container {
      background-color: white;
      padding: 40px;
      border-radius: 10px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
      max-width: 600px;
      width: 100%;
    }

    h2 {
      margin-bottom: 20px;
      text-align: center;
      color: #003B46;
    }

    form {
      display: flex;
      flex-direction: column;
    }

    label {
      margin-top: 12px;
      font-weight: 600;
    }

    input, textarea, select {
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 6px;
      margin-top: 5px;
      font-size: 16px;
    }

    input[type="file"] {
      padding: 5px;
    }

    button {
      margin-top: 20px;
      padding: 12px;
      background-color: #007C91;
      color: white;
      border: none;
      border-radius: 6px;
      font-size: 16px;
      font-weight: bold;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    button:hover {
      background-color: #005a66;
    }

    .message {
      margin-top: 15px;
      color: green;
      text-align: center;
    }

    @media (max-width: 600px) {
      .signup-container {
        padding: 20px;
      }
    }
  </style>
</head>
<body>

  <div class="signup-container">
    <h2>Join as a Lawyer</h2>

    <form action="#" method="POST" enctype="multipart/form-data">
  <label>Full Name</label>
  <input type="text" name="name" required />

  <label>Email</label>
  <input type="email" name="email" required />

  <label>Password</label>
  <input type="password" name="password" required />

  <label>Phone</label>
  <input type="text" name="phone" required />

  <label>CNIC</label>
  <input type="text" name="cnic" required />

  <label>Specialization</label>
  <input type="text" name="specialization" required />

  <label>Experience (Years)</label>
  <input type="number" name="experience" required />

  <label>Profile Image</label>
  <input type="file" name="profile_image" accept=".jpg,.jpeg,.png" required />

  <label>Upload License (PDF/Image)</label>
  <input type="file" name="license" accept=".pdf,.jpg,.jpeg,.png" required />

  <p>Already have an Account? <a href="lawyer_login.php">Login</a></p>

  <button type="submit">Submit Application</button>
</form>

  </div>

</body>
</html>
