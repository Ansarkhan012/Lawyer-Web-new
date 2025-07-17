<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Admin Lawyer Sidebar</title>
<style>
  body {
    margin: 0;
    font-family: Arial, sans-serif;
   
  }

  /* Sidebar container */
  .sidebar {
    width: 250px;
    height: 100vh;
   
    display: flex;
    flex-direction: column;
    padding: 20px;
    border-right:2px solid gray;
    box-sizing: border-box;
  }

  /* Sidebar header */
  .sidebar-header {
    font-size: 24px;
    font-weight: bold;
    color: #333;
    margin-bottom: 40px;
  }

  /* Sidebar links */
  .sidebar a {
    text-decoration: none;
    color: white;
    padding: 12px 15px;
    margin-bottom: 10px;
    border-radius: 6px;
    font-weight: 600;
    transition: background-color 0.3s ease;
  }

  .sidebar a:hover {
    background-color: #FFC107; /* Darker yellow on hover */
    color: #000;
  }

  /* Main content area */
  .content {
    flex-grow: 1;
    padding: 20px;
  }
</style>
</head>
<body>

  <div class="sidebar">
    <div class="sidebar-header">Admin Lawyer</div>
    <a href="#">Dashboard</a>
    <a href="#">Clients</a>
    <a href="#">Cases</a>
    <a href="#">Lawyers</a>
    <a href="#">Apoinments</a>
    <a href="#">Settings</a>
    <a href="#">Logout</a>
  </div>



</body>
</html>
