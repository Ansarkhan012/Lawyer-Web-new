

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lawyer Name - Contact</title>
 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .contact-info-card {
            transition: transform 0.3s;
        }
       
        .contact-form {
            background-color: #f8f9fa;
            border-radius: 10px;
        }
        .section-title {
            position: relative;
            padding-bottom: 15px;
        }
       

        .te{
            color: #0B5563;
        }

        .b{
            background-color: #0B5563;
            color: #f8f9fa;
            border-radius: 7px ;
            padding: 4px 6px;

        }

        .bgg{
            background-color: #0B5563;
        }
    </style>
</head>
<body>

<?php 
include_once './components/navbar.php';
?>


    <header class="bgg text-white py-5">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mt-5">
                    <h1 class="display-4">Contact Our Legal Team</h1>
                    <p class="lead">Schedule a consultation or get in touch with our office</p>
                </div>
            </div>
        </div>
    </header>

    <!-- Contact Section -->
    <section class="py-5">
        <div class="container">
            <div class="row mb-5">
                <div class="col-12 text-center">
                    <h2 class="section-title">How Can We Help You?</h2>
                    <p class="text-muted">Fill out the form below or contact us directly</p>
                </div>
            </div>
            
            <div class="row g-4">
      
                <div class="col-lg-4">
                    <div class="card contact-info-card shadow-sm h-100">
                        <div class="card-body text-center p-4">
                            <div class="mb-4">
                                <i class="fas fa-map-marker-alt fa-3x te mb-3"></i>
                                <h4>Office Address</h4>
                                <p class="text-muted">123 Legal Avenue<br>Suite 500<br>New York, NY 10001</p>
                            </div>
                            
                            <div class="mb-4">
                                <i class="fas fa-phone fa-3x te mb-3"></i>
                                <h4>Phone Number</h4>
                                <p class="text-muted">Office: (212) 555-1234<br>Direct: (212) 555-5678<br>Fax: (212) 555-9012</p>
                            </div>
                            
                            <div class="mb-4">
                                <i class="fas fa-envelope fa-3x te mb-3"></i>
                                <h4>Email Address</h4>
                                <p class="text-muted">info@lawyername.com<br>attorney@lawyername.com</p>
                            </div>
                            
                            <div class="mb-4">
                                <i class="fas fa-clock fa-3x te mb-3"></i>
                                <h4>Office Hours</h4>
                                <p class="text-muted">Monday - Friday: 9:00 AM - 5:00 PM<br>Saturday: By Appointment<br>Sunday: Closed</p>
                            </div>
                            
                            <div class="social-icons mt-3">
                                <a href="#" class="text-dark me-2"><i class="fab fa-linkedin fa-2x"></i></a>
                                <a href="#" class="text-dark me-2"><i class="fab fa-twitter fa-2x"></i></a>
                                <a href="#" class="text-dark me-2"><i class="fab fa-facebook fa-2x"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Contact Form -->
                <div class="col-lg-8">
                    <div class="contact-form p-4 shadow-sm">
                        <h3 class="mb-4">Send Us a Message</h3>
                        <form>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="firstName" class="form-label">First Name*</label>
                                    <input type="text" class="form-control" id="firstName" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="lastName" class="form-label">Last Name*</label>
                                    <input type="text" class="form-control" id="lastName" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email*</label>
                                    <input type="email" class="form-control" id="email" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <input type="tel" class="form-control" id="phone">
                                </div>
                                <div class="col-12">
                                    <label for="subject" class="form-label">Subject*</label>
                                    <select class="form-select" id="subject" required>
                                        <option value="" selected disabled>Select a subject</option>
                                        <option value="consultation">Schedule a Consultation</option>
                                        <option value="personal-injury">Personal Injury Inquiry</option>
                                        <option value="family-law">Family Law Matter</option>
                                        <option value="real-estate">Real Estate Transaction</option>
                                        <option value="other">Other Legal Matter</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label for="message" class="form-label">Your Message*</label>
                                    <textarea class="form-control" id="message" rows="5" required></textarea>
                                </div>
                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="disclaimer" required>
                                        <label class="form-check-label" for="disclaimer">
                                            I understand that submitting this form does not create an attorney-client relationship
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="b  btn-lg px-4">
                                        Send Message
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section class="bg-light py-5">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2 class="section-title mb-4">Our Location</h2>
                    <div class="ratio ratio-16x9">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3022.215573291234!2d-73.9878449242395!3d40.74844097138945!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c259a9b3117469%3A0xd134e199a405a163!2sEmpire%20State%20Building!5e0!3m2!1sen!2sus!4v1689871234567!5m2!1sen!2sus" 
                                allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
 
    <?php 
include_once './components/footer.php'
?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>