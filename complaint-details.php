<?php
/**
 * FixIt Smart Complaint Management System
 * Complaint Details Page
 */

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/functions.php';

Auth::requireLogin();

$user = Auth::getCurrentUser();
$complaint_id = $_GET['id'] ?? 0;

if (!$complaint_id) {
    header('Location: ' . APP_URL . '/dashboard.php');
    exit();
}

$complaint = Complaint::getComplaintById($complaint_id);

if (!$complaint) {
    header('Location: ' . APP_URL . '/dashboard.php');
    exit();
}

// Check if user owns this complaint or is admin
if ($complaint['user_id'] != $user['id'] && $user['user_type'] !== 'admin') {
    header('Location: ' . APP_URL . '/dashboard.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo APP_NAME; ?> - Complaint Details</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <!-- Navigation Bar -->
    <nav>
        <div class="nav-container">
            <div class="nav-brand">
                <span>🔧</span> FixIt
            </div>
            
            <ul class="nav-menu">
                <li><a href="index.php">Home</a></li>
                <li><a href="dashboard.php" class="active">Dashboard</a></li>
                <li><a href="submit-complaint.php">Submit Complaint</a></li>
            </ul>
            
            <div class="nav-actions">
                <a href="profile.php" class="btn btn-outline btn-small">Profile</a>
                <a href="logout.php" class="btn btn-primary btn-small">Logout</a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content" style="padding: 3rem 2rem;">
        <div style="max-width: 800px; margin: 0 auto;">
            <a href="dashboard.php" style="color: var(--primary); margin-bottom: 1rem; display: inline-flex; align-items: center; gap: 0.5rem;">
                ← Back to Dashboard
            </a>

            <div class="card">
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
                    <!-- Status Timeline -->
                    <div style="background: linear-gradient(135deg, rgba(99, 102, 241, 0.05) 0%, rgba(14, 165, 233, 0.05) 100%); padding: 1.5rem; border-radius: var(--radius-lg); margin-bottom: 2rem;">
                        <h3 style="margin-bottom: 1rem;">Status Timeline</h3>
                        <div style="display: flex; justify-content: space-around; flex-wrap: wrap; gap: 1rem;">
                            <div style="text-align: center;">
                                <div style="width: 40px; height: 40px; margin: 0 auto 0.5rem; background: linear-gradient(135deg, var(--primary), var(--secondary)); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold;">
                                    ✓
                                </div>
                                <p style="font-size: 0.9rem; color: var(--gray-600);">Submitted</p>
                                <small><?php echo formatDate($complaint['created_at']); ?></small>
                            </div>

                            <div style="text-align: center; opacity: <?php echo $complaint['status'] !== 'Pending' ? '1' : '0.5'; ?>;">
                                <div style="width: 40px; height: 40px; margin: 0 auto 0.5rem; background: <?php echo $complaint['status'] !== 'Pending' ? 'linear-gradient(135deg, var(--primary), var(--secondary))' : 'var(--gray-300)'; ?>; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold;">
                                    ◐
                                </div>
                                <p style="font-size: 0.9rem; color: var(--gray-600);">In Progress</p>
                            </div>

                            <div style="text-align: center; opacity: <?php echo $complaint['status'] === 'Resolved' ? '1' : '0.5'; ?>;">
                                <div style="width: 40px; height: 40px; margin: 0 auto 0.5rem; background: <?php echo $complaint['status'] === 'Resolved' ? 'var(--success)' : 'var(--gray-300)'; ?>; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold;">
                                    ✓
                                </div>
                                <p style="font-size: 0.9rem; color: var(--gray-600);">Resolved</p>
                                <?php if ($complaint['resolved_at']): ?>
                                    <small><?php echo formatDate($complaint['resolved_at']); ?></small>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Details Grid -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 2rem;">
                        <div>
                            <h4 style="color: var(--gray-600); font-size: 0.9rem; text-transform: uppercase; margin-bottom: 0.5rem;">Category</h4>
                            <p style="font-weight: 500; font-size: 1.05rem; margin-bottom: 1rem;"><?php echo htmlspecialchars($complaint['category']); ?></p>

                            <h4 style="color: var(--gray-600); font-size: 0.9rem; text-transform: uppercase; margin-bottom: 0.5rem;">Priority</h4>
                            <p style="margin-bottom: 1rem;">
                                <?php echo getPriorityBadge($complaint['priority']); ?>
                            </p>

                            <h4 style="color: var(--gray-600); font-size: 0.9rem; text-transform: uppercase; margin-bottom: 0.5rem;">Status</h4>
                            <p style="margin-bottom: 1rem;">
                                <?php echo getStatusBadge($complaint['status']); ?>
                            </p>
                        </div>

                        <div>
                            <h4 style="color: var(--gray-600); font-size: 0.9rem; text-transform: uppercase; margin-bottom: 0.5rem;">Submitted By</h4>
                            <p style="font-weight: 500; font-size: 1.05rem; margin-bottom: 1rem;"><?php echo htmlspecialchars($complaint['user_name']); ?></p>

                            <h4 style="color: var(--gray-600); font-size: 0.9rem; text-transform: uppercase; margin-bottom: 0.5rem;">Submitted On</h4>
                            <p style="font-weight: 500; margin-bottom: 1rem;"><?php echo formatDate($complaint['created_at']); ?></p>

                            <h4 style="color: var(--gray-600); font-size: 0.9rem; text-transform: uppercase; margin-bottom: 0.5rem;">Last Updated</h4>
                            <p style="font-weight: 500;"><?php echo formatRelativeTime($complaint['updated_at']); ?></p>
                        </div>
                    </div>

                    <!-- Description -->
                    <div>
                        <h4 style="color: var(--gray-600); font-size: 0.9rem; text-transform: uppercase; margin-bottom: 0.5rem;">Description</h4>
                        <div style="background: var(--gray-50); padding: 1.5rem; border-radius: var(--radius-lg); line-height: 1.8;">
                            <?php echo nl2br(htmlspecialchars($complaint['description'])); ?>
                        </div>
                    </div>

                    <!-- Resolution Notes (if resolved) -->
                    <?php if ($complaint['status'] === 'Resolved' && !empty($complaint['resolution_notes'])): ?>
                        <div style="margin-top: 2rem; padding-top: 2rem; border-top: 1px solid var(--gray-200);">
                            <h4 style="color: var(--success); font-size: 0.9rem; text-transform: uppercase; margin-bottom: 0.5rem;">Resolution Notes</h4>
                            <div style="background: linear-gradient(135deg, rgba(16, 185, 129, 0.05) 0%, rgba(34, 197, 94, 0.05) 100%); padding: 1.5rem; border-radius: var(--radius-lg); line-height: 1.8;">
                                <?php echo nl2br(htmlspecialchars($complaint['resolution_notes'])); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="card-footer">
                    <a href="dashboard.php" class="btn btn-outline">← Back to Dashboard</a>
                    <?php if ($complaint['status'] !== 'Resolved'): ?>
                        <span style="font-size: 0.9rem; color: var(--gray-600);">
                            ℹ️ Status updates will appear here as your complaint is processed
                        </span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer style="margin-top: 4rem;">
        <div class="footer-bottom" style="text-align: center;">
            <p>&copy; <?php echo date('Y'); ?> FixIt - Smart Complaint Management System</p>
        </div>
    </footer>

    <script src="/assets/js/validation.js"></script>
</body>
</html>
