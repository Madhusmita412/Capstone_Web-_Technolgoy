<?php
/**
 * FixIt API - Contact Endpoints
 * GET, POST /api/contact
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';

$request_method = $_SERVER['REQUEST_METHOD'];

try {
    if ($request_method === 'POST') {
        // Submit contact message
        $input = json_decode(file_get_contents('php://input'), true);

        $name = $input['name'] ?? '';
        $email = $input['email'] ?? '';
        $subject = $input['subject'] ?? '';
        $message = $input['message'] ?? '';

        if (empty($name) || empty($email) || empty($subject) || empty($message)) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing required fields']);
            exit();
        }

        $contact = new ContactMessage();
        if ($contact->save($name, $email, $subject, $message)) {
            http_response_code(201);
            echo json_encode(['message' => 'Message sent successfully']);
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'Failed to send message']);
        }
    }
    elseif ($request_method === 'GET') {
        // Get all messages (admin only)
        if (!Auth::isLoggedIn() || !Auth::isAdmin()) {
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized']);
            exit();
        }

        $contact = new ContactMessage();
        $messages = $contact->getAll();

        http_response_code(200);
        echo json_encode(['messages' => $messages]);
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
