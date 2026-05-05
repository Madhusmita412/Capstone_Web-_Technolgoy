<?php
/**
 * Database Connection Class
 * FixIt Smart Complaint Management System
 */

require_once __DIR__ . '/config.php';

class Database {
    private $conn;
    private static $instance;
    private $lastError = null;

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
    }

    /**
     * Connect to database
     */
    private function connect() {
        if ($this->conn instanceof mysqli) {
            return true;
        }

        try {
            $this->conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, (int)DB_PORT);
            
            if ($this->conn->connect_error) {
                $this->lastError = $this->conn->connect_error;
                $this->conn = null;
                return false;
            }
            
            $this->conn->set_charset('utf8mb4');
            $this->lastError = null;
            return true;
        } catch (Exception $e) {
            $this->lastError = $e->getMessage();
            $this->conn = null;
            return false;
        }
    }

    /**
     * Check whether the database connection is available.
     */
    public function isConnected() {
        return $this->connect();
    }

    /**
     * Get the last connection error if one occurred.
     */
    public function getLastError() {
        return $this->lastError;
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
            if (!$this->connect()) {
                return false;
            }

            $stmt = $this->conn->prepare($sql);
            if (!$stmt) {
                throw new Exception($this->conn->error);
            }
            
            if ($params && $types) {
                $stmt->bind_param($types, ...$params);
            }
            
            $stmt->execute();
            return $stmt;
        } catch (Exception $e) {
            $this->lastError = $e->getMessage();
            throw new Exception('Query Error: ' . $e->getMessage());
        }
    }

    /**
     * Get single result
     */
    public function getRow($sql, $params = [], $types = '') {
        $stmt = $this->query($sql, $params, $types);
        if (!$stmt) {
            return null;
        }
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    /**
     * Get multiple results
     */
    public function getRows($sql, $params = [], $types = '') {
        $stmt = $this->query($sql, $params, $types);
        if (!$stmt) {
            return [];
        }
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Insert data
     */
    public function insert($table, $data) {
        if (!$this->connect()) {
            return false;
        }

        $columns = array_keys($data);
        $values = array_values($data);
        $placeholders = array_fill(0, count($values), '?');
        $types = $this->getTypes($values);

        $sql = "INSERT INTO `$table` (" . implode(', ', $columns) . ") VALUES (" . implode(', ', $placeholders) . ")";
        
        $stmt = $this->query($sql, $values, $types);
        
        if ($stmt) {
            return $this->conn->insert_id;
        }
        $this->lastError = $this->conn ? $this->conn->error : $this->lastError;
        return false;
    }

    /**
     * Update data
     */
    public function update($table, $data, $where, $where_params = [], $where_types = '') {
        if (!$this->connect()) {
            return false;
        }

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
        if (!$this->connect()) {
            return false;
        }

        $sql = "DELETE FROM `$table` WHERE " . $where;
        $stmt = $this->query($sql, $params, $types);
        return $stmt ? $stmt->affected_rows > 0 : false;
    }

    /**
     * Count records
     */
    public function count($table, $where = '', $params = [], $types = '') {
        if (!$this->connect()) {
            return 0;
        }

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

// Create database instance without forcing an immediate connection.
$db = Database::getInstance();
?>
