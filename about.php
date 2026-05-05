<?php
/**
 * FixIt Smart Complaint Management System
 * About Page
 */

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/auth.php';

$isLoggedIn = Auth::isLoggedIn();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo APP_NAME; ?> - About</title>
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
                <li><a href="about.php" class="active">About</a></li>
                <li><a href="contact.php">Contact</a></li>
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

    <!-- About Hero -->
    <section style="background: linear-gradient(135deg, #6366f1 0%, #0ea5e9 100%); color: white; padding: 4rem 2rem; text-align: center;">
        <div class="container">
            <h1 style="color: white; font-size: 2.5rem; margin-bottom: 1rem;">About FixIt</h1>
            <p style="font-size: 1.2rem; color: rgba(255, 255, 255, 0.9);">Making Campus Better, One Complaint at a Time</p>
        </div>
    </section>

    <!-- Main Content -->
    <div style="padding: 4rem 2rem;">
        <div class="container">
            <!-- Mission Section -->
            <section style="margin-bottom: 4rem;">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 3rem; align-items: center;">
                    <div>
                        <h2>Our Mission</h2>
                        <p style="font-size: 1.05rem; line-height: 1.8; color: var(--gray-700);">
                            FixIt is dedicated to streamlining the complaint management process in educational institutions. We believe that every student voice matters, and quick resolution of campus issues directly contributes to a better learning environment.
                        </p>
                        <p style="font-size: 1.05rem; line-height: 1.8; color: var(--gray-700);">
                            Our platform empowers students to report issues efficiently, track their resolution progress in real-time, and helps administration prioritize maintenance and improvements.
                        </p>
                    </div>
                    <div style="background: linear-gradient(135deg, rgba(99, 102, 241, 0.1) 0%, rgba(14, 165, 233, 0.1) 100%); padding: 3rem; border-radius: 1rem; text-align: center;">
                        <div style="font-size: 3rem; margin-bottom: 1rem;">🎯</div>
                        <h3>Vision for Change</h3>
                        <p>Transform campus facility management through technology and transparency</p>
                    </div>
                </div>
            </section>

            <!-- Features Section -->
            <section style="margin-bottom: 4rem;">
                <h2 style="text-align: center; margin-bottom: 2rem;">Key Features</h2>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem;">
                    <div style="background: white; padding: 2rem; border-radius: 1rem; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);">
                        <div style="font-size: 2rem; margin-bottom: 1rem;">📝</div>
                        <h3>Easy Submission</h3>
                        <p>Simple and intuitive form to report any campus issue with multiple categories</p>
                    </div>

                    <div style="background: white; padding: 2rem; border-radius: 1rem; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);">
                        <div style="font-size: 2rem; margin-bottom: 1rem;">📊</div>
                        <h3>Real-time Tracking</h3>
                        <p>Monitor your complaints with live status updates from submission to resolution</p>
                    </div>

                    <div style="background: white; padding: 2rem; border-radius: 1rem; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);">
                        <div style="font-size: 2rem; margin-bottom: 1rem;">👥</div>
                        <h3>Multi-Category Support</h3>
                        <p>Report issues across hostel, lab, WiFi, classroom, and cleanliness categories</p>
                    </div>

                    <div style="background: white; padding: 2rem; border-radius: 1rem; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);">
                        <div style="font-size: 2rem; margin-bottom: 1rem;">⚡</div>
                        <h3>Priority Management</h3>
                        <p>Set priority levels to ensure urgent issues get immediate attention</p>
                    </div>

                    <div style="background: white; padding: 2rem; border-radius: 1rem; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);">
                        <div style="font-size: 2rem; margin-bottom: 1rem;">📱</div>
                        <h3>Responsive Design</h3>
                        <p>Access FixIt on any device - desktop, tablet, or mobile phone</p>
                    </div>

                    <div style="background: white; padding: 2rem; border-radius: 1rem; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);">
                        <div style="font-size: 2rem; margin-bottom: 1rem;">🔍</div>
                        <h3>Smart Search</h3>
                        <p>Filter and search complaints by category, status, or keywords</p>
                    </div>
                </div>
            </section>
        
                    
            <!-- Complaint Categories Section -->
            <section style="margin-bottom: 4rem;">
                <h2 style="text-align: center; margin-bottom: 2rem;">Supported Categories</h2>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 1.5rem;">
                    <div style="text-align: center; padding: 1.5rem; background: white; border-radius: 1rem; border: 2px solid var(--gray-200);">
                        <div style="font-size: 2rem; margin-bottom: 0.5rem;">🏠</div>
                        <p style="font-weight: 600;">Hostel Issues</p>
                    </div>
                    <div style="text-align: center; padding: 1.5rem; background: white; border-radius: 1rem; border: 2px solid var(--gray-200);">
                        <div style="font-size: 2rem; margin-bottom: 0.5rem;">🔬</div>
                        <p style="font-weight: 600;">Lab Issues</p>
                    </div>
                    <div style="text-align: center; padding: 1.5rem; background: white; border-radius: 1rem; border: 2px solid var(--gray-200);">
                        <div style="font-size: 2rem; margin-bottom: 0.5rem;">📶</div>
                        <p style="font-weight: 600;">WiFi Problems</p>
                    </div>
                    <div style="text-align: center; padding: 1.5rem; background: white; border-radius: 1rem; border: 2px solid var(--gray-200);">
                        <div style="font-size: 2rem; margin-bottom: 0.5rem;">🎓</div>
                        <p style="font-weight: 600;">Classroom Issues</p>
                    </div>
                    <div style="text-align: center; padding: 1.5rem; background: white; border-radius: 1rem; border: 2px solid var(--gray-200);">
                        <div style="font-size: 2rem; margin-bottom: 0.5rem;">🧹</div>
                        <p style="font-weight: 600;">Cleanliness Issues</p>
                    </div>
                    <div style="text-align: center; padding: 1.5rem; background: white; border-radius: 1rem; border: 2px solid var(--gray-200);">
                        <div style="font-size: 2rem; margin-bottom: 0.5rem;">⚡</div>
                        <p style="font-weight: 600;">Electrical Issues</p>
                    </div>
                </div>
            </section>

            <!-- How It Works -->
            <section style="background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%); color: white; padding: 3rem; border-radius: 1rem; margin-bottom: 4rem; text-align: center;">
                <h2 style="color: white; margin-bottom: 2rem;">How FixIt Works</h2>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 2rem;">
                    <div>
                        <div style="font-size: 2.5rem; margin-bottom: 1rem;">1️⃣</div>
                        <h3>Register</h3>
                        <p>Create your account with your college email</p>
                    </div>
                    <div>
                        <div style="font-size: 2.5rem; margin-bottom: 1rem;">2️⃣</div>
                        <h3>Report</h3>
                        <p>Submit a complaint with details and priority</p>
                    </div>
                    <div>
                        <div style="font-size: 2.5rem; margin-bottom: 1rem;">3️⃣</div>
                        <h3>Track</h3>
                        <p>Monitor status and updates in your dashboard</p>
                    </div>
                    <div>
                        <div style="font-size: 2.5rem; margin-bottom: 1rem;">4️⃣</div>
                        <h3>Resolve</h3>
                        <p>See your issue resolved with admin notes</p>
                    </div>
                </div>
            </section>

            <!-- CTA Section -->
            <section style="text-align: center;">
                <h2 style="margin-bottom: 1rem;">Ready to Make a Difference?</h2>
                <p style="font-size: 1.1rem; color: var(--gray-600); margin-bottom: 2rem;">
                    Join thousands of students using FixIt to improve our campus
                </p>
                <?php if (!$isLoggedIn): ?>
                    <a href="register.php" class="btn btn-primary btn-large">Get Started Now</a>
                <?php else: ?>
                    <a href="submit-complaint.php" class="btn btn-primary btn-large">Submit a Complaint</a>
                <?php endif; ?>
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
                </ul>
            </div>

            <div class="footer-section">
                <h4>Features</h4>
                <ul>
                    <li><a href="#">Easy Submission</a></li>
                    <li><a href="#">Track Status</a></li>
                    <li><a href="#">Smart Search</a></li>
                    <li><a href="#">Priority Levels</a></li>
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
