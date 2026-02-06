<?php
include 'adminheader.php'; 
require_once '../partials/config.php';

// Fetch all users
$sql = "SELECT * FROM users ORDER BY id DESC";
$result = $conn->query($sql);
?>

            <div class="card shadow-sm border-0">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-users me-2"></i>All Users</h5>
                    <span class="badge bg-primary"><?= $result->num_rows; ?> Users</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Full Name</th>
                                    <th>Email</th>
                                    <th>Username</th>
                                    <th>Phone</th>
                                    <th>Profession</th>
                                    <th>Address</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($result && $result->num_rows > 0): ?>
                                    <?php while ($row = $result->fetch_assoc()): ?>
                                        <tr>
                                            <td><?= $row['id']; ?></td>
                                            <td><?= htmlspecialchars($row['fullname'] ?? 'N/A'); ?></td>
                                            <td><a href="mailto:<?= htmlspecialchars($row['email'] ?? ''); ?>"><?= htmlspecialchars($row['email'] ?? 'N/A'); ?></a></td>
                                            <td><span class="badge bg-info"><?= htmlspecialchars($row['username'] ?? 'N/A'); ?></span></td>
                                            <td><?= htmlspecialchars($row['phone'] ?? 'N/A'); ?></td>
                                            <td><?= htmlspecialchars($row['profession'] ?? 'N/A'); ?></td>
                                            <td><?= htmlspecialchars($row['address'] ?? 'N/A'); ?></td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-4">No users found.</td>
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

<?php include '../partials/footer.php'; ?>
