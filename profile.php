<?php
/**
 * FixIt Smart Complaint Management System
 * User Profile Page
 */

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/functions.php';

Auth::requireLogin();

$user = Auth::getCurrentUser();
$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'update_profile') {
        $data = [
            'name' => $_POST['name'] ?? $user['name'],
            'phone' => $_POST['phone'] ?? ''
        ];

        if (Auth::updateProfile($user['id'], $data)) {
            $success = 'Profile updated successfully';
            $user = Auth::getCurrentUser();
        } else {
            $errors[] = 'Failed to update profile';
        }
    } elseif ($action === 'change_password') {
        $old_password = $_POST['old_password'] ?? '';
        $new_password = $_POST['new_password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';

        if (empty($old_password) || empty($new_password) || empty($confirm_password)) {
            $errors[] = 'All password fields are required';
        } elseif ($new_password !== $confirm_password) {
            $errors[] = 'New passwords do not match';
        } elseif (strlen($new_password) < 8) {
            $errors[] = 'Password must be at least 8 characters';
        } else {
            $result = Auth::changePassword($user['id'], $old_password, $new_password);
            if ($result['success']) {
                $success = $result['message'];
            } else {
                $errors[] = $result['message'];
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo APP_NAME; ?> - Profile</title>
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
                <li><a href="dashboard.php">Dashboard</a></li>
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
        <div style="max-width: 700px; margin: 0 auto;">
            <div style="margin-bottom: 2rem;">
                <h1>My Profile</h1>
                <p style="color: var(--gray-600);">Manage your account information</p>
            </div>

            <?php if ($success): ?>
                <div class="success-message">
                    ✓ <?php echo htmlspecialchars($success); ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($errors)): ?>
                <div class="error-message">
                    <?php foreach ($errors as $error): ?>
                        <?php echo htmlspecialchars($error); ?><br>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <!-- Profile Information Card -->
            <div class="card" style="margin-bottom: 2rem;">
                <div class="card-header">
                    <h2>👤 Profile Information</h2>
                </div>

                <form method="POST">
                    <input type="hidden" name="action" value="update_profile">

                    <div class="form-group">
                        <label for="name">Full Name *</label>
                        <input type="text" id="name" name="name" 
                               value="<?php echo htmlspecialchars($user['name']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" 
                               value="<?php echo htmlspecialchars($user['email']); ?>" disabled>
                        <small>Email cannot be changed</small>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div class="form-group">
                            <label for="roll_number">Roll Number</label>
                            <input type="text" id="roll_number" name="roll_number" 
                                   value="<?php echo htmlspecialchars($user['roll_number'] ?? ''); ?>" disabled>
                        </div>

                        <div class="form-group">
                            <label for="department">Department</label>
                            <input type="text" id="department" name="department" 
                                   value="<?php echo htmlspecialchars($user['department'] ?? ''); ?>" disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="tel" id="phone" name="phone" 
                               value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>" 
                               placeholder="Your phone number">
                    </div>

                    <div class="form-group">
                        <label for="created_at">Account Created</label>
                        <input type="text" id="created_at" name="created_at" 
                               value="<?php echo formatDate($user['created_at']); ?>" disabled>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block" style="margin-top: 1rem;">Update Profile</button>
                </form>
            </div>

            <!-- Account Status Card -->
            <div class="card" style="margin-bottom: 2rem;">
                <div class="card-header">
                    <h2>📋 Account Status</h2>
                </div>

                <div style="padding: 1rem 0;">
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 1rem; background: var(--gray-50); border-radius: var(--radius-lg); margin-bottom: 1rem;">
                        <div>
                            <p style="font-size: 0.9rem; color: var(--gray-600); text-transform: uppercase;">Account Status</p>
                            <p style="font-weight: 600;">
                                <span style="display: inline-block; width: 10px; height: 10px; background: var(--success); border-radius: 50%; margin-right: 0.5rem;"></span>
                                <?php echo ucfirst($user['status']); ?>
                            </p>
                        </div>
                    </div>

                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 1rem; background: var(--gray-50); border-radius: var(--radius-lg);">
                        <div>
                            <p style="font-size: 0.9rem; color: var(--gray-600); text-transform: uppercase;">User Type</p>
                            <p style="font-weight: 600;">
                                <?php echo $user['user_type'] === 'admin' ? '👨‍💼 Administrator' : '👨‍🎓 Student'; ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Change Password Card -->
            <div class="card">
                <div class="card-header">
                    <h2>🔐 Change Password</h2>
                </div>

                <form method="POST">
                    <input type="hidden" name="action" value="change_password">

                    <div class="form-group">
                        <label for="old_password">Current Password *</label>
                        <input type="password" id="old_password" name="old_password" required>
                    </div>

                    <div class="form-group">
                        <label for="new_password">New Password *</label>
                        <input type="password" id="new_password" name="new_password" required>
                        <small>Minimum 8 characters</small>
                    </div>

                    <div class="form-group">
                        <label for="confirm_password">Confirm New Password *</label>
                        <input type="password" id="confirm_password" name="confirm_password" required>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block" style="margin-top: 1rem;">Change Password</button>
                </form>
            </div>

            <!-- Quick Actions -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-top: 2rem;">
                <a href="dashboard.php" class="btn btn-outline" style="text-align: center;">← Back to Dashboard</a>
                <a href="logout.php" class="btn btn-danger" style="text-align: center;">Logout</a>
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
