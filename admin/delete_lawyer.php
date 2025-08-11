<?php
require_once '../config/config.php';

if (!isset($_GET['id'])) {
    die("Invalid request");
}

$id = intval($_GET['id']);
$sql = "DELETE FROM lawyers WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: lawyers.php");
    exit;
} else {
    echo "Failed to delete lawyer.";
}
?>
