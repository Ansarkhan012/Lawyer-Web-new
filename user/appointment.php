<?php
session_start();
require_once '../config/config.php';


if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'user') {
    header('Location: login.php');
    exit();
}

$check = $conn->prepare("SELECT id FROM appointments WHERE u_id = ? AND status = 'pending'");
$check->bind_param("i", $user_id);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
    echo "<script>alert('You already have a pending appointment. Please wait for a response.'); window.location.href='./my-appointments.php';</script>";
    exit();
}

$user_id = $_SESSION['u_id'] ?? null;

if (!$user_id) {
    die("User ID missing.");
}

// Fetch user's appointments with detailed lawyer info (removed file_path/file_type)
$sql = "SELECT a.id, a.appointment_date, a.appointment_time, a.status, 
               a.case_details,
               l.id AS lawyer_id, l.name AS lawyer_name, l.specialization, 
               l.experience, l.profile_image, l.phone, l.email AS lawyer_email,
               l.status AS lawyer_status
        FROM appointments a
        JOIN lawyers l ON a.lawyer_id = l.id
        WHERE a.u_id = ?
        ORDER BY a.appointment_date DESC, a.appointment_time DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
<head>
    <title>My Appointments</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f5f5f5;
        }

        
        .appointment-card {
            background: white;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
      
        .appointment-label {
            font-weight: 600;
            color: #495057;
            font-size: 0.9rem;
        }
        .appointment-value {
            color: #212529;
            margin-bottom: 12px;
            font-size: 1rem;
        }
        .lawyer-img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid #fff;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            display: inline-block;
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
        .lawyer-status {
            font-size: 0.8rem;
            padding: 3px 8px;
            border-radius: 4px;
        }
        .lawyer-approved {
            background-color: #d4edda;
            color: #155724;
        }
        .lawyer-pending {
            background-color: #fff3cd;
            color: #856404;
        }
        .lawyer-rejected {
            background-color: #f8d7da;
            color: #721c24;
        }
        .contact-info {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            margin-top: 15px;
        }
        .experience-badge {
            background-color: #e9ecef;
            color: #495057;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 0.8rem;
        }
    </style>
</head>
<body>
<?php 
include_once './components/navbar.php';
?>
<div class="container">
    <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
        <h2 class="mb-0"><i class="fas fa-calendar-alt me-2"></i>My Appointments</h2>
        <a href="consultant.php"  style="background:#bfa14a; color:white;"  class="btn">
            <i class="fas fa-plus me-1"></i> Book New Appointment
        </a>
    </div>

    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="appointment-card">
                <div class="row">
                    <div class="col-md-2 text-center">
                        <?php if ($row['profile_image']): ?>
                            <img src="../uploads/profile_images/<?= htmlspecialchars($row['profile_image']) ?>" 
                                 alt="Lawyer Image" class="lawyer-img mb-3">
                        <?php else: ?>
                            <img src="https://via.placeholder.com/100?text=<?= substr($row['lawyer_name'], 0, 1) ?>" 
                                 alt="Default Image" class="lawyer-img mb-3">
                        <?php endif; ?>
                        <div class="lawyer-status lawyer-<?= $row['lawyer_status'] ?> mb-2">
                            Lawyer: <?= ucfirst($row['lawyer_status']) ?>
                        </div>
                    </div>
                    <div class="col-md-10">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h4 class="mb-1"><?= htmlspecialchars($row['lawyer_name']) ?></h4>
                                        <div class="text-muted mb-2"><?= htmlspecialchars($row['specialization']) ?></div>
                                        <div class="experience-badge">
                                            <?= $row['experience'] ?>+ years experience
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <span class="status-badge status-<?= $row['status'] ?>">
                                            <?= ucfirst($row['status']) ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <span class="appointment-label">Appointment Date:</span>
                                        <div class="appointment-value">
                                            <i class="far fa-calendar-alt me-2"></i>
                                            <?= date('F j, Y', strtotime($row['appointment_date'])) ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <span class="appointment-label">Appointment Time:</span>
                                        <div class="appointment-value">
                                            <i class="far fa-clock me-2"></i>
                                            <?= date('h:i A', strtotime($row['appointment_time'])) ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php if (!empty($row['case_details'])): ?>
                            <div class="mb-3">
                                <span class="appointment-label">Appointment Notes:</span>
                                <div class="appointment-value p-3 bg-light rounded">
                                    <?= nl2br(htmlspecialchars($row['case_details'])) ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="contact-info">
                            <h5 class="mb-3"><i class="fas fa-address-card me-2"></i>Lawyer Contact Information</h5>
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <span class="appointment-label">Email:</span>
                                    <div class="appointment-value">
                                        <i class="fas fa-envelope me-2"></i>
                                        <a href="mailto:<?= htmlspecialchars($row['lawyer_email']) ?>">
                                            <?= htmlspecialchars($row['lawyer_email']) ?>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <span class="appointment-label">Phone:</span>
                                    <div class="appointment-value">
                                        <i class="fas fa-phone me-2"></i>
                                        <?= htmlspecialchars($row['phone']) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <div class="alert alert-info text-center py-4">
            <i class="fas fa-calendar-times fa-3x mb-3" style="color: #6c757d;"></i>
            <h4>No Appointments Found</h4>
            <p class="mb-0">You haven't booked any appointments yet. Click the button below to book your first appointment.</p>
            <a href="consultant.php" style="background:#bfa14a; color:white;" class="btn mt-3">
                 Book Appointment
            </a>
        </div>
    <?php endif; ?>
    </div>

<div>
    
<?php 
include_once './components/footer.php'
?>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>