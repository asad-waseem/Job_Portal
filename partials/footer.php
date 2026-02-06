<?php if (strpos($_SERVER['REQUEST_URI'], 'login.php') === false && strpos($_SERVER['REQUEST_URI'], 'dashboard.php') === false): ?>
    <!-- Footer -->
    <footer class="bg-dark text-white py-5 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <h5 class="fw-bold mb-3">
                        <i class="fas fa-briefcase me-2"></i>JobPortal
                    </h5>
                    <p class="text-white-50 mb-3">Your trusted partner in finding the perfect career opportunity. Connect with top employers and take the next step in your professional journey.</p>
                    <div class="social-links">
                        <a href="#" class="text-white me-3"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h6 class="fw-bold mb-3">Quick Links</h6>
                    <ul class="list-unstyled">
                        <li><a href="jobs.php" class="text-white-50 text-decoration-none">Browse Jobs</a></li>
                        <li><a href="aboutus.php" class="text-white-50 text-decoration-none">About Us</a></li>
                        <li><a href="contactus.php" class="text-white-50 text-decoration-none">Contact</a></li>
                    </ul>
                </div>

            </div>
            <hr class="my-4">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="text-white-50 mb-0">&copy; 2024 JobPortal. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="text-white-50 mb-0">Developed By Muhammad Asad Waseem</p>
                </div>
            </div>
        </div>
    </footer>
    <?php endif; ?>
    
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>