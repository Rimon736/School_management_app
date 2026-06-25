<div id="teacherStudentAttendanceView" class="view active" style="overflow-y: auto; padding: 16px; box-sizing: border-box; height: 100%;">
    <div class="attendance-take-container">
        
        <?php if (isset($_SESSION['toast'])): ?>
            <div style="background: rgba(46, 204, 113, 0.08); color: #2ecc71; border: 1px solid rgba(46, 204, 113, 0.15); padding: 10px 12px; border-radius: 8px; font-size: 12px; margin-bottom: 15px; width: 100%; display: flex; align-items: center; gap: 8px;">
                <i class="ph ph-check-circle" style="font-size: 18px; flex-shrink: 0;"></i>
                <span><?php echo htmlspecialchars($_SESSION['toast']); unset($_SESSION['toast']); ?></span>
            </div>
        <?php endif; ?>

        <!-- Filter Form -->
        <form method="GET" action="index.php" style="background: var(--white); border: 1px solid var(--border-color); padding: 16px; border-radius: 14px; margin-bottom: 16px; display: flex; flex-direction: column; gap: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.02);">
            <input type="hidden" name="controller" value="teacher">
            <input type="hidden" name="action" value="student_attendance">
            
            <div style="display: flex; gap: 8px; box-sizing: border-box;">
                <div style="flex: 1;">
                    <label style="font-size: 11px; color: var(--text-light); font-weight: bold; text-transform: uppercase;">Select Date</label>
                    <input type="date" name="date" value="<?php echo htmlspecialchars($selectedDate); ?>" required style="width: 100%; border: 1px solid var(--border-color); border-radius: 8px; padding: 8px 10px; font-size: 13px; outline: none; margin-top: 4px; box-sizing: border-box;">
                </div>
                <div style="flex: 1;">
                    <label style="font-size: 11px; color: var(--text-light); font-weight: bold; text-transform: uppercase;">Class</label>
                    <select name="class" required style="width: 100%; border: 1px solid var(--border-color); border-radius: 8px; padding: 8px 10px; font-size: 13px; outline: none; margin-top: 4px; box-sizing: border-box; background: #fff;">
                        <option value="Class 8" <?php echo $selectedClass === 'Class 8' ? 'selected' : ''; ?>>Class 8</option>
                        <option value="Class 6" <?php echo $selectedClass === 'Class 6' ? 'selected' : ''; ?>>Class 6</option>
                        <option value="Class 7" <?php echo $selectedClass === 'Class 7' ? 'selected' : ''; ?>>Class 7</option>
                        <option value="Class 9" <?php echo $selectedClass === 'Class 9' ? 'selected' : ''; ?>>Class 9</option>
                        <option value="Class 10" <?php echo $selectedClass === 'Class 10' ? 'selected' : ''; ?>>Class 10</option>
                    </select>
                </div>
            </div>
            <div>
                <label style="font-size: 11px; color: var(--text-light); font-weight: bold; text-transform: uppercase;">Section</label>
                <select name="section" required style="width: 100%; border: 1px solid var(--border-color); border-radius: 8px; padding: 8px 10px; font-size: 13px; outline: none; margin-top: 4px; box-sizing: border-box; background: #fff;">
                    <option value="Padma" <?php echo $selectedSection === 'Padma' ? 'selected' : ''; ?>>Padma</option>
                    <option value="Meghna" <?php echo $selectedSection === 'Meghna' ? 'selected' : ''; ?>>Meghna</option>
                    <option value="Jamuna" <?php echo $selectedSection === 'Jamuna' ? 'selected' : ''; ?>>Jamuna</option>
                </select>
            </div>
            <button type="submit" class="pay-now-btn" style="margin-top: 4px; border-radius: 12px; width: 100%; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 5px;">
                <i class="ph ph-funnel"></i> Reveal Student List
            </button>
        </form>

        <!-- Attendance List -->
        <?php if (!empty($selectedClass) && !empty($selectedSection)): ?>
            <form method="POST" action="?controller=teacher&action=save_attendance_process">
                <input type="hidden" name="date" value="<?php echo htmlspecialchars($selectedDate); ?>">
                <input type="hidden" name="class" value="<?php echo htmlspecialchars($selectedClass); ?>">
                <input type="hidden" name="section" value="<?php echo htmlspecialchars($selectedSection); ?>">
                
                <div style="display: flex; gap: 8px; margin-bottom: 12px; box-sizing: border-box;">
                    <button type="button" onclick="setAll('P')" style="flex: 1; padding: 10px; font-size: 12px; font-weight: bold; background: rgba(46, 204, 113, 0.08); color: #2ecc71; border: 1px solid rgba(46, 204, 113, 0.2); border-radius: 8px; cursor: pointer; transition: background-color 0.2s;">Present All</button>
                    <button type="button" onclick="setAll('A')" style="flex: 1; padding: 10px; font-size: 12px; font-weight: bold; background: rgba(231, 76, 60, 0.08); color: #e74c3c; border: 1px solid rgba(231, 76, 60, 0.2); border-radius: 8px; cursor: pointer; transition: background-color 0.2s;">Absent All</button>
                </div>

                <div class="teachers-list-grid">
                    <?php if (empty($students)): ?>
                        <div class="empty-state-routine" style="padding: 20px; text-align: center; color: var(--text-light);">No students found in this section.</div>
                    <?php else: ?>
                        <?php foreach ($students as $s): ?>
                            <div class="teacher-card" style="padding: 16px; border: 1px solid var(--border-color); background: white; border-radius: 14px; margin-bottom: 12px; display: flex; flex-direction: column; gap: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.01);">
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <div class="teacher-avatar" style="width: 40px; height: 40px; border-radius: 50%; overflow: hidden; background: #e6e0f8; display: flex; align-items: center; justify-content: center;">
                                        <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=<?php echo htmlspecialchars($s['avatar']); ?>&backgroundColor=E6E0F8" alt="<?php echo htmlspecialchars($s['full_name']); ?>" style="width: 100%; height: 100%; object-fit: cover;">
                                    </div>
                                    <div style="flex: 1;">
                                        <div style="font-weight: bold; font-size: 14px; color: var(--text-main);"><?php echo htmlspecialchars($s['full_name']); ?></div>
                                        <div style="font-size: 11px; color: var(--text-light);">Roll: <?php echo $s['roll']; ?> | ID: <?php echo htmlspecialchars($s['id']); ?></div>
                                    </div>
                                </div>

                                <div style="display: flex; gap: 6px;">
                                    <label style="flex: 1; text-align: center;">
                                        <input type="radio" name="attendance[<?php echo $s['user_id']; ?>]" value="P" <?php echo $s['status'] === 'P' ? 'checked' : ''; ?> style="display: none;" class="att-radio radio-p">
                                        <span class="att-btn btn-p" style="display: block; padding: 10px; border-radius: 8px; border: 1px solid var(--border-color); background: #f9f9f9; font-size: 12px; font-weight: bold; cursor: pointer; color: var(--text-light);">Present</span>
                                    </label>
                                    <label style="flex: 1; text-align: center;">
                                        <input type="radio" name="attendance[<?php echo $s['user_id']; ?>]" value="A" <?php echo $s['status'] === 'A' ? 'checked' : ''; ?> style="display: none;" class="att-radio radio-a">
                                        <span class="att-btn btn-a" style="display: block; padding: 10px; border-radius: 8px; border: 1px solid var(--border-color); background: #f9f9f9; font-size: 12px; font-weight: bold; cursor: pointer; color: var(--text-light);">Absent</span>
                                    </label>
                                    <label style="flex: 1; text-align: center;">
                                        <input type="radio" name="attendance[<?php echo $s['user_id']; ?>]" value="L" <?php echo $s['status'] === 'L' ? 'checked' : ''; ?> style="display: none;" class="att-radio radio-l">
                                        <span class="att-btn btn-l" style="display: block; padding: 10px; border-radius: 8px; border: 1px solid var(--border-color); background: #f9f9f9; font-size: 12px; font-weight: bold; cursor: pointer; color: var(--text-light);">Late</span>
                                    </label>
                                </div>

                                <div>
                                    <input type="text" name="comments[<?php echo $s['user_id']; ?>]" value="<?php echo htmlspecialchars($s['comments']); ?>" placeholder="Add remarks (optional)..." style="width: 100%; border: 1px solid var(--border-color); border-radius: 8px; padding: 8px 12px; font-size: 12px; outline: none; box-sizing: border-box;">
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <?php if (!empty($students)): ?>
                    <button type="submit" class="pay-now-btn" style="margin-top: 16px; background: var(--brand-color); box-shadow: 0 10px 18px rgba(142, 124, 195, 0.2); border-radius: 12px; width: 100%; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px;">
                        <i class="ph ph-floppy-disk" style="font-size: 18px;"></i> Save Attendance
                    </button>
                <?php endif; ?>
            </form>
        <?php endif; ?>
    </div>
</div>

<style>
/* Attendance radio styling hooks */
.att-radio:checked + .btn-p {
    background: #2ecc71 !important;
    border-color: #2ecc71 !important;
    color: white !important;
}
.att-radio:checked + .btn-a {
    background: #e74c3c !important;
    border-color: #e74c3c !important;
    color: white !important;
}
.att-radio:checked + .btn-l {
    background: #f39c12 !important;
    border-color: #f39c12 !important;
    color: white !important;
}
</style>

<script>
function setAll(status) {
    var radios = document.querySelectorAll('.radio-' + status.toLowerCase());
    radios.forEach(function(r) {
        r.checked = true;
    });
}
</script>
