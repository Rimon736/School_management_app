<div id="teacherStudentListView" class="view active">
    <div class="student-list-container" style="padding: 16px;">
        <div style="background: var(--white); border: 1px solid var(--border-color); padding: 16px; border-radius: 14px; margin-bottom: 16px; display: flex; flex-direction: column; gap: 12px;">
            <div style="display: flex; gap: 8px;">
                <div style="flex: 1;">
                    <label style="font-size: 11px; color: var(--text-light); font-weight: bold; text-transform: uppercase;">Class</label>
                    <select id="studentListClass" style="width: 100%; border: 1px solid var(--border-color); border-radius: 8px; padding: 8px 12px; font-size: 13px; outline: none; margin-top: 4px;">
                        <option value="Class 8">Class 8</option>
                        <option value="Class 6">Class 6</option>
                        <option value="Class 7">Class 7</option>
                        <option value="Class 9">Class 9</option>
                        <option value="Class 10">Class 10</option>
                    </select>
                </div>
                <div style="flex: 1;">
                    <label style="font-size: 11px; color: var(--text-light); font-weight: bold; text-transform: uppercase;">Section</label>
                    <select id="studentListSection" style="width: 100%; border: 1px solid var(--border-color); border-radius: 8px; padding: 8px 12px; font-size: 13px; outline: none; margin-top: 4px;">
                        <option value="Padma">Padma</option>
                        <option value="Meghna">Meghna</option>
                        <option value="Jamuna">Jamuna</option>
                    </select>
                </div>
            </div>
            <button class="pay-now-btn" onclick="revealStudentDirectoryList()" style="border-radius: 12px;">
                <i class="ph ph-list-magnifying-glass"></i> View Student Directory
            </button>
        </div>

        <div id="studentDirectoryListSection" style="display: none;">
            <div id="studentDirectoryListContainer" class="teachers-list-grid"></div>
        </div>
    </div>
</div>
