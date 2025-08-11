<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About Us</title>
  <style>
    :root {
      --primary-color: #003B46;
      --secondary-color: #007C91;
      --accent-color: #bfa14a;
      --light-color: #f4f6f8;
    }

    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background-color: var(--light-color);
      color: #333;
    }

    
    .hero {
      position: relative;
      background: url('https://avatars.mds.yandex.net/i?id=05d383901d2d2d93c6d0429da3ba6b8a4c043b07-5330858-images-thumbs&n=13') center/cover no-repeat;
      color: white;
      text-align: center;
      padding: 80px 20px;
    }
    
    .hero-content {
      position: relative;
      z-index: 1;
    }
    .hero h1 {
      font-size: 2.5rem;
      margin-bottom: 10px;
    }
    .hero p {
      font-size: 1.2rem;
      opacity: 0.9;
    }

    .about {
      display: flex;
      flex-wrap: wrap;
      padding: 40px 20px;
      background: white;
      border-radius: 10px;
      box-shadow: 0 0 20px rgba(0,0,0,0.1);
      margin: 30px auto;
      max-width: 1100px;
    }
    .about-image {
      flex: 1;
      min-width: 280px;
      padding: 10px;
    }
    .about-image img {
      width: 100%;
      border-radius: 10px;
    }
    .about-text {
      flex: 2;
      padding: 20px;
    }
    .about-text h2 {
      color: var(--primary-color);
      margin-bottom: 15px;
    }

    .mission {
      padding: 40px 20px;
      text-align: center;
      background-color: #1f2937;
      color: white;
      margin-top: 30px;
    }
    .mission h2 {
      margin-bottom: 15px;
      font-size: 1.8rem;
    }
    .mission p {
      max-width: 800px;
      margin: 0 auto;
      opacity: 0.95;
    }

 
   
  
    @media (max-width: 768px) {
      .about {
        flex-direction: column;
        text-align: center;
      }
    }
  </style>
</head>
<body>

<?php 
    include_once './components/navbar.php';
    ?>

  <section class="hero">
    <div class="hero-content">
      <h1>About Our Law Firm</h1>
      <p>Committed to Justice, Integrity, and Client Success</p>
    </div>
  </section>

  <!-- About Section -->
  <section class="about">
    <div class="about-image">
      <img src="https://avatars.mds.yandex.net/i?id=d11c920625d2dfd40786523586733979f46e538e-5364211-images-thumbs&n=13" alt="Lawyer Profile">
    </div>
    <div class="about-text">
      <h2>Justice Law</h2>
      <p>
        With over 15 years of experience in criminal defense, corporate law, and family law,
        Attorney John Smith has built a reputation for providing strong legal representation
        tailored to each client’s unique needs.
      </p>
      <p>
        Our firm believes in honest communication, thorough preparation, and relentless
        dedication to achieving the best possible results for our clients.
      </p>
    </div>
  </section>


  <section class="mission">
    <h2>Our Mission</h2>
    <p>
      We are dedicated to protecting our clients’ rights, ensuring fair legal processes,
      and delivering justice. Every case is handled with compassion, professionalism,
      and the highest ethical standards.
    </p>
  </section>

  <?php 
include_once './components/footer.php'
?>

</body>
</html>
