<?php
$action = isset($_GET['action']) ? $_GET['action'] : 'dashboard';
$controller = isset($_GET['controller']) ? $_GET['controller'] : '';
$isLoggedIn = isset($_SESSION['role']) && !empty($_SESSION['role']);

$innerMode = ($action !== 'dashboard' && $action !== 'login' && !empty($action));
$headerClass = $innerMode ? 'header inner-mode' : 'header';
$containerClass = (!$isLoggedIn || $action === 'login') ? 'app-container login-mode' : 'app-container';

// Setup view title based on action
$title = 'EduManage';
if ($innerMode) {
    $title = ucfirst(str_replace('_', ' ', $action));
    if ($action === 'academic_calendar') $title = 'Academic Calendar';
    if ($action === 'teachers_list') $title = 'Teachers List';
    if ($action === 'online_class') $title = 'Online Class';
    if ($action === 'mark_entry') $title = 'Mark Entry';
    if ($action === 'student_attendance') $title = 'Student Attendance';
    if ($action === 'student_list') $title = 'Student List';
    if ($action === 'personal_attendance') $title = 'My Attendance';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>EduManage - Raw PHP MVC</title>
    <link rel="stylesheet" href="assets/css/style.css?v=1.0.2">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="assets/js/main.js" defer></script>
</head>
<body>
    <div class="<?php echo $containerClass; ?>" id="mainContainer">
        <?php if ($isLoggedIn && $action !== 'login'): ?>
        <header class="<?php echo $headerClass; ?>" id="appHeader">
            <div class="header-default">
                <div class="header-left">
                    <div class="avatar" onclick="window.location.href='?controller=<?php echo $_SESSION['role']; ?>&action=profile'">
                        <img id="userAvatar" src="https://api.dicebear.com/7.x/avataaars/svg?seed=<?php echo $_SESSION['role'] === 'student' ? 'Jamil' : 'Anisul'; ?>&backgroundColor=8E7CC3" alt="Profile">
                    </div>
                    <div class="user-info">
                        <div class="user-name" id="userName"><?php echo $_SESSION['role'] === 'student' ? 'Jamil Mahmud' : 'Prof. Anisul Islam'; ?></div>
                        <div class="user-role" id="userRole"><?php echo $_SESSION['role'] === 'student' ? 'Student' : 'Teacher'; ?></div>
                        <?php if ($_SESSION['role'] !== 'student'): ?>
                        <div class="balance-pill" id="balanceBtn" onclick="toggleBalance()">
                            <i class="ph-fill ph-wallet" id="balanceIcon"></i>
                            <span id="balanceText">Tap for Balance</span>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="header-right">
                    <div class="header-icon" onclick="showToast('Search module clicked')">
                        <i class="ph ph-magnifying-glass"></i>
                    </div>
                    <div class="three-dots-btn" onclick="toggleMenu()">
                        <i class="ph ph-list"></i>
                    </div>
                </div>
            </div>
            <div class="header-inner">
                <i class="ph ph-arrow-left back-btn" onclick="window.location.href='?controller=<?php echo $_SESSION['role']; ?>&action=dashboard'"></i>
                <div class="view-title" id="innerViewTitle"><?php echo htmlspecialchars($title); ?></div>
                <i class="ph ph-dots-three-vertical back-btn" onclick="showToast('Options')"></i>
            </div>
        </header>
        <?php endif; ?>
        <main class="main-content">
