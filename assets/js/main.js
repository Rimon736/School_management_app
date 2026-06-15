// Centralized JS for EduManage (Raw PHP MVC Integration)
// Contains state models, UI utilities, calendars, and FlutterBridge hooks

// --- SUPABASE CLIENT INITIALIZATION (COMMENTED OUT FOR DEMO BYPASS) ---
/*
const supabaseUrl = 'https://your-supabase-project.supabase.co';
const supabaseKey = 'your-anonymous-key';
const supabase = supabaseJS.createClient(supabaseUrl, supabaseKey);
*/

// --- ROLE CONFIGURATIONS & DATA ---
const rolesData = {
    student: {
        balanceAmount: '৳ 12,500.00'
    },
    teacher: {
        balanceAmount: '৳ 45,000.00'
    }
};

const dummyViewData = {
    teacher: {
        classroom: {
            online: [
                { title: 'Bangla 1st Paper (Class 8)', subtitle: '38 Students Registered', icon: 'ph-video-camera', iconBg: 'rgba(142, 124, 195, 0.08)', iconColor: 'var(--brand-color)', link: 'https://meet.google.com/abc-defg-hij', time: '10:00 AM' }
            ]
        }
    }
};

// --- TEACHER FEATURE DATA STATES ---
let markEntryState = {
    step: 1, // 1: Category, 2: Term, 3: Test List, 4: Class, 5: Section, 6: Subject, 7: Edit Mode
    category: '',
    term: '',
    test: '',
    class: '',
    section: '',
    subject: ''
};

let markEntryTests = [
    { id: 'ct1', name: 'Class Test 1', category: 'Class Test', term: '1st Term' },
    { id: 'ct2', name: 'Class Test 2', category: 'Class Test', term: '1st Term' },
    { id: 'mt1', name: 'Model Test 1', category: 'Model Test', term: '1st Term' },
    { id: 'term1', name: 'Term Exam', category: 'Term Exam', term: '1st Term' }
];

let markEntryStudents = [
    { roll: 1, name: 'Anisur Rahman', marks: 85, remarks: 'Excellent performance' },
    { roll: 2, name: 'Fatema Khatun', marks: 78, remarks: 'Good progress' },
    { roll: 3, name: 'Jamil Mahmud', marks: 92, remarks: 'Very attentive' },
    { roll: 4, name: 'Tariqul Islam', marks: 64, remarks: 'Needs improvement' },
    { roll: 5, name: 'Sadia Sultana', marks: 88, remarks: 'Consistently good' }
];

let attendanceStudents = [
    { roll: 1, name: 'Anisur Rahman', status: 'present', remarks: '' },
    { roll: 2, name: 'Fatema Khatun', status: 'present', remarks: '' },
    { roll: 3, name: 'Jamil Mahmud', status: 'present', remarks: '' },
    { roll: 4, name: 'Tariqul Islam', status: 'present', remarks: '' },
    { roll: 5, name: 'Sadia Sultana', status: 'present', remarks: '' }
];

let studentDirectoryList = [
    { id: '2026-EDU-1001', name: 'Tahmid Hasan', roll: 1, phone: '01712-112233', avatar: 'Tahmid' },
    { id: '2026-EDU-1002', name: 'Nusrat Jahan', roll: 2, phone: '01712-445566', avatar: 'Nusrat' },
    { id: '2026-EDU-1003', name: 'Jamil Mahmud', roll: 3, phone: '01712-345678', avatar: 'Jamil' },
    { id: '2026-EDU-1004', name: 'Farhan Kabir', roll: 4, phone: '01819-223344', avatar: 'Farhan' },
    { id: '2026-EDU-1005', name: 'Ayesha Akter', roll: 5, phone: '01911-556677', avatar: 'Ayesha' }
];

