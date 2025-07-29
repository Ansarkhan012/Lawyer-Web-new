<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Role-Based Sidebar</title>
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      display: flex;
    }

    .sidebar {
      width: 240px;
      min-height: 100vh;
      background-color: #003B46;
      color: #fff;
      padding: 25px 20px;
      box-sizing: border-box;
    }

    .sidebar-header {
      font-size: 22px;
      font-weight: bold;
      margin-bottom: 35px;
    }

    .sidebar a {
      display: block;
      text-decoration: none;
      color: #fff;
      padding: 10px 14px;
      border-radius: 6px;
      margin-bottom: 12px;
      transition: all 0.3s ease;
      font-weight: 500;
    }

    .sidebar a:hover {
      background-color: #ffc107;
      color: #000;
    }

    .content {
      flex-grow: 1;
      padding: 30px;
    }

    @media (max-width: 768px) {
      .sidebar {
        width: 100%;
        min-height: auto;
      }
    }
  </style>
</head>
<body>

  <div class="sidebar">
    <div class="sidebar-header">
      <?php echo ucfirst($role); ?> Panel
    </div>

    <a href="#">Dashboard</a>

    <?php if ($role === "admin") : ?>
      <a href="#">Clients</a>
      <a href="#">Cases</a>
      <a href="#">Lawyers</a>
      <a href="#">New Lawyer Request</a>
      <a href="#">Appointments</a>
      <a href="#">Settings</a>
    <?php elseif ($role === "lawyer") : ?>
      <a href="#">My Cases</a>
      <a href="#">My Appointments</a>
      <a href="#">Client Messages</a>
      <a href="#">Reports</a>
    <?php endif; ?>

    <a href="#">Logout</a>
  </div>

</body>
</html>
