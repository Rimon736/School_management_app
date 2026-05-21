// View router and navigation
import { renderAttendance, renderAnalyticsDashboard } from './controllers/attendance.js';
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
    if(targetEl) {
        targetEl.classList.add('active');
    } else {
        document.getElementById('dashboardView').classList.add('active');
    }

    // Update Header
    document.getElementById('appHeader').classList.add('inner-mode');
    document.getElementById('innerViewTitle').innerText = title;

    if(targetViewId === 'attendanceView') {
        renderAttendance();
    } else if (targetViewId === 'analyticsDashboardView') {
        setTimeout(renderAnalyticsDashboard, 10);
    }

    updateNav(null);
    document.querySelector('.main-content').scrollTop = 0;

    if (document.getElementById('sideMenu').classList.contains('open')) {
        toggleMenu();
    }
}

export function closeView() {
    document.querySelectorAll('.view').forEach(el => el.classList.remove('active'));
    document.getElementById('dashboardView').classList.add('active');
    document.getElementById('appHeader').classList.remove('inner-mode');
    updateNav('navHome');
}

export function updateNav(activeId) {
    document.querySelectorAll('.bottom-nav .nav-item').forEach(el => el.classList.remove('active'));
    if(activeId) {
        document.getElementById(activeId).classList.add('active');
    }

    // TWO WAY SYNC FOR FLUTTER NATIVE NAV
    if (window.FlutterBridge) {
        window.FlutterBridge.postMessage(JSON.stringify({
            type: 'nav_change',
            id: activeId
        }));
    }
}
