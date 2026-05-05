<?php
/**
 * FixIt Smart Complaint Management System
 * Database Configuration File
 */

// Database Configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'complaint_system');

// Application Settings
define('APP_NAME', 'FixIt — Smart Complaint Portal');
define('APP_URL', 'http://localhost/complaint_web');
define('UPLOADS_DIR', __DIR__ . '/../uploads/');

// Session Configuration
define('SESSION_TIMEOUT', 3600); // 1 hour
define('REMEMBER_ME_DURATION', 2592000); // 30 days in seconds

// Complaint Categories
define('COMPLAINT_CATEGORIES', [
    'Hostel Issues' => 'hostel',
    'Lab Issues' => 'lab',
    'WiFi Problems' => 'wifi',
    'Classroom Problems' => 'classroom',
    'Cleanliness Issues' => 'cleanliness',
    'Electrical Problems' => 'electrical',
    'Other' => 'other'
]);

// Priority Levels
define('COMPLAINT_PRIORITIES', [
    'Low',
    'Medium',
    'High'
]);

// Complaint Status
define('COMPLAINT_STATUS', [
    'Pending' => 'pending',
    'In Progress' => 'in-progress',
    'Resolved' => 'resolved'
]);

// Error Reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Timezone
date_default_timezone_set('Asia/Kolkata');

// Security Headers
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: SAMEORIGIN');
header('X-XSS-Protection: 1; mode=block');
?>
