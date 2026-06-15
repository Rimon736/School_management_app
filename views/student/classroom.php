<div id="classroomView" class="view active">
    <div class="classroom-tabs">
        <button class="classroom-tab active" id="tab-online" onclick="switchClassroomTab('online')">Online Classes</button>
        <button class="classroom-tab" id="tab-recorded" onclick="switchClassroomTab('recorded')">Recorded Classes</button>
    </div>
    
    <div id="onlineClassesList" class="classroom-panel active">
        <?php if (empty($classroom['online'])): ?>
            <div style="text-align: center; padding: 30px; color: var(--text-light);">No online classes scheduled today.</div>
        <?php else: ?>
            <?php foreach ($classroom['online'] as $c): ?>
                <div class="bkash-list-item" onclick="window.open('<?php echo htmlspecialchars($c['link']); ?>', '_blank')">
                    <div class="bkash-list-icon" style="background: <?php echo $c['iconBg']; ?>; color: <?php echo $c['iconColor']; ?>;">
                        <i class="ph <?php echo $c['icon']; ?>"></i>
                    </div>
                    <div class="bkash-list-content">
                        <div class="bkash-list-title"><?php echo htmlspecialchars($c['title']); ?></div>
                        <div class="bkash-list-subtitle"><?php echo htmlspecialchars($c['subtitle']); ?></div>
                    </div>
                    <div class="bkash-list-right">
                        <div class="bkash-list-value"><?php echo htmlspecialchars($c['time']); ?></div>
                        <div class="bkash-list-subvalue join-link" style="color: var(--brand-color); font-weight: bold;">JOIN</div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    
    <div id="recordedClassesList" class="classroom-panel">
        <?php if (empty($classroom['recorded'])): ?>
            <div style="text-align: center; padding: 30px; color: var(--text-light);">No recorded classes available.</div>
        <?php else: ?>
            <?php foreach ($classroom['recorded'] as $c): ?>
                <div class="bkash-list-item" onclick="showToast('Playing <?php echo htmlspecialchars(addslashes($c['title'])); ?>')">
                    <div class="bkash-list-icon" style="background: <?php echo $c['iconBg']; ?>; color: <?php echo $c['iconColor']; ?>;">
                        <i class="ph <?php echo $c['icon']; ?>"></i>
                    </div>
                    <div class="bkash-list-content">
                        <div class="bkash-list-title"><?php echo htmlspecialchars($c['title']); ?></div>
                        <div class="bkash-list-subtitle"><?php echo htmlspecialchars($c['subtitle']); ?></div>
                    </div>
                    <div class="bkash-list-right">
                        <div class="bkash-list-value"><?php echo htmlspecialchars($c['duration']); ?></div>
                        <div class="bkash-list-subvalue" style="color: var(--text-light);"><?php echo htmlspecialchars($c['topic']); ?></div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
