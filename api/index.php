<?php
/**
 * FixIt API - Root Index
 * Redirects to documentation
 */

header('Content-Type: application/json');

$base_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'];

echo json_encode([
    'name' => 'FixIt API',
    'version' => '1.0.0',
    'description' => 'Smart Complaint Management System API',
    'documentation' => 'See API_DOCUMENTATION.md for complete API reference',
    'base_url' => $base_url,
    'endpoints' => [
        'auth' => [
            'register' => '/api/auth/register (POST)',
            'login' => '/api/auth/login (POST)',
            'logout' => '/api/auth/logout (POST)',
            'me' => '/api/auth/me (GET)',
            'change_password' => '/api/auth/change-password (POST)'
        ],
        'complaints' => [
            'list' => '/api/complaints (GET)',
            'create' => '/api/complaints (POST)',
            'get' => '/api/complaints?id=X (GET)',
            'update' => '/api/complaints?id=X (PUT - Admin only)',
            'delete' => '/api/complaints?id=X (DELETE - Admin only)'
        ],
        'contact' => [
            'submit' => '/api/contact (POST)',
            'list' => '/api/contact (GET - Admin only)'
        ],
        'stats' => [
            'dashboard' => '/api/stats (GET)'
        ]
    ],
    'demo_credentials' => [
        'email' => 'admin@fixit.local',
        'password' => 'admin@123'
    ]
]);
?>
