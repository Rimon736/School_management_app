// Dashboard controller
import { rolesData, dummyViewData, buildBkashList } from '../data.js';
import { renderAttendance } from './attendance.js';

export function renderRole(currentRole) {
    const data = rolesData[currentRole];
    const viewData = dummyViewData[currentRole];

    // Header
    const avatarUrl = `https://api.dicebear.com/7.x/avataaars/svg?seed=${data.avatarSeed}&backgroundColor=8E7CC3`;
    document.getElementById('userName').innerText = data.name;
    document.getElementById('userRole').innerText = data.roleLabel;
    document.getElementById('userAvatar').src = avatarUrl;
    document.getElementById('balanceIcon').className = `ph-fill ${data.balanceIcon}`;
    document.getElementById('currentRoleBadge').innerText = data.roleLabel;

    // Profile
    document.getElementById('innerProfileName').innerText = data.name;
    document.getElementById('innerProfileAvatar').src = avatarUrl;
    document.getElementById('innerProfileId').innerText = `ID: ${viewData.profile.id}`;
    document.getElementById('profileClass').innerText = viewData.profile.classRole;
    document.getElementById('profileRollLabel').innerText = viewData.profile.rollLabel;
    document.getElementById('profileRoll').innerText = viewData.profile.roll;
    document.getElementById('profileField1Label').innerText = viewData.profile.field1Label;
    document.getElementById('profileField1').innerText = viewData.profile.field1Val;
    document.getElementById('profileField2Label').innerText = viewData.profile.field2Label;
    document.getElementById('profileField2').innerText = viewData.profile.field2Val;
    document.getElementById('profileAddress').innerText = viewData.profile.address;
    document.getElementById('profilePhone').innerText = viewData.profile.phone;

    // Lists
    document.getElementById('routineListContainer').innerHTML = buildBkashList(viewData.routine);
    document.getElementById('financeHistoryContainer').innerHTML = buildBkashList(viewData.finance.history);
    document.getElementById('resSubjectsContainer').innerHTML = buildBkashList(viewData.results.subjects);

    renderAttendance();

    document.getElementById('financeTitle').innerText = viewData.finance.title;
    document.getElementById('financeAmount').innerText = viewData.finance.amount;

    document.getElementById('resGrade').innerText = viewData.results.grade;
    document.getElementById('resTotal').innerText = viewData.results.total;
    document.getElementById('resGpa').innerText = viewData.results.gpa;
    document.getElementById('resPosition').innerText = viewData.results.position;

    // Grid Menu
    const gridHTML = data.grid.map(item => `
        <div class="grid-item" onclick='${item.action}'>
            <div class="icon-circle ${item.color}"><i class="ph ${item.icon}"></i></div>
            <span>${item.label}</span>
        </div>
    `).join('');
    document.getElementById('mainGrid').innerHTML = gridHTML;

    // Quick Features
    const quickHTML = data.quick.map(item => `
        <div class="qf-card" onclick='${item.action}'>
            <i class="ph ${item.icon}" style="color: ${item.color};"></i>
            <span>${item.label}</span>
        </div>
    `).join('');
    document.getElementById('quickFeatures').innerHTML = quickHTML;
}
