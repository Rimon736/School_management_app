<div id="teacherOnlineClassView" class="view active" style="overflow-y: auto; padding: 16px; box-sizing: border-box; height: 100%;">
    <div class="routine-container">
        <!-- Collapsible Schedule Class Form -->
        <div id="scheduleFormContainer" style="background: white; border: 1px solid var(--border-color); border-radius: 16px; padding: 16px; margin-bottom: 20px; box-sizing: border-box; display: none; box-shadow: 0 4px 12px rgba(0,0,0,0.03);">
            <div style="font-weight: bold; color: var(--text-main); font-size: 15px; margin-bottom: 12px; display: flex; justify-content: space-between; align-items: center;">
                <span>Schedule New Class</span>
                <i class="ph ph-x" onclick="toggleScheduleForm()" style="cursor: pointer; font-size: 18px; color: var(--text-light);"></i>
            </div>
            <form method="POST" action="?controller=teacher&action=schedule_class_process" style="display: flex; flex-direction: column; gap: 12px;">
                <div style="display: flex; flex-direction: column; gap: 4px; text-align: left;">
                    <label style="font-size: 11px; font-weight: bold; color: var(--text-main); text-transform: uppercase;">Class Title</label>
                    <input type="text" name="title" required placeholder="e.g. Class 8 Bangla 1st Paper" style="padding: 10px; border: 1px solid var(--border-color); border-radius: 8px; font-size: 13px; outline: none; box-sizing: border-box;">
                </div>
                <div style="display: flex; flex-direction: column; gap: 4px; text-align: left;">
                    <label style="font-size: 11px; font-weight: bold; color: var(--text-main); text-transform: uppercase;">Time / Date</label>
                    <input type="text" name="time" required placeholder="e.g. Today, 11:30 AM" style="padding: 10px; border: 1px solid var(--border-color); border-radius: 8px; font-size: 13px; outline: none; box-sizing: border-box;">
                </div>
                <div style="display: flex; flex-direction: column; gap: 4px; text-align: left;">
                    <label style="font-size: 11px; font-weight: bold; color: var(--text-main); text-transform: uppercase;">Meeting Link</label>
                    <input type="url" name="link" required placeholder="https://meet.google.com/..." style="padding: 10px; border: 1px solid var(--border-color); border-radius: 8px; font-size: 13px; outline: none; box-sizing: border-box;">
                </div>
                <button type="submit" style="background: var(--brand-color); color: white; border: none; padding: 12px; border-radius: 8px; font-weight: bold; cursor: pointer; font-size: 13px; margin-top: 5px; box-shadow: 0 4px 10px rgba(142,124,195,0.15);">
                    Save Schedule
                </button>
            </form>
        </div>

        <button class="pay-now-btn" id="showFormBtn" onclick="toggleScheduleForm()" style="margin-bottom: 20px; border-radius: 12px; width: 100%; display: flex; align-items: center; justify-content: center; gap: 8px; box-shadow: 0 4px 10px rgba(142,124,195,0.15); border: none; cursor: pointer;">
            <i class="ph ph-plus-circle" style="font-size: 18px;"></i> Schedule Class
        </button>

        <div class="section-header" style="padding-left: 0; margin-bottom: 12px;">Scheduled Classes</div>
        <div id="teacherOnlineClassList" class="teachers-list-grid">
            <?php if (empty($classroom['online'])): ?>
                <div class="empty-state-routine" style="padding: 30px; text-align: center; color: var(--text-light);">No scheduled classes</div>
            <?php else: ?>
                <?php foreach ($classroom['online'] as $c): ?>
                    <div class="teacher-card" style="padding: 16px; flex-direction: column; align-items: stretch; gap: 10px; background: white; border: 1px solid var(--border-color); border-radius: 14px; margin-bottom: 12px; display: flex;">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div style="font-weight: bold; color: var(--text-main); font-size: 15px;"><?php echo htmlspecialchars($c['title']); ?></div>
                            <span style="font-size: 11px; background: rgba(142,124,195,0.1); color: var(--brand-color); padding: 4px 8px; border-radius: 20px; font-weight: bold;">Live</span>
                        </div>
                        <div style="font-size: 13px; color: var(--text-light); display: flex; flex-direction: column; gap: 4px;">
                            <div><i class="ph ph-calendar-blank"></i> Date/Time: <?php echo htmlspecialchars($c['time']); ?></div>
                            <div><i class="ph ph-link"></i> Link: <a href="<?php echo htmlspecialchars($c['link']); ?>" target="_blank" style="color: var(--brand-color); text-decoration: underline; word-break: break-all;"><?php echo htmlspecialchars($c['link']); ?></a></div>
                        </div>
                        <div style="display: flex; gap: 8px; margin-top: 4px; box-sizing: border-box;">
                            <a href="<?php echo htmlspecialchars($c['link']); ?>" target="_blank" class="classroom-join-btn" style="flex: 1; text-align: center; text-decoration: none; padding: 10px; font-size: 12px; border-radius: 8px; display: flex; align-items: center; justify-content: center; gap: 5px; font-weight: bold; background: var(--brand-color); color: white; border: none; cursor: pointer;">
                                <i class="ph ph-video-camera"></i> Start Class
                            </a>
                            <a href="?controller=teacher&action=delete_class&id=<?php echo $c['id']; ?>" onclick="return confirm('Are you sure you want to delete this scheduled class?')" style="padding: 8px 12px; margin: 0; background: rgba(231, 76, 60, 0.08); color: #e74c3c; border: 1px solid rgba(231, 76, 60, 0.2); border-radius: 8px; display: flex; align-items: center; justify-content: center; text-decoration: none; cursor: pointer;">
                                <i class="ph ph-trash" style="font-size: 16px;"></i>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
function toggleScheduleForm() {
    var form = document.getElementById('scheduleFormContainer');
    var btn = document.getElementById('showFormBtn');
    if (form.style.display === 'none') {
        form.style.display = 'block';
        btn.style.display = 'none';
    } else {
        form.style.display = 'none';
        btn.style.display = 'flex';
    }
}
</script>
