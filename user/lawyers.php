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
    :root {
      --primary-color: #003B46;
      --secondary-color: #007C91;
      --accent-color: #bfa14a;
      --light-bg: #f9f9f9;
      --card-shadow: 0 10px 20px rgba(0,0,0,0.08);
    }
    
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: whitesmoke;
      color: #333;
    }
    
    .hero-section {
      background: #0f2027;
      color: white;
      padding: 80px 0;
      margin-bottom: 50px;
      text-align: center;
    }
    
    .page-title {
      font-weight: 700;
      font-size: 2.5rem;
      margin-bottom: 20px;
    }
    
    .page-subtitle {
      font-weight: 300;
      font-size: 1.2rem;
      max-width: 700px;
      margin: 0 auto;
    }
    
    .lawyers-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
      gap: 30px;
      padding: 0 20px;
      max-width: 1200px;
      margin: 0 auto;
    }
    
    .lawyer-card {
      background: white;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: var(--card-shadow);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .lawyer-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 15px 30px rgba(0,0,0,0.12);
    }
    
    .lawyer-image {
      height: 220px;
      overflow: hidden;
    }
    
    .lawyer-image img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.5s ease;
    }
    
    .lawyer-card:hover .lawyer-image img {
      transform: scale(1.05);
    }
    
    .lawyer-info {
      padding: 25px;
      text-align: center;
    }
    
    .lawyer-name {
      font-size: 1.4rem;
      font-weight: 700;
      color: var(--primary-color);
      margin-bottom: 8px;
    }
    
    .lawyer-specialty {
      color: var(--secondary-color);
      font-weight: 600;
      margin-bottom: 15px;
      display: block;
    }
    
    .lawyer-bio {
      color: #666;
      font-size: 0.95rem;
      margin-bottom: 20px;
      line-height: 1.5;
    }
    
    .lawyer-meta {
      display: flex;
      justify-content: center;
      gap: 15px;
      margin-top: 15px;
    }
    
    .meta-item {
      display: flex;
      align-items: center;
      color: #666;
      font-size: 0.9rem;
    }
    
    .meta-item i {
      margin-right: 5px;
      color: var(--accent-color);
    }
    
    .join-section {
      text-align: center;
      padding: 60px 20px;
      background: white;
      margin-top: 50px;
    }
    
    .join-button {
      display: inline-flex;
      align-items: center;
      padding: 12px 30px;
      background-color: var(--accent-color);
      color: white;
      text-decoration: none;
      font-weight: 600;
      border-radius: 50px;
      transition: all 0.3s ease;
      box-shadow: 0 4px 15px rgba(191, 161, 74, 0.3);
    }
    
    .join-button:hover {
      background-color: var(--primary-color);
      color: white;
      transform: translateY(-3px);
      box-shadow: 0 7px 20px rgba(0, 59, 70, 0.3);
    }
    
    .join-button i {
      margin-left: 8px;
    }
    
    .no-lawyers {
      text-align: center;
      padding: 50px;
      grid-column: 1 / -1;
    }
    
    @media (max-width: 768px) {
      .lawyers-grid {
        grid-template-columns: 1fr;
      }
      
      .page-title {
        font-size: 2rem;
      }
    }
  </style>
</head>
<body>

  <section class="hero-section">
    <h1 class="page-title">Meet Our Legal Experts</h1>
    <p class="page-subtitle">Our team of experienced lawyers is dedicated to providing exceptional legal services tailored to your needs.</p>
  </section>

  <div class="lawyers-grid">
    <?php if ($result->num_rows > 0): ?>
      <?php while ($row = $result->fetch_assoc()): ?>
        <div class="lawyer-card">
          <div class="lawyer-image">
          <?php if (!empty($row['profile_image'])): ?>
    <img src="../uploads/profile_images/<?= htmlspecialchars($row['profile_image']) ?>" 
         alt="Lawyer Image" class="lawyer-img mb-3">
<?php else: ?>
    <img src="../assets/default-lawyer.jpg" 
         alt="Default Image" class="lawyer-img mb-3">
<?php endif; ?>


<img src="<?= htmlspecialchars($imagePath) ?>" alt="<?= htmlspecialchars($row['name']) ?>">

          </div>
          <div class="lawyer-info">
            <h3 class="lawyer-name"><?= htmlspecialchars($row['name']) ?></h3>
            <span class="lawyer-specialty"><?= htmlspecialchars($row['specialization']) ?></span>
            <p class="lawyer-bio"><?= htmlspecialchars(substr($row['bio'] ?? 'Experienced legal professional', 0, 100)) ?>...</p>
            <div class="lawyer-meta">
              <div class="meta-item">
                <i class="fas fa-briefcase"></i>
                <span><?= htmlspecialchars($row['experience']) ?>+ years</span>
              </div>
              <div class="meta-item">
                <i class="fas fa-star"></i>
                <span>4.8/5</span>
              </div>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <div class="no-lawyers">
        <h3>Currently No Lawyers Available</h3>
        <p>We're expanding our team. Check back soon or consider joining us.</p>
      </div>
    <?php endif; ?>
  </div>

  <section class="join-section">
    <h2 class="mb-4">Want to Join Our Team?</h2>
    <a href="signup_lawyer.php" class="join-button">
      Apply Now <i class="fas fa-arrow-right"></i>
    </a>
  </section>


  <?php 
include_once './components/footer.php'
?>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>