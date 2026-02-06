<?php


// Check if admin is logged in

$success_message = '';
$error_message = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Sanitize and validate input
        $title = sanitizeInput($_POST['title']);
        $company = sanitizeInput($_POST['company']);
        $location = sanitizeInput($_POST['location']);
        $category = sanitizeInput($_POST['category']);
        $job_type = sanitizeInput($_POST['job_type']);
        $description = sanitizeInput($_POST['description']);
        $salary_min = !empty($_POST['salary_min']) ? (int)$_POST['salary_min'] : null;
        $salary_max = !empty($_POST['salary_max']) ? (int)$_POST['salary_max'] : null;
        $requirements = sanitizeInput($_POST['requirements']);
        $benefits = sanitizeInput($_POST['benefits']);
        
        // Validation
        if (empty($title) || empty($company) || empty($location) || empty($category) || empty($job_type) || empty($description)) {
            throw new Exception('All required fields must be filled.');
        }
        
        if (strlen($title) < 3 || strlen($title) > 200) {
            throw new Exception('Job title must be between 3-200 characters.');
        }
        
        if (strlen($description) < 50) {
            throw new Exception('Job description must be at least 50 characters.');
        }
        
        // Insert into database
        $sql = "INSERT INTO jobs (title, company, location, category, job_type, description, salary_min, salary_max, requirements, benefits) 
                VALUES (:title, :company, :location, :category, :job_type, :description, :salary_min, :salary_max, :requirements, :benefits)";
        
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([
            ':title' => $title,
            ':company' => $company,
            ':location' => $location,
            ':category' => $category,
            ':job_type' => $job_type,
            ':description' => $description,
            ':salary_min' => $salary_min,
            ':salary_max' => $salary_max,
            ':requirements' => $requirements,
            ':benefits' => $benefits
        ]);
        
        if ($result) {
            $success_message = 'Job posted successfully!';
            // Clear form data
            $_POST = array();
        } else {
            throw new Exception('Failed to add job. Please try again.');
        }
        
    } catch (Exception $e) {
        $error_message = $e->getMessage();
    }
}

// Get categories for dropdown
$categories = ['development', 'design', 'marketing', 'sales', 'hr', 'finance', 'management', 'support', 'other'];
$job_types = ['full-time', 'part-time', 'remote', 'contract', 'internship'];
?>

<?php include '../partials/header.php'; ?>

<style>
.add-job-container {
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    min-height: 100vh;
    padding: 2rem 0;
}

.job-form-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    border: none;
    overflow: hidden;
}

.form-header {
    background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
    color: white;
    padding: 2rem;
    text-align: center;
    position: relative;
}

.form-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="dots" width="20" height="20" patternUnits="userSpaceOnUse"><circle cx="10" cy="10" r="1" fill="white" opacity="0.2"/></pattern></defs><rect width="100" height="100" fill="url(%23dots)"/></svg>');
}

.form-header h2 {
    position: relative;
    z-index: 1;
    margin: 0;
    font-weight: 700;
}

.form-section {
    background: #f8fafc;
    padding: 1.5rem;
    margin: 1.5rem 0;
    border-radius: 12px;
    border-left: 4px solid #3b82f6;
}

.form-section h5 {
    color: #1e3a8a;
    font-weight: 600;
    margin-bottom: 1rem;
}

.required-field::after {
    content: " *";
    color: #ef4444;
    font-weight: bold;
}

.char-counter {
    font-size: 0.875rem;
    color: #64748b;
    text-align: right;
    margin-top: 0.25rem;
}

