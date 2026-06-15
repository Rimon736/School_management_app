<div id="teacherMarkEntryView" class="view active">
    <div class="mark-entry-container" style="padding: 16px;">
        <button id="markEntryBackBtn" class="see-more-btn" onclick="goBackMarkEntryStep()" style="display: none; margin-bottom: 12px; width: 100%; justify-content: center; border-radius: 12px; padding: 12px;">
            <i class="ph ph-arrow-left"></i> Go Back
        </button>
        <div id="markEntryPanel"></div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    if (typeof renderMarkEntry === 'function') {
        renderMarkEntry();
    }
});
</script>
