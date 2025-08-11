<?php
 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Justice Law Partners | Expert Legal Counsel</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins&display=swap" rel="stylesheet">

    <style>
        * {
            font-family: 'Poppins', sans-serif;
            box-sizing: border-box;
        }
        
        body {
            padding-top: 70px; /* Space for fixed navbar */
        }
        
        .navbar {
            padding: 10px 0;
            transition: all 0.3s ease;
            background-color: rgba(15, 32, 39, 0.98);
        }
        
        .navbar.scrolled {
            padding: 10px 0;
            background-color: rgba(15, 32, 39, 0.98) !important;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: white !important;
        }
        
        .navbar-brand span {
            color: #d4a017;
        }
        
        .nav-link {
            font-weight: 500;
            padding: 8px 15px !important;
            margin: 0 5px;
            position: relative;
            color: rgba(255, 255, 255, 0.85) !important;
        }
        
        .nav-link:hover,
        .nav-link:focus {
            color: white !important;
        }
        
        .nav-link:before {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 0;
            background-color: #0B5563;
            visibility: hidden;
            transition: all 0.3s ease-in-out;
        }
        
        .nav-link:hover:before,
        .nav-link:focus:before {
            visibility: visible;
            width: 100%;
        }
        
        .nav-link.active {
            color: white !important;
        }
        
        .navbar-toggler {
            border: none;
            padding: 0.5rem;
        }
        
        .navbar-toggler:focus {
            box-shadow: none;
            outline: none;
        }
        
        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 1%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
            width: 1.5em;
            height: 1.5em;
        }
        
        .contact-btn {
            background-color: #0B5563;
            color: white !important;
            border-radius: 6px;
            padding: 8px 20px !important;
            transition: all 0.3s ease;
            border: none;
        }
        
        .contact-btn:hover,
        .contact-btn:focus {
            background-color: #0a4a57;
            transform: translateY(-2px);
            color: white !important;
        }
        
        /* Mobile-specific styles */
        @media (max-width: 991.98px) {
            .navbar {
                padding: 10px 0;
            }
            
            .navbar-collapse {
                background-color: rgba(15, 32, 39, 0.98);
                padding: 15px;
                margin-top: 10px;
                border-radius: 8px;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            }
            
            .nav-item {
                margin: 5px 0;
            }
            
            .nav-link {
                padding: 12px 15px !important;
                margin: 0;
                border-radius: 6px;
                transition: all 0.2s ease;
            }
            
            .nav-link:hover,
            .nav-link:focus {
                background-color: rgba(255, 255, 255, 0.1);
                color: white !important;
            }
            
            .nav-link:before {
                display: none;
            }
            
            .contact-btn {
                margin-top: 10px;
                display: block;
                width: 100%;
                text-align: center;
            }
            
            /* Active state for mobile */
            .navbar-collapse.show {
                max-height: calc(100vh - 80px);
                overflow-y: auto;
            }
            
            /* Better spacing for login/logout items */
            .navbar-nav .nav-item:last-child {
                margin-top: 15px;
                padding-top: 15px;
                border-top: 1px solid rgba(255, 255, 255, 0.1);
            }
        }
    </style>
</head>
<body>
    
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="./">
                Justice<span>Law</span>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="./">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./about.php">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./lawyers.php">Lawyers</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./contact.php">Contact</a>
                    </li>
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="./logout.php">Logout</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="./login.php">Login</a>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item ms-lg-2">
                        <a class="nav-link contact-btn" href="./appointment.php">
                            <i class="bi bi-telephone-fill me-1"></i> Consultation
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Navbar scroll effect
        document.addEventListener('DOMContentLoaded', function() {
            const navbar = document.querySelector('.navbar');
            
            // Immediately apply scrolled class if page is not at top
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            }
            
            window.addEventListener('scroll', function() {
                if (window.scrollY > 50) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
            });
            
            // Mobile menu functionality
            const navbarToggler = document.querySelector('.navbar-toggler');
            const navbarCollapse = document.querySelector('.navbar-collapse');
            
            // Close mobile menu when clicking a link
            document.querySelectorAll('.nav-link').forEach(link => {
                link.addEventListener('click', () => {
                    if (window.innerWidth < 992) {
                        const bsCollapse = new bootstrap.Collapse(navbarCollapse, {
                            toggle: false
                        });
                        bsCollapse.hide();
                        document.body.style.overflow = 'auto';
                    }
                });
            });
            
            // Prevent scrolling when mobile menu is open
            navbarToggler.addEventListener('click', function() {
                if (navbarCollapse.classList.contains('show')) {
                    document.body.style.overflow = 'auto';
                } else {
                    document.body.style.overflow = 'hidden';
                }
            });
            
            // Reset body overflow when menu is closed via other means
            navbarCollapse.addEventListener('hidden.bs.collapse', function() {
                document.body.style.overflow = 'auto';
            });
            
            // Initialize AOS animations
            AOS.init({
                duration: 800,       
                easing: 'ease-in-out',
                once: true,          
                mirror: false      
            });
        });
    </script>
</body>
</html>