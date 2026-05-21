// Role configurations and UI data
export const rolesData = {
    student: {
        name: 'Jamil Mahmud', roleLabel: 'Student', avatarSeed: 'Jamil',
        balanceIcon: 'ph-student', balanceAmount: '৳ 12,500.00',
        grid: [
            { action: 'openView("routineView", "Class Routine")', icon: 'ph-clock', color: 'ic-orange', label: 'Schedule' },
            { action: 'openView("attendanceView", "Attendance")', icon: 'ph-calendar-check', color: 'ic-green', label: 'Attendance' },
            { action: 'openView("resultView", "Academic Results")', icon: 'ph-chart-bar', color: 'ic-blue', label: 'Results' },
            { action: 'openView("feesView", "Fee Payment")', icon: 'ph-credit-card', color: 'ic-purple', label: 'Fee Payment' },
            { action: 'openView("profileView", "My Profile")', icon: 'ph-user', color: 'ic-teal', label: 'Profile' },
            { action: 'showToast("Assignments Opened")', icon: 'ph-file-text', color: 'ic-red', label: 'Assignments' },
            { action: 'showToast("Transport Opened")', icon: 'ph-bus', color: 'ic-blue', label: 'Transport' },
            { action: 'showToast("Notices Opened")', icon: 'ph-megaphone', color: 'ic-red', label: 'Notices' }
        ],
        quick: [
            { action: 'showToast("Events")', icon: 'ph-confetti', color: '#f39c12', label: 'Events' },
            { action: 'showToast("Scholarship")', icon: 'ph-medal', color: '#3498db', label: 'Scholarship' },
            { action: 'showToast("Hostel Dues")', icon: 'ph-house', color: '#9b59b6', label: 'Hostel Dues' }
        ]
    },
    teacher: {
        name: 'Prof. Anisul Islam', roleLabel: 'Teacher', avatarSeed: 'Anisul',
        balanceIcon: 'ph-wallet', balanceAmount: '৳ 45,000.00',
        grid: [
            { action: 'openView("routineView", "My Schedule")', icon: 'ph-clock', color: 'ic-orange', label: 'Schedule' },
            { action: 'openView("attendanceView", "Take Attendance")', icon: 'ph-calendar-plus', color: 'ic-green', label: 'Take Attend' },
            { action: 'openView("resultView", "Enter Marks")', icon: 'ph-clipboard-text', color: 'ic-red', label: 'Enter Marks' },
            { action: 'showToast("Student List Opened")', icon: 'ph-list-numbers', color: 'ic-purple', label: 'Student List' },
            { action: 'openView("profileView", "Teacher Profile")', icon: 'ph-user', color: 'ic-teal', label: 'Profile' },
            { action: 'showToast("My Classes")', icon: 'ph-users-three', color: 'ic-blue', label: 'My Classes' },
            { action: 'showToast("Leave Request")', icon: 'ph-paper-plane-tilt', color: 'ic-blue', label: 'Leave Req' },
            { action: 'showToast("Notices")', icon: 'ph-megaphone', color: 'ic-red', label: 'Notices' }
        ],
        quick: [
            { action: 'showToast("Staff Meeting")', icon: 'ph-users', color: '#f39c12', label: 'Staff Meet' },
            { action: 'showToast("Training")', icon: 'ph-presentation-chart', color: '#3498db', label: 'Training' },
            { action: 'showToast("Research")', icon: 'ph-flask', color: '#9b59b6', label: 'Research' }
        ]
    }
};

