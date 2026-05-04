// Helper Toast Function
function showMessage(title, detail) {
  const existingToast = document.querySelector('.toast-msg');
  if (existingToast) existingToast.remove();
  
  const toast = document.createElement('div');
  toast.className = 'toast-msg';
  toast.innerText = `${title}: ${detail}`;
  document.body.appendChild(toast);
  
  setTimeout(() => toast.remove(), 2000);
}

// Education Action Mapping
function getActionInfo(action) {
  const map = {
    assignment: { 
      title: '📝 Assignments', 
      detail: '3 pending: Math, Physics, English. Due this week.' 
    },
    attendance: { 
      title: '✅ Attendance', 
      detail: 'Overall 94% | This month: 18/20 days present.' 
    },
    results: { 
      title: '📊 Results', 
      detail: 'Midterm: A in CS, B+ in Calculus. View details.' 
    },
    schedule: { 
      title: '📅 Class Schedule', 
      detail: 'Today: 10:30 AM - Data Structures (Room 204).' 
    },
    fee: { 
      title: '💰 Fee Payment', 
      detail: 'Semester fee: $450 due by Dec 5. Easy pay.' 
    },
    library: { 
      title: '📖 Library', 
      detail: '2 books borrowed: "AI Basics" due Nov 28.' 
    },
    transport: { 
      title: '🚌 Transport', 
      detail: 'Bus route #4: pickup 7:45 AM from Main Gate.' 
    },
    notice: { 
      title: '📢 Notices', 
      detail: 'Sports meet registration open till Dec 10.' 
    },
    event: { 
      title: '🎓 Campus Events', 
      detail: 'Tech Fest on Dec 15 | Register now.' 
    },
    scholarship: { 
      title: '🏅 Scholarships', 
      detail: 'Merit scholarship: Min GPA 3.5, apply by Dec 1.' 
    },
    internship: { 
      title: '💼 Internships', 
      detail: 'Google & Microsoft internships: apply by Dec 1.' 
    },
    hostel: { 
      title: '🏠 Hostel Dues', 
      detail: 'Hostel fee for December: $200. Due 5th Dec.' 
    }
  };
  return map[action] || { title: 'Education Hub', detail: 'Explore more features soon.' };
}

// Menu Tray Controls
const menuTray = document.getElementById('menuTray');
const overlay = document.getElementById('menuOverlay');
const toggleBtn = document.getElementById('menuToggleBtn');

function openMenu() {
  menuTray.classList.add('open');
  overlay.classList.add('active');
  document.body.style.overflow = 'hidden';
}

function closeMenu() {
  menuTray.classList.remove('open');
  overlay.classList.remove('active');
  document.body.style.overflow = '';
}

if (toggleBtn) {
  toggleBtn.addEventListener('click', openMenu);
}

if (overlay) {
  overlay.addEventListener('click', closeMenu);
}

// Close menu on tray item click
const trayItems = document.querySelectorAll('.menu-item-tray');
trayItems.forEach(item => {
  item.addEventListener('click', (e) => {
    const trayAction = item.getAttribute('data-tray');
    
    const trayMessages = {
      dashboard: { title: '📊 Dashboard', detail: 'Your academic summary: GPA 3.78, attendance 94%, upcoming exams.' },
      profile: { title: '👤 My Profile', detail: 'Jamil Mahmud, ID:2024-EDU-1122, Email: jamil.m@edu.com, Department: CSE.' },
      courses: { title: '📚 Enrolled Courses', detail: 'Data Structures, Algorithms, AI, Web Dev, Database Systems.' },
      grades: { title: '🏆 Grade Reports', detail: 'Fall 2024: A (DS), A- (Algo), B+ (AI), Overall GPA 3.78' },
      'attendance-full': { title: '📆 Attendance History', detail: 'September: 92%, October: 95%, November: 94% (so far).' },
      payment: { title: '💳 Payment History', detail: 'Last payment: $500 on Oct 20. Outstanding: $350.' },
      support: { title: '🛟 Support', detail: 'Contact helpdesk@edumanage.com or call +880 1234 567890' },
      settings: { title: '⚙️ Settings', detail: 'Notification preferences, theme, language options coming soon.' }
    };
    
    const message = trayMessages[trayAction] || { title: 'Menu', detail: 'Navigating to ' + trayAction };
    showMessage(message.title, message.detail);
    closeMenu();
  });
});

