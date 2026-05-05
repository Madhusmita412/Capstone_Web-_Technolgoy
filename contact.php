<?php
/**
 * FixIt Smart Complaint Management System
 * Contact Page
 */

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/validator.php';

$isLoggedIn = Auth::isLoggedIn();
$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $formData = [
        'name' => $_POST['name'] ?? '',
        'email' => $_POST['email'] ?? '',
        'subject' => $_POST['subject'] ?? '',
        'message' => $_POST['message'] ?? ''
    ];

    $errors = FormValidator::validateContact($formData);

    if (empty($errors)) {
        $result = ContactMessage::save(
            $formData['name'],
            $formData['email'],
            $formData['subject'],
            $formData['message']
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
    <title><?php echo APP_NAME; ?> - Contact</title>
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
                <li><a href="about.php">About</a></li>
                <li><a href="contact.php" class="active">Contact</a></li>
                <?php if ($isLoggedIn): ?>
                    <li><a href="dashboard.php">Dashboard</a></li>
                <?php endif; ?>
            </ul>
            
            <div class="nav-actions">
                <?php if (!$isLoggedIn): ?>
                    <a href="login.php" class="btn btn-outline btn-small">Login</a>
                    <a href="register.php" class="btn btn-primary btn-small">Register</a>
                <?php else: ?>
                    <a href="profile.php" class="btn btn-outline btn-small">Profile</a>
                    <a href="logout.php" class="btn btn-primary btn-small">Logout</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Contact Hero -->
    <section style="background: linear-gradient(135deg, #6366f1 0%, #0ea5e9 100%); color: white; padding: 4rem 2rem; text-align: center;">
        <div class="container">
            <h1 style="color: white; font-size: 2.5rem; margin-bottom: 1rem;">Get in Touch</h1>
            <p style="font-size: 1.2rem; color: rgba(255, 255, 255, 0.9);">We'd love to hear from you. Send us a message!</p>
        </div>
    </section>

    <!-- Main Content -->
    <div style="padding: 4rem 2rem;">
        <div class="container">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 3rem; max-width: 1000px; margin: 0 auto;">
                <!-- Contact Form -->
                <div>
                    <h2 style="margin-bottom: 1.5rem;">Send us a Message</h2>

                    <?php if ($success): ?>
                        <div class="success-message">
                            ✓ Thank you! Your message has been sent successfully. We'll get back to you soon!
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($errors) && isset($errors['form'])): ?>
                        <div class="error-message">
                            <?php echo $errors['form']; ?>
                        </div>
                    <?php endif; ?>

                    <form id="contactForm" method="POST">
                        <div class="form-group">
                            <label for="name">Your Name *</label>
                            <input type="text" id="name" name="name" 
                                   value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>"
                                   placeholder="John Doe" required>
                            <?php if (isset($errors['name'])): ?>
                                <span class="error"><?php echo $errors['name']; ?></span>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label for="email">Email Address *</label>
                            <input type="email" id="email" name="email" 
                                   value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"
                                   placeholder="you@example.com" required>
                            <?php if (isset($errors['email'])): ?>
                                <span class="error"><?php echo $errors['email']; ?></span>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label for="subject">Subject</label>
                            <input type="text" id="subject" name="subject" 
                                   value="<?php echo htmlspecialchars($_POST['subject'] ?? ''); ?>"
                                   placeholder="How can we help?">
                        </div>

                        <div class="form-group">
                            <label for="message">Message *</label>
                            <textarea id="message" name="message" 
                                      placeholder="Tell us what you think..."
                                      required><?php echo htmlspecialchars($_POST['message'] ?? ''); ?></textarea>
                            <?php if (isset($errors['message'])): ?>
                                <span class="error"><?php echo $errors['message']; ?></span>
                            <?php endif; ?>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">Send Message</button>
                    </form>
                </div>

                <!-- Contact Information -->
                <div>
                    <h2 style="margin-bottom: 1.5rem;">Contact Information</h2>

                    <div style="background: linear-gradient(135deg, rgba(99, 102, 241, 0.05) 0%, rgba(14, 165, 233, 0.05) 100%); padding: 2rem; border-radius: 1rem; margin-bottom: 2rem;">
                        <h3 style="margin-bottom: 1rem;">📧 Email</h3>
                        <p style="color: var(--gray-700); margin-bottom: 0.5rem;">
                            Support: <a href="mailto:support@fixit.local" style="font-weight: 600;">support@fixit.local</a>
                        </p>
                        <p style="color: var(--gray-700);">
                            Admin: <a href="mailto:admin@fixit.local" style="font-weight: 600;">admin@fixit.local</a>
                        </p>
                    </div>

                    <div style="background: linear-gradient(135deg, rgba(14, 165, 233, 0.05) 0%, rgba(99, 102, 241, 0.05) 100%); padding: 2rem; border-radius: 1rem; margin-bottom: 2rem;">
                        <h3 style="margin-bottom: 1rem;">📞 Phone</h3>
                        <p style="color: var(--gray-700);">
                            +91 XXXX XXX XXX<br>
                            (Available Monday - Friday, 9 AM - 5 PM)
                        </p>
                    </div>

                    <div style="background: linear-gradient(135deg, rgba(14, 165, 233, 0.05) 0%, rgba(99, 102, 241, 0.05) 100%); padding: 2rem; border-radius: 1rem; margin-bottom: 2rem;">
                        <h3 style="margin-bottom: 1rem;">📍 Office</h3>
                        <p style="color: var(--gray-700);">
                            Campus Administration<br>
                            College Name<br>
                            City, State 123456<br>
                            India
                        </p>
                    </div>

                    <div style="background: linear-gradient(135deg, rgba(16, 185, 129, 0.05) 0%, rgba(34, 197, 94, 0.05) 100%); padding: 2rem; border-radius: 1rem;">
                        <h3 style="margin-bottom: 1rem;">⏰ Response Time</h3>
                        <p style="color: var(--gray-700);">
                            We typically respond to all inquiries within 24-48 hours during business days.
                        </p>
                    </div>
                </div>
            </div>

            <!-- FAQ Section -->
            <section style="margin-top: 4rem; max-width: 800px; margin-left: auto; margin-right: auto;">
                <h2 style="text-align: center; margin-bottom: 2rem;">Frequently Asked Questions</h2>

                <div style="background: white; padding: 1.5rem; border-radius: 1rem; margin-bottom: 1rem; border-left: 4px solid var(--primary);">
                    <h4 style="margin-bottom: 0.5rem;">How do I submit a complaint?</h4>
                    <p style="color: var(--gray-600);">
                        First, register an account using your college email. Once logged in, click "Submit Complaint" and fill in the details including category, title, description, and priority level.
                    </p>
                </div>

                <div style="background: white; padding: 1.5rem; border-radius: 1rem; margin-bottom: 1rem; border-left: 4px solid var(--primary);">
                    <h4 style="margin-bottom: 0.5rem;">How can I track my complaint?</h4>
                    <p style="color: var(--gray-600);">
                        Go to your Dashboard after logging in. You'll see all your complaints with their current status, priority, and last update date. Click on any complaint to view full details.
                    </p>
                </div>

                <div style="background: white; padding: 1.5rem; border-radius: 1rem; margin-bottom: 1rem; border-left: 4px solid var(--primary);">
                    <h4 style="margin-bottom: 0.5rem;">What should I do if I forgot my password?</h4>
                    <p style="color: var(--gray-600);">
                        On the login page, look for a "Forgot Password?" link. Enter your email address and follow the instructions sent to recover your account.
                    </p>
                </div>

                <div style="background: white; padding: 1.5rem; border-radius: 1rem; margin-bottom: 1rem; border-left: 4px solid var(--primary);">
                    <h4 style="margin-bottom: 0.5rem;">Can I delete or edit my complaint?</h4>
                    <p style="color: var(--gray-600);">
                        You can view and track your complaints, but once submitted, direct editing isn't available. Contact us if you need to update or modify a complaint.
                    </p>
                </div>

                <div style="background: white; padding: 1.5rem; border-radius: 1rem; border-left: 4px solid var(--primary);">
                    <h4 style="margin-bottom: 0.5rem;">How long does it take for resolution?</h4>
                    <p style="color: var(--gray-600);">
                        Resolution time depends on the complaint category and priority. High-priority complaints are addressed within 24 hours, while lower priorities may take 3-7 days.
                    </p>
                </div>
            </section>
        </div>
    </div>

    <!-- Footer -->
    <footer style="margin-top: 4rem;">
        <div class="footer-content">
            <div class="footer-section">
                <h4>About FixIt</h4>
                <p>FixIt is a smart complaint management system designed to streamline the process of reporting and resolving campus issues.</p>
            </div>

            <div class="footer-section">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="about.php">About</a></li>
                    <li><a href="contact.php">Contact</a></li>
                    <?php if ($isLoggedIn): ?>
                        <li><a href="dashboard.php">Dashboard</a></li>
                    <?php endif; ?>
                </ul>
            </div>

            <div class="footer-section">
                <h4>Support</h4>
                <ul>
                    <li><a href="contact.php">Contact Us</a></li>
                    <li><a href="#">FAQ</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Terms & Conditions</a></li>
                </ul>
            </div>

            <div class="footer-section">
                <h4>Information</h4>
                <ul>
                    <li><a href="about.php">About Us</a></li>
                    <li><a href="#">Our Team</a></li>
                    <li><a href="#">Technology</a></li>
                    <li><a href="contact.php">Contact</a></li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> FixIt - Smart Complaint Management System. All rights reserved.</p>
        </div>
    </footer>

    <script src="assets/js/validation.js"></script>
</body>
</html>
