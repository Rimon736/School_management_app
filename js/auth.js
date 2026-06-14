// Authentication and role management
import { supabaseClient } from './api.js';
import { showToast, toggleMenu } from './ui.js';
import { renderRole } from './controllers/dashboard.js';
import { rolesData } from './data.js';
import { updateNav, closeView } from './router.js';

let currentRole = 'student';

export function getCurrentRole() {
    return currentRole;
}

export async function handleLogin() {
    const emailEl = document.getElementById('emailInput');
    const passwordEl = document.getElementById('passwordInput');
    
    const email = emailEl ? emailEl.value : '';
    const password = passwordEl ? passwordEl.value : '';

    if (!email || !password) {
        showToast("Please enter email and password");
        return;
    }

    showToast("Authenticating...");

    // For demo: accept any non-empty email/password
    if (email && password) {
        const role = email.includes('teacher') ? 'teacher' : 'student';
        loginAs(role);
        return;
    }

    // Real Supabase auth (if credentials are valid)
    try {
        const { data: authData, error: authError } = await supabaseClient.auth.signInWithPassword({
            email: email,
            password: password,
        });

        if (authError) {
            showToast(authError.message);
            return;
        }

        const { data: profileData, error: profileError } = await supabaseClient
            .from('profiles')
            .select('role')
            .eq('id', authData.user.id)
            .single();

        if (profileError) {
            console.error("Profile fetch error:", profileError);
            showToast("Error loading profile");
            return;
        }

        console.log("Logged in successfully. Role:", profileData.role);
        loginAs(profileData.role);
    } catch (err) {
        console.error("Login error:", err);
        showToast("Login failed");
    }
}

export function loginAs(role) {
    console.log('loginAs called with role:', role);
    
    // Normalize role and fallback to student if invalid
    let cleanRole = role ? role.toLowerCase() : 'student';
    if (!rolesData[cleanRole]) {
        cleanRole = 'student';
    }
    currentRole = cleanRole;

    console.log('Removing login-mode class');
    const mainContainer = document.getElementById('mainContainer');
    if (mainContainer) {
        mainContainer.classList.remove('login-mode');
    }

    console.log('Calling renderRole');
    renderRole(currentRole);

    console.log('Deactivating all views');
    document.querySelectorAll('.view').forEach(el => el.classList.remove('active'));

    console.log('Activating dashboardView');
    const dashboardView = document.getElementById('dashboardView');
    if (dashboardView) {
        dashboardView.classList.add('active');
    }

    updateNav('navHome');

    showToast(`Logged in as ${rolesData[currentRole].roleLabel}`);

    if (window.FlutterBridge) {
        window.FlutterBridge.postMessage(JSON.stringify({ type: 'auth_change', status: 'logged_in' }));
    }
}

export function switchRole() {
    currentRole = currentRole === 'student' ? 'teacher' : 'student';
    renderRole(currentRole);
    closeView();
    showToast(`Switched to ${rolesData[currentRole].roleLabel} View`);
}

export function logout() {
    const mainContainer = document.getElementById('mainContainer');
    if (mainContainer) {
        mainContainer.classList.add('login-mode');
    }
    
    document.querySelectorAll('.view').forEach(el => el.classList.remove('active'));
    
    const loginView = document.getElementById('loginView');
    if (loginView) {
        loginView.classList.add('active');
    }
    
    const appHeader = document.getElementById('appHeader');
    if (appHeader) {
        appHeader.classList.remove('inner-mode');
    }

    const sideMenu = document.getElementById('sideMenu');
    if (sideMenu && sideMenu.classList.contains('open')) {
        toggleMenu();
    }
    showToast('Logged out successfully');

    // Tell Flutter to HIDE the native bottom nav
    if (window.FlutterBridge) {
        window.FlutterBridge.postMessage(JSON.stringify({ type: 'auth_change', status: 'logged_out' }));
    }
}
