<?php
class AuthController extends Controller {
    public function login() {
        $this->render('auth/login');
    }

    public function db_inspector() {
        $db = Database::getInstance()->getConnection();
        $tables = [];
        $selectedTable = isset($_GET['table']) ? trim($_GET['table']) : 'users';
        $rows = [];
        $columns = [];
        
        if ($db) {
            // Get list of tables
            $stmt = $db->query("SELECT name FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%'");
            $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
            
            if (in_array($selectedTable, $tables)) {
                // Get table rows
                $stmtRows = $db->query("SELECT * FROM {$selectedTable} LIMIT 100");
                $rows = $stmtRows->fetchAll(PDO::FETCH_ASSOC);
                
                // Get column names
                if (!empty($rows)) {
                    $columns = array_keys($rows[0]);
                } else {
                    // Fetch schema to get columns if empty
                    $stmtCol = $db->query("PRAGMA table_info({$selectedTable})");
                    $cols = $stmtCol->fetchAll(PDO::FETCH_ASSOC);
                    $columns = array_map(function($c) { return $c['name']; }, $cols);
                }
            }
        }
        
        $data = [
            'tables' => $tables,
            'selectedTable' => $selectedTable,
            'rows' => $rows,
            'columns' => $columns
        ];
        $this->render('auth/db_inspector', $data);
    }

    /**
     * Process user login request.
     * Authenticates school_code, user_id, and user_pass against the database.
     */
    public function process() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $schoolCode = isset($_POST['school_code']) ? trim($_POST['school_code']) : '';
            $userId = isset($_POST['user_id']) ? trim($_POST['user_id']) : '';
            $userPass = isset($_POST['user_pass']) ? trim($_POST['user_pass']) : '';

            $db = Database::getInstance()->getConnection();
            if ($db) {
                // For simplicity, we compare password directly as requested: "keep id and pass same"
                $stmt = $db->prepare("SELECT * FROM users WHERE school_code = :school_code AND username = :username AND password = :password");
                $stmt->execute([
                    'school_code' => $schoolCode,
                    'username' => $userId,
                    'password' => $userPass
                ]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($user) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['role'] = $user['role'];
                    $_SESSION['school_code'] = $user['school_code'];

                    // Retrieve role-specific profiles for dynamic dashboard displays
                    if ($user['role'] === 'student') {
                        $stmtProfile = $db->prepare("SELECT id, full_name, avatar FROM students WHERE user_id = :user_id");
                        $stmtProfile->execute(['user_id' => $user['id']]);
                        $student = $stmtProfile->fetch(PDO::FETCH_ASSOC);
                        
                        $_SESSION['student_db_id'] = $student ? $student['id'] : null;
                        $_SESSION['user_full_name'] = $student ? $student['full_name'] : $user['username'];
                        $_SESSION['user_avatar'] = $student ? $student['avatar'] : 'Jamil';
                        
                        header('Location: index.php?controller=student&action=dashboard');
                    } else {
                        $stmtProfile = $db->prepare("SELECT id, full_name, avatar FROM teachers WHERE user_id = :user_id");
                        $stmtProfile->execute(['user_id' => $user['id']]);
                        $teacher = $stmtProfile->fetch(PDO::FETCH_ASSOC);
                        
                        $_SESSION['teacher_db_id'] = $teacher ? $teacher['id'] : null;
                        $_SESSION['user_full_name'] = $teacher ? $teacher['full_name'] : $user['username'];
                        $_SESSION['user_avatar'] = $teacher ? $teacher['avatar'] : 'Anisul';
                        
                        header('Location: index.php?controller=teacher&action=dashboard');
                    }
                    exit;
                } else {
                    $_SESSION['error'] = "Invalid School Code, User ID, or Password.";
                }
            } else {
                $_SESSION['error'] = "Database Connection Offline.";
            }
        }
        header('Location: index.php?controller=auth&action=login');
        exit;
    }

    /**
     * Toggles logged-in user between roles for demo/viewing purposes.
     * Dynamically swaps user credentials to match the target role within the same school.
     */
    public function switch() {
        if (isset($_SESSION['role'])) {
            $newRole = ($_SESSION['role'] === 'student') ? 'teacher' : 'student';
            $schoolCode = isset($_SESSION['school_code']) ? $_SESSION['school_code'] : 'DHAKA100';

            $db = Database::getInstance()->getConnection();
            if ($db) {
                // Find a demo user of the new role in the same school
                $stmt = $db->prepare("SELECT * FROM users WHERE school_code = :school_code AND role = :role LIMIT 1");
                $stmt->execute(['school_code' => $schoolCode, 'role' => $newRole]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($user) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['role'] = $user['role'];
                    $_SESSION['school_code'] = $user['school_code'];

                    if ($user['role'] === 'student') {
                        $stmtProfile = $db->prepare("SELECT id, full_name, avatar FROM students WHERE user_id = :user_id");
                        $stmtProfile->execute(['user_id' => $user['id']]);
                        $student = $stmtProfile->fetch(PDO::FETCH_ASSOC);
                        
                        $_SESSION['student_db_id'] = $student ? $student['id'] : null;
                        $_SESSION['user_full_name'] = $student ? $student['full_name'] : $user['username'];
                        $_SESSION['user_avatar'] = $student ? $student['avatar'] : 'Jamil';
                    } else {
                        $stmtProfile = $db->prepare("SELECT id, full_name, avatar FROM teachers WHERE user_id = :user_id");
                        $stmtProfile->execute(['user_id' => $user['id']]);
                        $teacher = $stmtProfile->fetch(PDO::FETCH_ASSOC);
                        
                        $_SESSION['teacher_db_id'] = $teacher ? $teacher['id'] : null;
                        $_SESSION['user_full_name'] = $teacher ? $teacher['full_name'] : $user['username'];
                        $_SESSION['user_avatar'] = $teacher ? $teacher['avatar'] : 'Anisul';
                    }
                } else {
                    $_SESSION['role'] = $newRole;
                }
            } else {
                $_SESSION['role'] = $newRole;
            }

            header('Location: index.php?controller=' . $_SESSION['role'] . '&action=dashboard');
        } else {
            header('Location: index.php?controller=auth&action=login');
        }
        exit;
    }

    /**
     * Terminate user session and redirect to login page.
     */
    public function logout() {
        // Clear all session variables
        $_SESSION = array();

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        session_destroy();
        header('Location: index.php?controller=auth&action=login');
        exit;
    }
}
