<?php  
session_start();
include '../config/config.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header("Location: ./login.php");
    exit();
}

$user_id = $_SESSION['u_id'];
$lawyer_id = $_POST['lawyer_id'];
$date = $_POST['date'];
$time = $_POST['time'];
$details = $_POST['details'];

// Get client info
$client_stmt = $conn->prepare("SELECT name, email, phone FROM users WHERE u_id = ?");
$client_stmt->bind_param("i", $user_id);
$client_stmt->execute();
$client_result = $client_stmt->get_result();
$client = $client_result->fetch_assoc();


$sql = "INSERT INTO appointments (u_id, lawyer_id, appointment_date, appointment_time, case_details, status)
        VALUES (?, ?, ?, ?, ?, 'pending')";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iisss", $user_id, $lawyer_id, $date, $time, $details);

if ($stmt->execute()) {

    // Get lawyer email
    $lawyer_stmt = $conn->prepare("SELECT email, name FROM lawyers WHERE id = ?");
    $lawyer_stmt->bind_param("i", $lawyer_id);
    $lawyer_stmt->execute();
    $lawyer_result = $lawyer_stmt->get_result();
    $lawyer = $lawyer_result->fetch_assoc();

    if ($lawyer) {
        $to = $lawyer['email'];
        $subject = "New Appointment Request - Legal Connect";
        $message = "
Dear " . $lawyer['name'] . ",

You have received a new appointment request.

Client Name: " . $client['name'] . "
Client Email: " . $client['email'] . "
Client Phone: " . $client['phone'] . "
Date: " . $date . "
Time: " . $time . "
Case Details: " . $details . "

Please log in to your Legal Connect account to approve or cancel this appointment.
";

        $headers = "From: no-reply@yourdomain.com\r\n";
        $headers .= "Reply-To: " . $client['email'] . "\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

        
        mail($to, $subject, $message, $headers);
    }

    echo "<script>alert('Appointment booked successfully!'); window.location.href='appointment.php';</script>";
} else {
    echo "<script>alert('Failed to book appointment. Try again!'); window.history.back();</script>";
}

$stmt->close();
$conn->close();
?>
