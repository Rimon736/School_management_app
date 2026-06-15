<div id="teacherOnlineClassView" class="view active">
    <div class="routine-container">
        <button class="pay-now-btn" onclick="scheduleOnlineClass()" style="margin-bottom: 20px; border-radius: 12px;">
            <i class="ph ph-plus-circle"></i> Schedule Class
        </button>
        <div class="section-header" style="padding-left: 0;">Scheduled Classes</div>
        <div id="teacherOnlineClassList" class="teachers-list-grid"></div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    if (typeof renderScheduledClasses === 'function') {
        renderScheduledClasses();
    }
});
</script>
