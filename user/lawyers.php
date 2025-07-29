<?php 
include_once './components/navbar.php';
require_once '../config/config.php';


$sql = "SELECT name, specialization, experience, profile_image FROM lawyers WHERE status = 'approved'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Our Lawyers</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #f9f9f9;
      margin: 0;
      padding: 0;
    }

    .container {
      max-width: 1200px;
      margin: auto;
      padding: 40px 20px;
      text-align: center;
    }

    h1 {
      color: #003B46;
      margin-bottom: 30px;
    }

    .lawyers-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
      gap: 20px;
    }

    .lawyer-card {
      background: white;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      text-align: center;
    }

    .lawyer-card img {
      width: 100px;
      height: 100px;
      object-fit: cover;
      border-radius: 50%;
      margin-bottom: 15px;
    }

    .lawyer-card h3 {
      margin: 10px 0 5px;
      color: #007C91;
    }

    .lawyer-card p {
      color: #555;
      font-size: 14px;
    }

    .join-button {
      display: inline-block;
      margin-top: 40px;
      padding: 12px 25px;
      background-color: #007C91;
      color: white;
      text-decoration: none;
      font-weight: 600;
      border-radius: 6px;
      transition: background 0.3s ease;
    }

    .join-button:hover {
      background-color: #005a66;
    }
  </style>
</head>
<body>

  <div class="container">
    <h1>Meet Our Lawyers</h1>

    <div class="lawyers-grid">
      <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
          <div class="lawyer-card">
            <img src="<?= $row['profile_image'] ?? 'default-avatar.png' ?>" alt="Lawyer Photo" />
            <h3><?= htmlspecialchars($row['name']) ?></h3>
            <p><?= htmlspecialchars($row['specialization']) ?></p>
            <p><?= htmlspecialchars($row['experience']) ?> years of experience</p>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <p>No lawyers found.</p>
      <?php endif; ?>
    </div>

    <a href="signup_lawyer.php" class="join-button">Join as a Lawyer</a>
  </div>

</body>
</html>
