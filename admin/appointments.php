<?php
require_once '../config/config.php';

// Query to get appointments with client & lawyer info
$query = "
SELECT 
    a.id AS appointment_id,
    u.u_id AS client_id,
    u.name AS client_name,
    u.email AS client_email,
    l.name AS lawyer_name,
    a.appointment_date,
    a.appointment_time,
    a.case_details,
    a.status
FROM appointments a
JOIN users u ON a.u_id = u.u_id
JOIN lawyers l ON a.lawyer_id = l.id
ORDER BY a.created_at DESC
";

$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Appointments</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary-color: #003B46;
            --secondary-color: #007C91;
            --accent-color: #bfa14a;
        }

        body {
            background-color: #f8f9fa;
        }

        .main-container {
            padding: 20px;
            margin-left: 20%;
        }

        .page-header {
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 1px solid #dee2e6;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }

        .table-responsive {
            border-radius: 10px;
            overflow: hidden;
        }

        .table th {
            background-color: var(--primary-color);
            color: white;
            padding: 15px;
            font-weight: 600;
        }

        .table td {
            vertical-align: middle;
            padding: 12px 15px;
        }

        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-confirmed {
            background-color: #d4edda;
            color: #155724;
        }

        .status-cancelled {
            background-color: #f8d7da;
            color: #721c24;
        }

        .action-btn {
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 0.8rem;
            margin-right: 5px;
            transition: all 0.3s;
        }

        .btn-approve { background-color: #28a745; color: white; }
        .btn-reject { background-color: #dc3545; color: white; }
        .btn-delete { background-color: #6c757d; color: white; }

        .btn-approve:hover { background-color: #218838; }
        .btn-reject:hover { background-color: #c82333; }
        .btn-delete:hover { background-color: #5a6268; }

        .case-details {
            max-width: 250px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            cursor: pointer;
        }

        .no-appointments {
            text-align: center;
            padding: 50px;
        }
    </style>
</head>
<body>
    <?php include_once './componets/sidebar.php'; ?>

    <div class="main-container">
        <div class="page-header">
            <h1> Appointment Management</h1>
            <p class="text-muted">Manage and update appointment statuses</p>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Client</th>
                                <th>Email</th>
                                <th>Lawyer</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Case Details</th>
                                <th>Status</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($result && $result->num_rows > 0): ?>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?= (int)$row['appointment_id'] ?></td>
                                        <td><?= htmlspecialchars($row['client_name']) ?></td>
                                        <td><?= htmlspecialchars($row['client_email']) ?></td>
                                        <td><?= htmlspecialchars($row['lawyer_name']) ?></td>
                                        <td><?= date('M j, Y', strtotime($row['appointment_date'])) ?></td>
                                        <td><?= date('h:i A', strtotime($row['appointment_time'])) ?></td>
                                        <td class="case-details" title="<?= htmlspecialchars($row['case_details']) ?>">
                                            <?= htmlspecialchars($row['case_details']) ?>
                                        </td>
                                        <td>
                                            <span class="status-badge status-<?= strtolower($row['status']) ?>">
                                                <?= ucfirst($row['status']) ?>
                                            </span>
                                        </td>
                                      
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="9" class="text-center py-4">
                                        <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                                        <h4>No Appointments Found</h4>
                                        <p class="text-muted">There are currently no appointments in the system.</p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
