<?php 
require_once 'partials/config.php';

// Initialize variables
$success_message = "";
$error_message = "";

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data and sanitize
    $full_name = trim($_POST['fullName']);
    $email = trim($_POST['email']);
    $subject = trim($_POST['subject']);
    $message = trim($_POST['message']);
    
    // Validate required fields
    if (empty($full_name) || empty($email) || empty($subject) || empty($message)) {
        $error_message = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Please enter a valid email address.";
    } else {
        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO contact_messages (full_name, email, subject, message) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $full_name, $email, $subject, $message);
        
        // Execute the statement
        if ($stmt->execute()) {
            $success_message = "Your message has been sent successfully! We'll get back to you soon.";
            // Clear form data after successful submission
            $_POST = array();
        } else {
            $error_message = "Sorry, there was an error sending your message. Please try again.";
        }
        
        $stmt->close();
    }
}

$conn->close();

include('partials/header.php'); 
?>

<!-- Contact Us Page -->
<div class="contact-hero">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8">
                <h1 class="display-4 fw-bold text-white mb-3">Contact Us</h1>
                <p class="lead text-white-50 mb-5">Have questions? We'd love to hear from you. Send us a message and we'll respond as soon as possible.</p>
            </div>
        </div>
    </div>
</div>

<div class="container py-5">
    <div class="row justify-content-center">
        <!-- Contact Form -->
        <div class="col-lg-8 col-md-10">
            <div class="card shadow-lg border-0 contact-card">
                <div class="card-header bg-gradient text-white text-center py-4">
                    <h3 class="mb-0"><i class="fas fa-envelope me-2"></i>Get In Touch</h3>
                </div>
                <div class="card-body p-5">
                    <!-- Success Message -->
                    <?php if (!empty($success_message)): ?>
                    <div class="alert alert-success" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        <strong>Success!</strong> <?php echo $success_message; ?>
                    </div>
                    <?php endif; ?>
                    
                    <!-- Error Message -->
                    <?php if (!empty($error_message)): ?>
                    <div class="alert alert-danger" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Error!</strong> <?php echo $error_message; ?>
                    </div>
                    <?php endif; ?>

                    <form id="contactForm" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" novalidate>
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="fullName" class="form-label fw-semibold">
                                    <i class="fas fa-user text-primary me-1"></i>Full Name
                                </label>
                                <input type="text" class="form-control form-control-lg" id="fullName" name="fullName" 
                                       value="<?php echo isset($_POST['fullName']) ? htmlspecialchars($_POST['fullName']) : ''; ?>" required>
                                <div class="invalid-feedback">
                                    Please provide your full name.
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="email" class="form-label fw-semibold">
                                    <i class="fas fa-envelope text-primary me-1"></i>Email Address
                                </label>
                                <input type="email" class="form-control form-control-lg" id="email" name="email" 
                                       value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
                                <div class="invalid-feedback">
                                    Please provide a valid email address.
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="subject" class="form-label fw-semibold">
                                <i class="fas fa-tag text-primary me-1"></i>Subject
                            </label>
                            <input type="text" class="form-control form-control-lg" id="subject" name="subject" 
                                   value="<?php echo isset($_POST['subject']) ? htmlspecialchars($_POST['subject']) : ''; ?>" required>
                            <div class="invalid-feedback">
                                Please provide a subject for your message.
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="message" class="form-label fw-semibold">
                                <i class="fas fa-comment text-primary me-1"></i>Message
                            </label>
                            <textarea class="form-control" id="message" name="message" rows="6" required placeholder="Tell us how we can help you..."><?php echo isset($_POST['message']) ? htmlspecialchars($_POST['message']) : ''; ?></textarea>
                            <div class="invalid-feedback">
                                Please provide your message.
                            </div>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg py-3">
                                <i class="fas fa-paper-plane me-2"></i>Send Message
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Contact Information Sidebar -->
        <div class="col-lg-4 col-md-10 mt-5 mt-lg-0">
            <div class="row">
                <!-- Contact Info Card -->
                <div class="col-12 mb-4">
                    <div class="card h-100 border-0 shadow contact-info-card">
                        <div class="card-body p-4 text-center">
                            <div class="contact-icon mb-3">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <h5 class="card-title">Our Office</h5>
                            <p class="card-text text-muted">
                                123 Business Avenue<br>
                                Karachi, Sindh 75000<br>
                                Pakistan
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- Phone Card -->
                <div class="col-12 mb-4">
                    <div class="card h-100 border-0 shadow contact-info-card">
                        <div class="card-body p-4 text-center">
                            <div class="contact-icon mb-3">
                                <i class="fas fa-phone"></i>
                            </div>
                            <h5 class="card-title">Call Us</h5>
                            <p class="card-text text-muted">
                                +92 21 1234 5678<br>
                                Mon - Fri: 9:00 AM - 6:00 PM
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- Email Card -->
                <div class="col-12 mb-4">
                    <div class="card h-100 border-0 shadow contact-info-card">
                        <div class="card-body p-4 text-center">
                            <div class="contact-icon mb-3">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <h5 class="card-title">Email Us</h5>
                            <p class="card-text text-muted">
                                info@jobportal.com<br>
                                support@jobportal.com
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Google Map Section (Optional) -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="card border-0 shadow">
                <div class="card-header bg-light text-center py-3">
                    <h4 class="mb-0"><i class="fas fa-map text-primary me-2"></i>Find Us</h4>
                </div>
                <div class="card-body p-0">
                    <div class="map-container">
                        <!-- Replace with your actual Google Maps embed code -->
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d462560.68282767845!2d67.01224485820313!3d25.193202199999997!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3eb33e06651d4bbf%3A0x9cf92f44555a0c23!2sKarachi%2C%20Karachi%20City%2C%20Sindh%2C%20Pakistan!5e0!3m2!1sen!2s!4v1623456789012!5m2!1sen!2s" 
                            width="100%" 
                            height="300" 
                            style="border:0;" 
                            allowfullscreen="" 
                            loading="lazy">
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Contact Page Specific Styles */
.contact-hero {
    background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
    padding: 80px 0 50px;
    margin-top: -20px;
}

