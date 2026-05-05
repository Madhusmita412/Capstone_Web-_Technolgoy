<?php
/**
 * Authentication Functions
 * FixIt Smart Complaint Management System
 */

require_once __DIR__ . '/db.php';

class Auth {
    /**
     * Start session with security
     */
    public static function startSession() {
        if (session_status() === PHP_SESSION_NONE) {
            ini_set('session.cookie_httponly', 1);
            ini_set('session.cookie_secure', isset($_SERVER['HTTPS']));
            ini_set('session.use_only_cookies', 1);
            session_start();
        }
    }

    /**
     * Register new user
     */
    public static function register($name, $email, $password, $roll_number = '', $department = '') {
        $db = Database::getInstance();

        if (!$db->isConnected()) {
            return [
                'success' => false,
                'message' => 'Database connection failed: ' . ($db->getLastError() ?: 'unknown error')
            ];
        }
        
        // Validate inputs
        if (empty($name) || empty($email) || empty($password)) {
            return ['success' => false, 'message' => 'All fields are required'];
        }

        // Check if email already exists
        $existing = $db->getRow("SELECT id FROM users WHERE email = ?", [$email], 's');
        if ($existing) {
            return ['success' => false, 'message' => 'Email already registered'];
        }

        // Hash password
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Insert user
        $user_id = $db->insert('users', [
            'name' => $name,
            'email' => $email,
            'password' => $hashed_password,
            'roll_number' => $roll_number,
            'department' => $department
        ]);

        if ($user_id) {
            return ['success' => true, 'message' => 'Registration successful', 'user_id' => $user_id];
        }

        return [
            'success' => false,
            'message' => 'Registration failed: ' . ($db->getLastError() ?: 'unknown error')
        ];
    }

    /**
     * Login user
     */
    public static function login($email, $password) {
        $db = Database::getInstance();

        // Get user
        $user = $db->getRow("SELECT * FROM users WHERE email = ? AND status = 'active'", [$email], 's');

        if (!$user) {
            return ['success' => false, 'message' => 'Invalid email or password'];
        }

        // Verify password
        if (!password_verify($password, $user['password'])) {
            return ['success' => false, 'message' => 'Invalid email or password'];
        }

        // Set session
        self::startSession();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_type'] = $user['user_type'];
        $_SESSION['login_time'] = time();

        return ['success' => true, 'message' => 'Login successful', 'user_type' => $user['user_type']];
    }

    /**
     * Check if user is logged in
     */
    public static function isLoggedIn() {
        self::startSession();
        return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
    }

    /**
     * Check if user is admin
     */
    public static function isAdmin() {
        self::startSession();
        return isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'admin';
    }

    /**
     * Get current user
     */
    public static function getCurrentUser() {
        self::startSession();
        
        if (!self::isLoggedIn()) {
            return null;
        }

        $db = Database::getInstance();
        return $db->getRow("SELECT * FROM users WHERE id = ?", [$_SESSION['user_id']], 'i');
    }

    /**
     * Logout user
     */
    public static function logout() {
        self::startSession();
        session_destroy();
        return true;
    }

    /**
     * Require login
     */
    public static function requireLogin() {
        if (!self::isLoggedIn()) {
            header('Location: ' . APP_URL . '/login.php');
            exit();
        }
    }

    /**
     * Require admin
     */
    public static function requireAdmin() {
        if (!self::isAdmin()) {
            header('Location: ' . APP_URL . '/index.php');
            exit();
        }
    }

    /**
     * Get user by ID
     */
    public static function getUserById($id) {
        $db = Database::getInstance();
        return $db->getRow("SELECT id, name, email, roll_number, department, user_type, status, created_at FROM users WHERE id = ?", [$id], 'i');
    }

    /**
     * Update user profile
     */
    public static function updateProfile($user_id, $data) {
        $db = Database::getInstance();
        return $db->update('users', $data, 'id = ?', [$user_id], 'i');
    }

    /**
     * Change password
     */
    public static function changePassword($user_id, $old_password, $new_password) {
        $db = Database::getInstance();
        
        // Get user
        $user = $db->getRow("SELECT password FROM users WHERE id = ?", [$user_id], 'i');
        
        if (!$user) {
            return ['success' => false, 'message' => 'User not found'];
        }

        // Verify old password
        if (!password_verify($old_password, $user['password'])) {
            return ['success' => false, 'message' => 'Incorrect current password'];
        }

        // Update with new password
        $new_hashed = password_hash($new_password, PASSWORD_BCRYPT);
        $db->update('users', ['password' => $new_hashed], 'id = ?', [$user_id], 'i');

        return ['success' => true, 'message' => 'Password changed successfully'];
    }
}

// Start session automatically
Auth::startSession();
?>
