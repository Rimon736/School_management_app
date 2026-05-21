// Shared UI functions
import { rolesData } from './data.js';

const balanceBtn = document.getElementById('balanceBtn');
const balanceText = document.getElementById('balanceText');
const sideMenu = document.getElementById('sideMenu');
const menuOverlay = document.getElementById('menuOverlay');
const toastEl = document.getElementById('toastMsg');

let balanceRevealed = false;
let balanceTimeout;
let toastTimeout;

export function showToast(message) {
    toastEl.innerText = message;
    toastEl.classList.add('show');

    clearTimeout(toastTimeout);
    toastTimeout = setTimeout(() => {
        toastEl.classList.remove('show');
    }, 2000);

    if (sideMenu.classList.contains('open') && message !== 'Options' && !message.includes('Details')) {
        toggleMenu();
    }
}

export function toggleMenu() {
    const isOpen = sideMenu.classList.contains('open');
    if (isOpen) {
        sideMenu.classList.remove('open');
        menuOverlay.classList.remove('active');
    } else {
        sideMenu.classList.add('open');
        menuOverlay.classList.add('active');
    }
}

export function toggleBalance(currentRole) {
    if (balanceRevealed) return;

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

export function enableNativeMode() {
    document.body.classList.add('native-mode');
    console.log("Native mode enabled by Flutter. Web UI adapted.");
}
