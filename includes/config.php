<?php
/**
 * FixIt Smart Complaint Management System
 * Database Configuration File
 */

// Database Configuration
define('DB_HOST', getenv('DB_HOST') ?: '127.0.0.1');
define('DB_PORT', getenv('DB_PORT') ?: '8800');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') ?: 'Manish098@#$');
define('DB_NAME', getenv('DB_NAME') ?: 'complaint_system');

// Application Settings
define('APP_NAME', 'FixIt — Smart Complaint Portal');

// Application base URL - try to detect dynamically when running via web server
$defaultAppUrl = 'http://localhost/complaint_web';
if (php_sapi_name() !== 'cli' && isset($_SERVER['HTTP_HOST'])) {
    $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'];
    $base = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
    define('APP_URL', $scheme . '://' . $host . ($base === '/' ? '' : $base));
} else {
    define('APP_URL', $defaultAppUrl);
}
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
