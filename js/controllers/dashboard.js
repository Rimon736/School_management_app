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

    // Teacher specific profile details
    if (currentRole === 'teacher' && viewData.profile) {
        setTxt('teacherProfileName', viewData.profile.name || data.name);
        setTxt('teacherProfileDesignation', viewData.profile.designation || 'Principal & Tech Head');
        setTxt('teacherProfileDept', viewData.profile.dept || 'General Section');
        setTxt('teacherProfileLevel', viewData.profile.level || 'Class Teacher, Grade 8');
        setTxt('teacherProfileEmail', viewData.profile.email || 'anisul.islam@edumanage.com');
        setTxt('teacherProfileContact', viewData.profile.phone || '01819-123456');
        setTxt('teacherProfileOffice', viewData.profile.officePhone || '+880-2-998877');
        setTxt('teacherProfileBlood', viewData.profile.bloodGroup || 'O+ (Positive)');
        setTxt('teacherProfileJoin', viewData.profile.joiningDate || '12 Jan 2015');
        setTxt('teacherProfileAddress', viewData.profile.address || 'Dhanmondi, Dhaka');
        setTxt('teacherProfileDOB', viewData.profile.dob || '04 Oct 1985');
        setTxt('teacherProfileNID', viewData.profile.nid || '1985263598741');
        const tAvatarUrl = `https://api.dicebear.com/7.x/avataaars/svg?seed=${viewData.profile.avatarSeed || data.avatarSeed}&backgroundColor=8E7CC3`;
        setSrc('teacherProfileAvatar', tAvatarUrl);
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
    if (viewData.classRoutine || viewData.teacherRoutine) {
        const dayNames = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        const todayIndex = new Date().getDay();
        let defaultDay = dayNames[todayIndex];
        if (defaultDay === 'Friday' && currentRole !== 'teacher') defaultDay = 'Saturday'; // Friday is weekend, default to Saturday
        
        if (currentRole === 'teacher') {
            // Wait slightly for DOM or define directly
            setTimeout(() => { selectTeacherRoutineDay(defaultDay); }, 10);
        } else {
            selectRoutineDay(defaultDay);
        }
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

    if (currentRole === 'teacher') {
        renderScheduledClasses();
        renderMarkEntry();
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

// Dummy data structures for Teacher features
export let markEntryState = {
    step: 1, // 1: Category, 2: Term, 3: Test List, 4: Class, 5: Section, 6: Subject, 7: Edit Mode
    category: '',
    term: '',
    test: '',
    class: '',
    section: '',
    subject: ''
};

export let markEntryTests = [
    { id: 'ct1', name: 'Class Test 1', category: 'Class Test', term: '1st Term' },
    { id: 'ct2', name: 'Class Test 2', category: 'Class Test', term: '1st Term' },
    { id: 'mt1', name: 'Model Test 1', category: 'Model Test', term: '1st Term' },
    { id: 'term1', name: 'Term Exam', category: 'Term Exam', term: '1st Term' }
];

export let markEntryStudents = [
    { roll: 1, name: 'Anisur Rahman', marks: 85, remarks: 'Excellent performance' },
    { roll: 2, name: 'Fatema Khatun', marks: 78, remarks: 'Good progress' },
    { roll: 3, name: 'Jamil Mahmud', marks: 92, remarks: 'Very attentive' },
    { roll: 4, name: 'Tariqul Islam', marks: 64, remarks: 'Needs improvement' },
    { roll: 5, name: 'Sadia Sultana', marks: 88, remarks: 'Consistently good' }
];

export let attendanceStudents = [
    { roll: 1, name: 'Anisur Rahman', status: 'present', remarks: '' },
    { roll: 2, name: 'Fatema Khatun', status: 'present', remarks: '' },
    { roll: 3, name: 'Jamil Mahmud', status: 'present', remarks: '' },
    { roll: 4, name: 'Tariqul Islam', status: 'present', remarks: '' },
    { roll: 5, name: 'Sadia Sultana', status: 'present', remarks: '' }
];

export let studentDirectoryList = [
    { id: '2026-EDU-1001', name: 'Tahmid Hasan', roll: 1, phone: '01712-112233', avatar: 'Tahmid' },
    { id: '2026-EDU-1002', name: 'Nusrat Jahan', roll: 2, phone: '01712-445566', avatar: 'Nusrat' },
    { id: '2026-EDU-1003', name: 'Jamil Mahmud', roll: 3, phone: '01712-345678', avatar: 'Jamil' },
    { id: '2026-EDU-1004', name: 'Farhan Kabir', roll: 4, phone: '01819-223344', avatar: 'Farhan' },
    { id: '2026-EDU-1005', name: 'Ayesha Akter', roll: 5, phone: '01911-556677', avatar: 'Ayesha' }
];

// --- TEACHER ROUTINE SCHEDULE ---
export function selectTeacherRoutineDay(dayName) {
    const routineData = dummyViewData.teacher.teacherRoutine;
    
    // Highlight day pill
    document.querySelectorAll('#teacherRoutineView .routine-day-btn').forEach(btn => {
        if (btn.innerText.trim().toLowerCase() === dayName.substring(0, 3).toLowerCase()) {
            btn.classList.add('active');
        } else {
            btn.classList.remove('active');
        }
    });

    const container = document.getElementById('teacherRoutineContainer');
    if (!container) return;

    const items = routineData ? routineData[dayName] : null;
    if (!items || items.length === 0) {
        container.innerHTML = `<div class="empty-state-routine">No classes scheduled for ${dayName}</div>`;
    } else {
        container.innerHTML = buildBkashList(items);
    }
}

// --- ONLINE CLASS SCHEDULING ---
export function renderScheduledClasses() {
    const listContainer = document.getElementById('teacherOnlineClassList');
    if (!listContainer) return;

    const classes = dummyViewData.teacher.classroom.online || [];
    if (classes.length === 0) {
        listContainer.innerHTML = `<div class="empty-state-routine">No scheduled classes</div>`;
        return;
    }

    listContainer.innerHTML = classes.map((c, index) => `
        <div class="teacher-card" style="padding: 16px; flex-direction: column; align-items: stretch; gap: 10px; background: white;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div style="font-weight: bold; color: var(--text-main); font-size: 15px;">${c.title}</div>
                <div style="font-size: 11px; background: rgba(142,124,195,0.1); color: var(--brand-color); padding: 4px 8px; border-radius: 20px; font-weight: bold;">Live</div>
            </div>
            <div style="font-size: 13px; color: var(--text-light); display: flex; flex-direction: column; gap: 4px;">
                <div><i class="ph ph-calendar-blank"></i> Date/Time: ${c.time || '10:00 AM'}</div>
                <div><i class="ph ph-link"></i> Link: <a href="${c.link}" target="_blank" style="color: var(--brand-color); text-decoration: underline; word-break: break-all;">${c.link}</a></div>
            </div>
            <div style="display: flex; gap: 8px; margin-top: 4px;">
                <button class="classroom-join-btn" onclick="window.showToast('Launching class...'); window.open('${c.link}', '_blank');" style="flex: 1; margin: 0; padding: 8px; font-size: 12px; border-radius: 8px;">
                    <i class="ph ph-video-camera"></i> Start Class
                </button>
                <button class="routine-day-btn" onclick="deleteScheduledClass(${index})" style="padding: 8px 12px; margin: 0; background: rgba(231, 76, 60, 0.1); color: #e74c3c; border: 1px solid #e74c3c; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                    <i class="ph ph-trash" style="font-size: 16px;"></i>
                </button>
            </div>
        </div>
    `).join('');
}

export function scheduleOnlineClass() {
    const title = prompt("Enter Class Title (e.g. Class 8 Bangla 2nd Paper):", "Class 8 Bangla");
    if (!title) return;
    const date = prompt("Enter Date and Time (e.g. Today, 11:30 AM):", "Today, 11:30 AM");
    if (!date) return;
    const link = prompt("Enter Meeting Link:", "https://meet.google.com/xyz-pqrs-tuv");
    if (!link) return;

    if (!dummyViewData.teacher.classroom) {
        dummyViewData.teacher.classroom = { online: [], recorded: [] };
    }
    dummyViewData.teacher.classroom.online.push({
        title: title,
        subtitle: 'Teacher Class',
        icon: 'ph-video-camera',
        iconBg: 'rgba(142, 124, 195, 0.08)',
        iconColor: 'var(--brand-color)',
        link: link,
        time: date
    });

    renderScheduledClasses();
    window.showToast("Class Scheduled Successfully");
}

export function deleteScheduledClass(index) {
    if (confirm("Are you sure you want to delete this scheduled class?")) {
        dummyViewData.teacher.classroom.online.splice(index, 1);
        renderScheduledClasses();
        window.showToast("Class Deleted");
    }
}

// --- MARK ENTRY HIERARCHY ---
export function renderMarkEntry() {
    const container = document.getElementById('markEntryPanel');
    if (!container) return;

    const backBtn = document.getElementById('markEntryBackBtn');
    if (backBtn) {
        backBtn.style.display = markEntryState.step > 1 ? 'flex' : 'none';
    }

    if (markEntryState.step === 1) {
        container.innerHTML = `
            <div class="section-header" style="padding-left: 0; font-weight: bold; font-size: 15px; margin-bottom: 6px;">Select Mark Category</div>
            <div class="routine-section-note" style="margin-bottom: 16px;">Choose which type of marks you want to enter.</div>
            <div style="display: flex; flex-direction: column; gap: 12px;">
                <button class="pay-now-btn" onclick="selectMarkCategory('Class Test')" style="background: white; border: 1px solid var(--border-color); color: var(--text-main); font-weight: 500; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 5px rgba(0,0,0,0.02); margin-top: 0; padding: 14px 16px; border-radius: 12px;">
                    <span>Class Test</span> <i class="ph ph-caret-right" style="color: var(--brand-color);"></i>
                </button>
                <button class="pay-now-btn" onclick="selectMarkCategory('Model Test')" style="background: white; border: 1px solid var(--border-color); color: var(--text-main); font-weight: 500; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 5px rgba(0,0,0,0.02); margin-top: 0; padding: 14px 16px; border-radius: 12px;">
                    <span>Model Test</span> <i class="ph ph-caret-right" style="color: var(--brand-color);"></i>
                </button>
                <button class="pay-now-btn" onclick="selectMarkCategory('Term Exam')" style="background: white; border: 1px solid var(--border-color); color: var(--text-main); font-weight: 500; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 5px rgba(0,0,0,0.02); margin-top: 0; padding: 14px 16px; border-radius: 12px;">
                    <span>Term Exam</span> <i class="ph ph-caret-right" style="color: var(--brand-color);"></i>
                </button>
            </div>
        `;
    } else if (markEntryState.step === 2) {
        container.innerHTML = `
            <div class="section-header" style="padding-left: 0; font-weight: bold; font-size: 15px; margin-bottom: 2px;">Select Term/Session</div>
            <div style="font-size: 12px; color: var(--brand-color); font-weight: 500; margin-bottom: 16px;"><i class="ph ph-tag"></i> Category: ${markEntryState.category}</div>
            <div style="display: flex; flex-direction: column; gap: 12px;">
                <button class="pay-now-btn" onclick="selectMarkTerm('1st Term')" style="background: white; border: 1px solid var(--border-color); color: var(--text-main); font-weight: 500; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 5px rgba(0,0,0,0.02); margin-top: 0; padding: 14px 16px; border-radius: 12px;">
                    <span>1st Term</span> <i class="ph ph-caret-right" style="color: var(--brand-color);"></i>
                </button>
                <button class="pay-now-btn" onclick="selectMarkTerm('Mid Term')" style="background: white; border: 1px solid var(--border-color); color: var(--text-main); font-weight: 500; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 5px rgba(0,0,0,0.02); margin-top: 0; padding: 14px 16px; border-radius: 12px;">
                    <span>Mid Term</span> <i class="ph ph-caret-right" style="color: var(--brand-color);"></i>
                </button>
                <button class="pay-now-btn" onclick="selectMarkTerm('Final Term')" style="background: white; border: 1px solid var(--border-color); color: var(--text-main); font-weight: 500; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 5px rgba(0,0,0,0.02); margin-top: 0; padding: 14px 16px; border-radius: 12px;">
                    <span>Final Term</span> <i class="ph ph-caret-right" style="color: var(--brand-color);"></i>
                </button>
            </div>
        `;
    } else if (markEntryState.step === 3) {
        const filteredTests = markEntryTests.filter(t => t.category === markEntryState.category && t.term === markEntryState.term);
        container.innerHTML = `
            <div class="section-header" style="padding-left: 0; font-weight: bold; font-size: 15px; margin-bottom: 2px;">Select Test</div>
            <div style="font-size: 12px; color: var(--brand-color); font-weight: 500; margin-bottom: 16px;"><i class="ph ph-tag"></i> Category: ${markEntryState.category} | Term: ${markEntryState.term}</div>
            
            <button class="pay-now-btn" onclick="addMarkNewTest()" style="margin-top: 0; margin-bottom: 16px; background: var(--brand-color); box-shadow: 0 4px 10px rgba(142,124,195,0.25); border-radius: 12px;">
                <i class="ph ph-plus-circle"></i> Add New Test
            </button>
            
            <div style="display: flex; flex-direction: column; gap: 12px;">
                ${filteredTests.length === 0 ? `
                    <div style="text-align: center; padding: 20px; color: var(--text-light); font-size: 13px;">No tests found. Click "Add New Test" to create one.</div>
                ` : filteredTests.map(t => `
                    <button class="pay-now-btn" onclick="selectMarkTest('${t.name}')" style="background: white; border: 1px solid var(--border-color); color: var(--text-main); font-weight: 500; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 5px rgba(0,0,0,0.02); margin-top: 0; padding: 14px 16px; border-radius: 12px;">
                        <span>${t.name}</span> <i class="ph ph-caret-right" style="color: var(--brand-color);"></i>
                    </button>
                `).join('')}
            </div>
        `;
    } else if (markEntryState.step === 4) {
        container.innerHTML = `
            <div class="section-header" style="padding-left: 0; font-weight: bold; font-size: 15px; margin-bottom: 2px;">Select Class (Level)</div>
            <div style="font-size: 12px; color: var(--brand-color); font-weight: 500; margin-bottom: 16px;"><i class="ph ph-tag"></i> Test: ${markEntryState.test}</div>
            <div style="display: flex; flex-direction: column; gap: 12px;">
                ${['Class 6', 'Class 7', 'Class 8', 'Class 9', 'Class 10'].map(c => `
                    <button class="pay-now-btn" onclick="selectMarkClass('${c}')" style="background: white; border: 1px solid var(--border-color); color: var(--text-main); font-weight: 500; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 5px rgba(0,0,0,0.02); margin-top: 0; padding: 14px 16px; border-radius: 12px;">
                        <span>${c}</span> <i class="ph ph-caret-right" style="color: var(--brand-color);"></i>
                    </button>
                `).join('')}
            </div>
        `;
    } else if (markEntryState.step === 5) {
        container.innerHTML = `
            <div class="section-header" style="padding-left: 0; font-weight: bold; font-size: 15px; margin-bottom: 2px;">Select Section</div>
            <div style="font-size: 12px; color: var(--brand-color); font-weight: 500; margin-bottom: 16px;"><i class="ph ph-tag"></i> Class: ${markEntryState.class}</div>
            <div style="display: flex; flex-direction: column; gap: 12px;">
                ${['Padma', 'Meghna', 'Jamuna'].map(sec => `
                    <button class="pay-now-btn" onclick="selectMarkSection('${sec}')" style="background: white; border: 1px solid var(--border-color); color: var(--text-main); font-weight: 500; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 5px rgba(0,0,0,0.02); margin-top: 0; padding: 14px 16px; border-radius: 12px;">
                        <span>Section ${sec}</span> <i class="ph ph-caret-right" style="color: var(--brand-color);"></i>
                    </button>
                `).join('')}
            </div>
        `;
    } else if (markEntryState.step === 6) {
        container.innerHTML = `
            <div class="section-header" style="padding-left: 0; font-weight: bold; font-size: 15px; margin-bottom: 2px;">Select Subject</div>
            <div style="font-size: 12px; color: var(--brand-color); font-weight: 500; margin-bottom: 16px;"><i class="ph ph-tag"></i> Class: ${markEntryState.class} | Section: ${markEntryState.section}</div>
            <div style="display: flex; flex-direction: column; gap: 12px;">
                ${['Bangla', 'English', 'Mathematics', 'Science'].map(sub => `
                    <div style="background: white; border: 1px solid var(--border-color); padding: 14px 16px; border-radius: 12px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 5px rgba(0,0,0,0.02);">
                        <span style="font-weight: 600; color: var(--text-main); font-size: 14px;">${sub}</span>
                        <button class="classroom-join-btn" onclick="selectMarkSubject('${sub}')" style="margin: 0; padding: 8px 16px; font-size: 12px; border-radius: 8px;">
                            <i class="ph ph-pencil-simple"></i> View/Edit
                        </button>
                    </div>
                `).join('')}
            </div>
        `;
    } else if (markEntryState.step === 7) {
        container.innerHTML = `
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                <div>
                    <div class="section-header" style="padding-left: 0; font-weight: bold; font-size: 15px; margin-bottom: 2px;">Enter Marks</div>
                    <div style="font-size: 11px; color: var(--text-light); font-weight: 500;">
                        ${markEntryState.class} - ${markEntryState.section} | ${markEntryState.subject}
                    </div>
                </div>
                <div id="autoSaveStatus" style="font-size: 12px; color: #2ecc71; display: flex; align-items: center; gap: 4px; font-weight: 500;">
                    <i class="ph ph-cloud-check"></i> Saved
                </div>
            </div>

            <div style="display: flex; flex-direction: column; gap: 14px;">
                ${markEntryStudents.map(s => `
                    <div class="teacher-card" style="padding: 14px; flex-direction: column; align-items: stretch; gap: 10px; background: white; border: 1px solid var(--border-color); border-radius: 14px; box-shadow: 0 2px 8px rgba(0,0,0,0.02);">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div style="font-weight: bold; color: var(--text-main); font-size: 14px;">
                                Roll: ${s.roll} | ${s.name}
                            </div>
                        </div>
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <span style="font-size: 12px; font-weight: bold; color: var(--text-light);">Marks:</span>
                            <div style="display: flex; align-items: center; border: 1px solid var(--border-color); border-radius: 8px; overflow: hidden; background: #f9f9f9; width: 120px; height: 32px;">
                                <button onclick="stepMark(${s.roll}, -1)" style="border: none; background: none; width: 32px; height: 100%; cursor: pointer; color: var(--brand-color); font-weight: bold; font-size: 16px; display: flex; align-items: center; justify-content: center;">-</button>
                                <input type="number" id="mark_input_${s.roll}" value="${s.marks}" onchange="updateMarkVal(${s.roll}, this.value)" style="border: none; background: none; width: 56px; height: 100%; text-align: center; font-weight: bold; font-size: 14px; outline: none; border-left: 1px solid var(--border-color); border-right: 1px solid var(--border-color); -moz-appearance: textfield;">
                                <button onclick="stepMark(${s.roll}, 1)" style="border: none; background: none; width: 32px; height: 100%; cursor: pointer; color: var(--brand-color); font-weight: bold; font-size: 16px; display: flex; align-items: center; justify-content: center;">+</button>
                            </div>
                        </div>
                        <div style="display: flex; flex-direction: column; gap: 4px;">
                            <span style="font-size: 10px; font-weight: bold; color: var(--text-light); text-transform: uppercase;">Remarks</span>
                            <input type="text" value="${s.remarks}" oninput="triggerAutoSave(${s.roll}, 'remarks', this.value)" style="width: 100%; border: 1px solid var(--border-color); border-radius: 8px; padding: 6px 10px; font-size: 12px; outline: none;" placeholder="Enter remark...">
                        </div>
                    </div>
                `).join('')}
            </div>

            <button class="pay-now-btn" onclick="saveAllMarks()" style="margin-top: 20px; background: var(--brand-color); box-shadow: 0 10px 18px rgba(142, 124, 195, 0.28); border-radius: 12px;">
                <i class="ph ph-floppy-disk"></i> Complete Entry & Lock
            </button>
        `;
    }
}

export function goBackMarkEntryStep() {
    if (markEntryState.step > 1) {
        markEntryState.step--;
        renderMarkEntry();
    }
}

export function selectMarkCategory(cat) {
    markEntryState.category = cat;
    markEntryState.step = 2;
    renderMarkEntry();
}

export function selectMarkTerm(term) {
    markEntryState.term = term;
    markEntryState.step = 3;
    renderMarkEntry();
}

export function selectMarkTest(test) {
    markEntryState.test = test;
    markEntryState.step = 4;
    renderMarkEntry();
}

export function addMarkNewTest() {
    const name = prompt("Enter Test Name:", "Class Test 3");
    if (!name) return;
    markEntryTests.push({
        id: 'ct_' + Date.now(),
        name: name,
        category: markEntryState.category,
        term: markEntryState.term
    });
    renderMarkEntry();
    window.showToast("New test added!");
}

export function selectMarkClass(cls) {
    markEntryState.class = cls;
    markEntryState.step = 5;
    renderMarkEntry();
}

export function selectMarkSection(sec) {
    markEntryState.section = sec;
    markEntryState.step = 6;
    renderMarkEntry();
}

export function selectMarkSubject(sub) {
    markEntryState.subject = sub;
    markEntryState.step = 7;
    renderMarkEntry();
}

export function stepMark(roll, delta) {
    const student = markEntryStudents.find(s => s.roll === roll);
    if (student) {
        student.marks = Math.max(0, Math.min(100, student.marks + delta));
        const inputEl = document.getElementById(`mark_input_${roll}`);
        if (inputEl) inputEl.value = student.marks;
        triggerAutoSave(roll, 'marks', student.marks);
    }
}

export function updateMarkVal(roll, val) {
    const student = markEntryStudents.find(s => s.roll === roll);
    if (student) {
        const parsed = parseInt(val, 10);
        student.marks = isNaN(parsed) ? 0 : Math.max(0, Math.min(100, parsed));
        triggerAutoSave(roll, 'marks', student.marks);
    }
}

let saveTimeout;
export function triggerAutoSave(roll, type, value) {
    const student = markEntryStudents.find(s => s.roll === roll);
    if (student) {
        if (type === 'remarks') {
            student.remarks = value;
        }
    }
    
    const statusEl = document.getElementById('autoSaveStatus');
    if (statusEl) {
        statusEl.innerHTML = `<i class="ph ph-spinner ph-spin" style="color: #f39c12;"></i> <span style="color: #f39c12;">Saving...</span>`;
    }
    
    clearTimeout(saveTimeout);
    saveTimeout = setTimeout(() => {
        if (statusEl) {
            statusEl.innerHTML = `<i class="ph ph-cloud-check" style="color: #2ecc71;"></i> <span style="color: #2ecc71;">Saved</span>`;
        }
    }, 600);
}

export function saveAllMarks() {
    window.showToast("Marks submitted & locked successfully!");
    markEntryState.step = 1;
    renderMarkEntry();
}

// --- STUDENT ATTENDANCE TAKING ---
export function revealTakeAttendanceList() {
    const listSection = document.getElementById('takeAttendanceListSection');
    if (listSection) {
        listSection.style.display = 'block';
    }
    
    const dateInput = document.getElementById('takeAttDate');
    if (dateInput && !dateInput.value) {
        const todayStr = new Date().toISOString().substring(0, 10);
        dateInput.value = todayStr;
    }
    
    renderTakeAttendanceList();
}

export function renderTakeAttendanceList() {
    const container = document.getElementById('takeAttendanceListContainer');
    if (!container) return;

    container.innerHTML = attendanceStudents.map(s => `
        <div class="teacher-card" style="padding: 14px; flex-direction: column; align-items: stretch; gap: 10px; border: 1px solid var(--border-color); background: white; border-radius: 14px;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div style="font-weight: bold; color: var(--text-main); font-size: 14px;">
                    Roll: ${s.roll} | ${s.name}
                </div>
            </div>
            
            <div style="display: flex; gap: 6px; margin-top: 4px;">
                <button onclick="setStudentStatus(${s.roll}, 'present')" class="routine-day-btn" style="flex: 1; padding: 8px; font-size: 12px; margin: 0; font-weight: bold; border-radius: 8px; transition: transform 0.1s;
                    ${s.status === 'present' ? 'background: #2ecc71; color: white; border: 1px solid #2ecc71;' : 'background: #f7f7f7; color: var(--text-light); border: 1px solid var(--border-color);'}">
                    Present
                </button>
                <button onclick="setStudentStatus(${s.roll}, 'absent')" class="routine-day-btn" style="flex: 1; padding: 8px; font-size: 12px; margin: 0; font-weight: bold; border-radius: 8px; transition: transform 0.1s;
                    ${s.status === 'absent' ? 'background: #e74c3c; color: white; border: 1px solid #e74c3c;' : 'background: #f7f7f7; color: var(--text-light); border: 1px solid var(--border-color);'}">
                    Absent
                </button>
                <button onclick="setStudentStatus(${s.roll}, 'late')" class="routine-day-btn" style="flex: 1; padding: 8px; font-size: 12px; margin: 0; font-weight: bold; border-radius: 8px; transition: transform 0.1s;
                    ${s.status === 'late' ? 'background: #f39c12; color: white; border: 1px solid #f39c12;' : 'background: #f7f7f7; color: var(--text-light); border: 1px solid var(--border-color);'}">
                    Late
                </button>
            </div>
            
            <div style="display: flex; flex-direction: column; gap: 4px;">
                <input type="text" id="att_remarks_${s.roll}" value="${s.remarks || ''}" oninput="updateAttendanceRemarks(${s.roll}, this.value)" style="width: 100%; border: 1px solid var(--border-color); border-radius: 8px; padding: 8px 12px; font-size: 12px; outline: none;" placeholder="Add remarks (optional)...">
            </div>
        </div>
    `).join('');
}

export function toggleAllAttendance(status) {
    attendanceStudents.forEach(s => {
        s.status = status;
    });
    renderTakeAttendanceList();
    window.showToast(`Marked all as ${status.charAt(0).toUpperCase() + status.slice(1)}`);
}

export function setStudentStatus(roll, status) {
    const student = attendanceStudents.find(s => s.roll === roll);
    if (student) {
        student.status = status;
        renderTakeAttendanceList();
    }
}

export function updateAttendanceRemarks(roll, val) {
    const student = attendanceStudents.find(s => s.roll === roll);
    if (student) {
        student.remarks = val;
    }
}

export function saveAttendanceRecord() {
    const dateInput = document.getElementById('takeAttDate')?.value || new Date().toISOString().substring(0, 10);
    const cls = document.getElementById('takeAttClass')?.value || 'Class 8';
    const sec = document.getElementById('takeAttSection')?.value || 'Padma';
    
    window.showToast(`Saved attendance for ${cls} - ${sec} on ${dateInput}`);
    
    const listSection = document.getElementById('takeAttendanceListSection');
    if (listSection) {
        listSection.style.display = 'none';
    }
}

// --- STUDENT DIRECTORY ---
export function revealStudentDirectoryList() {
    const listSection = document.getElementById('studentDirectoryListSection');
    if (listSection) {
        listSection.style.display = 'block';
    }
    renderStudentDirectoryList();
}

export function renderStudentDirectoryList() {
    const container = document.getElementById('studentDirectoryListContainer');
    if (!container) return;

    container.innerHTML = studentDirectoryList.map(s => `
        <div class="teacher-card" style="padding: 12px; align-items: center; border: 1px solid var(--border-color); background: white; border-radius: 14px; margin-bottom: 10px;">
            <div class="teacher-avatar" style="margin-right: 12px;">
                <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=${s.avatar}&backgroundColor=E6E0F8" alt="${s.name}">
            </div>
            <div class="teacher-info" style="flex: 1;">
                <div class="teacher-name" style="font-size: 14px; font-weight: bold;">${s.name}</div>
                <div class="teacher-designation" style="font-size: 11px;">ID: ${s.id} | Roll: ${s.roll}</div>
                <div style="font-size: 11px; color: var(--text-light); margin-top: 2px;"><i class="ph ph-phone"></i> ${s.phone}</div>
            </div>
            <button class="routine-day-btn" onclick="editStudentInfo('${s.id}')" style="margin: 0; padding: 6px 12px; font-size: 11px; background: rgba(142,124,195,0.1); color: var(--brand-color); border: 1px solid var(--brand-color); border-radius: 8px; font-weight: 500;">
                <i class="ph ph-pencil-simple"></i> Edit
            </button>
        </div>
    `).join('');
}

export function editStudentInfo(id) {
    const s = studentDirectoryList.find(item => item.id === id);
    if (!s) return;

    const newName = prompt(`Edit Name for ${s.name}:`, s.name);
    if (newName === null) return;
    const newPhone = prompt(`Edit Phone for ${s.name}:`, s.phone);
    if (newPhone === null) return;

    s.name = newName;
    s.phone = newPhone;
    renderStudentDirectoryList();
    window.showToast("Student profile updated!");
}

// Assign to window for global inline event handlers
window.selectRoutineDay = selectRoutineDay;
window.switchClassroomTab = switchClassroomTab;
window.toggleResultBreakdown = toggleResultBreakdown;
window.copyToClipboard = copyToClipboard;

// Teacher actions bindings
window.selectTeacherRoutineDay = selectTeacherRoutineDay;
window.scheduleOnlineClass = scheduleOnlineClass;
window.deleteScheduledClass = deleteScheduledClass;
window.renderScheduledClasses = renderScheduledClasses;

window.renderMarkEntry = renderMarkEntry;
window.goBackMarkEntryStep = goBackMarkEntryStep;
window.selectMarkCategory = selectMarkCategory;
window.selectMarkTerm = selectMarkTerm;
window.selectMarkTest = selectMarkTest;
window.addMarkNewTest = addMarkNewTest;
window.selectMarkClass = selectMarkClass;
window.selectMarkSection = selectMarkSection;
window.selectMarkSubject = selectMarkSubject;
window.stepMark = stepMark;
window.updateMarkVal = updateMarkVal;
window.triggerAutoSave = triggerAutoSave;
window.saveAllMarks = saveAllMarks;

window.revealTakeAttendanceList = revealTakeAttendanceList;
window.renderTakeAttendanceList = renderTakeAttendanceList;
window.toggleAllAttendance = toggleAllAttendance;
window.setStudentStatus = setStudentStatus;
window.updateAttendanceRemarks = updateAttendanceRemarks;
window.saveAttendanceRecord = saveAttendanceRecord;

window.revealStudentDirectoryList = revealStudentDirectoryList;
window.renderStudentDirectoryList = renderStudentDirectoryList;
window.editStudentInfo = editStudentInfo;