.salary-input-group {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.alert-custom {
    border-radius: 12px;
    border: none;
    padding: 1rem 1.5rem;
    margin-bottom: 2rem;
}
</style>


<div class="add-job-container">
    <div class="container">
        <?php if ($success_message): ?>
            <div class="alert alert-success alert-custom">
                <i class="fas fa-check-circle me-2"></i><?php echo $success_message; ?>
            </div>
        <?php endif; ?>
        
        <?php if ($error_message): ?>
            <div class="alert alert-danger alert-custom">
                <i class="fas fa-exclamation-triangle me-2"></i><?php echo $error_message; ?>
            </div>
        <?php endif; ?>
        
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card job-form-card">
                    <div class="form-header">
                        <h2><i class="fas fa-plus-circle me-3"></i>Add New Job Posting</h2>
                        <p class="mb-0 mt-2 opacity-90">Fill out the form below to create a new job listing</p>
                    </div>
                    
                    <div class="card-body p-4">
                        <form method="POST" action="" id="addJobForm">
                            <!-- Basic Information Section -->
                            <div class="form-section">
                                <h5><i class="fas fa-info-circle me-2"></i>Basic Information</h5>
                                <div class="row g-3">
                                    <div class="col-md-8">
                                        <label for="title" class="form-label fw-semibold required-field">Job Title</label>
                                        <input type="text" class="form-control form-control-lg" id="title" name="title" 
                                               value="<?php echo isset($_POST['title']) ? htmlspecialchars($_POST['title']) : ''; ?>" 
                                               required maxlength="200" onkeyup="updateCharCounter('title', 200)">
                                        <div class="char-counter" id="title-counter">0/200 characters</div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="job_type" class="form-label fw-semibold required-field">Job Type</label>
                                        <select class="form-select form-select-lg" id="job_type" name="job_type" required>
                                            <option value="">Select Type</option>
                                            <?php foreach ($job_types as $type): ?>
                                                <option value="<?php echo $type; ?>" 
                                                        <?php echo (isset($_POST['job_type']) && $_POST['job_type'] == $type) ? 'selected' : ''; ?>>
                                                    <?php echo ucfirst(str_replace('-', ' ', $type)); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="company" class="form-label fw-semibold required-field">Company Name</label>
                                        <input type="text" class="form-control form-control-lg" id="company" name="company" 
                                               value="<?php echo isset($_POST['company']) ? htmlspecialchars($_POST['company']) : ''; ?>" 
                                               required maxlength="100">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="location" class="form-label fw-semibold required-field">Location</label>
                                        <input type="text" class="form-control form-control-lg" id="location" name="location" 
                                               value="<?php echo isset($_POST['location']) ? htmlspecialchars($_POST['location']) : ''; ?>" 
                                               required maxlength="100" placeholder="e.g. Karachi, Pakistan">
                                    </div>
                                    <div class="col-md-12">
                                        <label for="category" class="form-label fw-semibold required-field">Category</label>
                                        <select class="form-select form-select-lg" id="category" name="category" required>
                                            <option value="">Select Category</option>
                                            <?php foreach ($categories as $cat): ?>
                                                <option value="<?php echo $cat; ?>" 
                                                        <?php echo (isset($_POST['category']) && $_POST['category'] == $cat) ? 'selected' : ''; ?>>
                                                    <?php echo ucfirst($cat); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Job Details Section -->
                            <div class="form-section">
                                <h5><i class="fas fa-file-alt me-2"></i>Job Details</h5>
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label for="description" class="form-label fw-semibold required-field">Job Description</label>
                                        <textarea class="form-control" id="description" name="description" rows="6" 
                                                  required minlength="50" onkeyup="updateCharCounter('description', 2000)"
                                                  placeholder="Provide a detailed description of the role, responsibilities, and what you're looking for in a candidate..."><?php echo isset($_POST['description']) ? htmlspecialchars($_POST['description']) : ''; ?></textarea>
                                        <div class="char-counter" id="description-counter">0/2000 characters (minimum 50)</div>
                                    </div>
                                    <div class="col-12">
                                        <label for="requirements" class="form-label fw-semibold">Requirements & Qualifications</label>
                                        <textarea class="form-control" id="requirements" name="requirements" rows="4" 
                                                  onkeyup="updateCharCounter('requirements', 1000)"
                                                  placeholder="List the required skills, experience, education, and qualifications..."><?php echo isset($_POST['requirements']) ? htmlspecialchars($_POST['requirements']) : ''; ?></textarea>
                                        <div class="char-counter" id="requirements-counter">0/1000 characters</div>
                                    </div>
                                    <div class="col-12">
                                        <label for="benefits" class="form-label fw-semibold">Benefits & Perks</label>
                                        <textarea class="form-control" id="benefits" name="benefits" rows="3" 
                                                  onkeyup="updateCharCounter('benefits', 500)"
                                                  placeholder="List the benefits, perks, and what makes this opportunity attractive..."><?php echo isset($_POST['benefits']) ? htmlspecialchars($_POST['benefits']) : ''; ?></textarea>
                                        <div class="char-counter" id="benefits-counter">0/500 characters</div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Salary Information Section -->
                            <div class="form-section">
                                <h5><i class="fas fa-money-bill-wave me-2"></i>Salary Information (Optional)</h5>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="salary_min" class="form-label fw-semibold">Minimum Salary (PKR)</label>
                                        <input type="number" class="form-control form-control-lg" id="salary_min" name="salary_min" 
                                               value="<?php echo isset($_POST['salary_min']) ? $_POST['salary_min'] : ''; ?>" 
                                               min="0" step="1000" placeholder="e.g. 50000">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="salary_max" class="form-label fw-semibold">Maximum Salary (PKR)</label>
                                        <input type="number" class="form-control form-control-lg" id="salary_max" name="salary_max" 
                                               value="<?php echo isset($_POST['salary_max']) ? $_POST['salary_max'] : ''; ?>" 
                                               min="0" step="1000" placeholder="e.g. 80000">
                                    </div>
                                    <div class="col-12">
                                        <small class="text-muted">
                                            <i class="fas fa-info-circle me-1"></i>
                                            Leave empty if you prefer not to disclose salary information
                                        </small>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Submit Buttons -->
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                                <a href="dashboard.php" class="btn btn-outline-secondary btn-lg me-md-2">
                                    <i class="fas fa-times me-2"></i>Cancel
                                </a>
                                <button type="reset" class="btn btn-outline-primary btn-lg me-md-2">
                                    <i class="fas fa-undo me-2"></i>Reset Form
                                </button>
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-save me-2"></i>Post Job
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Character counter function
function updateCharCounter(fieldId, maxLength) {
    const field = document.getElementById(fieldId);
    const counter = document.getElementById(fieldId + '-counter');
    const currentLength = field.value.length;
    
    if (fieldId === 'description') {
        counter.textContent = currentLength + '/' + maxLength + ' characters (minimum 50)';
        if (currentLength < 50) {
            counter.style.color = '#ef4444';
        } else {
            counter.style.color = '#10b981';
        }
    } else {
        counter.textContent = currentLength + '/' + maxLength + ' characters';
        if (currentLength > maxLength * 0.9) {
            counter.style.color = '#f59e0b';
        } else {
            counter.style.color = '#64748b';
        }
    }
}

// Initialize character counters
document.addEventListener('DOMContentLoaded', function() {
    updateCharCounter('title', 200);
    updateCharCounter('description', 2000);
    updateCharCounter('requirements', 1000);
    updateCharCounter('benefits', 500);
});

// Form validation
document.getElementById('addJobForm').addEventListener('submit', function(e) {
    const description = document.getElementById('description').value;
    if (description.length < 50) {
        e.preventDefault();
        alert('Job description must be at least 50 characters long.');
        return false;
    }
    
    const salaryMin = document.getElementById('salary_min').value;
    const salaryMax = document.getElementById('salary_max').value;
    
    if (salaryMin && salaryMax && parseInt(salaryMin) > parseInt(salaryMax)) {
        e.preventDefault();
        alert('Minimum salary cannot be greater than maximum salary.');
        return false;
    }
});

// Auto-resize textareas
document.querySelectorAll('textarea').forEach(textarea => {
    textarea.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = this.scrollHeight + 'px';
    });
});
</script>

<?php include '../partials/footer.php'; ?>