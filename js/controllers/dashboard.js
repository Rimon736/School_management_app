// Dashboard controller
import { rolesData, dummyViewData, buildBkashList } from '../data.js';
import { renderAttendance } from './attendance.js';

export function renderRole(currentRole) {
    const data = rolesData[currentRole];
    const viewData = dummyViewData[currentRole];

    if (!data || !viewData) {
        console.error(`Missing data for role: ${currentRole}`);
        return;
    }

    // Helper functions to set element properties safely
    const setTxt = (id, val) => {
        const el = document.getElementById(id);
        if (el) el.innerText = val;
    };

    const setSrc = (id, val) => {
        const el = document.getElementById(id);
        if (el) el.src = val;
    };

    const setHtml = (id, val) => {
        const el = document.getElementById(id);
        if (el) el.innerHTML = val;
    };

    // Header
    const avatarUrl = `https://api.dicebear.com/7.x/avataaars/svg?seed=${data.avatarSeed}&backgroundColor=8E7CC3`;
    setTxt('userName', data.name);
    setTxt('userRole', data.roleLabel);
    setSrc('userAvatar', avatarUrl);
    
    const balanceIcon = document.getElementById('balanceIcon');
    if (balanceIcon) balanceIcon.className = `ph-fill ${data.balanceIcon}`;
    setTxt('currentRoleBadge', data.roleLabel);

    // Profile
    setTxt('innerProfileName', data.name);
    setSrc('innerProfileAvatar', avatarUrl);
    if (viewData.profile) {
        setTxt('innerProfileId', `ID: ${viewData.profile.id}`);
        setTxt('profileClass', viewData.profile.classRole);
        setTxt('profileRollLabel', viewData.profile.rollLabel);
        setTxt('profileRoll', viewData.profile.roll);
        setTxt('profileField1Label', viewData.profile.field1Label);
        setTxt('profileField1', viewData.profile.field1Val);
        setTxt('profileField2Label', viewData.profile.field2Label);
        setTxt('profileField2', viewData.profile.field2Val);
        setTxt('profileAddress', viewData.profile.address);
        setTxt('profilePhone', viewData.profile.phone);
        setTxt('profileNationality', viewData.profile.nationality);
        setTxt('profileDOB', viewData.profile.dob);
    }

    // Classroom rendering
    if (viewData.classroom) {
        const onlineHTML = (viewData.classroom.online || []).map(c => `
            <div class="classroom-card">
                <div class="classroom-card-details">
                    <h4>${c.title}</h4>
                    <p><i class="ph ph-user"></i> ${c.subtitle} | <i class="ph ph-clock"></i> ${c.time}</p>
                </div>
                <button class="classroom-join-btn" onclick="window.showToast('Joining zoom...'); window.open('${c.link}', '_blank');">
                    <i class="ph-fill ph-video-camera"></i> Join
                </button>
            </div>
        `).join('') || `<div class="empty-state-routine">No live classes scheduled</div>`;
        setHtml('onlineClassesList', onlineHTML);

        const recordedHTML = (viewData.classroom.recorded || []).map(c => `
            <div class="classroom-card" onclick="window.showToast('Playing recorded lecture...')">
                <div class="classroom-card-details">
                    <h4>${c.title}</h4>
                    <p><i class="ph ph-tag"></i> ${c.topic} | <i class="ph ph-clock"></i> ${c.duration} | ${c.subtitle}</p>
                </div>
                <div class="teacher-phone-btn"><i class="ph-fill ph-play"></i></div>
            </div>
        `).join('') || `<div class="empty-state-routine">No recorded lectures uploaded</div>`;
        setHtml('recordedClassesList', recordedHTML);
    }

    // Routine rendering (Auto-detect day)
    if (viewData.classRoutine) {
        const dayNames = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        const todayIndex = new Date().getDay();
        let defaultDay = dayNames[todayIndex];
        if (defaultDay === 'Friday') defaultDay = 'Saturday'; // Friday is weekend, default to Saturday
        
        selectRoutineDay(defaultDay);
    }
    
    if (viewData.examRoutine) {
        const examEl = document.getElementById('examRoutineContainer');
        if (examEl) examEl.innerHTML = buildBkashList(viewData.examRoutine);
    }
    
    if (viewData.finance && viewData.finance.history) {
        setHtml('financeHistoryContainer', buildBkashList(viewData.finance.history));
    }

    // Results rendering with Collapsible subject breakdowns
    if (viewData.results && viewData.results.terms) {
        const termResultsHTML = viewData.results.terms.map((term, index) => {
            const subjectsHTML = (term.subjects || []).map(s => `
                <tr>
                    <td>${s.name}</td>
                    <td>${s.marks}</td>
                    <td><strong>${s.grade}</strong></td>
                    <td>${typeof s.gpa === 'number' ? s.gpa.toFixed(2) : s.gpa}</td>
                </tr>
            `).join('');

            return `
                <div class="term-result-card" onclick="toggleResultBreakdown(this)">
                    <div class="term-result-header">
                        <div>
                            <div class="term-result-term">${term.term}</div>
                            <div class="term-result-note">${term.note}</div>
                        </div>
                        <div class="term-result-grade">${term.grade}</div>
                    </div>
                    <div class="term-result-grid">
                        <div>
                            <span>Total</span>
                            <strong>${term.total}</strong>
                        </div>
                        <div>
                            <span>GPA</span>
                            <strong>${term.gpa}</strong>
                        </div>
                        <div>
                            <span>Position</span>
                            <strong>${term.position}</strong>
                        </div>
                    </div>
                    <div class="term-result-details" style="display: none;" onclick="event.stopPropagation()">
                        <h4>Subject-wise breakdown</h4>
                        <table class="breakdown-table">
                            <thead>
                                <tr>
                                    <th>Subject</th>
                                    <th>Marks</th>
                                    <th>Grade</th>
                                    <th>GPA</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${subjectsHTML}
                            </tbody>
                        </table>
                    </div>
                    <div class="term-result-toggle-hint">Tap to show subject details</div>
                </div>
            `;
        }).join('');
        setHtml('termResultsContainer', termResultsHTML);
    }

    // Teachers List rendering
    if (viewData.teachers) {
        const teachersHTML = viewData.teachers.map(t => `
            <div class="teacher-card">
                <div class="teacher-avatar">
                    <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=${t.avatar}&backgroundColor=E6E0F8" alt="${t.name}">
                </div>
                <div class="teacher-info">
                    <div class="teacher-name">${t.name}</div>
                    <div class="teacher-designation">${t.designation}</div>
                </div>
                <div class="teacher-phone-btn" onclick="copyToClipboard('${t.phone}'); event.stopPropagation();">
                    <i class="ph ph-phone"></i>
                </div>
            </div>
        `).join('');
        setHtml('teachersListContainer', teachersHTML);
    }

    renderAttendance();

    // Render academic calendar as well if available
    const acadCalGrid = document.getElementById('acadCalGridContainer');
    if (acadCalGrid) {
        import('./attendance.js').then(m => {
            if (m.renderAcademicCalendar) m.renderAcademicCalendar();
        });
    }

    if (viewData.finance) {
        setTxt('financeTitle', viewData.finance.title);
        setTxt('financeAmount', viewData.finance.amount);
    }

    // Grid Menu
    if (data.grid) {
        const gridHTML = data.grid.map(item => `
            <div class="grid-item" onclick='${item.action}'>
                <div class="icon-circle ${item.color}"><i class="ph ${item.icon}"></i></div>
                <span>${item.label}</span>
            </div>
        `).join('');
        setHtml('mainGrid', gridHTML);

        // Populate side menu dynamically to match the grid menu actions
        const sideMenuHTML = `
            <li class="sm-item" onclick="switchRole()" style="background-color: #f4f0fa; font-weight: 500;">
                <i class="ph ph-arrows-left-right" style="color: var(--brand-color);"></i> Switch Role
                <span class="sm-badge" id="currentRoleBadge">${data.roleLabel}</span>
            </li>
            ${data.grid.map(item => `
                <li class="sm-item" onclick='${item.action}'>
                    <i class="ph ${item.icon}"></i> ${item.label}
                </li>
            `).join('')}
            <li class="sm-item" onclick="logout()">
                <i class="ph ph-sign-out"></i> Log out
            </li>
        `;
        setHtml('sideMenuListContainer', sideMenuHTML);
    }

    // Quick Features
    if (data.quick) {
        const quickHTML = data.quick.map(item => `
            <div class="qf-card" onclick='${item.action}'>
                <i class="ph ${item.icon}" style="color: ${item.color};"></i>
                <span>${item.label}</span>
            </div>
        `).join('');
        setHtml('quickFeatures', quickHTML);
    }
}

