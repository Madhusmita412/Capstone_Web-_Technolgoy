<?php
/**
 * FixIt Smart Complaint Management System
 * Admin Dashboard
 */

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';

Auth::requireAdmin();

$user = Auth::getCurrentUser();
$admin_id = $user['id'];

// Get statistics
$total_complaints = Complaint::getStatistics()['total'];
$pending_count = Complaint::getStatistics()['Pending'];
$in_progress_count = Complaint::getStatistics()['In Progress'];
$resolved_count = Complaint::getStatistics()['Resolved'];

// Get recent complaints
$recent_complaints = Complaint::getAllComplaints([], 10, 0);

// Get users count
$db = Database::getInstance();
$users_count = $db->count('users', "user_type = 'student'");
$contact_messages_count = $db->count('contact_messages', "read_status = 0");

// Get category breakdown
$category_breakdown = Complaint::getByCategory();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo APP_NAME; ?> - Admin Dashboard</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <style>
        .admin-container {
            display: flex;
        }
        
        .admin-sidebar {
            width: 250px;
            background: linear-gradient(180deg, #0f172a 0%, #1e293b 100%);
            color: white;
            min-height: 100vh;
            padding: 1.5rem 0;
            position: fixed;
            left: 0;
            top: 0;
            overflow-y: auto;
        }
        
        .admin-main {
            margin-left: 250px;
            flex: 1;
            background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
            min-height: 100vh;
        }
        
        .admin-header {
            background: white;
            padding: 1.5rem 2rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }
        
        .admin-content {
            padding: 2rem;
        }
        
        @media (max-width: 768px) {
            .admin-sidebar {
                width: 0;
                z-index: 1000;
            }
            
            .admin-main {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <!-- Admin Sidebar -->
        <aside class="admin-sidebar">
            <div style="padding: 1rem 1.5rem; margin-bottom: 1.5rem; border-bottom: 1px solid rgba(255, 255, 255, 0.1);">
                <h2 style="margin: 0; background: linear-gradient(135deg, var(--primary-light), var(--secondary)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">FixIt Admin</h2>
            </div>

            <nav style="list-style: none;">
                <li style="margin-bottom: 0;">
                    <a href="dashboard.php" class="sidebar-menu-link active" style="color: white; background: linear-gradient(135deg, var(--primary), var(--secondary)); margin: 0 1rem; border-radius: var(--radius-lg); padding: 0.75rem 1rem; display: flex; align-items: center; gap: 0.5rem;">
                        📊 Dashboard
                    </a>
                </li>
                <li style="margin-bottom: 0.5rem;">
                    <a href="complaints.php" class="sidebar-menu-link" style="color: rgba(255, 255, 255, 0.7); margin: 0 1rem; border-radius: var(--radius-lg); padding: 0.75rem 1rem; display: flex; align-items: center; gap: 0.5rem; transition: all 0.3s;">
                        📝 Manage Complaints
                    </a>
                </li>
                <li style="margin-bottom: 0.5rem;">
                    <a href="users.php" class="sidebar-menu-link" style="color: rgba(255, 255, 255, 0.7); margin: 0 1rem; border-radius: var(--radius-lg); padding: 0.75rem 1rem; display: flex; align-items: center; gap: 0.5rem; transition: all 0.3s;">
                        👥 Users
                    </a>
                </li>
                <li style="margin-bottom: 0.5rem;">
                    <a href="messages.php" class="sidebar-menu-link" style="color: rgba(255, 255, 255, 0.7); margin: 0 1rem; border-radius: var(--radius-lg); padding: 0.75rem 1rem; display: flex; align-items: center; gap: 0.5rem; transition: all 0.3s;">
                        💬 Messages <span style="background: var(--danger); color: white; padding: 0.125rem 0.375rem; border-radius: var(--radius-full); font-size: 0.8rem; margin-left: auto;"><?php echo $contact_messages_count; ?></span>
                    </a>
                </li>
                <li style="margin-bottom: 0.5rem;">
                    <a href="reports.php" class="sidebar-menu-link" style="color: rgba(255, 255, 255, 0.7); margin: 0 1rem; border-radius: var(--radius-lg); padding: 0.75rem 1rem; display: flex; align-items: center; gap: 0.5rem; transition: all 0.3s;">
                        📈 Reports
                    </a>
                </li>
                <li style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid rgba(255, 255, 255, 0.1); margin-bottom: 0;">
                    <a href="../profile.php" class="sidebar-menu-link" style="color: rgba(255, 255, 255, 0.7); margin: 0 1rem; border-radius: var(--radius-lg); padding: 0.75rem 1rem; display: flex; align-items: center; gap: 0.5rem; transition: all 0.3s;">
                        ⚙️ Settings
                    </a>
                </li>
                <li style="margin-bottom: 0;">
                    <a href="../logout.php" class="sidebar-menu-link" style="color: rgba(255, 255, 255, 0.7); margin: 0 1rem; border-radius: var(--radius-lg); padding: 0.75rem 1rem; display: flex; align-items: center; gap: 0.5rem; transition: all 0.3s;">
                        🚪 Logout
                    </a>
                </li>
            </nav>
        </aside>

        <!-- Admin Main Content -->
        <main class="admin-main">
            <!-- Header -->
            <div class="admin-header">
                <h1 style="margin: 0;">Admin Dashboard</h1>
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <span style="color: var(--gray-600);">Welcome, <?php echo htmlspecialchars($user['name']); ?></span>
                    <a href="../profile.php" class="btn btn-small btn-outline">Profile</a>
                </div>
            </div>

            <!-- Dashboard Content -->
            <div class="admin-content">
                <!-- Statistics -->
                <div class="stats-grid" style="margin-bottom: 2rem;">
                    <div class="stat-card">
                        <h3><?php echo $total_complaints; ?></h3>
                        <p class="stat-label">Total Complaints</p>
                    </div>

                    <div class="stat-card">
                        <h3><?php echo $pending_count; ?></h3>
                        <p class="stat-label">Pending</p>
                    </div>

                    <div class="stat-card">
                        <h3><?php echo $in_progress_count; ?></h3>
                        <p class="stat-label">In Progress</p>
                    </div>

                    <div class="stat-card">
                        <h3><?php echo $resolved_count; ?></h3>
                        <p class="stat-label">Resolved</p>
                    </div>

                    <div class="stat-card">
                        <h3><?php echo $users_count; ?></h3>
                        <p class="stat-label">Total Students</p>
                    </div>

                    <div class="stat-card">
                        <h3><?php echo $contact_messages_count; ?></h3>
                        <p class="stat-label">New Messages</p>
                    </div>
                </div>

                <!-- Two Column Layout -->
                <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem; margin-bottom: 2rem;">
                    <!-- Recent Complaints -->
                    <div class="card">
                        <div class="card-header">
                            <h3>Recent Complaints</h3>
                        </div>

                        <div style="overflow-x: auto;">
                            <table style="margin-bottom: 0;">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Status</th>
                                        <th>Priority</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($recent_complaints as $complaint): ?>
                                        <tr>
                                            <td>#<?php echo str_pad($complaint['id'], 5, '0', STR_PAD_LEFT); ?></td>
                                            <td><?php echo htmlspecialchars(truncateText($complaint['title'], 30)); ?></td>
                                            <td><?php echo getStatusBadge($complaint['status']); ?></td>
                                            <td><?php echo getPriorityBadge($complaint['priority']); ?></td>
                                            <td><?php echo formatDateOnly($complaint['created_at']); ?></td>
                                            <td>
                                                <a href="complaint-details.php?id=<?php echo $complaint['id']; ?>" class="btn btn-small" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;">View</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="card-footer">
                            <a href="complaints.php" class="btn btn-primary btn-small">View All Complaints →</a>
                        </div>
                    </div>

                    <!-- Category Breakdown -->
                    <div class="card">
                        <div class="card-header">
                            <h3>By Category</h3>
                        </div>

                        <div style="padding: 1rem 0;">
                            <?php foreach ($category_breakdown as $cat): ?>
                                <div style="padding: 0.75rem; border-bottom: 1px solid var(--gray-200); display: flex; justify-content: space-between; align-items: center;">
                                    <span style="font-weight: 500;"><?php echo htmlspecialchars($cat['category']); ?></span>
                                    <span style="background: linear-gradient(135deg, var(--primary), var(--secondary)); color: white; padding: 0.25rem 0.75rem; border-radius: var(--radius-full); font-weight: 600; font-size: 0.9rem;">
                                        <?php echo $cat['count']; ?>
                                    </span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="card">
                    <div class="card-header">
                        <h3>Quick Actions</h3>
                    </div>

                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; padding: 1rem 0;">
                        <a href="complaints.php?status=Pending" class="btn btn-primary" style="text-align: center; text-decoration: none;">View Pending Complaints</a>
                        <a href="complaints.php?status=In%20Progress" class="btn btn-secondary" style="text-align: center; text-decoration: none;">In Progress Cases</a>
                        <a href="users.php" class="btn btn-outline" style="text-align: center; text-decoration: none;">Manage Users</a>
                        <a href="messages.php" class="btn btn-outline" style="text-align: center; text-decoration: none;">View Messages</a>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="../assets/js/validation.js"></script>
</body>
</html>