// --- HELPER FUNCTION FOR LIST RENDERING ---
function buildBkashList(items) {
    return items.map(item => `
        <div class="bkash-list-item" onclick="showToast('${item.title} Details')">
            <div class="bkash-list-icon" style="background: ${item.iconBg}; color: ${item.iconColor}; font-weight: bold; font-size: ${item.icon.length <= 2 ? '18px' : '24px'};">
                ${item.icon.startsWith('ph-') ? `<i class="ph ${item.icon}"></i>` : item.icon}
            </div>
            <div class="bkash-list-content">
                <div class="bkash-list-title">${item.title}</div>
                <div class="bkash-list-subtitle">${item.subtitle}</div>
            </div>
            <div class="bkash-list-right">
                <div class="bkash-list-value">${item.value}</div>
                <div class="bkash-list-subvalue ${item.subStatus}">${item.subvalue}</div>
            </div>
        </div>
    `).join('');
}

// --- SHARED UI ACTIONS ---
let balanceRevealed = false;
let balanceTimeout;
let toastTimeout;

function showToast(message) {
    const toastEl = document.getElementById('toastMsg');
    if (!toastEl) return;

    toastEl.innerText = message;
    toastEl.classList.add('show');

    clearTimeout(toastTimeout);
    toastTimeout = setTimeout(() => {
        toastEl.classList.remove('show');
    }, 2000);

    const sideMenu = document.getElementById('sideMenu');
    if (sideMenu && sideMenu.classList.contains('open') && message !== 'Options' && !message.includes('Details')) {
        toggleMenu();
    }
}

function toggleMenu() {
    const sideMenu = document.getElementById('sideMenu');
    const menuOverlay = document.getElementById('menuOverlay');
    if (!sideMenu || !menuOverlay) return;

    const isOpen = sideMenu.classList.contains('open');
    if (isOpen) {
        sideMenu.classList.remove('open');
        menuOverlay.classList.remove('active');
    } else {
        sideMenu.classList.add('open');
        menuOverlay.classList.add('active');
    }
}

function toggleBalance() {
    if (balanceRevealed) return;

    const balanceBtn = document.getElementById('balanceBtn');
    const balanceText = document.getElementById('balanceText');
    const roleBadge = document.getElementById('currentRoleBadge');
    if (!balanceBtn || !balanceText) return;

    // Infer current role
    const currentRole = (roleBadge && roleBadge.innerText.toLowerCase() === 'teacher') ? 'teacher' : 'student';

    balanceRevealed = true;
    balanceText.style.opacity = '0';

    setTimeout(() => {
        balanceText.innerText = rolesData[currentRole].balanceAmount;
        balanceText.style.opacity = '1';
        balanceBtn.style.paddingLeft = '12px';
    }, 150);

    clearTimeout(balanceTimeout);
    balanceTimeout = setTimeout(() => {
        balanceText.style.opacity = '0';
        setTimeout(() => {
            balanceText.innerText = 'Tap for Balance';
            balanceText.style.opacity = '1';
            balanceBtn.style.paddingLeft = '6px';
            balanceRevealed = false;
        }, 150);
    }, 3000);
}

function enableNativeMode() {
    document.body.classList.add('native-mode');
    console.log("Native mode enabled by Flutter. Web UI adapted.");
}

// --- CLASSROOM TAB TOGGLE ---
function switchClassroomTab(tab) {
    document.querySelectorAll('.classroom-tab').forEach(b => b.classList.remove('active'));
    document.querySelectorAll('.classroom-panel').forEach(p => p.classList.remove('active'));
    
    if (tab === 'online') {
        document.getElementById('tab-online')?.classList.add('active');
        document.getElementById('onlineClassesList')?.classList.add('active');
    } else {
        document.getElementById('tab-recorded')?.classList.add('active');
        document.getElementById('recordedClassesList')?.classList.add('active');
    }
}

// --- STUDENT ROUTINE NAVIGATION ---
function selectRoutineDay(day) {
    document.querySelectorAll('.routine-day-btn').forEach(b => b.classList.remove('active'));
    document.querySelectorAll('.day-routine-panel').forEach(p => p.style.display = 'none');
    
    document.getElementById('btn-' + day)?.classList.add('active');
    const panel = document.getElementById('routine-' + day);
    if (panel) {
        panel.style.display = 'block';
    }
}

