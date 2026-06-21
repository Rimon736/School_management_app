<?php
$role = isset($_SESSION['role']) ? $_SESSION['role'] : '';
$roleLabel = $role === 'teacher' ? 'Teacher' : 'Student';
?>
<div class="menu-overlay" id="menuOverlay" onclick="toggleMenu()"></div>
<div class="side-menu" id="sideMenu">
    <div class="sm-header">
        <div class="sm-logo">Edu Menu</div>
        <div class="sm-lang"><span class="active">Eng</span><span>বাং</span></div>
    </div>
    <div class="sm-banner" onclick="showToast('Opening AVA Assistant')">
        <i class="ph-fill ph-robot"></i>
        <div class="sm-banner-text">
            <div>AVA <span style="font-size: 9px; color: var(--brand-color); vertical-align: top;">BETA</span></div>
            <div>Active virtual Assistant</div>
        </div>
    </div>
    <ul class="sm-list" id="sideMenuListContainer">
        <?php if ($role === 'student'): ?>
            <li class="sm-item" onclick="window.location.href='index.php?controller=student&action=classroom'">
                <i class="ph ph-chalkboard-teacher"></i> Classroom
                <span class="sidebar-badge">2</span>
            </li>
            <li class="sm-item" onclick="window.location.href='index.php?controller=student&action=routine'">
                <i class="ph ph-clock"></i> Routine
            </li>
            <li class="sm-item" onclick="window.location.href='index.php?controller=student&action=attendance'">
                <i class="ph ph-calendar-check"></i> Attendance
            </li>
            <li class="sm-item" onclick="window.location.href='index.php?controller=student&action=results'">
                <i class="ph ph-chart-bar"></i> Results
            </li>
            <li class="sm-item" onclick="window.location.href='index.php?controller=student&action=profile'">
                <i class="ph ph-user"></i> Profile
            </li>
            <li class="sm-item" onclick="window.location.href='index.php?controller=student&action=fees'">
                <i class="ph ph-credit-card"></i> Fees
            </li>
            <li class="sm-item" onclick="window.location.href='index.php?controller=student&action=academic_calendar'">
                <i class="ph ph-calendar"></i> Academic Calendar
            </li>
            <li class="sm-item" onclick="window.location.href='index.php?controller=student&action=teachers_list'">
                <i class="ph ph-users-three"></i> Teachers
            </li>
            <li class="sm-item" onclick="window.location.href='index.php?controller=student&action=notices'">
                <i class="ph ph-megaphone"></i> Notices
            </li>
            <li class="sm-item" onclick="window.location.href='index.php?controller=student&action=inbox'">
                <i class="ph ph-envelope-simple"></i> Inbox
                <span class="sidebar-badge alert">2</span>
            </li>
        <?php elseif ($role === 'teacher'): ?>
            <li class="sm-item" onclick="window.location.href='index.php?controller=teacher&action=profile'">
                <i class="ph ph-user"></i> Profile
            </li>
            <li class="sm-item" onclick="window.location.href='index.php?controller=teacher&action=online_class'">
                <i class="ph ph-video-camera"></i> Online Class
                <span class="sidebar-badge">1</span>
            </li>
            <li class="sm-item" onclick="window.location.href='index.php?controller=teacher&action=mark_entry'">
                <i class="ph ph-clipboard-text"></i> Mark Entry
            </li>
            <li class="sm-item" onclick="window.location.href='index.php?controller=teacher&action=student_attendance'">
                <i class="ph ph-calendar-plus"></i> Student Attendance
            </li>
            <li class="sm-item" onclick="window.location.href='index.php?controller=teacher&action=student_list'">
                <i class="ph ph-list-numbers"></i> Student List
            </li>
            <li class="sm-item" onclick="window.location.href='index.php?controller=teacher&action=routine'">
                <i class="ph ph-clock"></i> Routine
            </li>
            <li class="sm-item" onclick="window.location.href='index.php?controller=teacher&action=personal_attendance'">
                <i class="ph ph-calendar-check"></i> Personal Attendance
            </li>
            <li class="sm-item" onclick="window.location.href='index.php?controller=teacher&action=academic_calendar'">
                <i class="ph ph-calendar"></i> Academic Calendar
            </li>
            <li class="sm-item" onclick="window.location.href='index.php?controller=teacher&action=notices'">
                <i class="ph ph-megaphone"></i> Notices
            </li>
            <li class="sm-item" onclick="window.location.href='index.php?controller=teacher&action=inbox'">
                <i class="ph ph-envelope-simple"></i> Inbox
                <span class="sidebar-badge alert">2</span>
            </li>
        <?php endif; ?>
        
        <li class="sm-item" onclick="window.location.href='?controller=auth&action=switch'" style="background-color: #f4f0fa; font-weight: 500; margin-top: 10px;">
            <i class="ph ph-arrows-left-right" style="color: var(--brand-color);"></i> Switch Role
            <span class="sm-badge" id="currentRoleBadge"><?php echo htmlspecialchars($roleLabel); ?></span>
        </li>
        <li class="sm-item" onclick="window.location.href='?controller=auth&action=logout'">
            <i class="ph ph-sign-out"></i> Log out
        </li>
    </ul>
    <div class="sm-footer">Version 7.0.0</div>
</div>
