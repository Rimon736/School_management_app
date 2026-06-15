<div id="routineView" class="view active">
    <div class="routine-container">
        <div class="routine-nav">
            <button class="routine-day-btn" id="btn-Saturday" onclick="selectRoutineDay('Saturday')">Sat</button>
            <button class="routine-day-btn" id="btn-Sunday" onclick="selectRoutineDay('Sunday')">Sun</button>
            <button class="routine-day-btn" id="btn-Monday" onclick="selectRoutineDay('Monday')">Mon</button>
            <button class="routine-day-btn" id="btn-Tuesday" onclick="selectRoutineDay('Tuesday')">Tue</button>
            <button class="routine-day-btn" id="btn-Wednesday" onclick="selectRoutineDay('Wednesday')">Wed</button>
            <button class="routine-day-btn" id="btn-Thursday" onclick="selectRoutineDay('Thursday')">Thu</button>
        </div>
        <div class="routine-section">
            <div class="section-header routine-title" style="padding-left: 0; margin-bottom: 6px;">Class Routine</div>
            <div class="routine-section-note">Weekly school classes for the regular academic day.</div>
            
            <?php foreach ($routine as $day => $classes): ?>
                <div class="day-routine-panel" id="routine-<?php echo $day; ?>" style="display: none;">
                    <?php if (empty($classes)): ?>
                        <div style="text-align: center; padding: 25px; color: var(--text-light); font-size: 13px;">No classes scheduled for <?php echo $day; ?>.</div>
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
        
        <div class="routine-section" style="margin-top: 20px;">
            <div class="section-header routine-title" style="padding-left: 0; margin-bottom: 6px;">Exam Routine</div>
            <div class="routine-section-note">Upcoming term exam timetable for the school.</div>
            <?php if (empty($examRoutine)): ?>
                <div style="text-align: center; padding: 25px; color: var(--text-light); font-size: 13px;">No exam routines scheduled.</div>
            <?php else: ?>
                <?php foreach ($examRoutine as $item): ?>
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
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const dayNames = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
    const todayName = dayNames[new Date().getDay()];
    const targetDay = (todayName === 'Friday') ? 'Saturday' : todayName;
    selectRoutineDay(targetDay);
});
</script>
