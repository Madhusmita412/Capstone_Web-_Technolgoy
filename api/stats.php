<?php
/**
 * FixIt API - Dashboard/Statistics Endpoints
 * GET /api/stats
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';

try {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if (!Auth::isLoggedIn()) {
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized']);
            exit();
        }

        $user = Auth::getCurrentUser();
        
        if ($user['user_type'] === 'admin') {
            // Admin statistics
            $stats = Complaint::getStatistics();
            $total_users = Database::getInstance()->count('users');
            $contact_messages = Database::getInstance()->count('contact_messages');

            http_response_code(200);
            echo json_encode([
                'total_complaints' => $stats['total'],
                'pending' => $stats['pending'],
                'in_progress' => $stats['in_progress'],
                'resolved' => $stats['resolved'],
                'total_users' => $total_users,
                'unread_messages' => $contact_messages,
                'user_type' => 'admin'
            ]);
        } else {
            // User statistics
            $stats = Complaint::getStatistics($user['id']);

            http_response_code(200);
            echo json_encode([
                'total_complaints' => $stats['total'],
                'pending' => $stats['pending'],
                'in_progress' => $stats['in_progress'],
                'resolved' => $stats['resolved'],
                'user_type' => 'student'
            ]);
        }
    }
    else {
        http_response_code(405);
        echo json_encode(['error' => 'Method not allowed']);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
