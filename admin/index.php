<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Lawyer Dashboard</title>
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
      display: flex;
      min-height: 100vh;
      background-color: #f5f7fa;
      color: #333;
    }

    .sidebar {
      width: 220px;
      background: #003B46;
      color: #fff;
      padding: 30px 20px;
    }

    .sidebar h2 {
      font-size: 22px;
      margin-bottom: 30px;
    }

    .sidebar ul {
      list-style: none;
    }

    .sidebar ul li {
      margin-bottom: 15px;
    }

    .sidebar ul li a {
      color: #fff;
      text-decoration: none;
      padding: 10px;
      display: block;
      border-radius: 5px;
      transition: background 0.2s ease;
    }

    .sidebar ul li a:hover {
      background: #025e6a;
    }

    .main-content {
      flex: 1;
      padding: 40px;
      background-color: #fff;
    }

    header h1 {
      font-size: 28px;
      margin-bottom: 30px;
      color: #003B46;
    }

    .stats-container {
      display: flex;
      gap: 20px;
      margin-bottom: 40px;
      flex-wrap: wrap;
    }

    .stat-box {
      flex: 1;
      background: #007C91;
      color: #fff;
      padding: 20px;
      border-radius: 8px;
      min-width: 200px;
      text-align: center;
      transition: background 0.3s;
    }

    .stat-box:hover {
      background: #00A6B4;
    }

    .stat-box h3 {
      font-size: 16px;
      margin-bottom: 10px;
    }

    .stat-box p {
      font-size: 24px;
      font-weight: bold;
    }

    .reports h2 {
      margin-bottom: 20px;
      color: #003B46;
    }

    .table-container {
      overflow-x: auto;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      border-radius: 8px;
      overflow: hidden;
    }

    th, td {
      padding: 14px;
      border-bottom: 1px solid #ddd;
      text-align: left;
    }

    th {
      background: #007C91;
      color: #fff;
    }

    tr:hover {
      background: #f0f0f0;
    }

    @media (max-width: 768px) {
      body {
        flex-direction: column;
      }

      .sidebar {
        width: 100%;
        height: auto;
      }

      .main-content {
        padding: 20px;
      }

      .stats-container {
        flex-direction: column;
      }
    }
  </style>
</head>
<body>

  <aside class="sidebar">
    <h2>Admin Panel</h2>
    <ul>
      <li><a href="#">Dashboard</a></li>
      <li><a href="#">Lawyers</a></li>
      <li><a href="#">Appointments</a></li>
      <li><a href="#">Cases</a></li>
      <li><a href="#">Clients</a></li>
      <li><a href="#">Settings</a></li>
      <li><a href="#">Logout</a></li>
    </ul>
  </aside>

  <main class="main-content">
    <header>
      <h1>Dashboard Overview</h1>
    </header>

    <section class="stats-container">
      <div class="stat-box">
        <h3>Active Cases</h3>
        <p>27</p>
      </div>
      <div class="stat-box">
        <h3>Upcoming Appointments</h3>
        <p>8</p>
      </div>
      <div class="stat-box">
        <h3>Total Clients</h3>
        <p>125</p>
      </div>
    </section>

    <section class="reports">
      <h2>Recent Case Reports</h2>
      <div class="table-container">
        <table>
          <thead>
            <tr>
              <th>Date</th>
              <th>Case Name</th>
              <th>Status</th>
              <th>Download</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>2025-07-10</td>
              <td>Johnson vs. Smith</td>
              <td>Open</td>
              <td><a href="#">Download</a></td>
            </tr>
            <tr>
              <td>2025-07-05</td>
              <td>Estate Settlement</td>
              <td>Closed</td>
              <td><a href="#">Download</a></td>
            </tr>
            <tr>
              <td>2025-07-01</td>
              <td>Contract Dispute</td>
              <td>Open</td>
              <td><a href="#">Download</a></td>
            </tr>
          </tbody>
        </table>
      </div>
    </section>
  </main>

</body>
</html>
