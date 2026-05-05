<?php
/**
 * FixIt Smart Complaint Management System
 * Logout Page
 */

require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/config.php';

Auth::logout();
header('Location: ' . APP_URL . '/index.php');
exit();
?>