// --- TEACHER ROUTINE NAVIGATION ---
function selectTeacherRoutineDay(day) {
    document.querySelectorAll('#teacherRoutineView .routine-day-btn').forEach(b => b.classList.remove('active'));
    document.querySelectorAll('.teacher-routine-panel').forEach(p => p.style.display = 'none');
    
    document.getElementById('tbtn-' + day)?.classList.add('active');
    const panel = document.getElementById('troutine-' + day);
    if (panel) {
        panel.style.display = 'block';
    }
}

// --- ATTENDANCE CALENDAR RENDER ---
let attViewDate = new Date();
const attDataCache = {};

function getAttendanceData(role, year, month) {
    const key = `${role}-${year}-${month}`;
    if (attDataCache[key]) return attDataCache[key];

    const records = {};
    const daysInMonth = new Date(year, month + 1, 0).getDate();
    let presentCount = 0, absentCount = 0, leaveCount = 0;

    const today = new Date();
    const isCurrentMonth = today.getFullYear() === year && today.getMonth() === month;
    const maxDay = isCurrentMonth ? today.getDate() : daysInMonth;

    for (let i = 1; i <= daysInMonth; i++) {
        const date = new Date(year, month, i);
        const dayOfWeek = date.getDay();

        if (dayOfWeek !== 5 && dayOfWeek !== 6 && i <= maxDay) {
            const rand = Math.sin(year + month + i + (role === 'student' ? 1 : 2)) * 10000;
            const normalized = rand - Math.floor(rand);

            let status = 'present';
            if (role === 'student') {
                if (normalized < 0.1) status = 'absent';
                else if (normalized < 0.15) status = 'leave';
            } else {
                if (normalized < 0.05) status = 'leave';
            }

            records[i] = status;
            if(status === 'present') presentCount++;
            else if(status === 'absent') absentCount++;
            else if(status === 'leave') leaveCount++;
        }
    }

    attDataCache[key] = {
        records,
        stats: { total: presentCount + absentCount + leaveCount, present: presentCount, absent: absentCount, leave: leaveCount }
    };
    return attDataCache[key];
}

