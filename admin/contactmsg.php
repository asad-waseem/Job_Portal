<?php
include 'adminheader.php'; 
require_once '../partials/config.php';

// Fetch all contact messages
$sql = "SELECT * FROM contact_messages ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Messages - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
    
        .admin-header {
    background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
    color: white;
    padding: 20px 0;
    margin-bottom: 30px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 40px; /* Added horizontal padding */
    border-radius: 15px; /* Added rounded corners */
  }
        .message-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            transition: transform 0.3s ease;
        }
        .message-card:hover {
            transform: translateY(-5px);
        }
        .message-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px 15px 0 0;
            padding: 15px 20px;
        }
        .badge-new {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%);
        }
        .btn-back {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            border: none;
            color: white;
            padding: 10px 20px;
            border-radius: 25px;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        .btn-back:hover {
            background: linear-gradient(135deg, #2a5298 0%, #1e3c72 100%);
            color: white;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-white py-3">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h4 class="mb-0">
                                    <i class="fas fa-inbox text-primary me-2"></i>
                                    All Messages (<?php echo $result->num_rows; ?>)
                                </h4>
                            </div>
                            <div class="col-md-6 text-end">
                                <small class="text-muted">
                                    <i class="fas fa-clock me-1"></i>
                                    Last updated: <?php echo date('Y-m-d H:i:s'); ?>
                                </small>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <?php if ($result->num_rows > 0): ?>
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>ID</th>
                                            <th>Full Name</th>
                                            <th>Email</th>
                                            <th>Subject</th>
                                            <th>Message</th>
                                            <th>Date</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while($row = $result->fetch_assoc()): ?>
                                        <tr>
                                            <td><span class="badge bg-primary">#<?php echo $row['id']; ?></span></td>
                                            <td>
                                                <strong><?php echo htmlspecialchars($row['full_name']); ?></strong>
                                            </td>
                                            <td>
                                                <a href="mailto:<?php echo htmlspecialchars($row['email']); ?>" class="text-decoration-none">
                                                    <i class="fas fa-envelope me-1"></i>
                                                    <?php echo htmlspecialchars($row['email']); ?>
                                                </a>
                                            </td>
                                            <td>
                                                <span class="fw-semibold"><?php echo htmlspecialchars($row['subject']); ?></span>
                                            </td>
                                            <td>
                                                <div style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                                    <?php echo htmlspecialchars(substr($row['message'], 0, 50)) . (strlen($row['message']) > 50 ? '...' : ''); ?>
                                                </div>
                                                <button class="btn btn-sm btn-outline-info mt-1" onclick="showFullMessage(<?php echo $row['id']; ?>)">
                                                    <i class="fas fa-eye"></i> View Full
                                                </button>
                                            </td>
                                            <td>
                                                <small class="text-muted">
                                                    <?php echo date('M j, Y', strtotime($row['created_at'])); ?><br>
                                                    <?php echo date('H:i A', strtotime($row['created_at'])); ?>
                                                </small>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <button class="btn btn-sm btn-success" onclick="replyToMessage('<?php echo htmlspecialchars($row['email']); ?>', '<?php echo htmlspecialchars($row['subject']); ?>')">
                                                        <i class="fas fa-reply"></i>
                                                    </button>
                                                    
                                                </div>
                                            </td>
                                        </tr>
                                        <!-- Hidden full message row -->
                                        <tr id="fullMessage<?php echo $row['id']; ?>" style="display: none;">
                                            <td colspan="7">
                                                <div class="alert alert-info mb-0">
                                                    <h6><i class="fas fa-comment-alt me-2"></i>Full Message:</h6>
                                                    <p class="mb-0"><?php echo nl2br(htmlspecialchars($row['message'])); ?></p>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-5">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No messages yet</h5>
                                <p class="text-muted">Contact form submissions will appear here.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div> <br>
<div class="admin-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1><i class="fas fa-envelope me-2"></i>Contact Messages</h1>
                    <p class="mb-0">Manage and view all contact form submissions</p>
                </div>
                <div class="col-md-4 text-end">
                    <a href="../index..I.php" class="btn-back">
                        <i class="fas fa-arrow-left me-2"></i>Back to Site
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        function showFullMessage(id) {
            const fullMessageRow = document.getElementById('fullMessage' + id);
            if (fullMessageRow.style.display === 'none') {
                fullMessageRow.style.display = 'table-row';
            } else {
                fullMessageRow.style.display = 'none';
            }
        }

        function replyToMessage(email, subject) {
            const replySubject = 'Re: ' + subject;
            const mailtoLink = `mailto:${email}?subject=${encodeURIComponent(replySubject)}&body=Dear%20Customer,%0D%0A%0D%0AThank%20you%20for%20contacting%20us.%0D%0A%0D%0ABest%20regards,%0D%0AJob%20Portal%20Team`;
            window.open(mailtoLink);
        }

        function deleteMessage(id) {
            if (confirm('Are you sure you want to delete this message?')) {
                // You can implement AJAX delete functionality here
                alert('Delete functionality would be implemented here with AJAX');
            }
        }

        // Auto-refresh every 30 seconds
        setInterval(function() {
            location.reload();
        }, 30000);
    </script>
</body>
</html>

<?php
$conn->close();
?>