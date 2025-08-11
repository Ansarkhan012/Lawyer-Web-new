<?php 
include '../config/config.php';

// Total Lawyer
$lawyersQuery = "SELECT COUNT(*) as total_lawyers FROM lawyers WHERE status = 'approved'";
$lawyersResult = $conn->query($lawyersQuery);
$lawyersRow = $lawyersResult->fetch_assoc();
$totalLawyers = $lawyersRow['total_lawyers'] ?? 0;

// Total Appointments (This Week)
$startOfWeek = date('Y-m-d', strtotime("last Sunday"));
$endOfWeek = date('Y-m-d', strtotime("next Saturday"));

$appointmentsQuery = "SELECT COUNT(*) as total_appointments FROM appointments WHERE appointment_date BETWEEN '$startOfWeek' AND '$endOfWeek'";
$appointmentsResult = $conn->query($appointmentsQuery);
$appointmentsRow = $appointmentsResult->fetch_assoc();
$totalAppointments = $appointmentsRow['total_appointments'] ?? 0;


$latestAppointmentsQuery = "
    SELECT a.id, a.appointment_date, name AS client_name
    FROM appointments a
    LEFT JOIN users u ON u.u_id = u.u_id
    ORDER BY a.appointment_date DESC
    LIMIT 5
";
$latestAppointmentsResult = $conn->query($latestAppointmentsQuery);

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title><?php echo ucfirst($role ?? 'Admin'); ?> Dashboard</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<style>
body {
    margin: 0;
    font-family: 'Segoe UI', sans-serif;
    background-color: #f3f4f6;
}
.main-content {
    flex: 1;
    padding: 30px;
    margin-left: 20%;
}
.dashboard-header {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
}
.welcome-message h1 {
    font-weight: 700;
    color: #1f2937;
}
.welcome-message p {
    color: #6b7280;
    margin-bottom: 0;
}
.stats-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}
.stat-card {
    background: white;
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.05);
    transition: transform 0.2s ease;
    display: flex;
    align-items: center;
    gap: 15px;
}

.stat-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    color: white;
}
.stat-card h3 {
    color: #6b7280;
    font-size: 14px;
    margin-bottom: 5px;
}
.stat-card .value {
    font-size: 26px;
    font-weight: 700;
    color: #1f2937;
}
.recent-activity {
    background: white;
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.05);
}
.activity-item {
    display: flex;
    align-items: flex-start;
    gap: 15px;
    padding: 15px 0;
    border-bottom: 1px solid #f0f0f0;
}
.activity-item:last-child {
    border-bottom: none;
}
.activity-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #3b82f6;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
@media (max-width: 768px) {
    .main-content {
        padding: 20px;
    }
}
</style>
</head>
<body>

<?php include_once './componets/sidebar.php'; ?>

<div class="main-content">
    <div class="dashboard-header">
        <div class="welcome-message">
            <h1>Welcome, <?php echo ucfirst($name ?? 'User'); ?></h1>
            <p>Here's what's happening with your practice today</p>
        </div>
        <div class="date-display text-muted">
            <?php echo date('l, F j, Y'); ?>
        </div>
    </div>

    <div class="stats-container">
        <div class="stat-card">
            <div class="stat-icon" style="background:#bfa14a;"><i class="fas fa-user-tie"></i></div>
            <div>
                <h3>Total Lawyers</h3>
                <div class="value"><?= $totalLawyers ?></div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#bfa14a;"><i class="fas fa-calendar-check"></i></div>
            <div>
                <h3>Upcoming Appointments</h3>
                <div class="value"><?= $totalAppointments ?></div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#bfa14a;"><i class="fas fa-envelope"></i></div>
            <div>
                <h3>Client Messages</h3>
                <div class="value">14</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#bfa14a;"><i class="fas fa-briefcase"></i></div>
            <div>
                <h3>Completed Cases</h3>
                <div class="value">42</div>
            </div>
        </div>
    </div>


    <div class="recent-activity">
        <h2 class="mb-3">Recent Appointments</h2>
        <?php if ($latestAppointmentsResult && $latestAppointmentsResult->num_rows > 0): ?>
            <?php while ($row = $latestAppointmentsResult->fetch_assoc()): ?>
                <div class="activity-item">
                    <div class="activity-icon" style="background:#bfa14a;"><i class="fas fa-calendar-plus"></i></div>
                    <div>
                        <h5 class="mb-1"><?= htmlspecialchars($row['client_name'] ?? 'Unknown Client') ?></h5>
                        <p class="mb-0 text-muted">
                            <?= date('l, F j, Y', strtotime($row['appointment_date'])) ?>
                        </p>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="text-muted">No recent appointments found.</p>
        <?php endif; ?>
    </div>


    <div class="mt-4 d-flex flex-wrap gap-2">
        <a href="appointments.php" style="background:#bfa14a; color: white;" class="btn"><i class="fas fa-calendar"></i> View All Appointments</a>
        <a href="lawyers.php" style="background:#bfa14a; color: white;" class="btn"><i class="fas fa-user-tie"></i> Manage Lawyers</a>
        <a href="messages.php" style="background:#bfa14a; color: white;" class="btn"><i class="fas fa-envelope"></i> Client Messages</a>
        <a href="cases.php" style="background:#bfa14a; color: white;" class="btn"><i class="fas fa-briefcase"></i> Completed Cases</a>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