function renderAttendance() {
    const calMonthDisplay = document.getElementById('calMonthDisplay');
    if (!calMonthDisplay) return;
    
    const year = attViewDate.getFullYear();
    const month = attViewDate.getMonth();
    const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

    calMonthDisplay.innerText = `${monthNames[month]} ${year}`;

    const dataObj = getAttendanceData('student', year, month);
    if (!dataObj) return;

    const records = dataObj.records;
    const stats = dataObj.stats;

    const firstDay = new Date(year, month, 1).getDay();
    const daysInMonth = new Date(year, month + 1, 0).getDate();

    let gridHTML = `
        <div class="bkash-cal-header">Su</div><div class="bkash-cal-header">Mo</div>
        <div class="bkash-cal-header">Tu</div><div class="bkash-cal-header">We</div>
        <div class="bkash-cal-header">Th</div><div class="bkash-cal-header">Fr</div>
        <div class="bkash-cal-header">Sa</div>
    `;

    for (let i = 0; i < firstDay; i++) {
        gridHTML += `<div class="bkash-cal-date empty"></div>`;
    }

    for (let i = 1; i <= daysInMonth; i++) {
        const status = records[i] || 'none';
        let classList = "bkash-cal-date " + status;
        let onclick = status !== 'none' ? `onclick="window.showToast('Date: ${i} ${monthNames[month]} - ${status.charAt(0).toUpperCase() + status.slice(1)}');"` : '';

        gridHTML += `<div class="${classList}" ${onclick}><span>${i}</span></div>`;
    }
    
    const calGridContainer = document.getElementById('calGridContainer');
    if (calGridContainer) calGridContainer.innerHTML = gridHTML;

    const attTotal = document.getElementById('attTotal');
    if (attTotal) attTotal.innerText = stats.total;

    const attPresent = document.getElementById('attPresent');
    if (attPresent) attPresent.innerText = stats.present;

    const attAbsent = document.getElementById('attAbsent');
    if (attAbsent) attAbsent.innerText = stats.absent;

    const listItems = [];
    for (let i = daysInMonth; i >= 1; i--) {
        if(records[i]) {
            const status = records[i];
            let icon = 'ph-check-circle', iconBg = 'rgba(46, 204, 113, 0.1)', iconColor = '#2ecc71', subStatus = 'paid';

            if (status === 'absent') { icon = 'ph-x-circle'; iconBg = 'rgba(231, 76, 60, 0.1)'; iconColor = '#e74c3c'; subStatus = 'due'; }
            else if (status === 'leave') { icon = 'ph-minus-circle'; iconBg = 'rgba(243, 156, 18, 0.1)'; iconColor = '#f39c12'; subStatus = 'neutral'; }

            listItems.push({
                title: `${i} ${monthNames[month]} ${year}`,
                subtitle: 'Daily Attendance',
                icon: icon, iconBg: iconBg, iconColor: iconColor,
                value: status.charAt(0).toUpperCase() + status.slice(1),
                subvalue: status === 'present' ? 'Recorded' : 'Noted',
                subStatus: subStatus
            });

            if(listItems.length >= 5) break;
        }
    }

    const attListContainer = document.getElementById('attListContainer');
    if (attListContainer) {
        attListContainer.innerHTML = listItems.length > 0
            ? buildBkashList(listItems)
            : `<div style="text-align:center; padding: 20px; color: var(--text-light); font-size: 13px;">No records for this month</div>`;
    }
}

function changeAttMonth(delta) {
    attViewDate.setMonth(attViewDate.getMonth() + delta);
    renderAttendance();
}

// --- ACADEMIC CALENDAR RENDER ---
let acadViewDate = new Date();

