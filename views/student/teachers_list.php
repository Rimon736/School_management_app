<div id="teachersView" class="view active">
    <div class="teachers-container">
        <div class="section-header routine-title" style="padding-left: 0; margin-bottom: 6px;">Faculty Directory</div>
        <div class="routine-section-note">School teachers and administrators list. Tap the phone icon to copy their contact.</div>
        <div id="teachersListContainer" class="teachers-list-grid">
            <?php foreach ($teachers as $t): ?>
                <div class="teacher-card" style="padding: 12px; align-items: center; border: 1px solid var(--border-color); background: white; border-radius: 14px; margin-bottom: 10px; display: flex; gap: 12px;">
                    <div class="teacher-avatar" style="width: 44px; height: 44px; border-radius: 50%; overflow: hidden; background: #e6e0f8; display: flex; align-items: center; justify-content: center;">
                        <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=<?php echo htmlspecialchars($t['avatar']); ?>&backgroundColor=E6E0F8" alt="<?php echo htmlspecialchars($t['name']); ?>" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <div class="teacher-info" style="flex: 1;">
                        <div class="teacher-name" style="font-size: 14px; font-weight: bold; color: var(--text-main);"><?php echo htmlspecialchars($t['name']); ?></div>
                        <div class="teacher-designation" style="font-size: 11px; color: var(--text-light);"><?php echo htmlspecialchars($t['designation']); ?></div>
                    </div>
                    <div class="teacher-actions" onclick="copyToClipboard('<?php echo htmlspecialchars($t['phone']); ?>')" style="cursor: pointer; width: 32px; height: 32px; border-radius: 50%; background: rgba(142, 124, 195, 0.1); color: var(--brand-color); display: flex; align-items: center; justify-content: center;">
                        <i class="ph ph-phone"></i>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
