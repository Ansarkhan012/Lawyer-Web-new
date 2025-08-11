
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?php echo ucfirst($role); ?> Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      margin: 0;
      font-family: 'Georgia', serif;
      display: flex;
      background-color: #f3f4f6;
    }

    .sidebar {
      position: fixed;
      width: 20%;
      height: 100vh;
      background-color: #2c3e50;
      color: #fff;
      padding: 30px 20px;
      box-shadow: 2px 0 8px rgba(0, 0, 0, 0.15);
    }

    .sidebar-header {
      font-size: 24px;
      font-weight: bold;
      margin-bottom: 40px;
      color: #bfa14a;
      letter-spacing: 2px;
    }

    .sidebar a {
      display: block;
      text-decoration: none;
      color: #fff;
      padding: 12px 16px;
      border-radius: 8px;
      margin-bottom: 14px;
      transition: 0.3s;
      font-weight: 600;
    }

    .sidebar a:hover {
      background-color: #bfa14a;
      color: #1f2937;
    }

  

    @media (max-width: 768px) {
      .sidebar {
        width: 30%;
        min-height: auto;
        padding: 20px 15px;
      }

      .sidebar-header{
        font-size: large;
      }

      .sidebar a{
        font-size: small
      }
    }
  </style>
</head>
<body>

  <div class="sidebar">
    <div class="sidebar-header">
      Lawyer Panel
    </div>

    <a href="index.php">Dashboard</a>
      <a href="myCases.php">My Cases</a>
      <a href="laywer_appointment.php">My Appointments</a>
  
      <a href="reports.php">Reports</a>

    <a href="./logout.php">Logout</a>
  </div>



</body>
</html>