function renderAcademicCalendar() {
    const acadCalMonthDisplay = document.getElementById('acadCalMonthDisplay');
    if (!acadCalMonthDisplay) return;

    const year = acadViewDate.getFullYear();
    const month = acadViewDate.getMonth();
    const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

    acadCalMonthDisplay.innerText = `${monthNames[month]} ${year}`;

    const firstDay = new Date(year, month, 1).getDay();
    const daysInMonth = new Date(year, month + 1, 0).getDate();

    const holidays = {
        '1-21': { name: 'Shaheed Day & Mother Language Day', type: 'holiday' },
        '2-26': { name: 'Independence Day', type: 'holiday' },
        '3-14': { name: 'Pohela Boishakh (Bangla New Year)', type: 'holiday' },
        '4-1': { name: 'May Day', type: 'holiday' },
        '11-16': { name: 'Victory Day', type: 'holiday' },
        '11-25': { name: 'Christmas Day', type: 'holiday' }
    };

    const getEventForDate = (y, m, d) => {
        const key = `${m}-${d}`;
        if (holidays[key]) return holidays[key];
        
        const date = new Date(y, m, d);
        const dayOfWeek = date.getDay();
        
        if (dayOfWeek === 5) {
            return { name: 'Weekly Holy Weekend (Friday)', type: 'holiday' };
        }

        if (m === 10 && d >= 10 && d <= 15) {
            return { name: 'Mid Term Examination', type: 'exam-day' };
        }

        if (m === 11 && d >= 5 && d <= 12) {
            return { name: 'Final Examination', type: 'exam-day' };
        }

        if (m === 3 && d >= 5 && d <= 10) {
            return { name: '1st Term Examination', type: 'exam-day' };
        }

        return { name: 'Regular Class Day', type: 'class-day' };
    };

    let gridHTML = `
        <div class="bkash-cal-header">Su</div><div class="bkash-cal-header">Mo</div>
        <div class="bkash-cal-header">Tu</div><div class="bkash-cal-header">We</div>
        <div class="bkash-cal-header">Th</div><div class="bkash-cal-header">Fr</div>
        <div class="bkash-cal-header">Sa</div>
    `;

    for (let i = 0; i < firstDay; i++) {
        gridHTML += `<div class="bkash-cal-date empty"></div>`;
    }

    const eventList = [];

    for (let i = 1; i <= daysInMonth; i++) {
        const ev = getEventForDate(year, month, i);
        let classList = "bkash-cal-date " + ev.type;
        let onclick = `onclick="window.showToast('Date: ${i} ${monthNames[month]} - ${ev.name}');"`;

        gridHTML += `<div class="${classList}" ${onclick}><span>${i}</span></div>`;

        if (ev.type === 'holiday' || ev.type === 'exam-day') {
            eventList.push({
                title: `${i} ${monthNames[month]} ${year}`,
                subtitle: ev.name,
                icon: ev.type === 'holiday' ? 'ph-sparkles' : 'ph-exam',
                iconBg: ev.type === 'holiday' ? 'rgba(243, 156, 18, 0.1)' : 'rgba(231, 76, 60, 0.1)',
                iconColor: ev.type === 'holiday' ? '#f39c12' : '#e74c3c',
                value: ev.type === 'holiday' ? 'Holiday' : 'Exam',
                subvalue: ev.type === 'holiday' ? 'Closed' : 'Schedule',
                subStatus: ev.type === 'holiday' ? 'neutral' : 'due'
            });
        }
    }

    const acadCalGridContainer = document.getElementById('acadCalGridContainer');
    if (acadCalGridContainer) acadCalGridContainer.innerHTML = gridHTML;

    const acadEventsList = document.getElementById('acadEventsList');
    if (acadEventsList) {
        acadEventsList.innerHTML = eventList.length > 0
            ? buildBkashList(eventList)
            : `<div style="text-align:center; padding: 20px; color: var(--text-light); font-size: 13px;">No exams or holidays scheduled for this month</div>`;
    }
}

function changeAcadMonth(delta) {
    acadViewDate.setMonth(acadViewDate.getMonth() + delta);
    renderAcademicCalendar();
}

// --- TEACHER PERSONAL ATTENDANCE RENDER ---
let teacherAttViewDate = new Date();

