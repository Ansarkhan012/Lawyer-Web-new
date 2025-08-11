<?php
session_start();
require_once '../config/config.php';

// Check if lawyer is logged in
if (!isset($_SESSION['lawyer_id'])) {
    header("Location: ../login.php");
    exit();
}

// Get case ID from URL
$case_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($case_id <= 0) {
    header("Location: cases.php");
    exit();
}

// Get case details
$query = "
SELECT 
    a.id AS case_id,
    a.case_details,
    a.appointment_date,
    a.appointment_time,
    a.status,
    a.created_at,
    u.name AS client_name,
    u.email AS client_email,
    l.name AS lawyer_name,
    l.specialization
FROM appointments a
JOIN users u ON a.u_id = u.u_id
JOIN lawyers l ON a.lawyer_id = l.id
WHERE a.id = ? AND a.lawyer_id = ?
";

$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $case_id, $_SESSION['lawyer_id']);
$stmt->execute();
$result = $stmt->get_result();
$case = $result->fetch_assoc();

if (!$case) {
    header("Location: cases.php");
    exit();
}

// Update status if form submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['status'])) {
    $new_status = $_POST['status'];
    $update_query = "UPDATE appointments SET status = ? WHERE id = ? AND lawyer_id = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("sii", $new_status, $case_id, $_SESSION['lawyer_id']);
    $update_stmt->execute();
    
    // Refresh case data
    $stmt->execute();
    $result = $stmt->get_result();
    $case = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Case Details - <?= htmlspecialchars($case['case_id']) ?></title>
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
        
        .case-header {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            padding: 25px;
            margin-bottom: 30px;
        }
        
        .case-id {
            color: var(--primary-color);
            font-weight: 700;
        }
        
        .status-badge {
            padding: 5px 15px;
            border-radius: 20px;
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
        
        .case-details-card {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            padding: 25px;
            margin-bottom: 30px;
        }
        
        .detail-label {
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 5px;
        }
        
        .detail-value {
            margin-bottom: 20px;
            padding-left: 15px;
        }
        
        .btn-update {
            background-color: var(--accent-color);
            color: white;
            border: none;
            padding: 8px 20px;
            font-weight: 600;
        }
        
        .btn-update:hover {
            background-color: var(--primary-color);
            color: white;
        }
        
        .timeline {
            position: relative;
            padding-left: 30px;
        }
        
        .timeline::before {
            content: '';
            position: absolute;
            left: 10px;
            top: 0;
            bottom: 0;
            width: 2px;
            background-color: #e9ecef;
        }
        
        .timeline-item {
            position: relative;
            padding-bottom: 20px;
        }
        
        .timeline-item::before {
            content: '';
            position: absolute;
            left: -30px;
            top: 5px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background-color: var(--accent-color);
            border: 2px solid white;
        }
        
        .timeline-date {
            font-size: 0.85rem;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <?php include_once './componets/sidebar.php'; ?>
    
    <div class="main-container">
        <div class="case-header">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <h1>Case <span class="case-id">#<?= htmlspecialchars($case['case_id']) ?></span></h1>
                    <p class="text-muted">Detailed view of the case</p>
                </div>
                <span class="status-badge status-<?= strtolower($case['status']) ?>">
                    <?= ucfirst($case['status']) ?>
                </span>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-8">
                <div class="case-details-card">
                    <h3 class="mb-4">Case Details</h3>
                    <div class="detail-label">Case Description:</div>
                    <div class="detail-value">
                        <?= nl2br(htmlspecialchars($case['case_details'])) ?>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="detail-label">Appointment Date:</div>
                            <div class="detail-value">
                                <i class="far fa-calendar-alt me-2"></i>
                                <?= date('F j, Y', strtotime($case['appointment_date'])) ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-label">Appointment Time:</div>
                            <div class="detail-value">
                                <i class="far fa-clock me-2"></i>
                                <?= date('h:i A', strtotime($case['appointment_time'])) ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="detail-label">Date Created:</div>
                    <div class="detail-value">
                        <i class="far fa-calendar me-2"></i>
                        <?= date('F j, Y \a\t h:i A', strtotime($case['created_at'])) ?>
                    </div>
                </div>
                
                <div class="case-details-card">
                    <h3 class="mb-4">Case Timeline</h3>
                    <div class="timeline">
                        <div class="timeline-item">
                            <h5>Case Created</h5>
                            <div class="timeline-date"><?= date('M j, Y', strtotime($case['created_at'])) ?></div>
                            <p>Case was initially created by the client.</p>
                        </div>
                        <div class="timeline-item">
                            <h5>Appointment Scheduled</h5>
                            <div class="timeline-date"><?= date('M j, Y', strtotime($case['appointment_date'])) ?></div>
                            <p>Appointment scheduled for consultation.</p>
                        </div>
                        <!-- Additional timeline items can be added dynamically from database -->
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="case-details-card">
                    <h3 class="mb-4">Client Information</h3>
                    
                    <div class="detail-label">Client Name:</div>
                    <div class="detail-value">
                        <i class="fas fa-user me-2"></i>
                        <?= htmlspecialchars($case['client_name']) ?>
                    </div>
                    
                    <div class="detail-label">Email:</div>
                    <div class="detail-value">
                        <i class="fas fa-envelope me-2"></i>
                        <a href="mailto:<?= htmlspecialchars($case['client_email']) ?>">
                            <?= htmlspecialchars($case['client_email']) ?>
                        </a>
                    </div>
                    
                    <div class="detail-label">Phone:</div>
                    <div class="detail-value">
                        <i class="fas fa-phone me-2"></i>
                        <?= htmlspecialchars($case['client_phone']) ?>
                    </div>
                </div>
                
                <div class="case-details-card">
                    <h3 class="mb-4">Assigned Lawyer</h3>
                    
                    <div class="detail-label">Lawyer Name:</div>
                    <div class="detail-value">
                        <i class="fas fa-user-tie me-2"></i>
                        <?= htmlspecialchars($case['lawyer_name']) ?>
                    </div>
                    
                    <div class="detail-label">Specialization:</div>
                    <div class="detail-value">
                        <i class="fas fa-briefcase me-2"></i>
                        <?= htmlspecialchars($case['specialization']) ?>
                    </div>
                </div>
                
                
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>