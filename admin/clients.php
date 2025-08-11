<?php 
include '../config/config.php'; 

// Fetch unique clients who booked appointments
$query = "
SELECT DISTINCT 
    u.u_id AS client_id,
    u.name AS client_name,
    u.email AS client_email
FROM appointments a
JOIN users u ON a.u_id = u.u_id
ORDER BY u.name ASC
";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Clients</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            display: none;
        }
        .main-container {
            padding: 20px;
            margin-left: 20%;
        }
        .clients-header {
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #003B46;
        }
        .clients-header h1 {
            font-weight: 700;
            color: #003B46;
           
        }
        .table-container {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            padding: 20px;
        }
        .table thead th {
            background-color: #003B46;
            color: #bfa14a;
            white-space: nowrap;
        }
        .table tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        .no-clients {
            text-align: center;
            padding: 50px 20px;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }

        .see{
            position: absolute;
            top: 20%;
            right: 5%;
        }

        @media (max-width: 768px) {
            .main-container {
                margin-left: 0;
                padding: 10px;
            }
        }
    </style>
</head>
<body>

    <?php include_once './componets/sidebar.php'; ?>
    
    <div class="main-container">
        <div class="clients-header d-flex flex-wrap justify-content-between align-items-center">
            <div>
                <h1>All Clients</h1>
                <p class="text-muted mb-0">List of all unique clients who booked an appointment</p>
            </div>
            <div class="see">
                <input type="text" id="searchInput" class="form-control" placeholder="Search clients...">
            </div>
        </div>

        <div class="table-container mt-3">
            <?php if (mysqli_num_rows($result) > 0): ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle" id="clientsTable">
                        <thead>
                            <tr>
                                <th> Client ID</th>
                                <th> Name</th>
                                <th> Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row = mysqli_fetch_assoc($result)): ?>
                                <tr>
                                    <td><?= $row['client_id']; ?></td>
                                    <td><?= htmlspecialchars($row['client_name']); ?></td>
                                    <td><?= htmlspecialchars($row['client_email']); ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="no-clients">
                    <i class="fas fa-user-slash fa-3x mb-3 text-muted"></i>
                    <h3>No Clients Found</h3>
                    <p class="text-muted">There are currently no clients in the system.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
   
        document.getElementById('searchInput').addEventListener('keyup', function () {
            let filter = this.value.toLowerCase();
            let rows = document.querySelectorAll('#clientsTable tbody tr');
            rows.forEach(row => {
                let text = row.innerText.toLowerCase();
                row.style.display = text.includes(filter) ? '' : 'none';
            });
        });
    </script>
</body>
</html>
