<?php
session_start();
require_once '../config/config.php';

// Only admin can access
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../user/login.php");
    exit();
}


$query = "
SELECT 
    a.id AS appointment_id,
    cl.name AS client_name,
    l.name AS lawyer_name,
    a.appointment_date,
    a.appointment_time,
    a.case_details,
    a.status,
    a.created_at
FROM appointments a
JOIN users u ON a.u_id =u.u_id
JOIN lawyers l ON a.lawyer_id = l.id
ORDER BY a.created_at DESC
";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Appointments</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
<h1>All Appointments</h1>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Client</th>
        <th>Lawyer</th>
        <th>Date</th>
        <th>Time</th>
        <th>Case Details</th>
        <th>Status</th>
        <th>Created At</th>
        <th>Action</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
    <tr>
        <td><?= $row['appointment_id'] ?></td>
        <td><?= htmlspecialchars($row['client_name']) ?></td>
        <td><?= htmlspecialchars($row['lawyer_name']) ?></td>
        <td><?= $row['appointment_date'] ?></td>
        <td><?= $row['appointment_time'] ?></td>
        <td><?= nl2br(htmlspecialchars($row['case_details'])) ?></td>
        <td><?= ucfirst($row['status']) ?></td>
        <td><?= $row['created_at'] ?></td>
        <td>
            <a href="view_appointment.php?id=<?= $row['appointment_id'] ?>">View</a> |
            <a href="edit_appointment.php?id=<?= $row['appointment_id'] ?>">Edit</a> |
            <a href="delete_appointment.php?id=<?= $row['appointment_id'] ?>" onclick="return confirm('Delete this appointment?')">Delete</a>
        </td>
    </tr>
    <?php } ?>
</table>

</body>
</html>
