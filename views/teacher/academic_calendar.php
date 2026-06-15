<div id="acadCalendarView" class="view active">
    <div class="acad-cal-container">
        <div class="month-navigator">
            <div class="nav-arrow" onclick="changeAcadMonth(-1)"><i class="ph ph-caret-left"></i></div>
            <div class="current-month" id="acadCalMonthDisplay">November 2024</div>
            <div class="nav-arrow" onclick="changeAcadMonth(1)"><i class="ph ph-caret-right"></i></div>
        </div>
        <div class="bkash-calendar-card">
            <div class="legend">
                <div class="legend-item"><div class="dot class-day"></div> Class Day</div>
                <div class="legend-item"><div class="dot exam-day"></div> Exam</div>
                <div class="legend-item"><div class="dot holiday"></div> Holiday</div>
            </div>
            <div class="bkash-calendar-grid" id="acadCalGridContainer"></div>
        </div>
        <div class="section-header" style="padding-left: 0;">Academic Events</div>
        <div id="acadEventsList"></div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    if (typeof renderAcademicCalendar === 'function') {
        renderAcademicCalendar();
    }
});
</script>