// Global functions for views interactions
export function selectRoutineDay(dayName) {
    const role = (document.getElementById('currentRoleBadge')?.innerText.toLowerCase() === 'teacher') ? 'teacher' : 'student';
    const routineData = dummyViewData[role].classRoutine;
    
    // Highlight day pill
    document.querySelectorAll('.routine-day-btn').forEach(btn => {
        if (btn.innerText.trim().toLowerCase() === dayName.substring(0, 3).toLowerCase()) {
            btn.classList.add('active');
        } else {
            btn.classList.remove('active');
        }
    });

    const container = document.getElementById('classRoutineContainer');
    if (!container) return;

    const items = routineData ? routineData[dayName] : null;
    if (!items || items.length === 0) {
        container.innerHTML = `<div class="empty-state-routine">No classes scheduled for ${dayName}</div>`;
    } else {
        container.innerHTML = buildBkashList(items);
    }
}

export function switchClassroomTab(tabName) {
    document.querySelectorAll('.classroom-tab').forEach(btn => btn.classList.remove('active'));
    document.querySelectorAll('.classroom-panel').forEach(panel => panel.classList.remove('active'));
    
    if (tabName === 'online') {
        const tabEl = document.querySelector('.classroom-tab:nth-child(1)');
        if (tabEl) tabEl.classList.add('active');
        const panelEl = document.getElementById('onlineClassesList');
        if (panelEl) panelEl.classList.add('active');
    } else {
        const tabEl = document.querySelector('.classroom-tab:nth-child(2)');
        if (tabEl) tabEl.classList.add('active');
        const panelEl = document.getElementById('recordedClassesList');
        if (panelEl) panelEl.classList.add('active');
    }
}

