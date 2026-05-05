<?php
/**
 * Admin Reports - Placeholder
 */

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/auth.php';

Auth::requireAdmin();

header('Location: ' . APP_URL . '/admin/dashboard.php');
exit();
?>
