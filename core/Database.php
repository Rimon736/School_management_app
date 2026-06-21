<?php
class Database {
    private static $instance = null;
    private $pdo;

    // Private constructor prevents direct creation
    private function __construct() {
        $dbPath = __DIR__ . '/../database.sqlite';
        try {
            // Verify driver availability before attempting connection
            if (!class_exists('PDO') || !in_array('sqlite', PDO::getAvailableDrivers())) {
                throw new PDOException("SQLite PDO driver is not enabled in this PHP environment.");
            }
            // Setup SQLite PDO connection
            $this->pdo = new PDO("sqlite:" . $dbPath);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->initTables();
        } catch (PDOException $e) {
            // Graceful fallback to null connection instead of killing process
            error_log("Database connection failed: " . $e->getMessage() . " Falling back to mock arrays.");
            $this->pdo = null;
        }
    }

    // Singleton getInstance method
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    // Get connection object
    public function getConnection() {
        return $this->pdo;
    }

    // Initialize sample tables and seed data automatically for the demo
    private function initTables() {
        // 1. Table for global system configuration values
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS system_config (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            key_name TEXT UNIQUE,
            value_data TEXT
        )");

        // 2. Table for dynamic menu sections/features
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS menu_items (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            role TEXT,
            label TEXT,
            action_name TEXT,
            icon_class TEXT,
            badge_count INTEGER DEFAULT 0
        )");

        // Seed data if tables are currently empty
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM menu_items");
        if ($stmt->fetchColumn() == 0) {
            // Seed student menu items
            $this->pdo->exec("INSERT INTO menu_items (role, label, action_name, icon_class, badge_count) VALUES
                ('student', 'Classroom', 'classroom', 'ph-chalkboard-teacher', 2),
                ('student', 'Routine', 'routine', 'ph-clock', 0),
                ('student', 'Attendance', 'attendance', 'ph-calendar-check', 0),
                ('student', 'Results', 'results', 'ph-chart-bar', 0),
                ('student', 'Inbox', 'inbox', 'ph-envelope-simple', 2)
            ");
            
            // Seed teacher menu items
            $this->pdo->exec("INSERT INTO menu_items (role, label, action_name, icon_class, badge_count) VALUES
                ('teacher', 'Online Class', 'online_class', 'ph-video-camera', 1),
                ('teacher', 'Routine', 'routine', 'ph-clock', 0),
                ('teacher', 'Inbox', 'inbox', 'ph-envelope-simple', 2)
            ");
        }
        
        $stmt2 = $this->pdo->query("SELECT COUNT(*) FROM system_config");
        if ($stmt2->fetchColumn() == 0) {
            $this->pdo->exec("INSERT INTO system_config (key_name, value_data) VALUES
                ('school_name', 'EduManage High School (Dhaka)'),
                ('currency', 'BDT')
            ");
        }
    }
}
