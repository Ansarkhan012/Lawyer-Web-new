<?php
include_once '../config/config.php';
$id = $_GET['id'];

$query = "UPDATE lawyers SET status = 'approved' WHERE id = $id";
mysqli_query($conn, $query);

header("Location: New_lawyer.php");
exit();
