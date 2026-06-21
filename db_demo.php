<?php
// Include the Database singleton class
require_once 'core/Database.php';

// Fetch the database instance and connection
$db = Database::getInstance();
$pdo = $db->getConnection();

$dbAvailable = ($pdo !== null);
$configs = [];
$studentMenuItems = [];
$teacherMenuItems = [];

if ($dbAvailable) {
    // Fetch system config values from database
    $configStmt = $pdo->query("SELECT key_name, value_data FROM system_config");
    while ($row = $configStmt->fetch()) {
        $configs[$row['key_name']] = $row['value_data'];
    }

    // Fetch student menu items from database
    $studentStmt = $pdo->prepare("SELECT * FROM menu_items WHERE role = :role");
    $studentStmt->execute(['role' => 'student']);
    $studentMenuItems = $studentStmt->fetchAll();

    // Fetch teacher menu items from database
    $teacherStmt = $pdo->prepare("SELECT * FROM menu_items WHERE role = :role");
    $teacherStmt->execute(['role' => 'teacher']);
    $teacherMenuItems = $teacherStmt->fetchAll();
} else {
    // Fallback: Populate static mock structures for the demo UI
    $configs = [
        'school_name' => 'EduManage High School (Mock Fallback)',
        'currency' => 'BDT (Mock)'
    ];
    $studentMenuItems = [
        ['label' => 'Classroom (Mock)', 'action_name' => 'classroom', 'icon_class' => 'ph-chalkboard-teacher', 'badge_count' => 2],
        ['label' => 'Routine (Mock)', 'action_name' => 'routine', 'icon_class' => 'ph-clock', 'badge_count' => 0],
        ['label' => 'Attendance (Mock)', 'action_name' => 'attendance', 'icon_class' => 'ph-calendar-check', 'badge_count' => 0],
        ['label' => 'Results (Mock)', 'action_name' => 'results', 'icon_class' => 'ph-chart-bar', 'badge_count' => 0],
        ['label' => 'Inbox (Mock)', 'action_name' => 'inbox', 'icon_class' => 'ph-envelope-simple', 'badge_count' => 2]
    ];
    $teacherMenuItems = [
        ['label' => 'Online Class (Mock)', 'action_name' => 'online_class', 'icon_class' => 'ph-video-camera', 'badge_count' => 1],
        ['label' => 'Routine (Mock)', 'action_name' => 'routine', 'icon_class' => 'ph-clock', 'badge_count' => 0],
        ['label' => 'Inbox (Mock)', 'action_name' => 'inbox', 'icon_class' => 'ph-envelope-simple', 'badge_count' => 2]
    ];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Connectivity Demo</title>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f4f6;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .demo-container {
            width: 100%;
            max-width: 400px;
            background: white;
            padding: 24px;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        h2, h3 {
            color: #674EA7;
            margin-top: 0;
        }
        .status-alert {
            font-size: 11px;
            font-weight: bold;
            padding: 8px 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .status-alert.success {
            background-color: #e8f8f0;
            color: #2ecc71;
        }
        .status-alert.warning {
            background-color: #fef5e7;
            color: #f39c12;
        }
        .config-card {
            background-color: #f8f6fc;
            border-left: 4px solid #8E7CC3;
            padding: 12px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        .config-item {
            margin: 6px 0;
            font-size: 14px;
        }
        .menu-list {
            list-style: none;
            padding: 0;
            margin: 0 0 20px;
        }
        .menu-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            background: #fafafa;
            border: 1px solid #eeeeee;
            border-radius: 8px;
            margin-bottom: 8px;
            font-size: 14px;
        }
        .menu-item i {
            font-size: 18px;
            color: #8E7CC3;
        }
        .badge {
            margin-left: auto;
            background-color: #e74c3c;
            color: white;
            font-size: 10px;
            font-weight: bold;
            padding: 2px 8px;
            border-radius: 10px;
        }
        .badge.neutral {
            background-color: #8E7CC3;
        }
    </style>
</head>
<body>
    <div class="demo-container">
        <h2>Database Dynamic Demo</h2>
        
        <?php if ($dbAvailable): ?>
            <div class="status-alert success">
                <i class="ph-fill ph-check-circle"></i>
                Database Status: Connected (SQLite Active)
            </div>
        <?php else: ?>
            <div class="status-alert warning">
                <i class="ph-fill ph-warning"></i>
                Database Status: Fallback (SQLite/PDO Extension Missing in CLI)
            </div>
        <?php endif; ?>

        <p style="font-size: 12px; color: #666; margin-bottom: 20px;">
            This demo fetches layout sections, icons, and counts dynamically from a local SQLite database file (<code>database.sqlite</code>).
        </p>

        <!-- System configuration card -->
        <div class="config-card">
            <h3>System Settings</h3>
            <div class="config-item"><strong>School:</strong> <?php echo htmlspecialchars($configs['school_name'] ?? 'N/A'); ?></div>
            <div class="config-item"><strong>Currency:</strong> <?php echo htmlspecialchars($configs['currency'] ?? 'N/A'); ?></div>
        </div>

        <!-- Student Dynamic Sections -->
        <h3>Student Menu (Dynamic)</h3>
        <ul class="menu-list">
            <?php foreach ($studentMenuItems as $item): ?>
                <li class="menu-item">
                    <i class="ph <?php echo htmlspecialchars($item['icon_class']); ?>"></i>
                    <span><?php echo htmlspecialchars($item['label']); ?></span>
                    <?php if ($item['badge_count'] > 0): ?>
                        <span class="badge <?php echo $item['action_name'] === 'classroom' ? 'neutral' : ''; ?>">
                            <?php echo $item['badge_count']; ?>
                        </span>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>

        <!-- Teacher Dynamic Sections -->
        <h3>Teacher Menu (Dynamic)</h3>
        <ul class="menu-list">
            <?php foreach ($teacherMenuItems as $item): ?>
                <li class="menu-item">
                    <i class="ph <?php echo htmlspecialchars($item['icon_class']); ?>"></i>
                    <span><?php echo htmlspecialchars($item['label']); ?></span>
                    <?php if ($item['badge_count'] > 0): ?>
                        <span class="badge">
                            <?php echo $item['badge_count']; ?>
                        </span>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>
