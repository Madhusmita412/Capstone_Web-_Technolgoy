<?php
/**
 * FixIt Smart Complaint Management System
 * Admin - Manage Complaints
 */

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';

Auth::requireAdmin();

$user = Auth::getCurrentUser();

// Handle complaint update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $complaint_id = $_POST['complaint_id'] ?? 0;
    $action = $_POST['action'];

    if ($action === 'update_status') {
        $new_status = $_POST['status'] ?? '';
        $resolution_notes = $_POST['resolution_notes'] ?? '';
        
        if (Complaint::updateStatus($complaint_id, $new_status, $resolution_notes, $user['id'])) {
            $success_msg = 'Complaint status updated successfully';
        }
    } elseif ($action === 'delete') {
        if (Complaint::deleteComplaint($complaint_id)) {
            $success_msg = 'Complaint deleted successfully';
        }
    }
}

// Get filters
$filter_status = $_GET['status'] ?? '';
$filter_category = $_GET['category'] ?? '';
$filter_priority = $_GET['priority'] ?? '';
$filter_search = $_GET['search'] ?? '';

$filters = [];
if ($filter_status) $filters['status'] = $filter_status;
if ($filter_category) $filters['category'] = $filter_category;
if ($filter_priority) $filters['priority'] = $filter_priority;
if ($filter_search) $filters['search'] = $filter_search;

$complaints = Complaint::getAllComplaints($filters, 50, 0);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo APP_NAME; ?> - Manage Complaints</title>
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
        }
        
        .admin-content {
            padding: 2rem;
        }
        
        .sidebar-menu-link {
            color: rgba(255, 255, 255, 0.7);
            margin: 0 1rem;
            border-radius: var(--radius-lg);
            padding: 0.75rem 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s;
            text-decoration: none;
        }
        
        .sidebar-menu-link:hover,
        .sidebar-menu-link.active {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <div style="padding: 1rem 1.5rem; margin-bottom: 1.5rem; border-bottom: 1px solid rgba(255, 255, 255, 0.1);">
                <h2 style="margin: 0; background: linear-gradient(135deg, var(--primary-light), var(--secondary)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">FixIt Admin</h2>
            </div>

            <nav style="list-style: none;">
                <li style="margin-bottom: 0;">
                    <a href="dashboard.php" class="sidebar-menu-link">📊 Dashboard</a>
                </li>
                <li style="margin-bottom: 0.5rem;">
                    <a href="complaints.php" class="sidebar-menu-link active">📝 Manage Complaints</a>
                </li>
                <li style="margin-bottom: 0.5rem;">
                    <a href="users.php" class="sidebar-menu-link">👥 Users</a>
                </li>
                <li style="margin-bottom: 0.5rem;">
                    <a href="messages.php" class="sidebar-menu-link">💬 Messages</a>
                </li>
                <li style="margin-bottom: 0.5rem;">
                    <a href="reports.php" class="sidebar-menu-link">📈 Reports</a>
                </li>
                <li style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid rgba(255, 255, 255, 0.1); margin-bottom: 0;">
                    <a href="../profile.php" class="sidebar-menu-link">⚙️ Settings</a>
                </li>
                <li style="margin-bottom: 0;">
                    <a href="../logout.php" class="sidebar-menu-link">🚪 Logout</a>
                </li>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="admin-main">
            <div class="admin-header">
                <h1 style="margin: 0;">Manage Complaints</h1>
                <a href="dashboard.php" class="btn btn-small btn-outline">← Back to Dashboard</a>
            </div>

            <div class="admin-content">
                <?php if (isset($success_msg)): ?>
                    <div class="success-message" style="margin-bottom: 1rem;">
                        ✓ <?php echo htmlspecialchars($success_msg); ?>
                    </div>
                <?php endif; ?>

                <!-- Filters -->
                <div class="card" style="margin-bottom: 2rem;">
                    <div class="card-body">
                        <form method="GET" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
                            <input type="text" name="search" placeholder="Search complaints..." 
                                   value="<?php echo htmlspecialchars($filter_search); ?>"
                                   style="padding: 0.75rem 1rem; border: 2px solid var(--gray-200); border-radius: var(--radius-lg);">

                            <select name="status" style="padding: 0.75rem 1rem; border: 2px solid var(--gray-200); border-radius: var(--radius-lg);">
                                <option value="">All Status</option>
                                <option value="Pending" <?php echo $filter_status === 'Pending' ? 'selected' : ''; ?>>Pending</option>
                                <option value="In Progress" <?php echo $filter_status === 'In Progress' ? 'selected' : ''; ?>>In Progress</option>
                                <option value="Resolved" <?php echo $filter_status === 'Resolved' ? 'selected' : ''; ?>>Resolved</option>
                            </select>

                            <select name="category" style="padding: 0.75rem 1rem; border: 2px solid var(--gray-200); border-radius: var(--radius-lg);">
                                <option value="">All Categories</option>
                                <?php foreach (COMPLAINT_CATEGORIES as $cat_name => $cat_value): ?>
                                    <option value="<?php echo htmlspecialchars($cat_name); ?>" <?php echo $filter_category === $cat_name ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($cat_name); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>

                            <select name="priority" style="padding: 0.75rem 1rem; border: 2px solid var(--gray-200); border-radius: var(--radius-lg);">
                                <option value="">All Priorities</option>
                                <option value="Low" <?php echo $filter_priority === 'Low' ? 'selected' : ''; ?>>Low</option>
                                <option value="Medium" <?php echo $filter_priority === 'Medium' ? 'selected' : ''; ?>>Medium</option>
                                <option value="High" <?php echo $filter_priority === 'High' ? 'selected' : ''; ?>>High</option>
                            </select>

                            <button type="submit" class="btn btn-primary" style="width: 100%;">🔍 Filter</button>
                        </form>
                    </div>
                </div>

                <!-- Complaints Table -->
                <div class="card">
                    <div style="overflow-x: auto;">
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Student</th>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                    <th>Priority</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($complaints)): ?>
                                    <tr>
                                        <td colspan="8" style="text-align: center; padding: 2rem;">
                                            No complaints found
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($complaints as $complaint): ?>
                                        <tr>
                                            <td>#<?php echo str_pad($complaint['id'], 5, '0', STR_PAD_LEFT); ?></td>
                                            <td><?php echo htmlspecialchars($complaint['user_name']); ?></td>
                                            <td><?php echo htmlspecialchars(truncateText($complaint['title'], 25)); ?></td>
                                            <td><?php echo htmlspecialchars($complaint['category']); ?></td>
                                            <td><?php echo getStatusBadge($complaint['status']); ?></td>
                                            <td><?php echo getPriorityBadge($complaint['priority']); ?></td>
                                            <td><?php echo formatDateOnly($complaint['created_at']); ?></td>
                                            <td>
                                                <a href="complaint-details.php?id=<?php echo $complaint['id']; ?>" class="btn btn-small" style="padding: 0.35rem 0.6rem; font-size: 0.8rem; margin-right: 0.25rem;">View</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="/assets/js/validation.js"></script>
</body>
</html>
