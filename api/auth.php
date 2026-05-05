<?php
/**
 * FixIt API - Authentication Endpoints
 * Endpoints: POST /api/auth/register, /api/auth/login, /api/auth/logout
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

$request_method = $_SERVER['REQUEST_METHOD'];
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$path = str_replace('/api/auth/', '', $path);

try {
    if ($request_method === 'POST') {
        $input = json_decode(file_get_contents('php://input'), true);

        if ($path === 'register.php' || $path === 'register') {
            // Register new user
            $name = $input['name'] ?? '';
            $email = $input['email'] ?? '';
            $password = $input['password'] ?? '';
            $roll_number = $input['roll_number'] ?? '';
            $department = $input['department'] ?? '';
            $phone = $input['phone'] ?? '';

            if (empty($name) || empty($email) || empty($password)) {
                http_response_code(400);
                echo json_encode(['error' => 'Missing required fields']);
                exit();
            }

            if (Auth::register($name, $email, $password, $roll_number, $department, $phone)) {
                http_response_code(201);
                echo json_encode(['message' => 'User registered successfully']);
            } else {
                http_response_code(409);
                echo json_encode(['error' => 'Email already exists']);
            }
        } 
        elseif ($path === 'login.php' || $path === 'login') {
            // Login user
            $email = $input['email'] ?? '';
            $password = $input['password'] ?? '';

            if (empty($email) || empty($password)) {
                http_response_code(400);
                echo json_encode(['error' => 'Email and password required']);
                exit();
            }

            $user = Auth::login($email, $password);
            if ($user) {
                http_response_code(200);
                echo json_encode([
                    'message' => 'Login successful',
                    'user' => [
                        'id' => $user['id'],
                        'name' => $user['name'],
                        'email' => $user['email'],
                        'user_type' => $user['user_type']
                    ]
                ]);
            } else {
                http_response_code(401);
                echo json_encode(['error' => 'Invalid credentials']);
            }
        }
        elseif ($path === 'logout.php' || $path === 'logout') {
            // Logout user
            Auth::logout();
            http_response_code(200);
            echo json_encode(['message' => 'Logged out successfully']);
        }
        elseif ($path === 'change-password.php' || $path === 'change-password') {
            // Change password
            if (!Auth::isLoggedIn()) {
                http_response_code(401);
                echo json_encode(['error' => 'Unauthorized']);
                exit();
            }

            $old_password = $input['old_password'] ?? '';
            $new_password = $input['new_password'] ?? '';
            $confirm_password = $input['confirm_password'] ?? '';

            if ($new_password !== $confirm_password) {
                http_response_code(400);
                echo json_encode(['error' => 'Passwords do not match']);
                exit();
            }

            $user = Auth::getCurrentUser();
            if (Auth::changePassword($user['id'], $old_password, $new_password)) {
                http_response_code(200);
                echo json_encode(['message' => 'Password changed successfully']);
            } else {
                http_response_code(400);
                echo json_encode(['error' => 'Failed to change password']);
            }
        }
        else {
            http_response_code(404);
            echo json_encode(['error' => 'Endpoint not found']);
        }
    }
    elseif ($request_method === 'GET') {
        if ($path === 'me.php' || $path === 'me') {
            // Get current user
            if (!Auth::isLoggedIn()) {
                http_response_code(401);
                echo json_encode(['error' => 'Unauthorized']);
                exit();
            }

            $user = Auth::getCurrentUser();
            http_response_code(200);
            echo json_encode(['user' => $user]);
        }
        else {
            http_response_code(404);
            echo json_encode(['error' => 'Endpoint not found']);
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
