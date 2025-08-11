<?php
include_once '../config/config.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && isset($_POST['lawyer_id'])) {
        $lawyer_id = intval($_POST['lawyer_id']);
        $action = $_POST['action'];

        if ($action === 'approve') {
            $update_query = "UPDATE lawyers SET status = 'approved' WHERE id = $lawyer_id";
            $success_message = "Lawyer approved successfully!";
        } elseif ($action === 'reject') {
            $update_query = "UPDATE lawyers SET status = 'rejected' WHERE id = $lawyer_id";
            $success_message = "Lawyer rejected successfully!";
        }

        if (isset($update_query)) {
            if (mysqli_query($conn, $update_query)) {
                $_SESSION['message'] = $success_message;
                $_SESSION['message_type'] = 'success';
            } else {
                $_SESSION['message'] = "Error: " . mysqli_error($conn);
                $_SESSION['message_type'] = 'danger';
            }
            header("Location: new_lawyer.php");
            exit();
        }
    }
}

$query = "SELECT * FROM lawyers WHERE status = 'pending'";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>New Lawyer Requests</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <style>
    * {
      font-family: 'Georgia', serif;
    }

    body {

      display: flex;
    }

    .main-content {
      flex: 1;
      padding: 40px;
      background-color: #fff;
      margin-left: 20%;
    }

    .page-header {
      margin-bottom: 30px;
      border-bottom: 2px solid #003B46;
      padding-bottom: 10px;
    }

    .page-header h2 {
      color: #003B46;
      font-weight: bold;
    }

    .table-container {
 
      padding: 25px;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

   

    .table td {
      vertical-align: middle;
    }

    .btn-approve {
      background-color: #2f855a;
      border: none;
      font-weight: bold;
    }

    .btn-reject {
      background-color: #c53030;
      border: none;
      font-weight: bold;
    }

    .btn-approve:hover,
    .btn-reject:hover {
      opacity: 0.9;
    }

    .document-link {
      color: #bfa14a;
      font-weight: bold;
      text-decoration: none;
    }

    .document-link:hover {
      text-decoration: underline;
    }

    .action-form {
      display: inline-block;
      margin-right: 8px;
    }

    .alert {
      margin-top: 10px;
      font-size: 15px;
    }

    @media (max-width: 768px) {
      .main-content {
        padding: 20px;
      }

      .action-form {
        display: block;
        margin-bottom: 10px;
      }
    }
  </style>
</head>
<body>

<?php include_once './componets/sidebar.php'; ?>

<div class="main-content">
  <div class="page-header">
    <h2>New Lawyer Requests</h2>
  </div>

  <?php if (isset($_SESSION['message'])): ?>
    <div class="alert alert-<?= $_SESSION['message_type'] ?> alert-dismissible fade show" role="alert">
      <?= $_SESSION['message'] ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php unset($_SESSION['message'], $_SESSION['message_type']); ?>
  <?php endif; ?>

  <div class="table-container">
    <?php if (mysqli_num_rows($result) > 0): ?>
      <div class="table-responsive">
        <table class="table table-hover align-middle">
          <thead>
            <tr>
              <th>Name</th>
              <th>Email</th>
              <th>Experience</th>
              <th>Specialization</th>
              <th>Documents</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
              <tr>
                <td><?= htmlspecialchars($row['name']); ?></td>
                <td><?= htmlspecialchars($row['email']); ?></td>
                <td><?= htmlspecialchars($row['experience']); ?> years</td>
                <td><?= htmlspecialchars($row['specialization'] ?? 'Not specified'); ?></td>
                <td>
                  <a href="../uploads/licenses/<?= htmlspecialchars($row['licence_file']); ?>" class="document-link" target="_blank">
                    <i class="fas fa-file-pdf me-1"></i>License
                  </a>
                  <?php if (!empty($row['cv_file'])): ?>
                    <br>
                    <a href="../uploads/cvs/<?= htmlspecialchars($row['cv_file']); ?>" class="document-link" target="_blank">
                      <i class="fas fa-file-alt me-1"></i>CV
                    </a>
                  <?php endif; ?>
                </td>
                <td>
                  <form method="post" class="action-form">
                    <input type="hidden" name="lawyer_id" value="<?= $row['id']; ?>">
                    <input type="hidden" name="action" value="approve">
                    <button type="submit" class="btn btn-sm btn-approve text-black">
                      <i class="fas fa-check me-1"></i>Approve
                    </button>
                  </form>
                  <form method="post" class="action-form" onsubmit="return confirm('Are you sure you want to reject this lawyer application?');">
                    <input type="hidden" name="lawyer_id" value="<?= $row['id']; ?>">
                    <input type="hidden" name="action" value="reject">
                    <button type="submit" class="btn btn-sm btn-reject text-black">
                      <i class="fas fa-times me-1"></i>Reject
                    </button>
                  </form>
                </td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    <?php else: ?>
      <div class="alert alert-info">
        <i class="fas fa-info-circle me-2"></i>No pending lawyer requests at the moment.
      </div>
    <?php endif; ?>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
