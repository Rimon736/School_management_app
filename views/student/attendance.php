<div id="attendanceView" class="view active">
    <div class="att-container">
        <div class="month-navigator">
            <div class="nav-arrow" onclick="changeAttMonth(-1)"><i class="ph ph-caret-left"></i></div>
            <div class="current-month" id="calMonthDisplay">November 2024</div>
            <div class="nav-arrow" onclick="changeAttMonth(1)"><i class="ph ph-caret-right"></i></div>
        </div>
        <div class="bkash-calendar-card">
            <div class="legend">
                <div class="legend-item"><div class="dot present"></div> Present</div>
                <div class="legend-item"><div class="dot absent"></div> Absent</div>
                <div class="legend-item"><div class="dot leave"></div> Leave</div>
            </div>
            <div class="bkash-calendar-grid" id="calGridContainer"></div>
        </div>
        <div class="att-stats">
            <div class="stat-box">
                <div class="stat-val" style="color: var(--brand-color);" id="attTotal">0</div>
                <div class="stat-label">Total Classes</div>
            </div>
            <div class="stat-box">
                <div class="stat-val" style="color: #2ecc71;" id="attPresent">0</div>
                <div class="stat-label">Present</div>
            </div>
            <div class="stat-box">
                <div class="stat-val" style="color: #e74c3c;" id="attAbsent">0</div>
                <div class="stat-label">Absent</div>
            </div>
        </div>
        
        <div class="section-header" style="padding-left: 0;">Recent Records</div>
        <div id="attListContainer"></div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    if (typeof renderAttendance === 'function') {
        renderAttendance();
    }
});
</script>
