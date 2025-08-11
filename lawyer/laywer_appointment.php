<?php
session_start();
require_once '../config/config.php';

if (!isset($_SESSION['lawyer_id'])) {
    header("Location: ../login.php");
    exit();
}

$lawyer_id = $_SESSION['lawyer_id'];

$query = "
SELECT 
    a.id,
    u.name AS client_name,
    u.email AS client_email,
    a.appointment_date AS date,
    a.case_details AS message,
    a.status,
    a.appointment_time
FROM appointments a
JOIN users u ON a.u_id = u.u_id
WHERE a.lawyer_id = ?
ORDER BY a.appointment_date DESC, a.appointment_time DESC
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
    <title>My Appointments</title>
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
        .main-container { padding: 30px;
        margin-left: 20% }
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
        .table-responsive { border-radius: 10px; overflow: hidden; }
        .table th {
            background-color: var(--primary-color);
            color: white;
            padding: 15px;
            font-weight: 600;
        }
        .table td { vertical-align: middle; padding: 12px 15px; }
        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        .status-pending { background-color: #fff3cd; color: #856404; }
        .status-confirmed { background-color: #d4edda; color: #155724; }
        .status-cancelled { background-color: #f8d7da; color: #721c24; }
        .btn-action {
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 0.8rem;
            margin-right: 5px;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
        }
        .btn-approve { background-color: #28a745; color: white; border: 1px solid #28a745; }
        .btn-cancel { background-color: #dc3545; color: white; border: 1px solid #dc3545; }
        .btn-info { background-color: #0d6efd; color: white; border: 1px solid #0d6efd; }
        .btn-approve:hover { background-color: #218838; border-color: #1e7e34; }
        .btn-cancel:hover { background-color: #c82333; border-color: #bd2130; }
        .btn-info:hover { background-color: #0b5ed7; border-color: #0a58ca; }
        .no-actions { color: #6c757d; font-style: italic; }
        .case-message {
            max-width: 300px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
</head>
<body>
    <?php include_once './componets/sidebar.php'; ?>
    
    <div class="main-container">
        <div class="page-header">
            <h1>My Appointments</h1>
            <p class="text-muted">Manage your upcoming client appointments</p>
        </div>
        
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Client Name</th>
                                <th>Email</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Case Details</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($result->num_rows > 0): ?>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($row['client_name']) ?></td>
                                        <td><?= htmlspecialchars($row['client_email']) ?></td>
                                        <td><?= date('M j, Y', strtotime($row['date'])) ?></td>
                                        <td><?= date('h:i A', strtotime($row['appointment_time'])) ?></td>
                                        <td class="case-message" title="<?= htmlspecialchars($row['message']) ?>">
                                            <?= htmlspecialchars($row['message']) ?>
                                        </td>
                                        <td>
                                            <span class="status-badge status-<?= strtolower($row['status']) ?>">
                                                <?= ucfirst($row['status']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php if ($row['status'] === 'pending'): ?>
                                                <a href="approve.php?id=<?= $row['id'] ?>" class="btn-action btn-approve">
                                                    <i class="fas fa-check me-1"></i> Accept
                                                </a>
                
                                            <?php endif; ?>
                                            <a href="delete.php?id=<?= $row['id'] ?>" 
                                               class="btn-action btn-delete" style="background:#bfa14a; color:white; margin-bottom:5px;"
                                               onclick="return confirm('Are you sure you want to delete this appointment?');">
                                                <i class="fas fa-trash me-1"></i> Delete
                                            </a>
                                            <button 
                                                class="btn"  style="background:#bfa14a; color:white;"
                                                data-bs-toggle="modal"
                                                data-bs-target="#viewModal"
                                                data-client="<?= htmlspecialchars($row['client_name']) ?>"
                                                data-email="<?= htmlspecialchars($row['client_email']) ?>"
                                                data-date="<?= date('M j, Y', strtotime($row['date'])) ?>"
                                                data-time="<?= date('h:i A', strtotime($row['appointment_time'])) ?>"
                                                data-message="<?= htmlspecialchars($row['message']) ?>"
                                                data-status="<?= ucfirst($row['status']) ?>"
                                            >
                                                <i class="fas fa-eye me-1"></i> View
                                            </button>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                                        <h4>No Appointments Found</h4>
                                        <p class="text-muted">You don't have any appointments scheduled yet.</p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- View Appointment Modal -->
    <div class="modal fade" id="viewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Appointment Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Client Name:</strong> <span id="modalClient"></span></p>
                    <p><strong>Email:</strong> <span id="modalEmail"></span></p>
                    <p><strong>Date:</strong> <span id="modalDate"></span></p>
                    <p><strong>Time:</strong> <span id="modalTime"></span></p>
                    <p><strong>Status:</strong> <span id="modalStatus"></span></p>
                    <p><strong>Case Details:</strong></p>
                    <p id="modalMessage" class="border p-2 rounded bg-light"></p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const viewModal = document.getElementById('viewModal');
        viewModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            document.getElementById('modalClient').textContent = button.getAttribute('data-client');
            document.getElementById('modalEmail').textContent = button.getAttribute('data-email');
            document.getElementById('modalDate').textContent = button.getAttribute('data-date');
            document.getElementById('modalTime').textContent = button.getAttribute('data-time');
            document.getElementById('modalMessage').textContent = button.getAttribute('data-message');
            document.getElementById('modalStatus').textContent = button.getAttribute('data-status');
        });
    </script>
</body>
</html>