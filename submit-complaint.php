<?php
/**
 * FixIt Smart Complaint Management System
 * Submit Complaint Page
 */

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/validator.php';

Auth::requireLogin();

$user = Auth::getCurrentUser();
$user_id = $user['id'];
$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $formData = [
        'category' => $_POST['category'] ?? '',
        'title' => $_POST['title'] ?? '',
        'description' => $_POST['description'] ?? '',
        'priority' => $_POST['priority'] ?? 'Medium'
    ];

    $errors = FormValidator::validateComplaint($formData);

    if (empty($errors)) {
        $result = Complaint::submit(
            $user_id,
            $formData['category'],
            $formData['title'],
            $formData['description'],
            $formData['priority']
        );

        if ($result['success']) {
            $success = true;
        } else {
            $errors['form'] = $result['message'];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo APP_NAME; ?> - Submit Complaint</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <style>
        .form-container {
            max-width: 700px;
            margin: 0 auto;
        }
    </style>
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
                <li><a href="submit-complaint.php" class="active">Submit Complaint</a></li>
            </ul>
            
            <div class="nav-actions">
                <a href="profile.php" class="btn btn-outline btn-small">Profile</a>
                <a href="logout.php" class="btn btn-primary btn-small">Logout</a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content" style="padding: 3rem 2rem;">
        <div class="form-container">
            <div style="margin-bottom: 2rem;">
                <h1>📝 Submit a New Complaint</h1>
                <p style="color: var(--gray-600);">Help us improve the campus by reporting issues</p>
            </div>

            <?php if ($success): ?>
                <div class="success-message">
                    ✓ Complaint submitted successfully! <a href="dashboard.php">View your complaints</a>
                </div>
                <script>
                    setTimeout(() => {
                        window.location.href = '<?php echo APP_URL; ?>/dashboard.php';
                    }, 2000);
                </script>
            <?php endif; ?>

            <?php if (!empty($errors)): ?>
                <div class="error-message">
                    <?php echo $errors['form'] ?? 'Please fix the errors below'; ?>
                </div>
            <?php endif; ?>

            <div class="card">
                <form id="complaintForm" method="POST">
                    <div class="form-group">
                        <label for="category">Complaint Category *</label>
                        <select id="category" name="category" required>
                            <option value="">-- Select a Category --</option>
                            <?php foreach (COMPLAINT_CATEGORIES as $cat_name => $cat_value): ?>
                                <option value="<?php echo htmlspecialchars($cat_name); ?>" 
                                        <?php echo ($_POST['category'] ?? '') === $cat_name ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($cat_name); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (isset($errors['category'])): ?>
                            <span class="error"><?php echo $errors['category']; ?></span>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="title">Complaint Title *</label>
                        <input type="text" id="title" name="title" 
                               placeholder="Brief summary of the issue" 
                               value="<?php echo htmlspecialchars($_POST['title'] ?? ''); ?>"
                               maxlength="200" required>
                        <small>Minimum 10 characters, Maximum 200 characters</small>
                        <?php if (isset($errors['title'])): ?>
                            <span class="error"><?php echo $errors['title']; ?></span>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="description">Detailed Description *</label>
                        <textarea id="description" name="description" 
                                  placeholder="Please provide detailed information about the issue..."
                                  required><?php echo htmlspecialchars($_POST['description'] ?? ''); ?></textarea>
                        <small>Minimum 20 characters. Include location, time, and specific details.</small>
                        <?php if (isset($errors['description'])): ?>
                            <span class="error"><?php echo $errors['description']; ?></span>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="priority">Priority Level *</label>
                        <select id="priority" name="priority" required>
                            <option value="Low" <?php echo ($_POST['priority'] ?? 'Medium') === 'Low' ? 'selected' : ''; ?>>
                                🟢 Low - Can be resolved later
                            </option>
                            <option value="Medium" <?php echo ($_POST['priority'] ?? 'Medium') === 'Medium' ? 'selected' : ''; ?>>
                                🟡 Medium - Should be resolved soon
                            </option>
                            <option value="High" <?php echo ($_POST['priority'] ?? 'Medium') === 'High' ? 'selected' : ''; ?>>
                                🔴 High - Urgent, needs immediate attention
                            </option>
                        </select>
                        <?php if (isset($errors['priority'])): ?>
                            <span class="error"><?php echo $errors['priority']; ?></span>
                        <?php endif; ?>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-top: 2rem;">
                        <a href="dashboard.php" class="btn btn-outline" style="text-align: center;">Cancel</a>
                        <button type="submit" class="btn btn-primary">Submit Complaint</button>
                    </div>
                </form>
            </div>

            <!-- Guidelines -->
            <div class="card" style="margin-top: 2rem; background: linear-gradient(135deg, rgba(16, 185, 129, 0.05) 0%, rgba(34, 197, 94, 0.05) 100%);">
                <h3 style="color: var(--success); margin-bottom: 1rem;">💡 Tips for a Better Report</h3>
                <ul style="list-style: none;">
                    <li style="margin-bottom: 0.75rem;">✓ Be specific about the location and time of the issue</li>
                    <li style="margin-bottom: 0.75rem;">✓ Provide clear details about what's wrong</li>
                    <li style="margin-bottom: 0.75rem;">✓ Select the correct category for faster resolution</li>
                    <li style="margin-bottom: 0.75rem;">✓ Set appropriate priority level</li>
                    <li style="margin-bottom: 0.75rem;">✓ You can track your complaint status in the dashboard</li>
                </ul>
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
</body>
</html>
