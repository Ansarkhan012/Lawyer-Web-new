<?php
include_once '../config/config.php';
$id = $_GET['id'];

$query = "DELETE FROM lawyers WHERE id = $id";
mysqli_query($conn, $query);

header("Location: New_lawyer.php");
exit();
