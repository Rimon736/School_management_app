// Attendance controller
import { dummyViewData, buildBkashList } from '../data.js';
import { getCurrentRole } from '../auth.js';

let attViewDate = new Date();
const attDataCache = {};

export function getAttendanceData(role, year, month) {
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
            const rand = Math.sin(year + month + i + (role==='student'?1:2)) * 10000;
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

export function renderAttendance() {
    const currentRole = getCurrentRole();
    const year = attViewDate.getFullYear();
    const month = attViewDate.getMonth();
    const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

    const calMonthDisplay = document.getElementById('calMonthDisplay');
    if (calMonthDisplay) {
        calMonthDisplay.innerText = `${monthNames[month]} ${year}`;
    }

    const dataObj = getAttendanceData(currentRole, year, month);
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
    if (calGridContainer) {
        calGridContainer.innerHTML = gridHTML;
    }

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

export function changeAttMonth(delta) {
    attViewDate.setMonth(attViewDate.getMonth() + delta);
    renderAttendance();
}

export function renderAnalyticsDashboard() {
    const currentRole = getCurrentRole();
    const roleData = dummyViewData[currentRole];
    if (!roleData || !roleData.dash) return;
    const dashData = roleData.dash;

    const statsHTML = dashData.stats.map(stat => `
        <div class="dash-stat-card">
            <i class="ph ${stat.icon}" style="color: ${stat.color};"></i>
            <div class="dash-stat-val">${stat.value}</div>
            <div class="dash-stat-label">${stat.label}</div>
        </div>
    `).join('');
    
    const dashSummaryGrid = document.getElementById('dashSummaryGrid');
    if (dashSummaryGrid) {
        dashSummaryGrid.innerHTML = statsHTML;
    }

    const dashChartTitle = document.getElementById('dashChartTitle');
    if (dashChartTitle) {
        dashChartTitle.innerText = dashData.chartTitle;
    }
    
    const mainDashboardChart = document.getElementById('mainDashboardChart');
    if (mainDashboardChart) {
        const ctx = mainDashboardChart.getContext('2d');
        if (window.dashChartInst) { window.dashChartInst.destroy(); }
        // Create a deep copy of chartConfig to prevent Chart.js from mutating the source data object
        const chartConfigCopy = JSON.parse(JSON.stringify(dashData.chartConfig));
        window.dashChartInst = new Chart(ctx, chartConfigCopy);
    }

    const dashListTitle = document.getElementById('dashListTitle');
    if (dashListTitle) {
        dashListTitle.innerText = dashData.listTitle;
    }
    
    const dashActivityList = document.getElementById('dashActivityList');
    if (dashActivityList) {
        dashActivityList.innerHTML = buildBkashList(dashData.activities);
    }
}

/* --- ACADEMIC CALENDAR LOGIC --- */
let acadViewDate = new Date();

export function renderAcademicCalendar() {
    const year = acadViewDate.getFullYear();
    const month = acadViewDate.getMonth();
    const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

    const acadCalMonthDisplay = document.getElementById('acadCalMonthDisplay');
    if (acadCalMonthDisplay) {
        acadCalMonthDisplay.innerText = `${monthNames[month]} ${year}`;
    }

    const firstDay = new Date(year, month, 1).getDay();
    const daysInMonth = new Date(year, month + 1, 0).getDate();

    // Static holidays in a Bangladeshi school context (month is 0-indexed)
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
        
        // Friday is weekend in Bangladesh
        if (dayOfWeek === 5) {
            return { name: 'Weekly Holy Weekend (Friday)', type: 'holiday' };
        }

        // Mid Term Exam week: e.g., November 10 to November 15
        if (m === 10 && d >= 10 && d <= 15) {
            return { name: 'Mid Term Examination', type: 'exam-day' };
        }

        // Final Exam week: e.g., December 5 to December 12
        if (m === 11 && d >= 5 && d <= 12) {
            return { name: 'Final Examination', type: 'exam-day' };
        }

        // 1st Term Exam: e.g., April 5 to April 10
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
    if (acadCalGridContainer) {
        acadCalGridContainer.innerHTML = gridHTML;
    }

    const acadEventsList = document.getElementById('acadEventsList');
    if (acadEventsList) {
        acadEventsList.innerHTML = eventList.length > 0
            ? buildBkashList(eventList)
            : `<div style="text-align:center; padding: 20px; color: var(--text-light); font-size: 13px;">No exams or holidays scheduled for this month</div>`;
    }
}

export function changeAcadMonth(delta) {
    acadViewDate.setMonth(acadViewDate.getMonth() + delta);
    renderAcademicCalendar();
}

let teacherAttViewDate = new Date();

export function renderTeacherPersonalAttendance() {
    const year = teacherAttViewDate.getFullYear();
    const month = teacherAttViewDate.getMonth();
    const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

    const calMonthDisplay = document.getElementById('teacherPersonalCalMonthDisplay');
    if (calMonthDisplay) {
        calMonthDisplay.innerText = `${monthNames[month]} ${year}`;
    }

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
    if (calGridContainer) {
        calGridContainer.innerHTML = gridHTML;
    }

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

export function changeTeacherPersonalAttMonth(delta) {
    teacherAttViewDate.setMonth(teacherAttViewDate.getMonth() + delta);
    renderTeacherPersonalAttendance();
}
