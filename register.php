<?php
/**
 * FixIt Smart Complaint Management System
 * Registration Page
 */

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/validator.php';

if (Auth::isLoggedIn()) {
    header('Location: ' . APP_URL . '/dashboard.php');
    exit();
}

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $formData = [
        'name' => $_POST['name'] ?? '',
        'email' => $_POST['email'] ?? '',
        'password' => $_POST['password'] ?? '',
        'confirmPassword' => $_POST['confirm_password'] ?? '',
        'roll_number' => $_POST['roll_number'] ?? '',
        'department' => $_POST['department'] ?? ''
    ];

    $errors = FormValidator::validateRegistration($formData);

    if (empty($errors)) {
        $result = Auth::register(
            $formData['name'],
            $formData['email'],
            $formData['password'],
            $formData['roll_number'],
            $formData['department']
        );

        if ($result['success']) {
            $success = true;
            $_SESSION['registration_success'] = true;
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
    <title><?php echo APP_NAME; ?> - Register</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <style>
        .auth-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #6366f1 0%, #0ea5e9 100%);
            padding: 2rem;
        }
        
        .auth-card {
            background: white;
            border-radius: 1rem;
            padding: 2rem;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            max-width: 450px;
            width: 100%;
        }
        
        .auth-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .auth-header h1 {
            margin-bottom: 0.5rem;
        }
        
        .auth-header p {
            color: var(--gray-600);
        }
        
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }
        
        .form-row.full {
            grid-template-columns: 1fr;
        }
        
        .auth-footer {
            text-align: center;
            margin-top: 1.5rem;
        }
        
        .auth-footer a {
            color: var(--primary);
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <h1>🔧 Create Account</h1>
                <p>Join FixIt to report campus issues</p>
            </div>

            <?php if ($success): ?>
                <div class="success-message">
                    ✓ Registration successful! Redirecting to login...
                </div>
                <script>
                    setTimeout(() => {
                        window.location.href = '<?php echo APP_URL; ?>/login.php';
                    }, 2000);
                </script>
            <?php endif; ?>

            <?php if (!empty($errors)): ?>
                <div class="error-message">
                    <?php echo $errors['form'] ?? 'Please fix the errors below'; ?>
                </div>
            <?php endif; ?>

            <form id="registerForm" method="POST">
                <div class="form-group">
                    <label for="name">Full Name *</label>
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>" required>
                    <?php if (isset($errors['name'])): ?>
                        <span class="error"><?php echo $errors['name']; ?></span>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="email">Email Address *</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required>
                    <?php if (isset($errors['email'])): ?>
                        <span class="error"><?php echo $errors['email']; ?></span>
                    <?php endif; ?>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="roll_number">Roll Number</label>
                        <input type="text" id="roll_number" name="roll_number" value="<?php echo htmlspecialchars($_POST['roll_number'] ?? ''); ?>">
                    </div>

                    <div class="form-group">
                        <label for="department">Department</label>
                        <select id="department" name="department">
                            <option value="">Select Department</option>
                            <option value="CSE" <?php echo ($_POST['department'] ?? '') === 'CSE' ? 'selected' : ''; ?>>CSE</option>
                            <option value="ECE" <?php echo ($_POST['department'] ?? '') === 'ECE' ? 'selected' : ''; ?>>ECE</option>
                            <option value="EEE" <?php echo ($_POST['department'] ?? '') === 'EEE' ? 'selected' : ''; ?>>EEE</option>
                            <option value="MECH" <?php echo ($_POST['department'] ?? '') === 'MECH' ? 'selected' : ''; ?>>MECH</option>
                            <option value="CIVIL" <?php echo ($_POST['department'] ?? '') === 'CIVIL' ? 'selected' : ''; ?>>CIVIL</option>
                            <option value="Other" <?php echo ($_POST['department'] ?? '') === 'Other' ? 'selected' : ''; ?>>Other</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Password *</label>
                    <input type="password" id="password" name="password" required>
                    <small>Password must be at least 8 characters</small>
                    <?php if (isset($errors['password'])): ?>
                        <span class="error"><?php echo $errors['password']; ?></span>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="confirm_password">Confirm Password *</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                    <?php if (isset($errors['confirmPassword'])): ?>
                        <span class="error"><?php echo $errors['confirmPassword']; ?></span>
                    <?php endif; ?>
                </div>

                <button type="submit" class="btn btn-primary btn-block" style="margin-top: 1rem;">Create Account</button>
            </form>

            <div class="auth-footer">
                <p>Already have an account? <a href="login.php">Login here</a></p>
            </div>
        </div>
    </div>

    <script src="/assets/js/validation.js"></script>
</body>
</html>