function renderTeacherPersonalAttendance() {
    const calMonthDisplay = document.getElementById('teacherPersonalCalMonthDisplay');
    if (!calMonthDisplay) return;

    const year = teacherAttViewDate.getFullYear();
    const month = teacherAttViewDate.getMonth();
    const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

    calMonthDisplay.innerText = `${monthNames[month]} ${year}`;

    const dataObj = getAttendanceData('teacher', year, month);
    if (!dataObj) return;

    const records = dataObj.records;
    const stats = dataObj.stats;

    const firstDay = new Date(year, month, 1).getDay();
    const daysInMonth = new Date(year, month + 1, 0).getDate();

    let gridHTML = `
        <div class="bkash-cal-header">Su</div><div class="bkash-cal-header">Mo</div>
        <div class="bkash-cal-header">Tu</div><div class="bkash-cal-header">We</div>
        <div class="bkash-cal-header">Th</div><div class="bkash-cal-header">Fr</div>
        <div class="bkash-cal-header">Sa</div>
    `;

    for (let i = 0; i < firstDay; i++) {
        gridHTML += `<div class="bkash-cal-date empty"></div>`;
    }

    for (let i = 1; i <= daysInMonth; i++) {
        const status = records[i] || 'none';
        let classList = "bkash-cal-date " + status;
        let onclick = status !== 'none' ? `onclick="window.showToast('Date: ${i} ${monthNames[month]} - ${status.charAt(0).toUpperCase() + status.slice(1)}');"` : '';

        gridHTML += `<div class="${classList}" ${onclick}><span>${i}</span></div>`;
    }
    
    const calGridContainer = document.getElementById('teacherPersonalCalGridContainer');
    if (calGridContainer) calGridContainer.innerHTML = gridHTML;

    const attTotal = document.getElementById('teacherPersonalAttTotal');
    if (attTotal) attTotal.innerText = stats.total;

    const attPresent = document.getElementById('teacherPersonalAttPresent');
    if (attPresent) attPresent.innerText = stats.present;

    const attAbsent = document.getElementById('teacherPersonalAttAbsent');
    if (attAbsent) attAbsent.innerText = stats.absent;

    const listItems = [];
    for (let i = daysInMonth; i >= 1; i--) {
        if(records[i]) {
            const status = records[i];
            let icon = 'ph-check-circle', iconBg = 'rgba(46, 204, 113, 0.1)', iconColor = '#2ecc71', subStatus = 'paid';

            if (status === 'absent') { icon = 'ph-x-circle'; iconBg = 'rgba(231, 76, 60, 0.1)'; iconColor = '#e74c3c'; subStatus = 'due'; }
            else if (status === 'leave') { icon = 'ph-minus-circle'; iconBg = 'rgba(243, 156, 18, 0.1)'; iconColor = '#f39c12'; subStatus = 'neutral'; }

            listItems.push({
                title: `${i} ${monthNames[month]} ${year}`,
                subtitle: 'Personal Attendance Record',
                icon: icon, iconBg: iconBg, iconColor: iconColor,
                value: status.charAt(0).toUpperCase() + status.slice(1),
                subvalue: status === 'present' ? 'Recorded' : 'Noted',
                subStatus: subStatus
            });

            if(listItems.length >= 5) break;
        }
    }

    const attListContainer = document.getElementById('teacherPersonalAttListContainer');
    if (attListContainer) {
        attListContainer.innerHTML = listItems.length > 0
            ? buildBkashList(listItems)
            : `<div style="text-align:center; padding: 20px; color: var(--text-light); font-size: 13px;">No records for this month</div>`;
    }
}

function changeTeacherPersonalAttMonth(delta) {
    teacherAttViewDate.setMonth(teacherAttViewDate.getMonth() + delta);
    renderTeacherPersonalAttendance();
}

// --- COPY CONTACT TO CLIPBOARD ---
function copyToClipboard(phoneNum) {
    navigator.clipboard.writeText(phoneNum).then(() => {
        showToast("Phone number copied: " + phoneNum);
    }).catch(err => {
        const textArea = document.createElement('textarea');
        textArea.value = phoneNum;
        document.body.appendChild(textArea);
        textArea.select();
        try {
            document.execCommand('copy');
            showToast("Phone number copied: " + phoneNum);
        } catch (e) {
            showToast('Failed to copy contact');
        }
        document.body.removeChild(textArea);
    });
}