// Logout simulation
const logoutBtn = document.getElementById('logoutBtn');
if (logoutBtn) {
  logoutBtn.addEventListener('click', () => {
    showMessage('🚪 Logged Out', 'You have been signed out. (Demo mode)');
    closeMenu();
  });
}

// Grid menu actions
const menuActions = document.querySelectorAll('.menu-item');
menuActions.forEach(el => {
  el.addEventListener('click', (e) => {
    const action = el.getAttribute('data-action');
    const info = getActionInfo(action);
    showMessage(info.title, info.detail);
  });
});

// Extra pills
const extraPills = document.querySelectorAll('.extra-pill');
extraPills.forEach(pill => {
  pill.addEventListener('click', () => {
    const action = pill.getAttribute('data-action');
    const info = getActionInfo(action);
    showMessage(info.title, info.detail);
  });
});

// Tap Balance
const balanceBtn = document.getElementById('tapBalanceBtn');
if (balanceBtn) {
  balanceBtn.addEventListener('click', () => {
    showMessage('💰 Academic Wallet', 'Current balance: $1,250. Upcoming fee: $350 (Library & Lab). Last payment: Nov 5');
  });
}

// Bottom navigation
const navItems = document.querySelectorAll('.nav-item');
navItems.forEach(nav => {
  nav.addEventListener('click', () => {
    navItems.forEach(n => n.classList.remove('active'));
    nav.classList.add('active');
    
    const navType = nav.getAttribute('data-nav');
    const navMessages = {
      home: { title: '🏠 Home', detail: 'Welcome back, Jamil! Check your schedule & announcements.' },
      myclass: { title: '📚 My Class', detail: 'CS 301: Database Systems. Next class: Tomorrow 9:30 AM.' },
      scanqr: { title: '📲 Scan QR', detail: 'Point camera to mark attendance or library check-in.' },
      inbox: { title: '💬 Inbox', detail: '2 unread: Professor Smith about project, Library reminder.' }
    };
    
    const message = navMessages[navType] || { title: 'Navigation', detail: 'Loading section...' };
    showMessage(message.title, message.detail);
  });
});

// Stat cards click
const statCards = document.querySelectorAll('.stat-card');
statCards.forEach(card => {
  card.addEventListener('click', () => {
    const statType = card.getAttribute('data-stat');
    const statMessages = {
      att: { title: '📊 Attendance', detail: 'Current: 94% | Excellent standing, no shortage.' },
      gpa: { title: '🎓 GPA', detail: 'Cumulative GPA: 3.78 | Dean\'s list candidate.' },
      credits: { title: '📘 Credits', detail: 'Remaining: 12 credits | Expected graduation: Fall 2025.' }
    };
    
    const message = statMessages[statType] || { title: 'Stats', detail: 'Detailed academic analytics' };
    showMessage(message.title, message.detail);
  });
});

// Notice board click
const notice = document.querySelector('.notice-board');
if (notice) {
  notice.addEventListener('click', () => {
    showMessage('📢 Notice Board', 'Mid-term schedule: 10-20 Dec. Admit card from 25 Nov. Check portal.');
  });
}

// Header icons click (notification and settings)
const headerIcons = document.querySelectorAll('.header-icon');
headerIcons.forEach((icon, index) => {
  icon.addEventListener('click', () => {
    if (index === 0) {
      showMessage('🔔 Notifications', 'No new notifications. Check back later for updates!');
    } else if (index === 1) {
      showMessage('⚡ Quick Actions', 'Quick access: Fee Payment, Attendance, Results');
    }
  });
});

// Prevent body scroll when menu open (handled in open/close)
// Add keyboard accessibility: close menu on Escape key
document.addEventListener('keydown', (e) => {
  if (e.key === 'Escape' && menuTray.classList.contains('open')) {
    closeMenu();
  }
});

console.log('EduManage App Initialized - Header & Footer with Colored Background');