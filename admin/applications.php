<?php
include 'adminheader.php'; 
require_once '../partials/config.php';
// DB Connection

$sql = "SELECT * FROM job_applications ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Applications - Admin Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap + Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/your-kit-code.js" crossorigin="anonymous"></script>
</head>
<body>


            <div class="card shadow border-0">
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-file-alt me-2"></i>Job Applications</h5>
                    <span class="badge bg-success"><?= $result->num_rows; ?> Applications</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped mb-0">
                            <thead class="table-dark text-center">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Position</th>
                                    <th>Resume</th>
                                    <th>Cover Letter</th>
                                   
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($result && $result->num_rows > 0): ?>
                                    <?php while ($row = $result->fetch_assoc()): ?>
                                        <tr>
                                            <td class="text-center"><?= $row['id']; ?></td>
                                            <td><?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?></td>
                                            <td><a href="mailto:<?= $row['email']; ?>"><?= $row['email']; ?></a></td>
                                            <td><?= htmlspecialchars($row['phone']); ?></td>
                                            <td><span class="badge bg-primary"><?= htmlspecialchars($row['position']); ?></span></td>
                                            <td>
                                                <a href="<?= htmlspecialchars($row['resume_link']); ?>" target="_blank" class="btn btn-sm btn-outline-secondary">
                                                    <i class="fas fa-download"></i>
                                                </a>
                                           <td class="text-muted">
    <?= isset($row['created_at']) ? date('d M Y, h:i A', strtotime($row['created_at'])) : 'N/A'; ?>
</td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="8" class="text-center text-danger py-4">No applications found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
