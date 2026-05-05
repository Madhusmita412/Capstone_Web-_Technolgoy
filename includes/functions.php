<?php
/**
 * Complaint Management Functions
 * FixIt Smart Complaint Management System
 */

require_once __DIR__ . '/db.php';

class Complaint {
    /**
     * Submit new complaint
     */
    public static function submit($user_id, $category, $title, $description, $priority = 'Medium') {
        $db = Database::getInstance();

        // Validate
        if (empty($category) || empty($title) || empty($description)) {
            return ['success' => false, 'message' => 'All fields are required'];
        }

        $complaint_id = $db->insert('complaints', [
            'user_id' => $user_id,
            'category' => $category,
            'title' => $title,
            'description' => $description,
            'priority' => $priority,
            'status' => 'Pending'
        ]);

        if ($complaint_id) {
            return ['success' => true, 'message' => 'Complaint submitted successfully', 'id' => $complaint_id];
        }

        return ['success' => false, 'message' => 'Failed to submit complaint'];
    }

    /**
     * Get user complaints
     */
    public static function getUserComplaints($user_id, $filters = []) {
        $db = Database::getInstance();

        $sql = "SELECT * FROM complaints WHERE user_id = ?";
        $params = [$user_id];
        $types = 'i';

        // Apply filters
        if (!empty($filters['status'])) {
            $sql .= " AND status = ?";
            $params[] = $filters['status'];
            $types .= 's';
        }

        if (!empty($filters['category'])) {
            $sql .= " AND category = ?";
            $params[] = $filters['category'];
            $types .= 's';
        }

        if (!empty($filters['priority'])) {
            $sql .= " AND priority = ?";
            $params[] = $filters['priority'];
            $types .= 's';
        }

        if (!empty($filters['search'])) {
            $sql .= " AND (title LIKE ? OR description LIKE ?)";
            $search_term = '%' . $filters['search'] . '%';
            $params[] = $search_term;
            $params[] = $search_term;
            $types .= 'ss';
        }

        $sql .= " ORDER BY created_at DESC";

        return $db->getRows($sql, $params, $types);
    }

    /**
     * Get all complaints (Admin)
     */
    public static function getAllComplaints($filters = [], $limit = 50, $offset = 0) {
        $db = Database::getInstance();

        $sql = "SELECT c.*, u.name as user_name, u.email as user_email FROM complaints c 
                LEFT JOIN users u ON c.user_id = u.id WHERE 1=1";
        $params = [];
        $types = '';

        // Apply filters
        if (!empty($filters['status'])) {
            $sql .= " AND c.status = ?";
            $params[] = $filters['status'];
            $types .= 's';
        }

        if (!empty($filters['category'])) {
            $sql .= " AND c.category = ?";
            $params[] = $filters['category'];
            $types .= 's';
        }

        if (!empty($filters['priority'])) {
            $sql .= " AND c.priority = ?";
            $params[] = $filters['priority'];
            $types .= 's';
        }

        if (!empty($filters['search'])) {
            $sql .= " AND (c.title LIKE ? OR c.description LIKE ? OR u.name LIKE ?)";
            $search_term = '%' . $filters['search'] . '%';
            $params[] = $search_term;
            $params[] = $search_term;
            $params[] = $search_term;
            $types .= 'sss';
        }

        // Add pagination
        $params[] = $limit;
        $params[] = $offset;
        $types .= 'ii';

        $sql .= " ORDER BY c.priority DESC, c.created_at DESC LIMIT ? OFFSET ?";

        return $db->getRows($sql, $params, $types);
    }

    /**
     * Get complaint by ID
     */
    public static function getComplaintById($id) {
        $db = Database::getInstance();

        return $db->getRow(
            "SELECT c.*, u.name as user_name, u.email as user_email, u.roll_number FROM complaints c 
             LEFT JOIN users u ON c.user_id = u.id WHERE c.id = ?",
            [$id],
            'i'
        );
    }

    /**
     * Update complaint status (Admin)
     */
    public static function updateStatus($complaint_id, $status, $resolution_notes = '', $admin_id = null) {
        $db = Database::getInstance();

        $data = ['status' => $status];

        if ($status === 'Resolved' && !empty($resolution_notes)) {
            $data['resolution_notes'] = $resolution_notes;
            $data['resolved_at'] = date('Y-m-d H:i:s');
        }

        if ($admin_id) {
            $data['assigned_to'] = $admin_id;
        }

        return $db->update('complaints', $data, 'id = ?', [$complaint_id], 'i');
    }

    /**
     * Delete complaint (Admin)
     */
    public static function deleteComplaint($id) {
        $db = Database::getInstance();
        return $db->delete('complaints', 'id = ?', [$id], 'i');
    }

