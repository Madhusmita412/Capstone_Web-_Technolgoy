<?php
/**
 * Database Connection Class
 * FixIt Smart Complaint Management System
 */

require_once __DIR__ . '/config.php';

class Database {
    private $conn;
    private static $instance;

    /**
     * Singleton pattern - Get database instance
     */
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Private constructor for singleton
     */
    private function __construct() {
        $this->connect();
    }

    /**
     * Connect to database
     */
    private function connect() {
        try {
            $this->conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            
            if ($this->conn->connect_error) {
                throw new Exception('Database connection failed: ' . $this->conn->connect_error);
            }
            
            $this->conn->set_charset('utf8mb4');
        } catch (Exception $e) {
            die('Connection Error: ' . $e->getMessage());
        }
    }

    /**
     * Get connection object
     */
    public function getConnection() {
        return $this->conn;
    }

    /**
     * Execute prepared statement query
     */
    public function query($sql, $params = [], $types = '') {
        try {
            $stmt = $this->conn->prepare($sql);
            
            if ($params && $types) {
                $stmt->bind_param($types, ...$params);
            }
            
            $stmt->execute();
            return $stmt;
        } catch (Exception $e) {
            throw new Exception('Query Error: ' . $e->getMessage());
        }
    }

    /**
     * Get single result
     */
    public function getRow($sql, $params = [], $types = '') {
        $stmt = $this->query($sql, $params, $types);
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    /**
     * Get multiple results
     */
    public function getRows($sql, $params = [], $types = '') {
        $stmt = $this->query($sql, $params, $types);
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Insert data
     */
    public function insert($table, $data) {
        $columns = array_keys($data);
        $values = array_values($data);
        $placeholders = array_fill(0, count($values), '?');
        $types = $this->getTypes($values);

        $sql = "INSERT INTO `$table` (" . implode(', ', $columns) . ") VALUES (" . implode(', ', $placeholders) . ")";
        
        $stmt = $this->query($sql, $values, $types);
        
        if ($stmt) {
            return $this->conn->insert_id;
        }
        return false;
    }

    /**
     * Update data
     */
    public function update($table, $data, $where, $where_params = [], $where_types = '') {
        $sets = [];
        $values = [];
        
        foreach ($data as $column => $value) {
            $sets[] = "`$column` = ?";
            $values[] = $value;
        }
        
        $values = array_merge($values, $where_params);
        $types = $this->getTypes($values);
        
        $sql = "UPDATE `$table` SET " . implode(', ', $sets) . " WHERE " . $where;
        
        $stmt = $this->query($sql, $values, $types);
        return $stmt->affected_rows > 0;
    }

    /**
     * Delete data
     */
    public function delete($table, $where, $params = [], $types = '') {
        $sql = "DELETE FROM `$table` WHERE " . $where;
        $stmt = $this->query($sql, $params, $types);
        return $stmt->affected_rows > 0;
    }

    /**
     * Count records
     */
    public function count($table, $where = '', $params = [], $types = '') {
        $sql = "SELECT COUNT(*) as count FROM `$table`";
        
        if ($where) {
            $sql .= " WHERE " . $where;
        }
        
        if ($params) {
            $result = $this->getRow($sql, $params, $types);
        } else {
            $result = $this->getRow($sql);
        }
        
        return $result['count'] ?? 0;
    }

    /**
     * Get data types for prepared statements
     */
    private function getTypes($values) {
        $types = '';
        foreach ($values as $value) {
            if (is_int($value)) {
                $types .= 'i';
            } elseif (is_float($value)) {
                $types .= 'd';
            } else {
                $types .= 's';
            }
        }
        return $types;
    }

    /**
     * Close connection
     */
    public function close() {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}

// Create database instance
$db = Database::getInstance();
?>
