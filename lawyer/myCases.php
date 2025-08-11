<?php
session_start();

include '../config/config.php';

if (!isset($_SESSION['lawyer_id'])) {
    header("Location: ../login.php");
    exit();
}

$lawyer_id = $_SESSION['lawyer_id'];

$query = "
SELECT 
    a.id AS appointment_id,
    a.case_details,
    u.name AS client_name,
    a.appointment_date,
    a.status,
    a.appointment_time
FROM appointments a
JOIN users u ON a.u_id = u.u_id
WHERE a.lawyer_id = ?
ORDER BY a.appointment_date DESC
";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $lawyer_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Cases</title>
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
            padding: 30px;
            margin-left: 20%
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
        
        .case-details {
            max-width: 300px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .view-btn {
            background-color: var(--accent-color);
            color: white;
            border: none;
            padding: 5px 15px;
            border-radius: 5px;
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .view-btn:hover {
            background-color: var(--primary-color);
            color: white;
            transform: translateY(-2px);
        }

        /* Mobile responsive table to card layout */
        @media (max-width: 768px) {
            .table thead {
                display: none;
            }
            .table tbody tr {
                display: block;
                margin-bottom: 15px;
                border: 1px solid #dee2e6;
                border-radius: 10px;
                padding: 10px;
                background-color: white;
                box-shadow: 0 0 10px rgba(0,0,0,0.05);
            }
            .table tbody td {
                display: flex;
                justify-content: space-between;
                padding: 8px 5px;
                border-bottom: 1px solid #f1f1f1;
            }
            .table tbody td:last-child {
                border-bottom: none;
            }
            .table tbody td::before {
                content: attr(data-label);
                font-weight: bold;
                color: var(--primary-color);
                flex: 1;
                max-width: 120px;
            }
            .case-details {
                white-space: normal;
                overflow: visible;
            }
        }
    </style>
</head>
<body>
    <div class="m">
    <?php include_once './componets/sidebar.php'; ?>
    
    </div>
    <div class="main-container">
        <div class="page-header">
            <h1><i class="fas fa-gavel me-2"></i>My Cases</h1>
            <p class="text-muted">View and manage all your assigned cases</p>
        </div>
        
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Case Details</th>
                                <th>Client</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($result->num_rows > 0): ?>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td data-label="Case Details" class="case-details" title="<?= htmlspecialchars($row['case_details']) ?>">
                                            <?= htmlspecialchars($row['case_details']) ?>
                                        </td>
                                        <td data-label="Client"><?= htmlspecialchars($row['client_name']) ?></td>
                                        <td data-label="Date"><?= date('M j, Y', strtotime($row['appointment_date'])) ?></td>
                                        <td data-label="Time"><?= date('h:i A', strtotime($row['appointment_time'])) ?></td>
                                        <td data-label="Status">
                                            <span class="status-badge status-<?= strtolower($row['status']) ?>">
                                                <?= ucfirst($row['status']) ?>
                                            </span>
                                        </td>
                                        <td data-label="Actions">
                                            <a href="case_veiw.php?id=<?= $row['appointment_id'] ?>" class="view-btn">
                                                <i class="fas fa-eye me-1"></i> View
                                            </a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <i class="fas fa-gavel fa-3x text-muted mb-3"></i>
                                        <h4>No Cases Assigned</h4>
                                        <p class="text-muted">You don't have any cases assigned to you yet.</p>
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
