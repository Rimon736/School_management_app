<div id="teacherRoutineView" class="view active">
    <div class="routine-container">
        <div class="routine-nav">
            <button class="routine-day-btn" id="tbtn-Saturday" onclick="selectTeacherRoutineDay('Saturday')">Sat</button>
            <button class="routine-day-btn" id="tbtn-Sunday" onclick="selectTeacherRoutineDay('Sunday')">Sun</button>
            <button class="routine-day-btn" id="tbtn-Monday" onclick="selectTeacherRoutineDay('Monday')">Mon</button>
            <button class="routine-day-btn" id="tbtn-Tuesday" onclick="selectTeacherRoutineDay('Tuesday')">Tue</button>
            <button class="routine-day-btn" id="tbtn-Wednesday" onclick="selectTeacherRoutineDay('Wednesday')">Wed</button>
            <button class="routine-day-btn" id="tbtn-Thursday" onclick="selectTeacherRoutineDay('Thursday')">Thu</button>
            <button class="routine-day-btn" id="tbtn-Friday" onclick="selectTeacherRoutineDay('Friday')">Fri</button>
        </div>
        <div class="routine-section">
            <div class="section-header routine-title" style="padding-left: 0; margin-bottom: 6px;">Teacher Schedule</div>
            <div class="routine-section-note">7-day schedule including classes, staff meetings, and exam duties.</div>
            
            <?php foreach ($routine as $day => $classes): ?>
                <div class="teacher-routine-panel" id="troutine-<?php echo $day; ?>" style="display: none;">
                    <?php if (empty($classes)): ?>
                        <div style="text-align: center; padding: 25px; color: var(--text-light); font-size: 13px;">No classes or events scheduled for <?php echo $day; ?>.</div>
                    <?php else: ?>
                        <?php foreach ($classes as $item): ?>
                            <div class="bkash-list-item" onclick="showToast('<?php echo htmlspecialchars(addslashes($item['title'])); ?> Details')">
                                <div class="bkash-list-icon" style="background: <?php echo $item['iconBg']; ?>; color: <?php echo $item['iconColor']; ?>;">
                                    <i class="ph <?php echo $item['icon']; ?>"></i>
                                </div>
                                <div class="bkash-list-content">
                                    <div class="bkash-list-title"><?php echo htmlspecialchars($item['title']); ?></div>
                                    <div class="bkash-list-subtitle"><?php echo htmlspecialchars($item['subtitle']); ?></div>
                                </div>
                                <div class="bkash-list-right">
                                    <div class="bkash-list-value"><?php echo htmlspecialchars($item['value']); ?></div>
                                    <div class="bkash-list-subvalue" style="color: var(--brand-color);"><?php echo htmlspecialchars($item['subvalue']); ?></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const dayNames = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
    const todayName = dayNames[new Date().getDay()];
    selectTeacherRoutineDay(todayName);
});
</script>
