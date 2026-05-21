// Entry point - imports all modules and exposes functions for inline handlers
import { supabaseClient } from './api.js';
import { handleLogin, loginAs, switchRole, logout, getCurrentRole } from './auth.js';
import { openView, closeView, updateNav } from './router.js';
import { showToast, toggleMenu, toggleBalance, enableNativeMode } from './ui.js';
import { renderRole } from './controllers/dashboard.js';
import { changeAttMonth, renderAttendance, renderAnalyticsDashboard } from './controllers/attendance.js';
import { rolesData, dummyViewData, buildBkashList } from './data.js';

// Expose functions globally for inline onclick handlers
window.openView = openView;
window.closeView = closeView;
window.showToast = showToast;
window.toggleMenu = toggleMenu;
window.toggleBalance = toggleBalance;
window.loginAs = loginAs;
window.switchRole = switchRole;
window.logout = logout;
window.handleLogin = handleLogin;
window.changeAttMonth = changeAttMonth;
window.enableNativeMode = enableNativeMode;
window.renderRole = renderRole;
window.renderAttendance = renderAttendance;
window.renderAnalyticsDashboard = renderAnalyticsDashboard;

export function initApp() {
  console.log('EduManage app initialized');
  // App loads in login mode by default
}
