<div id="teacherStudentListView" class="view active" style="overflow-y: auto; padding: 16px; box-sizing: border-box; height: 100%;">
    <div class="student-list-container">
        
        <?php if (isset($_SESSION['toast'])): ?>
            <div style="background: rgba(46, 204, 113, 0.08); color: #2ecc71; border: 1px solid rgba(46, 204, 113, 0.15); padding: 10px 12px; border-radius: 8px; font-size: 12px; margin-bottom: 15px; width: 100%; display: flex; align-items: center; gap: 8px;">
                <i class="ph ph-check-circle" style="font-size: 18px; flex-shrink: 0;"></i>
                <span><?php echo htmlspecialchars($_SESSION['toast']); unset($_SESSION['toast']); ?></span>
            </div>
        <?php endif; ?>

        <!-- Filter Form -->
        <form method="GET" action="index.php" style="background: var(--white); border: 1px solid var(--border-color); padding: 16px; border-radius: 14px; margin-bottom: 16px; display: flex; flex-direction: column; gap: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.02);">
            <input type="hidden" name="controller" value="teacher">
            <input type="hidden" name="action" value="student_list">
            
            <div style="display: flex; gap: 8px; box-sizing: border-box;">
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
                <div style="flex: 1;">
                    <label style="font-size: 11px; color: var(--text-light); font-weight: bold; text-transform: uppercase;">Section</label>
                    <select name="section" required style="width: 100%; border: 1px solid var(--border-color); border-radius: 8px; padding: 8px 10px; font-size: 13px; outline: none; margin-top: 4px; box-sizing: border-box; background: #fff;">
                        <option value="Padma" <?php echo $selectedSection === 'Padma' ? 'selected' : ''; ?>>Padma</option>
                        <option value="Meghna" <?php echo $selectedSection === 'Meghna' ? 'selected' : ''; ?>>Meghna</option>
                        <option value="Jamuna" <?php echo $selectedSection === 'Jamuna' ? 'selected' : ''; ?>>Jamuna</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="pay-now-btn" style="border-radius: 12px; width: 100%; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 5px;">
                <i class="ph ph-list-magnifying-glass"></i> View Student Directory
            </button>
        </form>

        <!-- Directory List -->
        <?php if (!empty($selectedClass) && !empty($selectedSection)): ?>
            <div id="studentDirectoryListSection">
                <div class="teachers-list-grid">
                    <?php if (empty($students)): ?>
                        <div class="empty-state-routine" style="padding: 20px; text-align: center; color: var(--text-light);">No students found in this section.</div>
                    <?php else: ?>
                        <?php foreach ($students as $s): ?>
                            <div class="teacher-card" style="padding: 12px; align-items: center; border: 1px solid var(--border-color); background: white; border-radius: 14px; margin-bottom: 10px; display: flex; gap: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.01);">
                                <div class="teacher-avatar" style="width: 44px; height: 44px; border-radius: 50%; overflow: hidden; background: #e6e0f8; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                    <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=<?php echo htmlspecialchars($s['avatar']); ?>&backgroundColor=E6E0F8" alt="<?php echo htmlspecialchars($s['full_name']); ?>" style="width: 100%; height: 100%; object-fit: cover;">
                                </div>
                                <div class="teacher-info" style="flex: 1;">
                                    <div class="teacher-name" style="font-size: 14px; font-weight: bold; color: var(--text-main);"><?php echo htmlspecialchars($s['full_name']); ?></div>
                                    <div class="teacher-designation" style="font-size: 11px; color: var(--text-light);">ID: <?php echo htmlspecialchars($s['uniq_id']); ?> | Roll: <?php echo $s['roll']; ?></div>
                                    <div style="font-size: 11px; color: var(--text-light); margin-top: 2px;"><i class="ph ph-phone"></i> <?php echo htmlspecialchars($s['phone']); ?></div>
                                </div>
                                <button class="routine-day-btn" onclick="editStudent(<?php echo $s['id']; ?>, '<?php echo addslashes($s['full_name']); ?>', '<?php echo addslashes($s['phone']); ?>', '<?php echo addslashes($selectedClass); ?>', '<?php echo addslashes($selectedSection); ?>')" style="margin: 0; padding: 6px 12px; font-size: 11px; background: rgba(142,124,195,0.08); color: var(--brand-color); border: 1px solid var(--brand-color); border-radius: 8px; font-weight: bold; cursor: pointer;">
                                    <i class="ph ph-pencil-simple"></i> Edit
                                </button>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
function editStudent(id, currentName, currentPhone, classVal, sectionVal) {
    var name = prompt("Edit Name for student:", currentName);
    if (name === null || name.trim() === "") return;
    var phone = prompt("Edit Phone for student:", currentPhone);
    if (phone === null || phone.trim() === "") return;
    
    var form = document.createElement('form');
    form.method = 'POST';
    form.action = '?controller=teacher&action=edit_student_process';
    
    var fields = {
        id: id,
        name: name,
        phone: phone,
        class: classVal,
        section: sectionVal
    };
    
    for (var key in fields) {
        var input = document.createElement('input');
        input.type = 'hidden';
        input.name = key;
        input.value = fields[key];
        form.appendChild(input);
    }
    
    document.body.appendChild(form);
    form.submit();
}
</script>
