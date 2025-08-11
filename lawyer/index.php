<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'lawyer') {
    header('Location: ../user/lawyer_login.php');
    exit();
}

// Database connection
require_once '../config/config.php';
$lawyer_id = $_SESSION['lawyer_id'];
$lawyer_name = $_SESSION['lawyer_name'] ?? 'Attorney';




// Total appointments
$stmt = $conn->prepare("SELECT COUNT(*) as total FROM appointments WHERE lawyer_id = ?");
$stmt->bind_param("i", $lawyer_id);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();
$appointments_total = $result['total'] ?? 0;


$stmt = $conn->prepare("SELECT COUNT(*) as pending FROM appointments WHERE lawyer_id = ? AND status = 'pending'");
$stmt->bind_param("i", $lawyer_id);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();
$appointments_pending = $result['pending'] ?? 0;


$upcoming_hearings = []; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attorney Dashboard - <?php echo htmlspecialchars($lawyer_name); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        
        :root {
            --primary-dark: #1a365d;
            --primary: #2c5282;
            --primary-light: #4299e1;
            --accent: #e53e3e;
            --success: #38a169;
            --warning: #dd6b20;
            --light-bg: #f7fafc;
            --card-bg: #ffffff;
            --text-dark: #2d3748;
            --text-light: #718096;
            --border-radius: 0.5rem;
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.12);
        }
        body {
            font-family: 'Segoe UI', system-ui, sans-serif;
            background-color: var(--light-bg);
            color: var(--text-dark);
            margin: 0;
            padding: 0;
            display: flex;
        }
        .dashboard-container { 
            display: flex; flex: 1; min-height: 100vh;
         }

        .main-content { 
            flex: 1; padding: 2rem; margin-left: 20%;
         }
        .welcome-card { 
            background: var(--card-bg); border-radius: var(--border-radius); padding: 1.5rem; margin-bottom: 1.5rem; box-shadow: var(--shadow-sm); border-left: 4px solid var(--primary); 
        }
        .welcome-title { 
            font-weight: 700; color: var(--primary-dark); margin-bottom: 0.5rem;
         }
        .welcome-subtitle { 
            color: var(--text-light); font-size: 1rem;
         }
        .stats-grid {
             display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px; margin-bottom: 30px; 
            }
        .stat-card { 
            background: white; border-radius: 12px; padding: 20px; box-shadow: var(--shadow-sm); transition: transform 0.2s ease; }
       
        .stat-header { 
            display: flex; align-items: center; justify-content: space-between; margin-bottom: 15px; 
        }
        .stat-title { 
            font-size: 14px; font-weight: 600; color: var(--text-light); 
        }
        .stat-icon { width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 20px; color: white; }
        .stat-value { font-size: 26px; font-weight: 700; color: var(--text-dark); margin-bottom: 5px; }
        .stat-change { font-size: 12px; }
        .positive-change { color: var(--success); }
        .warning-change { color: var(--warning); }
        .negative-change { color: var(--accent); }
        .section-card { background: var(--card-bg); border-radius: var(--border-radius); padding: 1.5rem; margin-bottom: 1.5rem; box-shadow: var(--shadow-sm); }
        .section-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1rem; }
        .section-title { font-size: 1.25rem; font-weight: 600; color: var(--primary-dark); }
        .view-all { font-size: 0.9rem; color: var(--primary); text-decoration: none; }
        .view-all:hover { text-decoration: underline; }
    </style>
</head>
<body>

<?php include_once './componets/sidebar.php'; ?>
<div class="dashboard-container">
    <div class="main-content">
        <!-- Welcome Section -->
        <div class="welcome-card">
            <h1 class="welcome-title">Welcome, <?php echo htmlspecialchars($lawyer_name); ?></h1>
            <p class="welcome-subtitle">Your legal practice overview</p>
        </div>

        <!-- Stats Cards -->
        <div class="stats-grid">
            <!-- Appointments -->
            <div class="stat-card">
                <div class="stat-header">
                    <span class="stat-title">Appointments</span>
                    <div class="stat-icon" style="background:#bfa14a;">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                </div>
                <div class="stat-value"><?php echo $appointments_total; ?></div>
                <div class="stat-change positive-change">
                    <i class="fas fa-chart-line"></i> Total booked
                </div>
            </div>

        
            <div class="stat-card">
                <div class="stat-header">
                    <span class="stat-title">Pending Appointments</span>
                    <div class="stat-icon" style="background:#bfa14a;">
                        <i class="fas fa-clock"></i>
                    </div>
                </div>
                <div class="stat-value"><?php echo $appointments_pending; ?></div>
                <div class="stat-change warning-change" >
                    <i class="fas fa-exclamation-circle"></i> Awaiting confirmation
                </div>
            </div>

         
            <div class="stat-card">
                <div class="stat-header">
                    <span class="stat-title">Unread Messages</span>
                    <div class="stat-icon" style="background:#bfa14a;">
                        <i class="fas fa-envelope"></i>
                    </div>
                </div>
                <div class="stat-value"><?php echo $message_stats['unread_messages'] ?? 0; ?></div>
                <div class="stat-change negative-change">
                    <i class="fas fa-clock"></i> Requires attention
                </div>
            </div>
        </div>

        
        <div class="section-card">
            <div class="section-header">
                <h2 class="section-title">Quick Actions</h2>
            </div>
            <div class="row">
                <div class="col-md-3 col-6 mb-3">
                    <a href="myCases.php" style="background:#bfa14a; color:white;" class="btn w-100 py-2">
                        My Cases
                    </a>
                </div>
                <div class="col-md-3 col-6 mb-3">
                    <a href="laywer_appointment.php" style="background:#bfa14a; color:white;" class="btn w-100 py-2">
                        My Appointments
                    </a>
                </div>
                <div class="col-md-3 col-6 mb-3">
                    <a href="reports.php" style="background:#bfa14a; color:white;" class="btn w-100 py-2">
                         Report
                    </a>
                </div>
           
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