    /**
     * Get complaint statistics
     */
    public static function getStatistics($user_id = null) {
        $db = Database::getInstance();

        $where_clause = '';
        $params = [];
        $types = '';

        if ($user_id) {
            $where_clause = 'WHERE user_id = ?';
            $params = [$user_id];
            $types = 'i';
        }

        $stats = [];

        // Total complaints
        $result = $db->getRow("SELECT COUNT(*) as count FROM complaints $where_clause", $params, $types);
        $stats['total'] = $result['count'];

        // By status
        $statuses = ['Pending', 'In Progress', 'Resolved'];
        foreach ($statuses as $status) {
            $where = $where_clause ? $where_clause . ' AND status = ?' : 'WHERE status = ?';
            $p = array_merge($params, [$status]);
            $t = $types . 's';
            $result = $db->getRow("SELECT COUNT(*) as count FROM complaints $where", $p, $t);
            $stats[$status] = $result['count'];
        }

        // By priority
        $priorities = ['High', 'Medium', 'Low'];
        foreach ($priorities as $priority) {
            $where = $where_clause ? $where_clause . ' AND priority = ?' : 'WHERE priority = ?';
            $p = array_merge($params, [$priority]);
            $t = $types . 's';
            $result = $db->getRow("SELECT COUNT(*) as count FROM complaints $where", $p, $t);
            $stats[$priority] = $result['count'];
        }

        return $stats;
    }

    /**
     * Search complaints
     */
    public static function search($keyword, $user_id = null) {
        $db = Database::getInstance();

        $sql = "SELECT c.*, u.name as user_name FROM complaints c 
                LEFT JOIN users u ON c.user_id = u.id 
                WHERE (c.title LIKE ? OR c.description LIKE ? OR c.category LIKE ?)";
        $params = ['%' . $keyword . '%', '%' . $keyword . '%', '%' . $keyword . '%'];
        $types = 'sss';

        if ($user_id) {
            $sql .= " AND c.user_id = ?";
            $params[] = $user_id;
            $types .= 'i';
        }

        $sql .= " ORDER BY c.created_at DESC";

        return $db->getRows($sql, $params, $types);
    }

    /**
     * Get complaint count by category
     */
    public static function getByCategory($user_id = null) {
        $db = Database::getInstance();

        $sql = "SELECT category, COUNT(*) as count FROM complaints WHERE 1=1";
        $params = [];
        $types = '';

        if ($user_id) {
            $sql .= " AND user_id = ?";
            $params[] = $user_id;
            $types .= 'i';
        }

        $sql .= " GROUP BY category ORDER BY count DESC";

        return $db->getRows($sql, $params, $types);
    }
}

/**
 * Contact Message Class
 */
class ContactMessage {
    /**
     * Save contact message
     */
    public static function save($name, $email, $subject, $message) {
        $db = Database::getInstance();

        if (empty($name) || empty($email) || empty($message)) {
            return ['success' => false, 'message' => 'All fields are required'];
        }

        $msg_id = $db->insert('contact_messages', [
            'name' => $name,
            'email' => $email,
            'subject' => $subject,
            'message' => $message
        ]);

        if ($msg_id) {
            return ['success' => true, 'message' => 'Message sent successfully', 'id' => $msg_id];
        }

        return ['success' => false, 'message' => 'Failed to send message'];
    }

    /**
     * Get all contact messages (Admin)
     */
    public static function getAll($limit = 50, $offset = 0) {
        $db = Database::getInstance();

        return $db->getRows(
            "SELECT * FROM contact_messages ORDER BY created_at DESC LIMIT ? OFFSET ?",
            [$limit, $offset],
            'ii'
        );
    }

    /**
     * Mark as read
     */
    public static function markAsRead($id) {
        $db = Database::getInstance();
        return $db->update('contact_messages', ['read_status' => 1], 'id = ?', [$id], 'i');
    }
}

/**
 * Get status badge HTML
 */
function getStatusBadge($status) {
    $badges = [
        'Pending' => '<span class="badge badge-pending">● Pending</span>',
        'In Progress' => '<span class="badge badge-in-progress">● In Progress</span>',
        'Resolved' => '<span class="badge badge-resolved">✓ Resolved</span>'
    ];
    return isset($badges[$status]) ? $badges[$status] : $badges['Pending'];
}

/**
 * Get priority badge HTML
 */
function getPriorityBadge($priority) {
    return '<span class="priority priority-' . strtolower($priority) . '">
        <span class="priority-indicator"></span>
        ' . htmlspecialchars($priority) . '
    </span>';
}

/**
 * Truncate text to specified length
 */
function truncateText($text, $length = 100, $suffix = '...') {
    if (strlen($text) <= $length) {
        return $text;
    }
    return substr($text, 0, $length) . $suffix;
}

/**
 * Format date with time
 */
function formatDate($dateString) {
    if (empty($dateString)) {
        return 'N/A';
    }
    return date('M d, Y h:i A', strtotime($dateString));
}

/**
 * Format date only
 */
function formatDateOnly($dateString) {
    if (empty($dateString)) {
        return 'N/A';
    }
    return date('M d, Y', strtotime($dateString));
}

/**
 * Format relative time
 */
function formatRelativeTime($dateString) {
    if (empty($dateString)) {
        return 'N/A';
    }
    
    $date = new DateTime($dateString);
    $now = new DateTime();
    $interval = $now->diff($date);
    
    if ($interval->y > 0) return $interval->y . ' year' . ($interval->y > 1 ? 's' : '') . ' ago';
    if ($interval->m > 0) return $interval->m . ' month' . ($interval->m > 1 ? 's' : '') . ' ago';
    if ($interval->d > 0) return $interval->d . ' day' . ($interval->d > 1 ? 's' : '') . ' ago';
    if ($interval->h > 0) return $interval->h . ' hour' . ($interval->h > 1 ? 's' : '') . ' ago';
    if ($interval->i > 0) return $interval->i . ' minute' . ($interval->i > 1 ? 's' : '') . ' ago';
    return 'Just now';
}
?>
