<?php
session_start();
require_once '../config/config.php';

if (!isset($_SESSION['lawyer_id'])) {
    header("Location: ../login.php");
    exit();
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $appointment_id = intval($_GET['id']);
    $lawyer_id = $_SESSION['lawyer_id'];

    // Delete only if the appointment belongs to this lawyer
    $stmt = $conn->prepare("DELETE FROM appointments WHERE id = ? AND lawyer_id = ?");
    $stmt->bind_param("ii", $appointment_id, $lawyer_id);

    if ($stmt->execute()) {
        header("Location: laywer_appointment.php?msg=deleted");
        exit();
    } else {
        echo "Error deleting appointment: " . $conn->error;
    }
} else {
    echo "Invalid request.";
}
?>
