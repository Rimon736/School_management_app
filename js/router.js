// View router and navigation
import { renderAttendance, renderAnalyticsDashboard, renderTeacherPersonalAttendance } from './controllers/attendance.js';
import { toggleMenu } from './ui.js';

export function openView(viewId, title) {
    // MAPPING FLUTTER IDS TO YOUR HTML IDS
    const flutterRoutingMap = {
        'view-home': 'dashboardView',
        'view-routine': 'routineView',
        'view-qr': 'qrView',
        'view-inbox': 'inboxView'
    };
    const targetViewId = flutterRoutingMap[viewId] || viewId;

    // Hide all views
    document.querySelectorAll('.view').forEach(el => el.classList.remove('active'));

    // Show target view
    const targetEl = document.getElementById(targetViewId);
    if (targetEl) {
        targetEl.classList.add('active');
    } else {
        const dashboard = document.getElementById('dashboardView');
        if (dashboard) dashboard.classList.add('active');
    }

    // Update Header
    const appHeader = document.getElementById('appHeader');
    if (appHeader) {
        appHeader.classList.add('inner-mode');
    }
    
    const innerViewTitle = document.getElementById('innerViewTitle');
    if (innerViewTitle) {
        innerViewTitle.innerText = title;
    }

    if (targetViewId === 'attendanceView') {
        renderAttendance();
    } else if (targetViewId === 'teacherPersonalAttendanceView') {
        renderTeacherPersonalAttendance();
    } else if (targetViewId === 'analyticsDashboardView') {
        setTimeout(renderAnalyticsDashboard, 10);
    }

    updateNav(null);
    
    const mainContent = document.querySelector('.main-content');
    if (mainContent) {
        mainContent.scrollTop = 0;
    }

    const sideMenu = document.getElementById('sideMenu');
    if (sideMenu && sideMenu.classList.contains('open')) {
        toggleMenu();
    }
}

export function closeView() {
    document.querySelectorAll('.view').forEach(el => el.classList.remove('active'));
    
    const dashboard = document.getElementById('dashboardView');
    if (dashboard) {
        dashboard.classList.add('active');
    }
    
    const appHeader = document.getElementById('appHeader');
    if (appHeader) {
        appHeader.classList.remove('inner-mode');
    }
    
    updateNav('navHome');
}

export function updateNav(activeId) {
    document.querySelectorAll('.bottom-nav .nav-item').forEach(el => el.classList.remove('active'));
    if (activeId) {
        const activeNav = document.getElementById(activeId);
        if (activeNav) {
            activeNav.classList.add('active');
        }
    }

    // TWO WAY SYNC FOR FLUTTER NATIVE NAV
    if (window.FlutterBridge) {
        window.FlutterBridge.postMessage(JSON.stringify({
            type: 'nav_change',
            id: activeId
        }));
    }
}