// --- ONLINE CLASS SCHEDULING (TEACHER) ---
function renderScheduledClasses() {
    const listContainer = document.getElementById('teacherOnlineClassList');
    if (!listContainer) return;

    const classes = dummyViewData.teacher.classroom.online || [];
    if (classes.length === 0) {
        listContainer.innerHTML = `<div class="empty-state-routine">No scheduled classes</div>`;
        return;
    }

    listContainer.innerHTML = classes.map((c, index) => `
        <div class="teacher-card" style="padding: 16px; flex-direction: column; align-items: stretch; gap: 10px; background: white; border: 1px solid var(--border-color); border-radius: 14px; margin-bottom: 12px;">
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

function scheduleOnlineClass() {
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
    showToast("Class Scheduled Successfully");
}

function deleteScheduledClass(index) {
    if (confirm("Are you sure you want to delete this scheduled class?")) {
        dummyViewData.teacher.classroom.online.splice(index, 1);
        renderScheduledClasses();
        showToast("Class Deleted");
    }
}

// --- MARK ENTRY HIERARCHY FLOW (TEACHER) ---
function renderMarkEntry() {
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
                    <div class="teacher-card" style="padding: 14px; flex-direction: column; align-items: stretch; gap: 10px; background: white; border: 1px solid var(--border-color); border-radius: 14px; box-shadow: 0 2px 8px rgba(0,0,0,0.02); display: flex;">
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

function goBackMarkEntryStep() {
    if (markEntryState.step > 1) {
        markEntryState.step--;
        renderMarkEntry();
    }
}

function selectMarkCategory(cat) {
    markEntryState.category = cat;
    markEntryState.step = 2;
    renderMarkEntry();
}

function selectMarkTerm(term) {
    markEntryState.term = term;
    markEntryState.step = 3;
    renderMarkEntry();
}

function selectMarkTest(test) {
    markEntryState.test = test;
    markEntryState.step = 4;
    renderMarkEntry();
}

function addMarkNewTest() {
    const name = prompt("Enter Test Name:", "Class Test 3");
    if (!name) return;
    markEntryTests.push({
        id: 'ct_' + Date.now(),
        name: name,
        category: markEntryState.category,
        term: markEntryState.term
    });
    renderMarkEntry();
    showToast("New test added!");
}

function selectMarkClass(cls) {
    markEntryState.class = cls;
    markEntryState.step = 5;
    renderMarkEntry();
}

function selectMarkSection(sec) {
    markEntryState.section = sec;
    markEntryState.step = 6;
    renderMarkEntry();
}

function selectMarkSubject(sub) {
    markEntryState.subject = sub;
    markEntryState.step = 7;
    renderMarkEntry();
}

function stepMark(roll, delta) {
    const student = markEntryStudents.find(s => s.roll === roll);
    if (student) {
        student.marks = Math.max(0, Math.min(100, student.marks + delta));
        const inputEl = document.getElementById(`mark_input_${roll}`);
        if (inputEl) inputEl.value = student.marks;
        triggerAutoSave(roll, 'marks', student.marks);
    }
}

function updateMarkVal(roll, val) {
    const student = markEntryStudents.find(s => s.roll === roll);
    if (student) {
        const parsed = parseInt(val, 10);
        student.marks = isNaN(parsed) ? 0 : Math.max(0, Math.min(100, parsed));
        triggerAutoSave(roll, 'marks', student.marks);
    }
}

let saveTimeout;
function triggerAutoSave(roll, type, value) {
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

function saveAllMarks() {
    showToast("Marks submitted & locked successfully!");
    markEntryState.step = 1;
    renderMarkEntry();
}

// --- STUDENT ATTENDANCE TAKING (TEACHER) ---
function revealTakeAttendanceList() {
    const listSection = document.getElementById('takeAttendanceListSection');
    if (listSection) {
        listSection.style.display = 'block';
    }
    
    const dateInput = document.getElementById('takeAttDate');
    if (dateInput && !dateInput.value) {
        dateInput.value = new Date().toISOString().substring(0, 10);
    }
    
    renderTakeAttendanceList();
}

function renderTakeAttendanceList() {
    const container = document.getElementById('takeAttendanceListContainer');
    if (!container) return;

    container.innerHTML = attendanceStudents.map(s => `
        <div class="teacher-card" style="padding: 14px; flex-direction: column; align-items: stretch; gap: 10px; border: 1px solid var(--border-color); background: white; border-radius: 14px; display: flex;">
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

function toggleAllAttendance(status) {
    attendanceStudents.forEach(s => {
        s.status = status;
    });
    renderTakeAttendanceList();
    showToast(`Marked all as ${status.charAt(0).toUpperCase() + status.slice(1)}`);
}

function setStudentStatus(roll, status) {
    const student = attendanceStudents.find(s => s.roll === roll);
    if (student) {
        student.status = status;
        renderTakeAttendanceList();
    }
}

function updateAttendanceRemarks(roll, val) {
    const student = attendanceStudents.find(s => s.roll === roll);
    if (student) {
        student.remarks = val;
    }
}

function saveAttendanceRecord() {
    const dateInput = document.getElementById('takeAttDate')?.value || new Date().toISOString().substring(0, 10);
    const cls = document.getElementById('takeAttClass')?.value || 'Class 8';
    const sec = document.getElementById('takeAttSection')?.value || 'Padma';
    
    showToast(`Saved attendance for ${cls} - ${sec} on ${dateInput}`);
    
    const listSection = document.getElementById('takeAttendanceListSection');
    if (listSection) {
        listSection.style.display = 'none';
    }
}

// --- STUDENT DIRECTORY (TEACHER) ---
function revealStudentDirectoryList() {
    const listSection = document.getElementById('studentDirectoryListSection');
    if (listSection) {
        listSection.style.display = 'block';
    }
    renderStudentDirectoryList();
}

function renderStudentDirectoryList() {
    const container = document.getElementById('studentDirectoryListContainer');
    if (!container) return;

    container.innerHTML = studentDirectoryList.map(s => `
        <div class="teacher-card" style="padding: 12px; align-items: center; border: 1px solid var(--border-color); background: white; border-radius: 14px; margin-bottom: 10px; display: flex; gap: 12px;">
            <div class="teacher-avatar" style="width: 44px; height: 44px; border-radius: 50%; overflow: hidden; background: #e6e0f8; display: flex; align-items: center; justify-content: center;">
                <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=${s.avatar}&backgroundColor=E6E0F8" alt="${s.name}" style="width: 100%; height: 100%; object-fit: cover;">
            </div>
            <div class="teacher-info" style="flex: 1;">
                <div class="teacher-name" style="font-size: 14px; font-weight: bold; color: var(--text-main);">${s.name}</div>
                <div class="teacher-designation" style="font-size: 11px; color: var(--text-light);">ID: ${s.id} | Roll: ${s.roll}</div>
                <div style="font-size: 11px; color: var(--text-light); margin-top: 2px;"><i class="ph ph-phone"></i> ${s.phone}</div>
            </div>
            <button class="routine-day-btn" onclick="editStudentInfo('${s.id}')" style="margin: 0; padding: 6px 12px; font-size: 11px; background: rgba(142,124,195,0.1); color: var(--brand-color); border: 1px solid var(--brand-color); border-radius: 8px; font-weight: 500;">
                <i class="ph ph-pencil-simple"></i> Edit
            </button>
        </div>
    `).join('');
}

function editStudentInfo(id) {
    const s = studentDirectoryList.find(item => item.id === id);
    if (!s) return;

    const newName = prompt(`Edit Name for ${s.name}:`, s.name);
    if (newName === null) return;
    const newPhone = prompt(`Edit Phone for ${s.name}:`, s.phone);
    if (newPhone === null) return;

    s.name = newName;
    s.phone = newPhone;
    renderStudentDirectoryList();
    showToast("Student profile updated!");
}

// --- RESULT CARD EXPANSION ---
function toggleResultBreakdown(cardEl) {
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

// --- FLUTTER BRIDGE CONFIGURATION & SYNC ---
if (window.FlutterBridge) {
    console.log("FlutterBridge detected. Native integration active.");
}

// Expose functions to the global window scope
window.showToast = showToast;
window.toggleMenu = toggleMenu;
window.toggleBalance = toggleBalance;
window.enableNativeMode = enableNativeMode;
window.switchClassroomTab = switchClassroomTab;
window.selectRoutineDay = selectRoutineDay;
window.selectTeacherRoutineDay = selectTeacherRoutineDay;
window.changeAttMonth = changeAttMonth;
window.changeAcadMonth = changeAcadMonth;
window.changeTeacherPersonalAttMonth = changeTeacherPersonalAttMonth;
window.copyToClipboard = copyToClipboard;
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
window.toggleResultBreakdown = toggleResultBreakdown;
window.renderAttendance = renderAttendance;
window.renderAcademicCalendar = renderAcademicCalendar;
window.renderTeacherPersonalAttendance = renderTeacherPersonalAttendance;

console.log("EduManage scripts initialized.");