export function toggleResultBreakdown(cardEl) {
    const details = cardEl.querySelector('.term-result-details');
    const hint = cardEl.querySelector('.term-result-toggle-hint');
    if (!details) return;

    if (details.style.display === 'none') {
        details.style.display = 'block';
        if (hint) hint.innerText = 'Tap to hide details';
    } else {
        details.style.display = 'none';
        if (hint) hint.innerText = 'Tap to show subject details';
    }
}

export function copyToClipboard(phoneNum) {
    if (navigator.clipboard && navigator.clipboard.writeText) {
        navigator.clipboard.writeText(phoneNum).then(() => {
            window.showToast('Number copied!');
        }).catch(err => {
            console.error('Clipboard copy failed:', err);
            fallbackCopy(phoneNum);
        });
    } else {
        fallbackCopy(phoneNum);
    }
}

function fallbackCopy(text) {
    const textArea = document.createElement("textarea");
    textArea.value = text;
    textArea.style.position = "fixed";  // Avoid scrolling to bottom
    document.body.appendChild(textArea);
    textArea.focus();
    textArea.select();
    try {
        document.execCommand('copy');
        window.showToast('Number copied!');
    } catch (err) {
        console.error('Fallback copy failed:', err);
        window.showToast('Failed to copy');
    }
    document.body.removeChild(textArea);
}

// Assign to window for global inline event handlers
window.selectRoutineDay = selectRoutineDay;
window.switchClassroomTab = switchClassroomTab;
window.toggleResultBreakdown = toggleResultBreakdown;
window.copyToClipboard = copyToClipboard;
