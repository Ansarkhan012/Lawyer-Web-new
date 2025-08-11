<?php
session_start();
include '../config/config.php';


$sql = "SELECT id, name, specialization, profile_image FROM lawyers WHERE status = 'approved'";
$result = $conn->query($sql);

// For timing
$time_slots = [];
$start_time = strtotime('09:00');
$end_time = strtotime('17:00');
$current = $start_time;

while ($current <= $end_time) {
    $time_slots[] = date('H:i', $current);
    $current = strtotime('+30 minutes', $current);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Appointment | Legal Connect</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .booking-container {
            max-width: 800px;
            margin-top: 50px;
            margin-bottom: 50px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            padding: 30px;
        }
        .lawyer-option {
            display: flex;
            align-items: center;
            padding: 10px;
            border-radius: 5px;
            transition: background-color 0.2s;
        }
        .lawyer-option:hover {
            background-color: #f0f8ff;
        }
        .lawyer-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 15px;
            border: 2px solid #e9ecef;
        }
        .lawyer-info {
            flex-grow: 1;
        }
        .lawyer-name {
            font-weight: 600;
            margin-bottom: 2px;
        }
        .lawyer-specialty {
            color: #6c757d;
            font-size: 0.9em;
        }
        .time-slot {
            display: inline-block;
            margin: 5px;
        }
        .time-slot-btn {
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 5px 10px;
            background: white;
            cursor: pointer;
            transition: all 0.2s;
        }
        .time-slot-btn:hover {
            background: #f8f9fa;
        }
        .time-slot-btn.selected {
            background: #0d6efd;
            color: white;
            border-color: #0d6efd;
        }
        .form-section {
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
        }
        .section-title {
            font-size: 1.2rem;
            margin-bottom: 20px;
            color: #2c3e50;
            position: relative;
            padding-bottom: 8px;
        }
       
    </style>
</head>
<body>
    <div class="container booking-container">
        <h2 class="text-center mb-4">Book a Lawyer Appointment</h2>
        
        <?php if (isset($_SESSION['booking_error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= $_SESSION['booking_error']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['booking_error']); ?>
        <?php endif; ?>
        
        <form action="submit.php" method="POST" id="appointmentForm">
         
            <div class="form-section">
                <h3 class="section-title">Select Your Lawyer</h3>
                <div class="mb-3">
                    <select name="lawyer_id" id="lawyerSelect" class="form-select" required>
                        <option value="">-- Choose a Lawyer --</option>
                        <?php while ($lawyer = $result->fetch_assoc()) { ?>
                            <option value="<?= $lawyer['id']; ?>" data-specialization="<?= htmlspecialchars($lawyer['specialization']); ?>">
                                <?= htmlspecialchars($lawyer['name']); ?> - <?= htmlspecialchars($lawyer['specialization']); ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                
                <div id="lawyerPreview" class="d-none">
                    <div class="lawyer-option p-3 bg-light rounded">
                        <img id="previewAvatar" src="" alt="Lawyer" class="lawyer-avatar">
                        <div class="lawyer-info">
                            <div class="lawyer-name" id="previewName"></div>
                            <div class="lawyer-specialty" id="previewSpecialty"></div>
                        </div>
                    </div>
                </div>
            </div>
            
         
            <div class="form-section">
                <h3 class="section-title">Select Date & Time</h3>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="appointmentDate" class="form-label">Appointment Date</label>
                        <input type="date" name="date" id="appointmentDate" class="form-control" required 
                               min="<?= date('Y-m-d'); ?>" 
                               max="<?= date('Y-m-d', strtotime('+3 months')); ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="appointmentTime" class="form-label">Appointment Time</label>
                        <select name="time" id="appointmentTime" class="form-select" required>
                            <option value="">-- Select Time --</option>
                            <?php foreach ($time_slots as $slot) { ?>
                                <option value="<?= $slot; ?>"><?= $slot; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                
                <div class="alert alert-info mt-3">
                    <i class="fas fa-info-circle me-2"></i>Appointments are available Monday to Friday, 9:00 AM to 5:00 PM
                </div>
            </div>
            
            <!-- Case Details -->
            <div class="form-section">
                <h3 class="section-title">Case Details</h3>
                <div class="mb-3">
                    <label for="caseDetails" class="form-label">Brief Description</label>
                    <textarea name="details" id="caseDetails" class="form-control" rows="5" 
                              placeholder="Please describe your legal matter in detail..." required></textarea>
                </div>
                <div class="mb-3">
                    <label for="documents" class="form-label">Upload Documents (Optional)</label>
                    <input type="file" class="form-control" id="documents" multiple>
                    <div class="form-text">You can upload relevant documents after booking</div>
                </div>
            </div>
            
            <!-- Contact Information -->
            <div class="form-section">
                <h3 class="section-title">Your Information</h3>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="clientName" class="form-label">Full Name</label>
                        <input type="text" name="client_name" id="clientName" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="clientPhone" class="form-label">Phone Number</label>
                        <input type="tel" name="client_phone" id="clientPhone" class="form-control" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="clientEmail" class="form-label">Email Address</label>
                    <input type="email" name="client_email" id="clientEmail" class="form-control" required>
                </div>
            </div>
            
            <!-- Terms and Submit -->
            <div class="form-check mb-4">
                <input class="form-check-input" type="checkbox" id="termsCheck" required>
                <label class="form-check-label" for="termsCheck">
                    I agree to the <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">Terms of Service</a> and understand that this doesn't create an attorney-client relationship until confirmed.
                </label>
            </div>
            
            <div class="d-grid gap-2">
                <button type="submit" style="background:#bfa14a; color:white;" class="btn btn-lg">
                    Book Appointment
                </button>
            </div>
        </form>
    </div>
    
    
    <div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="termsModalLabel">Terms of Service</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h6>Appointment Booking Terms</h6>
                    <ol>
                        <li>Appointments are subject to lawyer availability and confirmation</li>
                        <li>You will receive a confirmation email within 24 hours</li>
                        <li>Cancellations require 24 hours notice</li>
                        <li>No attorney-client relationship is established until a retainer agreement is signed</li>
                        <li>All information provided is confidential</li>
                    </ol>
                    <h6 class="mt-4">Privacy Policy</h6>
                    <p>Your personal information will only be used to process your appointment and will not be shared with third parties without your consent.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Lawyer selection preview
        document.getElementById('lawyerSelect').addEventListener('change', function() {
            const preview = document.getElementById('lawyerPreview');
            if (this.value) {
                preview.classList.remove('d-none');
                const selectedOption = this.options[this.selectedIndex];
                document.getElementById('previewName').textContent = selectedOption.text.split(' - ')[0];
                document.getElementById('previewSpecialty').textContent = selectedOption.dataset.specialization;
                // In a real app, you would fetch the actual image URL from the selected lawyer's data
                document.getElementById('previewAvatar').src = 'https://via.placeholder.com/50';
            } else {
                preview.classList.add('d-none');
            }
        });

        // Date validation (disable weekends)
        document.getElementById('appointmentDate').addEventListener('change', function() {
            const selectedDate = new Date(this.value);
            const day = selectedDate.getDay();
            
            if (day === 0 || day === 6) {
                alert('Weekends are not available for appointments. Please select a weekday.');
                this.value = '';
            }
        });

        // Form submission handling
        document.getElementById('appointmentForm').addEventListener('submit', function(e) {
            // Additional validation can be added here
            if (!document.getElementById('termsCheck').checked) {
                e.preventDefault();
                alert('Please agree to the Terms of Service');
            }
        });
    </script>
</body>
</html>