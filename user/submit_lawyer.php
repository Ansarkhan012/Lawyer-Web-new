<?php
require_once '../config/config.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name     = mysqli_real_escape_string($conn, $_POST['name']);
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $phone    = mysqli_real_escape_string($conn, $_POST['phone']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $city     = mysqli_real_escape_string($conn, $_POST['city']);
    $expertise = mysqli_real_escape_string($conn, $_POST['expertise']);



   
    $sql = "INSERT INTO lawyers (name, email, phone, password, city, expertise, status) 
            VALUES ('$name', '$email', '$phone', '$password', '$city', '$expertise', 'pending')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>
                alert('Signup request submitted successfully. Please wait for admin approval.');
                window.location.href = 'login.php';
              </script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
