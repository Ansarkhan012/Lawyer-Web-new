
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Manage Lawyers</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <style>
    body {
      margin: 0;
      font-family: 'Georgia', serif;
      display: flex;
      background-color: #f3f4f6;
    }

    .main-content {
      flex: 1;
      padding: 30px;
      margin-left: 20%;
    }

    .page-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 30px;
    }

    .page-title h1 {
      color: #2c3e50;
      font-weight: 700;
    }

    .btn-primary {
      background-color: #2c3e50;
      border-color: #2c3e50;
    }

    .btn-primary:hover {
      background-color: #1a252f;
      border-color: #1a252f;
    }

    .table-container {
      background: white;
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }

    .table th {
      background-color: #2c3e50;
      color: white;
    }

    .status-active {
      color: #38a169;
      font-weight: 600;
    }

    .status-inactive {
      color: #e53e3e;
      font-weight: 600;
    }

    .action-btn {
      padding: 5px 10px;
      margin: 0 3px;
    }

    @media (max-width: 768px) {
      .main-content {
        margin-left: 0;
        padding: 20px;
      }
    }
  </style>
</head>
<body>

  <?php include_once './componets/sidebar.php'; ?>

  <div class="main-content">
    <div class="page-header">
      <div class="page-title">
        <h1>Manage Lawyers</h1>
      </div>
      <div>
        <a href="../user/signup_lawyer.php"><button style="background:#bfa14a; color: white;" class="btn" data-bs-toggle="modal" data-bs-target="#addLawyerModal">
          <i class="fas fa-plus"></i> Add New Lawyer
        </button></a>
      </div>
    </div>

    <div class="table-container">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Specialization</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
  <?php
    require_once '../config/config.php';

    $query = "SELECT id, name, email, specialization, status FROM lawyers";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
        $statusClass = ($row['status'] == 'active') ? 'status-active' : 'status-inactive';
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['name']}</td>
                <td>{$row['email']}</td>
                <td>{$row['specialization']}</td>
                <td class='{$statusClass}'>" . ucfirst($row['status']) . "</td>
                <td>
                  <a href='view_lawyer.php?id={$row['id']}' class='btn btn-sm btn-outline-primary action-btn'>
                    <i class='fas fa-eye'></i>
                  </a>
                  <a href='edit_lawyer.php?id={$row['id']}' class='btn btn-sm btn-outline-success action-btn'>
                    <i class='fas fa-edit'></i>
                  </a>
                  <a href='delete_lawyer.php?id={$row['id']}' 
                     class='btn btn-sm btn-outline-danger action-btn' 
                     onclick='return confirm(\"Are you sure you want to delete this lawyer?\");'>
                    <i class='fas fa-trash-alt'></i>
                  </a>
                </td>
              </tr>";
      }
    } else {
      echo "<tr><td colspan='6' class='text-center'>No lawyers found</td></tr>";
    }
    
  ?>
</tbody>

      </table>
    </div>

 


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>