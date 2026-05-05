<?php
/**
 * FixIt Smart Complaint Management System
 * Home Page
 */

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/functions.php';

$isLoggedIn = Auth::isLoggedIn();
$isAdmin = Auth::isAdmin();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="FixIt - Smart Complaint Management System for College Complaints">
    <meta name="author" content="Development Team">
    <title><?php echo APP_NAME; ?> - Home</title>
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
                <li><a href="index.php" class="active">Home</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="contact.php">Contact</a></li>
                <?php if ($isLoggedIn): ?>
                    <?php if ($isAdmin): ?>
                        <li><a href="admin/dashboard.php">Admin Panel</a></li>
                    <?php else: ?>
                        <li><a href="dashboard.php">Dashboard</a></li>
                    <?php endif; ?>
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

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>Welcome to FixIt</h1>
            <p>Smart Complaint Management System for Your College</p>
            <?php if (!$isLoggedIn): ?>
                <div class="flex-center gap-2" style="margin-top: 2rem; flex-wrap: wrap;">
                    <a href="register.php" class="btn btn-primary btn-large">Get Started</a>
                    <a href="about.php" class="btn btn-outline btn-large" style="color: white; border-color: white;">Learn More</a>
                </div>
            <?php else: ?>
                <div class="flex-center gap-2" style="margin-top: 2rem; flex-wrap: wrap;">
                    <?php if ($isAdmin): ?>
                        <a href="admin/dashboard.php" class="btn btn-primary btn-large">Admin Dashboard</a>
                    <?php else: ?>
                        <a href="dashboard.php" class="btn btn-primary btn-large">View Dashboard</a>
                        <a href="submit-complaint.php" class="btn btn-outline btn-large" style="color: white; border-color: white;">Submit Complaint</a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features">
        <div class="container">
            <div class="text-center mb-4">
                <h2>Key Features</h2>
                <p style="font-size: 1.1rem; color: var(--gray-600); max-width: 600px; margin: 1rem auto;">
                    Everything you need to report and track campus complaints efficiently
                </p>
            </div>

            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">📝</div>
                    <h3>Easy Submission</h3>
                    <p>Submit complaints about hostel, lab, WiFi, classroom, and other college issues in minutes</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">📊</div>
                    <h3>Real-time Tracking</h3>
                    <p>Monitor the status of your complaints with real-time updates and progress tracking</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">🔍</div>
                    <h3>Smart Search</h3>
                    <p>Search and filter complaints by category, status, priority, and more</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">👥</div>
                    <h3>Multi-Category</h3>
                    <p>Report issues across 7+ categories including hostel, lab, WiFi, and cleanliness</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">⚡</div>
                    <h3>Priority Levels</h3>
                    <p>Set priority levels (Low, Medium, High) to ensure urgent issues are addressed first</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">📱</div>
                    <h3>Responsive Design</h3>
                    <p>Access your complaints anytime, anywhere on any device - desktop, tablet, or mobile</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Complaint Categories Section -->
    <section style="padding: 4rem 2rem; background: linear-gradient(135deg, #f9fafb 0%, #f0f9ff 100%);">
        <div class="container">
            <div class="text-center mb-4">
                <h2>Complaint Categories</h2>
                <p style="font-size: 1.1rem; color: var(--gray-600); max-width: 600px; margin: 1rem auto;">
                    Select from a wide range of complaint categories
                </p>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 1.5rem; max-width: 1200px; margin: 0 auto;">
                <?php
                $categories = [
                    ['icon' => '🏠', 'name' => 'Hostel Issues'],
                    ['icon' => '🔬', 'name' => 'Lab Issues'],
                    ['icon' => '📶', 'name' => 'WiFi Problems'],
                    ['icon' => '🎓', 'name' => 'Classroom Problems'],
                    ['icon' => '🧹', 'name' => 'Cleanliness Issues'],
                    ['icon' => '⚡', 'name' => 'Electrical Problems'],
                    ['icon' => '🎯', 'name' => 'Other'],
                ];
                foreach ($categories as $cat):
                ?>
                <div style="text-align: center; padding: 1.5rem; background: white; border-radius: var(--radius-lg); box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05); transition: all var(--transition); cursor: pointer;" 
                     onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 20px rgba(99, 102, 241, 0.15)'" 
                     onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 10px rgba(0, 0, 0, 0.05)'">
                    <div style="font-size: 2.5rem; margin-bottom: 0.5rem;"><?php echo $cat['icon']; ?></div>
                    <p style="font-weight: 600; color: var(--gray-900);"><?php echo $cat['name']; ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Call to Action Section -->
    <section style="padding: 4rem 2rem; background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%); color: white; text-align: center;">
        <div class="container">
            <h2 style="color: white; margin-bottom: 1rem;">Ready to Report an Issue?</h2>
            <p style="color: rgba(255, 255, 255, 0.9); font-size: 1.1rem; margin-bottom: 2rem; max-width: 600px; margin-left: auto; margin-right: auto;">
                Join thousands of students who are already using FixIt to improve campus facilities
            </p>
            <?php if (!$isLoggedIn): ?>
                <a href="register.php" class="btn btn-outline btn-large" style="border-color: white; color: white;">Create Your Account Now</a>
            <?php else: ?>
                <a href="submit-complaint.php" class="btn btn-outline btn-large" style="border-color: white; color: white;">Submit a Complaint</a>
            <?php endif; ?>
        </div>
    </section>

    <!-- Footer -->
    <footer>
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
                <h4>Complaint Categories</h4>
                <ul>
                    <li><a href="#">Hostel Issues</a></li>
                    <li><a href="#">Lab Issues</a></li>
                    <li><a href="#">WiFi Problems</a></li>
                    <li><a href="#">Classroom Issues</a></li>
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
        </div>

        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> FixIt - Smart Complaint Management System. All rights reserved. | Built with ❤️ for campus improvement</p>
        </div>
    </footer>

    <script src="/assets/js/validation.js"></script>
</body>
</html>
