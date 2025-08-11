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


$imagePath = !empty($row['profile_image']) 
    ? "../uploads/profile_images/" . htmlspecialchars($row['profile_image']) 
    : "https://via.placeholder.com/150?text=" . urlencode(substr($row['name'], 0, 1));
?>
<!DOCTYPE html>
<html>
<head>
    <title>View Lawyer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f3f4f6;
        }
        .card {
            max-width: 400px;
            margin: auto;
            margin-top: 50px;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .profile-img {
            width: 100%;
            height: 250px;
            object-fit: cover;
        }
        .card-title {
            font-weight: bold;
            font-size: 1.5rem;
        }
        .status-active {
           
            color: #e53e3e;
            font-weight: bold;
        }
        .status-inactive {
            color: #38a169;
            font-weight: bold;
        }
    </style>
</head>
<body>
<a href="lawyers.php" class="btn btn-secondary m-3">Back</a>
<div class="card">
    <img src="<?= $imagePath ?>" alt="Lawyer Image" class="profile-img">
    <div class="card-body text-center">
        <h5 class="card-title"><?= htmlspecialchars($row['name']) ?></h5>
        <p class="card-text"><strong>Email:</strong> <?= htmlspecialchars($row['email']) ?></p>
        <p class="card-text"><strong>Specialization:</strong> <?= htmlspecialchars($row['specialization']) ?></p>
        <p class="card-text <?= ($row['status'] == 'active') ? 'status-active' : 'status-inactive' ?>">
            <?= ucfirst(htmlspecialchars($row['status'])) ?>
        </p>
       
    </div>
</div>

</body>
</html>
