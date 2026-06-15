<div id="teacherPersonalAttendanceView" class="view active">
    <div class="att-container">
        <div class="month-navigator">
            <div class="nav-arrow" onclick="changeTeacherPersonalAttMonth(-1)"><i class="ph ph-caret-left"></i></div>
            <div class="current-month" id="teacherPersonalCalMonthDisplay">November 2024</div>
            <div class="nav-arrow" onclick="changeTeacherPersonalAttMonth(1)"><i class="ph ph-caret-right"></i></div>
        </div>
        <div class="bkash-calendar-card">
            <div class="legend">
                <div class="legend-item"><div class="dot present"></div> Present</div>
                <div class="legend-item"><div class="dot absent"></div> Absent</div>
                <div class="legend-item"><div class="dot leave"></div> Leave</div>
            </div>
            <div class="bkash-calendar-grid" id="teacherPersonalCalGridContainer"></div>
        </div>
        <div class="att-stats">
            <div class="stat-box">
                <div class="stat-val" style="color: var(--brand-color);" id="teacherPersonalAttTotal">0</div>
                <div class="stat-label">Total Days</div>
            </div>
            <div class="stat-box">
                <div class="stat-val" style="color: #2ecc71;" id="teacherPersonalAttPresent">0</div>
                <div class="stat-label">Present</div>
            </div>
            <div class="stat-box">
                <div class="stat-val" style="color: #e74c3c;" id="teacherPersonalAttAbsent">0</div>
                <div class="stat-label">Absent</div>
            </div>
        </div>
        <div class="section-header" style="padding-left: 0;">Attendance Log</div>
        <div id="teacherPersonalAttListContainer"></div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    if (typeof renderTeacherPersonalAttendance === 'function') {
        renderTeacherPersonalAttendance();
    }
});
</script>
