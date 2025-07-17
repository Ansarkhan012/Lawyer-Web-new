<?php 
session_start();
if(!isset($_SESSION["role"]) || $_SESSION["role"]!="admin"){
  header("Location: ../user/login.php");
}
require_once "../config/config.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Lawyer Dashboard</title>
<style>
  /* Global box-sizing */
  *, *::before, *::after {
      box-sizing: border-box;
  }

  /* Reset */
  body, h1, h2, h3, p, ul, li, table {
      margin: 0;
      padding: 0;
      font-family: Arial, sans-serif;
  }

  body {
      display: flex;
      flex-direction: row;
      min-height: 100vh;
      background: #f4f7fa;
  }

  /* Sidebar */
  .sidebar {
      width: 220px;
      background-color: #c49300;
      color: #ecf0f1;
      padding: 20px;
      flex-shrink: 0;
      height: 100vh;
      overflow-y: auto;
  }

  .sidebar h2 {
      margin-bottom: 30px;
      font-weight: 700;
      font-size: 24px;
  }

  .sidebar ul {
      list-style: none;
  }

  .sidebar ul li {
      margin-bottom: 15px;
  }

  .sidebar ul li a {
      color: #ffffff;
      text-decoration: none;
      font-weight: 600;
      display: block;
      padding: 8px 12px;
      border-radius: 4px;
      transition: background 0.3s ease;
  }

  .sidebar ul li a:hover {
      background-color: #34495e;
  }

  /* Main content */
  .main-content {
      flex-grow: 1;
      padding: 20px 40px;
      overflow-y: auto;
      min-height: 100vh;
      background: #f4f7fa;
  }

  header {
      margin-bottom: 30px;
  }

  header h1 {
      font-weight: 700;
      font-size: 28px;
      color: #34495e;
  }

  /* Stats boxes */
  .stats-container {
      display: flex;
      gap: 20px;
      margin-bottom: 40px;
  }

  .stat-box {
      background-color: #c49300;
      color: white;
      padding: 20px;
      border-radius: 8px;
      flex: 1;
      text-align: center;
      box-shadow: 0 3px 6px rgba(0,0,0,0.1);
      transition: background-color 0.3s ease;
  }

  .stat-box h3 {
      font-size: 18px;
      margin-bottom: 10px;
  }

  .stat-box p {
      font-size: 24px;
      font-weight: 700;
  }

  .stat-box:hover {
      background-color: #ad8200;
  }

  /* Reports table */
  .reports h2 {
      margin-bottom: 15px;
      color: #34495e;
  }

  .table-container {
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 3px 6px rgba(0,0,0,0.1);
      background-color: white;
  }

  table {
      width: 100%;
      border-collapse: collapse;
  }

  th, td {
      padding: 12px 15px;
      border-bottom: 1px solid #ddd;
      text-align: left;
  }

  th {
      background-color: #967102;
      color: white;
  }

  tr:hover {
      background-color: #f1f1f1;
  }

  /* Responsive */
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
          min-height: auto;
      }
      .stats-container {
          flex-direction: column;
          gap: 15px;
      }
  }
</style>
</head>
<body>

  <aside class="sidebar">
    <h2>Lawyer Dashboard</h2>
    <ul>
      <li><a href="#">Home</a></li>
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
        <h3>Clients</h3>
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
