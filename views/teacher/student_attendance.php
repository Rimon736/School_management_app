<div id="teacherStudentAttendanceView" class="view active">
    <div class="attendance-take-container" style="padding: 16px;">
        <div style="background: var(--white); border: 1px solid var(--border-color); padding: 16px; border-radius: 14px; margin-bottom: 16px; display: flex; flex-direction: column; gap: 12px;">
            <div style="display: flex; gap: 8px;">
                <div style="flex: 1;">
                    <label style="font-size: 11px; color: var(--text-light); font-weight: bold; text-transform: uppercase;">Select Date</label>
                    <input type="date" id="takeAttDate" style="width: 100%; border: 1px solid var(--border-color); border-radius: 8px; padding: 8px 12px; font-size: 13px; outline: none; margin-top: 4px;">
                </div>
                <div style="flex: 1;">
                    <label style="font-size: 11px; color: var(--text-light); font-weight: bold; text-transform: uppercase;">Class</label>
                    <select id="takeAttClass" style="width: 100%; border: 1px solid var(--border-color); border-radius: 8px; padding: 8px 12px; font-size: 13px; outline: none; margin-top: 4px;">
                        <option value="Class 8">Class 8</option>
                        <option value="Class 6">Class 6</option>
                        <option value="Class 7">Class 7</option>
                        <option value="Class 9">Class 9</option>
                        <option value="Class 10">Class 10</option>
                    </select>
                </div>
            </div>
            <div>
                <label style="font-size: 11px; color: var(--text-light); font-weight: bold; text-transform: uppercase;">Section</label>
                <select id="takeAttSection" style="width: 100%; border: 1px solid var(--border-color); border-radius: 8px; padding: 8px 12px; font-size: 13px; outline: none; margin-top: 4px;">
                    <option value="Padma">Padma</option>
                    <option value="Meghna">Meghna</option>
                    <option value="Jamuna">Jamuna</option>
                </select>
            </div>
            <button class="pay-now-btn" onclick="revealTakeAttendanceList()" style="margin-top: 4px; border-radius: 12px;">
                <i class="ph ph-funnel"></i> Reveal Student List
            </button>
        </div>

        <div id="takeAttendanceListSection" style="display: none;">
            <div style="display: flex; gap: 8px; margin-bottom: 12px;">
                <button class="routine-day-btn" onclick="toggleAllAttendance('present')" style="flex: 1; padding: 8px; font-size: 12px; font-weight: bold; background: rgba(46, 204, 113, 0.1); color: #2ecc71; border: 1px solid #2ecc71;">Present All</button>
                <button class="routine-day-btn" onclick="toggleAllAttendance('absent')" style="flex: 1; padding: 8px; font-size: 12px; font-weight: bold; background: rgba(231, 76, 60, 0.1); color: #e74c3c; border: 1px solid #e74c3c;">Absent All</button>
            </div>
            <div id="takeAttendanceListContainer" class="teachers-list-grid"></div>
            <button class="pay-now-btn" onclick="saveAttendanceRecord()" style="margin-top: 16px; background: var(--brand-color); box-shadow: 0 10px 18px rgba(142, 124, 195, 0.28); border-radius: 12px;">
                <i class="ph ph-floppy-disk"></i> Save Attendance
            </button>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const dateInput = document.getElementById('takeAttDate');
    if (dateInput) {
        dateInput.value = new Date().toISOString().substring(0, 10);
    }
});
</script>
