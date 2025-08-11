<?php
require_once '../config/config.php';

if (!isset($_GET['id'])) {
    die("Invalid request");
}

$id = intval($_GET['id']);
$sql = "SELECT * FROM lawyers WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Lawyer not found");
}

$row = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $specialization = $_POST['specialization'];
    $status = $_POST['status'];

    $update = "UPDATE lawyers SET name=?, email=?, specialization=?, status=? WHERE id=?";
    $stmt = $conn->prepare($update);
    $stmt->bind_param("ssssi", $name, $email, $specialization, $status, $id);

    if ($stmt->execute()) {
        header("Location: lawyers.php");
        exit;
    } else {
        echo "Failed to update.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Lawyer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f3f4f6;
        }
        .edit-card {
            max-width: 500px;
            margin: 50px auto;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            background: #fff;
        }
        .edit-card-header {
           
            color: #2c3e50;
            padding: 15px;
            text-align: center;
            font-size: 1.5rem;
            font-weight: bold;
        }
        .edit-card-body {
            padding: 20px;
        }
        .btn-primary {
            background-color: #2c3e50;
            border: none;
        }
        .btn-primary:hover {
            background-color: #1a252f;
        }
    </style>
</head>
<body>

<div class="edit-card">
    <div class="edit-card-header">
        Edit Lawyer
    </div>
    <div class="edit-card-body">
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" value="<?= htmlspecialchars($row['name']) ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" value="<?= htmlspecialchars($row['email']) ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Specialization</label>
                <input type="text" name="specialization" value="<?= htmlspecialchars($row['specialization']) ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select" required>
                    <option value="active" <?= $row['status'] == 'active' ? 'selected' : '' ?>>Active</option>
                    <option value="inactive" <?= $row['status'] == 'inactive' ? 'selected' : '' ?>>Inactive</option>
                </select>
            </div>
            <div class="d-flex justify-content-between">
                <button class="btn btn-primary">Update</button>
                <a href="lawyers.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

</body>
</html>
