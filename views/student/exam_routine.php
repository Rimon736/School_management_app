<div id="examRoutineView" class="view active">
    <div class="routine-container" style="padding: 16px;">
        <div class="routine-section">
            <div class="routine-section-note" style="margin-bottom: 12px; color: var(--text-light); font-size: 11px;">Upcoming term exam timetable for the school.</div>
            <?php if (empty($examRoutine)): ?>
                <div style="text-align: center; padding: 25px; color: var(--text-light); font-size: 13px;">No exam routines scheduled.</div>
            <?php else: ?>
                <?php foreach ($examRoutine as $item): ?>
                    <div class="bkash-list-item" onclick="showToast('<?php echo htmlspecialchars(addslashes($item['title'])); ?> Details')" style="margin-bottom: 10px;">
                        <div class="bkash-list-icon" style="background: <?php echo $item['iconBg']; ?>; color: <?php echo $item['iconColor']; ?>;">
                            <i class="ph <?php echo $item['icon']; ?>"></i>
                        </div>
                        <div class="bkash-list-content">
                            <div class="bkash-list-title" style="font-weight: 500; font-size: 12px; color: var(--text-main);"><?php echo htmlspecialchars($item['title']); ?></div>
                            <div class="bkash-list-subtitle" style="font-size: 11px; color: var(--text-light);"><?php echo htmlspecialchars($item['subtitle']); ?></div>
                        </div>
                        <div class="bkash-list-right" style="text-align: right;">
                            <div class="bkash-list-value" style="font-weight: 500; font-size: 12px; color: var(--text-main);"><?php echo htmlspecialchars($item['value']); ?></div>
                            <div class="bkash-list-subvalue" style="font-size: 11px; color: var(--brand-color);"><?php echo htmlspecialchars($item['subvalue']); ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
