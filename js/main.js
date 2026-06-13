import { handleLogin, loginAs, switchRole, logout } from './auth.js';
import { openView, closeView, updateNav } from './router.js';
import { showToast, toggleMenu, toggleBalance, enableNativeMode } from './ui.js';
import { getCurrentRole } from './auth.js';
import { changeAttMonth } from './controllers/attendance.js';

// We wait for the DOM to fully load before attaching listeners
document.addEventListener('DOMContentLoaded', () => {
    console.log('EduManage DOM loaded, attaching listeners...');

    // 1. Attach Login Listener
    const loginBtn = document.getElementById('loginBtn');
    if (loginBtn) {
        loginBtn.addEventListener('click', () => {
            handleLogin();
        });
    }

    // 2. Attach Header Listeners
    const avatar = document.getElementById('userAvatar');
    if (avatar) avatar.parentElement.addEventListener('click', toggleMenu);

    const balancePill = document.getElementById('balanceBtn');
    if (balancePill) balancePill.addEventListener('click', () => toggleBalance(getCurrentRole()));

    // Attach listener for the logo bird to toggle menu
    const logoBird = document.querySelector('.logo-bird');
    if(logoBird) logoBird.addEventListener('click', toggleMenu);


    // 3. Attach Navigation Listeners
    document.getElementById('navHome').addEventListener('click', () => { closeView(); updateNav('navHome'); });
    document.getElementById('navClass').addEventListener('click', () => { openView('routineView', 'Class Routine'); updateNav('navClass'); });
    document.getElementById('navQr').addEventListener('click', () => { openView('qrView', 'Scan QR'); updateNav('navQr'); });
    document.getElementById('navInbox').addEventListener('click', () => { openView('inboxView', 'Messages'); updateNav('navInbox'); });

    // 4. Expose ONLY necessary functions for dynamic content (like generated lists)
    // It's better to avoid this, but it's okay for dynamically injected HTML strings for now.
    window.openView = openView;
    window.closeView = closeView;
    window.showToast = showToast;
    window.changeAttMonth = changeAttMonth;
    window.switchRole = switchRole;
    window.logout = logout;
    window.handleLogin = handleLogin;
    window.toggleMenu = toggleMenu;
    window.toggleBalance = () => toggleBalance(getCurrentRole());
    window.updateNav = updateNav;
});

export function initApp() {
  console.log('EduManage app initialized');
}