<?php
/**
 * FixIt Smart Complaint Management System
 * Login Page
 */

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/validator.php';

if (Auth::isLoggedIn()) {
    if (Auth::isAdmin()) {
        header('Location: ' . APP_URL . '/admin/dashboard.php');
    } else {
        header('Location: ' . APP_URL . '/dashboard.php');
    }
    exit();
}

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $formData = [
        'email' => $_POST['email'] ?? '',
        'password' => $_POST['password'] ?? ''
    ];

    $errors = FormValidator::validateLogin($formData);

    if (empty($errors)) {
        $result = Auth::login($formData['email'], $formData['password']);

        if ($result['success']) {
            // Redirect based on user type
            if ($result['user_type'] === 'admin') {
                header('Location: ' . APP_URL . '/admin/dashboard.php');
            } else {
                header('Location: ' . APP_URL . '/dashboard.php');
            }
            exit();
        } else {
            $errors['form'] = $result['message'];
        }
    }
}

// Check for registration success message
$showSuccess = isset($_SESSION['registration_success']);
if ($showSuccess) {
    unset($_SESSION['registration_success']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo APP_NAME; ?> - Login</title>
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
            max-width: 400px;
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
        
        .auth-footer {
            text-align: center;
            margin-top: 1.5rem;
        }
        
        .auth-footer a {
            color: var(--primary);
            font-weight: 500;
        }

        .demo-credentials {
            background: var(--gray-50);
            padding: 1rem;
            border-radius: var(--radius-lg);
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }

        .demo-credentials strong {
            color: var(--primary);
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <h1>🔧 FixIt Login</h1>
                <p>Access your complaint portal</p>
            </div>

            <?php if ($showSuccess): ?>
                <div class="success-message" style="margin-bottom: 1rem;">
                    ✓ Registration successful! Please login with your credentials.
                </div>
            <?php endif; ?>

            <?php if (!empty($errors)): ?>
                <div class="error-message">
                    <?php echo $errors['form'] ?? 'Login failed. Please try again.'; ?>
                </div>
            <?php endif; ?>

            <form id="loginForm" method="POST">
                <div class="form-group">
                    <label for="email">Email Address *</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required autofocus>
                    <?php if (isset($errors['email'])): ?>
                        <span class="error"><?php echo $errors['email']; ?></span>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="password">Password *</label>
                    <input type="password" id="password" name="password" required>
                    <?php if (isset($errors['password'])): ?>
                        <span class="error"><?php echo $errors['password']; ?></span>
                    <?php endif; ?>
                </div>

                <button type="submit" class="btn btn-primary btn-block" style="margin-top: 1rem;">Login</button>
            </form>

            <div class="demo-credentials">
                <strong>Demo Admin Account:</strong><br>
                Email: admin@fixit.local<br>
                Password: admin@123
            </div>

            <div class="auth-footer">
                <p>Don't have an account? <a href="register.php">Register here</a></p>
                <p style="margin-top: 1rem;"><a href="index.php" style="color: var(--gray-600);">← Back to Home</a></p>
            </div>
        </div>
    </div>

    <script src="assets/js/validation.js"></script>
</body>
</html>
