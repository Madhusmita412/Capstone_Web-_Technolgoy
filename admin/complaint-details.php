<?php
/**
 * FixIt Smart Complaint Management System
 * Admin - Complaint Details
 */

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';

Auth::requireAdmin();

$user = Auth::getCurrentUser();
$complaint_id = $_GET['id'] ?? 0;

$complaint = Complaint::getComplaintById($complaint_id);

if (!$complaint) {
    header('Location: ' . APP_URL . '/admin/complaints.php');
    exit();
}

$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_status = $_POST['status'] ?? $complaint['status'];
    $resolution_notes = $_POST['resolution_notes'] ?? '';

    if (Complaint::updateStatus($complaint_id, $new_status, $resolution_notes, $user['id'])) {
        $success = true;
        $complaint = Complaint::getComplaintById($complaint_id);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo APP_NAME; ?> - Complaint Details</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <!-- Navigation Bar -->
    <nav>
        <div class="nav-container">
            <div class="nav-brand">
                <span>🔧</span> FixIt Admin
            </div>
            
            <div class="nav-actions">
                <a href="dashboard.php" class="btn btn-outline btn-small">Dashboard</a>
                <a href="../logout.php" class="btn btn-primary btn-small">Logout</a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content" style="padding: 3rem 2rem;">
        <div style="max-width: 900px; margin: 0 auto;">
            <a href="complaints.php" style="color: var(--primary); margin-bottom: 1rem; display: inline-flex; align-items: center; gap: 0.5rem;">
                ← Back to Complaints
            </a>

            <div class="card">
                <?php if ($success): ?>
                    <div class="success-message" style="margin-bottom: 1rem;">
                        ✓ Complaint updated successfully
                    </div>
                <?php endif; ?>

                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: start; gap: 1rem; flex-wrap: wrap;">
                        <div>
                            <h1 style="margin-bottom: 0.5rem;"><?php echo htmlspecialchars($complaint['title']); ?></h1>
                            <p style="color: var(--gray-600);">Complaint ID: #<?php echo str_pad($complaint['id'], 5, '0', STR_PAD_LEFT); ?></p>
                        </div>
                        <div style="text-align: right;">
                            <?php echo getStatusBadge($complaint['status']); ?>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Details Grid -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 2rem; padding-bottom: 2rem; border-bottom: 1px solid var(--gray-200);">
                        <div>
                            <h4 style="color: var(--gray-600); font-size: 0.9rem; text-transform: uppercase; margin-bottom: 0.5rem;">Category</h4>
                            <p style="font-weight: 500;"><?php echo htmlspecialchars($complaint['category']); ?></p>

                            <h4 style="color: var(--gray-600); font-size: 0.9rem; text-transform: uppercase; margin-bottom: 0.5rem; margin-top: 1rem;">Priority</h4>
                            <p><?php echo getPriorityBadge($complaint['priority']); ?></p>

                            <h4 style="color: var(--gray-600); font-size: 0.9rem; text-transform: uppercase; margin-bottom: 0.5rem; margin-top: 1rem;">Submitted By</h4>
                            <p style="font-weight: 500;">
                                <?php echo htmlspecialchars($complaint['user_name']); ?>
                                <br><small style="color: var(--gray-600);"><?php echo htmlspecialchars($complaint['user_email']); ?></small>
                            </p>
                        </div>

                        <div>
                            <h4 style="color: var(--gray-600); font-size: 0.9rem; text-transform: uppercase; margin-bottom: 0.5rem;">Status</h4>
                            <p><?php echo getStatusBadge($complaint['status']); ?></p>

                            <h4 style="color: var(--gray-600); font-size: 0.9rem; text-transform: uppercase; margin-bottom: 0.5rem; margin-top: 1rem;">Submitted On</h4>
                            <p style="font-weight: 500;"><?php echo formatDate($complaint['created_at']); ?></p>

                            <h4 style="color: var(--gray-600); font-size: 0.9rem; text-transform: uppercase; margin-bottom: 0.5rem; margin-top: 1rem;">Last Updated</h4>
                            <p style="font-weight: 500;"><?php echo formatRelativeTime($complaint['updated_at']); ?></p>
                        </div>
                    </div>

                    <!-- Description -->
                    <div style="margin-bottom: 2rem;">
                        <h4 style="color: var(--gray-600); font-size: 0.9rem; text-transform: uppercase; margin-bottom: 0.5rem;">Description</h4>
                        <div style="background: var(--gray-50); padding: 1.5rem; border-radius: var(--radius-lg); line-height: 1.8;">
                            <?php echo nl2br(htmlspecialchars($complaint['description'])); ?>
                        </div>
                    </div>

                    <!-- Update Status Form -->
                    <form method="POST" style="background: linear-gradient(135deg, rgba(99, 102, 241, 0.05) 0%, rgba(14, 165, 233, 0.05) 100%); padding: 2rem; border-radius: var(--radius-lg); margin-bottom: 2rem;">
                        <h3 style="margin-bottom: 1.5rem;">Update Complaint Status</h3>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
                            <div class="form-group">
                                <label for="status">New Status *</label>
                                <select id="status" name="status" required>
                                    <option value="Pending" <?php echo $complaint['status'] === 'Pending' ? 'selected' : ''; ?>>Pending</option>
                                    <option value="In Progress" <?php echo $complaint['status'] === 'In Progress' ? 'selected' : ''; ?>>In Progress</option>
                                    <option value="Resolved" <?php echo $complaint['status'] === 'Resolved' ? 'selected' : ''; ?>>Resolved</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="resolution_notes">Resolution Notes</label>
                            <textarea id="resolution_notes" name="resolution_notes" placeholder="Add notes about the resolution..."><?php echo htmlspecialchars($complaint['resolution_notes'] ?? ''); ?></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Update Status</button>
                    </form>

                    <!-- Existing Resolution Notes -->
                    <?php if (!empty($complaint['resolution_notes'])): ?>
                        <div style="background: linear-gradient(135deg, rgba(16, 185, 129, 0.05) 0%, rgba(34, 197, 94, 0.05) 100%); padding: 1.5rem; border-radius: var(--radius-lg);">
                            <h4 style="color: var(--success); margin-bottom: 0.5rem;">📝 Resolution Notes</h4>
                            <p style="color: var(--gray-700);">
                                <?php echo nl2br(htmlspecialchars($complaint['resolution_notes'])); ?>
                            </p>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="card-footer">
                    <a href="complaints.php" class="btn btn-outline">← Back to List</a>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/js/validation.js"></script>
</body>
</html>
