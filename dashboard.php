<?php
/**
 * FixIt Smart Complaint Management System
 * Student Dashboard Page
 */

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/functions.php';

Auth::requireLogin();

$user = Auth::getCurrentUser();
$user_id = $user['id'];

// Get statistics
$stats = Complaint::getStatistics($user_id);

// Get filters
$filter_status = $_GET['status'] ?? '';
$filter_category = $_GET['category'] ?? '';
$filter_search = $_GET['search'] ?? '';

$filters = [];
if ($filter_status) $filters['status'] = $filter_status;
if ($filter_category) $filters['category'] = $filter_category;
if ($filter_search) $filters['search'] = $filter_search;

// Get complaints
$complaints = Complaint::getUserComplaints($user_id, $filters);

// Get category breakdown
$categories = Complaint::getByCategory($user_id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo APP_NAME; ?> - Dashboard</title>
    <link rel="stylesheet" href="assets/css/style.css">
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
    <div class="main-content" style="max-width: 1200px; margin: 0 auto;">
        <div class="container">
            <!-- Header -->
            <div style="margin-bottom: 2rem;">
                <h1>Welcome, <?php echo htmlspecialchars($user['name']); ?>! 👋</h1>
                <p style="color: var(--gray-600);">Track and manage your complaints here</p>
            </div>

            <!-- Statistics Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <h3><?php echo $stats['total']; ?></h3>
                    <p class="stat-label">Total Complaints</p>
                </div>

                <div class="stat-card">
                    <h3><?php echo $stats['Pending']; ?></h3>
                    <p class="stat-label">Pending</p>
                </div>

                <div class="stat-card">
                    <h3><?php echo $stats['In Progress']; ?></h3>
                    <p class="stat-label">In Progress</p>
                </div>

                <div class="stat-card">
                    <h3><?php echo $stats['Resolved']; ?></h3>
                    <p class="stat-label">Resolved</p>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card" style="margin-bottom: 2rem;">
                <div class="card-body">
                    <a href="submit-complaint.php" class="btn btn-primary">
                        + Submit New Complaint
                    </a>
                </div>
            </div>

            <!-- Filters -->
            <div class="card" style="margin-bottom: 2rem;">
                <div class="card-body">
                    <form method="GET" style="display: flex; gap: 1rem; flex-wrap: wrap;">
                        <div style="flex: 1; min-width: 200px;">
                            <input type="text" id="searchInput" name="search" placeholder="Search complaints..." 
                                   value="<?php echo htmlspecialchars($filter_search); ?>"
                                   style="width: 100%; padding: 0.75rem 1rem; border: 2px solid var(--gray-200); border-radius: var(--radius-lg);">
                        </div>

                        <select id="statusFilter" name="status" style="padding: 0.75rem 1rem; border: 2px solid var(--gray-200); border-radius: var(--radius-lg);">
                            <option value="">All Status</option>
                            <option value="Pending" <?php echo $filter_status === 'Pending' ? 'selected' : ''; ?>>Pending</option>
                            <option value="In Progress" <?php echo $filter_status === 'In Progress' ? 'selected' : ''; ?>>In Progress</option>
                            <option value="Resolved" <?php echo $filter_status === 'Resolved' ? 'selected' : ''; ?>>Resolved</option>
                        </select>

                        <select id="categoryFilter" name="category" style="padding: 0.75rem 1rem; border: 2px solid var(--gray-200); border-radius: var(--radius-lg);">
                            <option value="">All Categories</option>
                            <?php foreach (COMPLAINT_CATEGORIES as $cat_name => $cat_value): ?>
                                <option value="<?php echo htmlspecialchars($cat_name); ?>" <?php echo $filter_category === $cat_name ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($cat_name); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <button type="submit" class="btn btn-secondary" style="white-space: nowrap;">🔍 Filter</button>
                    </form>
                </div>
            </div>

            <!-- Complaints List -->
            <div>
                <h2 style="margin-bottom: 1.5rem;">Your Complaints</h2>

                <?php if (empty($complaints)): ?>
                    <div class="card" style="text-align: center; padding: 3rem 2rem;">
                        <p style="font-size: 1.1rem; color: var(--gray-600);">No complaints found. 
                            <a href="submit-complaint.php">Submit one now</a>
                        </p>
                    </div>
                <?php else: ?>
                    <?php foreach ($complaints as $complaint): ?>
                        <div class="complaint-item" data-status="<?php echo htmlspecialchars($complaint['status']); ?>" 
                             data-category="<?php echo htmlspecialchars($complaint['category']); ?>">
                            <div class="complaint-header">
                                <div class="complaint-title"><?php echo htmlspecialchars($complaint['title']); ?></div>
                                <a href="complaint-details.php?id=<?php echo $complaint['id']; ?>" class="btn btn-small btn-outline">View Details →</a>
                            </div>

                            <div class="complaint-meta">
                                <span style="background: rgba(99, 102, 241, 0.1); padding: 0.35rem 0.75rem; border-radius: var(--radius-full); font-size: 0.9rem;">
                                    <?php echo htmlspecialchars($complaint['category']); ?>
                                </span>
                                <?php echo getStatusBadge($complaint['status']); ?>
                                <?php echo getPriorityBadge($complaint['priority']); ?>
                            </div>

                            <div class="complaint-description">
                                <?php echo htmlspecialchars(truncateText($complaint['description'], 150)); ?>
                            </div>

                            <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.9rem; color: var(--gray-600);">
                                <span>📅 <?php echo formatDate($complaint['created_at']); ?></span>
                                <?php if ($complaint['status'] === 'Resolved' && $complaint['resolved_at']): ?>
                                    <span style="color: var(--success);">✓ Resolved on <?php echo formatDate($complaint['resolved_at']); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer style="margin-top: 4rem;">
        <div class="footer-bottom" style="text-align: center;">
            <p>&copy; <?php echo date('Y'); ?> FixIt - Smart Complaint Management System</p>
        </div>
    </footer>

    <script src="assets/js/validation.js"></script>
    <script>
        // Real-time filter
        document.getElementById('statusFilter').addEventListener('change', function() {
            filterComplaints();
        });

        document.getElementById('categoryFilter').addEventListener('change', function() {
            filterComplaints();
        });

        document.getElementById('searchInput').addEventListener('input', function() {
            filterComplaints();
        });
    </script>
</body>
</html>