// Dummy data for all views
export const dummyViewData = {
    student: {
        profile: {
            id: '2024-EDU-1122', classRole: 'Computer Science (BSc)', rollLabel: 'Student Roll', roll: '14',
            field1Label: "Father's Name", field1Val: "Abdul Mahmud",
            field2Label: "Mother's Name", field2Val: "Salma Begum",
            address: 'Mirpur 10, Dhaka', phone: '01712-345678'
        },
        routine: [
            { title: 'Data Structures', subtitle: '8:00 AM - 9:30 AM', icon: 'ph-books', iconBg: 'rgba(142,124,195,0.1)', iconColor: 'var(--brand-color)', value: 'Room 302', subvalue: 'Prof. Ahmed', subStatus: 'neutral' },
            { title: 'Discrete Math', subtitle: '9:30 AM - 11:00 AM', icon: 'ph-function', iconBg: 'rgba(52, 152, 219, 0.1)', iconColor: '#3498db', value: 'Room 105', subvalue: 'Dr. Rahman', subStatus: 'neutral' },
            { title: 'Lunch Break', subtitle: '1:00 PM - 2:00 PM', icon: 'ph-coffee', iconBg: '#f0f0f0', iconColor: '#777', value: '-', subvalue: 'Break', subStatus: '' }
        ],
        attendance: { total: '21', present: '19', absent: '1' },
        finance: {
            title: 'Total Fees Due', amount: '৳ 2,500',
            history: [
                { title: 'November - 2024', subtitle: 'Inv: 1903235135', icon: 'ph-receipt', iconBg: 'rgba(231, 76, 60, 0.1)', iconColor: '#e74c3c', value: '৳ 2,500.00', subvalue: 'Due', subStatus: 'due' },
                { title: 'October - 2024', subtitle: 'Inv: 1903233565', icon: 'ph-check-circle', iconBg: 'rgba(46, 204, 113, 0.1)', iconColor: '#2ecc71', value: '৳ 5,000.00', subvalue: 'Paid', subStatus: 'paid' }
            ]
        },
        results: {
            grade: 'A-', total: '197 / 200', gpa: '3.83', position: '5th',
            subjects: [
                { title: 'Data Structures', subtitle: 'Count Mark: 80 | Total: 80', icon: 'A+', iconBg: 'rgba(46, 204, 113, 0.1)', iconColor: '#2ecc71', value: 'GPA: 4.0', subvalue: 'Excellent', subStatus: 'paid' },
                { title: 'Discrete Math', subtitle: 'Count Mark: 55 | Total: 55', icon: 'B', iconBg: 'rgba(243, 156, 18, 0.1)', iconColor: '#f39c12', value: 'GPA: 3.0', subvalue: 'Good', subStatus: 'neutral' }
            ]
        },
        dash: {
            stats: [
                { label: 'Current GPA', value: '3.83', icon: 'ph-graduation-cap', color: '#8E7CC3' },
                { label: 'Attendance', value: '94%', icon: 'ph-calendar-check', color: '#2ecc71' },
                { label: 'Pending Due', value: '৳ 2.5K', icon: 'ph-money', color: '#e74c3c' },
                { label: 'Assignments', value: '3', icon: 'ph-file-text', color: '#3498db' }
            ],
            chartTitle: 'Monthly Performance',
            chartConfig: {
                type: 'line',
                data: {
                    labels: ['Jul', 'Aug', 'Sep', 'Oct', 'Nov'],
                    datasets: [{
                        label: 'Scores (%)',
                        data: [75, 82, 88, 85, 92],
                        borderColor: '#8E7CC3',
                        backgroundColor: 'rgba(142,124,195,0.2)',
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: { y: { beginAtZero: true, max: 100 } }
                }
            },
            listTitle: 'Recent Activity',
            activities: [
                { title: 'Math Assignment', subtitle: 'Submitted', icon: 'ph-check-circle', iconBg: 'rgba(46, 204, 113, 0.1)', iconColor: '#2ecc71', value: 'On Time', subvalue: 'Today', subStatus: 'paid' },
                { title: 'Library Book', subtitle: 'Due in 2 days', icon: 'ph-books', iconBg: 'rgba(243, 156, 18, 0.1)', iconColor: '#f39c12', value: 'Physics', subvalue: 'Pending', subStatus: 'neutral' }
            ]
        }
    },
    teacher: {
        profile: {
            id: 'EMP-2015-045', classRole: 'Senior Lecturer', rollLabel: 'Department', roll: 'CSE Dept.',
            field1Label: "Joining Date", field1Val: "12 Jan 2015",
            field2Label: "Qualification", field2Val: "MSc in CS",
            address: 'Dhanmondi, Dhaka', phone: '01819-123456'
        },
        routine: [
            { title: 'Data Structures (A)', subtitle: '8:00 AM - 9:30 AM', icon: 'ph-users-three', iconBg: 'rgba(142,124,195,0.1)', iconColor: 'var(--brand-color)', value: 'Room 302', subvalue: '45 Students', subStatus: 'neutral' },
            { title: 'Algorithms (C)', subtitle: '10:00 AM - 11:30 AM', icon: 'ph-users-three', iconBg: 'rgba(46, 204, 113, 0.1)', iconColor: '#2ecc71', value: 'Room 305', subvalue: '38 Students', subStatus: 'neutral' }
        ],
        attendance: { total: '21', present: '21', absent: '0' },
        finance: {
            title: 'Next Salary Date', amount: '01 Dec 2024',
            history: [
                { title: 'October - 2024', subtitle: 'Ref: SAL-OCT-45', icon: 'ph-wallet', iconBg: 'rgba(46, 204, 113, 0.1)', iconColor: '#2ecc71', value: '৳ 45,000.00', subvalue: 'Credited', subStatus: 'paid' },
                { title: 'September - 2024', subtitle: 'Ref: SAL-SEP-45', icon: 'ph-wallet', iconBg: 'rgba(46, 204, 113, 0.1)', iconColor: '#2ecc71', value: '৳ 45,000.00', subvalue: 'Credited', subStatus: 'paid' }
            ]
        },
        results: {
            grade: 'B+', total: 'Pass: 95%', gpa: '3.42', position: 'Class: CS-A',
            subjects: [
                { title: 'Highest Score', subtitle: 'Data Structures', icon: '98', iconBg: 'rgba(46, 204, 113, 0.1)', iconColor: '#2ecc71', value: 'Grade: A+', subvalue: 'Outstanding', subStatus: 'paid' },
                { title: 'Average Score', subtitle: 'Data Structures', icon: '72', iconBg: 'rgba(243, 156, 18, 0.1)', iconColor: '#f39c12', value: 'Grade: A-', subvalue: 'Good', subStatus: 'neutral' }
            ]
        },
        dash: {
            stats: [
                { label: 'Classes Today', value: '4', icon: 'ph-users-three', color: '#8E7CC3' },
                { label: 'Avg Attend', value: '88%', icon: 'ph-chart-line-up', color: '#2ecc71' },
                { label: 'To Grade', value: '25', icon: 'ph-exam', color: '#e74c3c' },
                { label: 'Next Pay', value: 'Dec 1', icon: 'ph-calendar', color: '#3498db' }
            ],
            chartTitle: 'Class Attendance Average',
            chartConfig: {
                type: 'bar',
                data: {
                    labels: ['CS101', 'CS102', 'MATH201', 'PHY101'],
                    datasets: [{
                        label: 'Attendance (%)',
                        data: [85, 92, 78, 88],
                        backgroundColor: '#8E7CC3',
                        borderRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: { y: { beginAtZero: true, max: 100 } }
                }
            },
            listTitle: 'Recent Tasks',
            activities: [
                { title: 'CS101 Midterms', subtitle: 'Grading Published', icon: 'ph-check-circle', iconBg: 'rgba(46, 204, 113, 0.1)', iconColor: '#2ecc71', value: '45/45', subvalue: 'Done', subStatus: 'paid' },
                { title: 'Leave Request', subtitle: 'For Nov 25', icon: 'ph-clock', iconBg: 'rgba(243, 156, 18, 0.1)', iconColor: '#f39c12', value: 'Pending', subvalue: 'HR Review', subStatus: 'neutral' }
            ]
        }
    }
};

// Helper function to build list items HTML
export const buildBkashList = (items) => items.map(item => `
    <div class="bkash-list-item" onclick="showToast('${item.title} Details')">
        <div class="bkash-list-icon" style="background: ${item.iconBg}; color: ${item.iconColor}; font-weight: bold; font-size: ${item.icon.length <= 2 ? '18px' : '24px'};">
            ${item.icon.startsWith('ph-') ? `<i class="ph ${item.icon}"></i>` : item.icon}
        </div>
        <div class="bkash-list-content">
            <div class="bkash-list-title">${item.title}</div>
            <div class="bkash-list-subtitle">${item.subtitle}</div>
        </div>
        <div class="bkash-list-right">
            <div class="bkash-list-value">${item.value}</div>
            <div class="bkash-list-subvalue ${item.subStatus}">${item.subvalue}</div>
        </div>
    </div>
`).join('');
