<?php
session_start();
require_once '../config/config.php';

// Lawyer login check
if (!isset($_SESSION['lawyer_id'])) {
    header("Location: ../login.php");
    exit();
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $appointment_id = intval($_GET['id']);
    $lawyer_id = $_SESSION['lawyer_id'];

    $query = "UPDATE appointments SET status = 'cancelled' WHERE id = ? AND lawyer_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $appointment_id, $lawyer_id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Appointment cancelled successfully!";
    } else {
        $_SESSION['error'] = "Something went wrong. Please try again.";
    }
} else {
    $_SESSION['error'] = "Invalid appointment ID.";
}

header("Location: laywer_appointment.php");
exit();
?>