.contact-card {
    border-radius: 15px;
    overflow: hidden;
}

.contact-card .card-header {
    background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
    border: none;
}

.contact-info-card {
    border-radius: 15px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.contact-info-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.15) !important;
}

.contact-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    color: white;
    font-size: 1.5rem;
}

.form-control:focus {
    border-color: #2a5298;
    box-shadow: 0 0 0 0.2rem rgba(42, 82, 152, 0.25);
}

.btn-primary {
    background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
    border: none;
    border-radius: 10px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #2a5298 0%, #1e3c72 100%);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(30, 60, 114, 0.3);
}

.map-container {
    border-radius: 0 0 15px 15px;
    overflow: hidden;
}

/* Animation for form validation */
.was-validated .form-control:valid {
    border-color: #28a745;
}

.was-validated .form-control:invalid {
    border-color: #dc3545;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .contact-hero {
        padding: 60px 0 30px;
    }
    
    .contact-hero h1 {
        font-size: 2.5rem;
    }
    
    .card-body {
        padding: 2rem !important;
    }
}
</style>

<script>
// Form validation
document.getElementById('contactForm').addEventListener('submit', function(e) {
    // Add Bootstrap validation classes
    this.classList.add('was-validated');
    
    // If form is invalid, prevent submission
    if (!this.checkValidity()) {
        e.preventDefault();
        e.stopPropagation();
    }
});

// Real-time validation feedback
document.querySelectorAll('.form-control').forEach(function(input) {
    input.addEventListener('blur', function() {
        if (this.value.trim() !== '') {
            this.classList.add('is-valid');
            this.classList.remove('is-invalid');
        }
    });
    
    input.addEventListener('input', function() {
        if (this.classList.contains('was-validated')) {
            if (this.checkValidity()) {
                this.classList.add('is-valid');
                this.classList.remove('is-invalid');
            } else {
                this.classList.add('is-invalid');
                this.classList.remove('is-valid');
            }
        }
    });
});
</script>

<?php include('partials/footer.php'); ?>