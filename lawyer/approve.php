<?php
session_start();
require_once '../config/config.php';


if (!isset($_SESSION['lawyer_id'])) {
    header("Location: ../login.php");
    exit();
}

// Check if appointment id mil rahi hai
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $appointment_id = intval($_GET['id']);
    $lawyer_id = $_SESSION['lawyer_id'];

    // Update query
    $query = "UPDATE appointments SET status = 'confirmed' WHERE id = ? AND lawyer_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $appointment_id, $lawyer_id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Appointment approved successfully!";
    } else {
        $_SESSION['error'] = "Something went wrong. Please try again.";
    }
} else {
    $_SESSION['error'] = "Invalid appointment ID.";
}

// Wapis list page par bhejo
header("Location: laywer_appointment.php");
exit();
?>
