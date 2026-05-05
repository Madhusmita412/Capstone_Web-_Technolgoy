<?php
/**
 * FixIt API - Complaints Endpoints
 * GET, POST /api/complaints
 * GET, PUT /api/complaints/:id
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
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
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

try {
    if ($request_method === 'GET') {
        // Get complaints
        if (!Auth::isLoggedIn()) {
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized']);
            exit();
        }

        $user = Auth::getCurrentUser();
        $complaint_id = isset($_GET['id']) ? $_GET['id'] : null;

        if ($complaint_id) {
            // Get single complaint
            $complaint = Complaint::getComplaintById($complaint_id);
            if (!$complaint) {
                http_response_code(404);
                echo json_encode(['error' => 'Complaint not found']);
                exit();
            }

            // Check permission
            if ($complaint['user_id'] != $user['id'] && $user['user_type'] != 'admin') {
                http_response_code(403);
                echo json_encode(['error' => 'Access denied']);
                exit();
            }

            http_response_code(200);
            echo json_encode(['complaint' => $complaint]);
        } else {
            // Get all complaints (for admin) or user's complaints
            if ($user['user_type'] === 'admin') {
                $complaints = Complaint::getAllComplaints();
            } else {
                $complaints = Complaint::getUserComplaints($user['id']);
            }

            http_response_code(200);
            echo json_encode(['complaints' => $complaints]);
        }
    }
    elseif ($request_method === 'POST') {
        // Create new complaint
        if (!Auth::isLoggedIn()) {
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized']);
            exit();
        }

        $input = json_decode(file_get_contents('php://input'), true);

        $category = $input['category'] ?? '';
        $title = $input['title'] ?? '';
        $description = $input['description'] ?? '';
        $priority = $input['priority'] ?? 'Low';

        if (empty($category) || empty($title) || empty($description)) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing required fields']);
            exit();
        }

        $user = Auth::getCurrentUser();
        $complaint_id = Complaint::submit($user['id'], $category, $title, $description, $priority);

        if ($complaint_id) {
            http_response_code(201);
            echo json_encode([
                'message' => 'Complaint created successfully',
                'complaint_id' => $complaint_id
            ]);
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'Failed to create complaint']);
        }
    }
    elseif ($request_method === 'PUT') {
        // Update complaint (admin only)
        if (!Auth::isLoggedIn() || !Auth::isAdmin()) {
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized']);
            exit();
        }

        $complaint_id = $_GET['id'] ?? null;
        if (!$complaint_id) {
            http_response_code(400);
            echo json_encode(['error' => 'Complaint ID required']);
            exit();
        }

        $input = json_decode(file_get_contents('php://input'), true);
        $new_status = $input['status'] ?? '';
        $resolution_notes = $input['resolution_notes'] ?? '';

        if (empty($new_status)) {
            http_response_code(400);
            echo json_encode(['error' => 'Status required']);
            exit();
        }

        $user = Auth::getCurrentUser();
        if (Complaint::updateStatus($complaint_id, $new_status, $resolution_notes, $user['id'])) {
            http_response_code(200);
            echo json_encode(['message' => 'Complaint updated successfully']);
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'Failed to update complaint']);
        }
    }
    elseif ($request_method === 'DELETE') {
        // Delete complaint (admin only)
        if (!Auth::isLoggedIn() || !Auth::isAdmin()) {
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized']);
            exit();
        }

        $complaint_id = $_GET['id'] ?? null;
        if (!$complaint_id) {
            http_response_code(400);
            echo json_encode(['error' => 'Complaint ID required']);
            exit();
        }

        if (Complaint::delete($complaint_id)) {
            http_response_code(200);
            echo json_encode(['message' => 'Complaint deleted successfully']);
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'Failed to delete complaint']);
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
