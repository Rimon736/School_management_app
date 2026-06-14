import { handleLogin, loginAs, switchRole, logout } from './auth.js';
import { openView, closeView, updateNav } from './router.js';
import { showToast, toggleMenu, toggleBalance, enableNativeMode } from './ui.js';
import { changeAttMonth, changeAcadMonth } from './controllers/attendance.js';

// Expose necessary functions globally for inline HTML event handlers
window.openView = openView;
window.closeView = closeView;
window.updateNav = updateNav;
window.showToast = showToast;
window.changeAttMonth = changeAttMonth;
window.changeAcadMonth = changeAcadMonth;
window.switchRole = switchRole;
window.logout = logout;
window.toggleMenu = toggleMenu;
window.toggleBalance = toggleBalance;
window.handleLogin = handleLogin;
window.enableNativeMode = enableNativeMode;

export function initApp() {
    console.log('EduManage app initialized');
}