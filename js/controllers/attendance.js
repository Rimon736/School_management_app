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

    document.getElementById('calMonthDisplay').innerText = `${monthNames[month]} ${year}`;

    const dataObj = getAttendanceData(currentRole, year, month);
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
        let onclick = status !== 'none' ? `onclick="showToast('Date: ${i} ${monthNames[month]} - ${status.charAt(0).toUpperCase() + status.slice(1)}');"` : '';

        gridHTML += `<div class="${classList}" ${onclick}><span>${i}</span></div>`;
    }
    document.getElementById('calGridContainer').innerHTML = gridHTML;

    document.getElementById('attTotal').innerText = stats.total;
    document.getElementById('attPresent').innerText = stats.present;
    document.getElementById('attAbsent').innerText = stats.absent;

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

    document.getElementById('attListContainer').innerHTML = listItems.length > 0
        ? buildBkashList(listItems)
        : `<div style="text-align:center; padding: 20px; color: var(--text-light); font-size: 13px;">No records for this month</div>`;
}

export function changeAttMonth(delta) {
    attViewDate.setMonth(attViewDate.getMonth() + delta);
    renderAttendance();
}

export function renderAnalyticsDashboard() {
    const currentRole = getCurrentRole();
    const dashData = dummyViewData[currentRole].dash;

    const statsHTML = dashData.stats.map(stat => `
        <div class="dash-stat-card">
            <i class="ph ${stat.icon}" style="color: ${stat.color};"></i>
            <div class="dash-stat-val">${stat.value}</div>
            <div class="dash-stat-label">${stat.label}</div>
        </div>
    `).join('');
    document.getElementById('dashSummaryGrid').innerHTML = statsHTML;

    document.getElementById('dashChartTitle').innerText = dashData.chartTitle;
    const ctx = document.getElementById('mainDashboardChart').getContext('2d');

    if (window.dashChartInst) { window.dashChartInst.destroy(); }
    window.dashChartInst = new Chart(ctx, dashData.chartConfig);

    document.getElementById('dashListTitle').innerText = dashData.listTitle;
    document.getElementById('dashActivityList').innerHTML = buildBkashList(dashData.activities);
}
