<?php
session_start();

// Autoload core and controller/model files
require_once 'core/Controller.php';
require_once 'models/StudentModel.php';
require_once 'models/TeacherModel.php';
require_once 'controllers/AuthController.php';
require_once 'controllers/StudentController.php';
require_once 'controllers/TeacherController.php';

// Parse controller and action from request parameters
$controllerName = isset($_GET['controller']) ? trim($_GET['controller']) : '';
$actionName = isset($_GET['action']) ? trim($_GET['action']) : '';

// Authentication check
$isLoggedIn = isset($_SESSION['role']) && !empty($_SESSION['role']);

if (!$isLoggedIn) {
    // Force AuthController if not logged in
    $controllerName = 'auth';
    if ($actionName !== 'process') {
        $actionName = 'login';
    }
} else {
    // Logged in: ensure we default to role-appropriate controller/action
    $userRole = $_SESSION['role']; // 'student' or 'teacher'
    
    if (empty($controllerName)) {
        $controllerName = $userRole;
    }
    if (empty($actionName)) {
        $actionName = 'dashboard';
    }

    // Role safety checks: prevent accessing the wrong panel
    if ($controllerName !== 'auth' && $controllerName !== $userRole) {
        $controllerName = $userRole;
        $actionName = 'dashboard';
    }
}

// Route dispatching
$className = '';
if ($controllerName === 'auth') {
    $className = 'AuthController';
} elseif ($controllerName === 'student') {
    $className = 'StudentController';
} elseif ($controllerName === 'teacher') {
    $className = 'TeacherController';
}

if (class_exists($className)) {
    $controllerInstance = new $className();
    $methodName = $actionName;
    
    if (method_exists($controllerInstance, $methodName)) {
        $controllerInstance->$methodName();
    } else {
        // Fallback or 404
        $fallbackMethod = 'dashboard';
        if (method_exists($controllerInstance, $fallbackMethod)) {
            $controllerInstance->$fallbackMethod();
        } else {
            echo "Action not found.";
        }
    }
} else {
    echo "Controller not found.";
}
