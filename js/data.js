// Role configurations and UI data
export const rolesData = {
    student: {
        name: 'Jamil Mahmud', roleLabel: 'Student', avatarSeed: 'Jamil',
        balanceIcon: 'ph-student', balanceAmount: '৳ 12,500.00',
        grid: [
            { action: 'openView("classroomView", "My Classroom")', icon: 'ph-chalkboard-teacher', color: 'ic-purple', label: 'Classroom' },
            { action: 'openView("routineView", "My Routine")', icon: 'ph-clock', color: 'ic-orange', label: 'Routine' },
            { action: 'openView("attendanceView", "Attendance")', icon: 'ph-calendar-check', color: 'ic-green', label: 'Attendance' },
            { action: 'openView("resultView", "Results")', icon: 'ph-chart-bar', color: 'ic-blue', label: 'Results' },
            { action: 'openView("profileView", "Profile")', icon: 'ph-user', color: 'ic-teal', label: 'Profile' },
            { action: 'openView("feesView", "Fees")', icon: 'ph-credit-card', color: 'ic-purple', label: 'Fees' },
            { action: 'openView("acadCalendarView", "Academic Calendar")', icon: 'ph-calendar', color: 'ic-orange', label: 'Academic Cal' },
            { action: 'openView("teachersView", "Teachers List")', icon: 'ph-users-three', color: 'ic-blue', label: 'Teachers' }
        ],
        quick: [
            { action: 'showToast("School Picnic Event")', icon: 'ph-confetti', color: '#f39c12', label: 'Events' },
            { action: 'showToast("Board Scholarship 2026")', icon: 'ph-medal', color: '#3498db', label: 'Scholarship' },
            { action: 'showToast("Hostel Dues for June")', icon: 'ph-house', color: '#9b59b6', label: 'Hostel Dues' }
        ]
    },
    teacher: {
        name: 'Prof. Anisul Islam', roleLabel: 'Teacher', avatarSeed: 'Anisul',
        balanceIcon: 'ph-wallet', balanceAmount: '৳ 45,000.00',
        grid: [
            { action: 'openView("teacherProfileView", "Teacher Profile")', icon: 'ph-user', color: 'ic-teal', label: 'Profile' },
            { action: 'openView("teacherOnlineClassView", "Online Classes")', icon: 'ph-video-camera', color: 'ic-purple', label: 'Online Class' },
            { action: 'openView("teacherMarkEntryView", "Mark Entry")', icon: 'ph-clipboard-text', color: 'ic-red', label: 'Mark Entry' },
            { action: 'openView("teacherStudentAttendanceView", "Student Attendance")', icon: 'ph-calendar-plus', color: 'ic-green', label: 'Take Attend' },
            { action: 'openView("teacherStudentListView", "Student List")', icon: 'ph-list-numbers', color: 'ic-blue', label: 'Student List' },
            { action: 'openView("teacherRoutineView", "Teacher Routine")', icon: 'ph-clock', color: 'ic-orange', label: 'Routine' },
            { action: 'openView("teacherPersonalAttendanceView", "Personal Attendance")', icon: 'ph-calendar-check', color: 'ic-teal', label: 'My Attendance' },
            { action: 'openView("acadCalendarView", "Academic Calendar")', icon: 'ph-calendar', color: 'ic-orange', label: 'Academic Cal' }
        ],
        quick: [
            { action: 'showToast("Staff Meeting Agenda")', icon: 'ph-users', color: '#f39c12', label: 'Staff Meet' },
            { action: 'showToast("Teacher Training Workshop")', icon: 'ph-presentation-chart', color: '#3498db', label: 'Training' },
            { action: 'showToast("Academic Research Plan")', icon: 'ph-flask', color: '#9b59b6', label: 'Research' }
        ]
    }
};

// Dummy data for all views
export const dummyViewData = {
    student: {
        profile: {
            id: '2024-SCH-1122', classRole: 'Class 8, Section A', rollLabel: 'Class Roll', roll: '14',
            field1Label: "Father's Name", field1Val: "Abdul Mahmud",
            field2Label: "Mother's Name", field2Val: "Salma Begum",
            address: 'Mirpur 10, Dhaka', phone: '01712-345678',
            nationality: 'Bangladeshi', dob: '15 April 2011'
        },
        classroom: {
            online: [
                { title: 'Bangla 1st Paper class', subtitle: 'Ms. Shila Begum', icon: 'ph-video-camera', iconBg: 'rgba(142, 124, 195, 0.08)', iconColor: 'var(--brand-color)', link: 'https://meet.google.com/abc-defg-hij', time: '10:00 AM' },
                { title: 'Mathematics class', subtitle: 'Mr. Rafiqul Islam', icon: 'ph-video-camera', iconBg: 'rgba(52, 152, 219, 0.08)', iconColor: '#3498db', link: 'https://meet.google.com/xyz-pqrs-tuv', time: '11:30 AM' }
            ],
            recorded: [
                { title: 'English Grammar - Parts of Speech', subtitle: 'Ms. Nipa Sultana', icon: 'ph-play-circle', iconBg: 'rgba(243, 156, 18, 0.08)', iconColor: '#f39c12', duration: '24 Mins', topic: 'English' },
                { title: 'Science - Force & Acceleration', subtitle: 'Mr. Hasan Mahmud', icon: 'ph-play-circle', iconBg: 'rgba(231, 76, 60, 0.08)', iconColor: '#e74c3c', duration: '35 Mins', topic: 'Physics' },
                { title: 'ICT - Internet Safety', subtitle: 'Mr. Rahman', icon: 'ph-play-circle', iconBg: 'rgba(46, 204, 113, 0.08)', iconColor: '#2ecc71', duration: '18 Mins', topic: 'ICT' }
            ]
        },
        classRoutine: {
            Saturday: [
                { title: 'Assembly & Dua', subtitle: '8:15 AM - 8:35 AM', icon: 'ph-church', iconBg: 'rgba(46, 204, 113, 0.10)', iconColor: '#2ecc71', value: 'School Ground', subvalue: 'All Students', subStatus: 'neutral' },
                { title: 'Bangla 1st Paper', subtitle: '8:40 AM - 9:20 AM', icon: 'ph-book-open-text', iconBg: 'rgba(142,124,195,0.1)', iconColor: 'var(--brand-color)', value: 'Room 8A', subvalue: 'Ms. Shila', subStatus: 'neutral' },
                { title: 'Mathematics', subtitle: '9:25 AM - 10:05 AM', icon: 'ph-calculator', iconBg: 'rgba(52, 152, 219, 0.10)', iconColor: '#3498db', value: 'Room 8A', subvalue: 'Mr. Karim', subStatus: 'neutral' }
            ],
            Sunday: [
                { title: 'English Grammar', subtitle: '8:30 AM - 9:10 AM', icon: 'ph-spell-check', iconBg: 'rgba(243, 156, 18, 0.10)', iconColor: '#f39c12', value: 'Room 8A', subvalue: 'Ms. Nipa', subStatus: 'neutral' },
                { title: 'General Science', subtitle: '9:15 AM - 9:55 AM', icon: 'ph-flask', iconBg: 'rgba(231, 76, 60, 0.10)', iconColor: '#e74c3c', value: 'Lab Room', subvalue: 'Mr. Hasan', subStatus: 'neutral' },
                { title: 'Religion & Ethics', subtitle: '10:10 AM - 10:50 AM', icon: 'ph-book-bookmark', iconBg: 'rgba(46, 204, 113, 0.10)', iconColor: '#2ecc71', value: 'Room 8B', subvalue: 'Moulvi Sahab', subStatus: 'neutral' }
            ],
            Monday: [
                { title: 'ICT Core', subtitle: '8:30 AM - 9:10 AM', icon: 'ph-desktop', iconBg: 'rgba(52, 152, 219, 0.10)', iconColor: '#3498db', value: 'Computer Lab', subvalue: 'Mr. Rahman', subStatus: 'neutral' },
                { title: 'Bangla 2nd Paper', subtitle: '9:15 AM - 9:55 AM', icon: 'ph-book-open-text', iconBg: 'rgba(142,124,195,0.1)', iconColor: 'var(--brand-color)', value: 'Room 8A', subvalue: 'Ms. Shila', subStatus: 'neutral' },
                { title: 'Mathematics', subtitle: '10:10 AM - 10:50 AM', icon: 'ph-calculator', iconBg: 'rgba(52, 152, 219, 0.10)', iconColor: '#3498db', value: 'Room 8A', subvalue: 'Mr. Karim', subStatus: 'neutral' }
            ],
            Tuesday: [
                { title: 'General Science', subtitle: '8:30 AM - 9:10 AM', icon: 'ph-flask', iconBg: 'rgba(231, 76, 60, 0.10)', iconColor: '#e74c3c', value: 'Lab Room', subvalue: 'Mr. Hasan', subStatus: 'neutral' },
                { title: 'English Literature', subtitle: '9:15 AM - 9:55 AM', icon: 'ph-book-open', iconBg: 'rgba(243, 156, 18, 0.10)', iconColor: '#f39c12', value: 'Room 8A', subvalue: 'Ms. Nipa', subStatus: 'neutral' },
                { title: 'Arts & Crafts', subtitle: '10:10 AM - 10:50 AM', icon: 'ph-palette', iconBg: 'rgba(155, 89, 182, 0.10)', iconColor: '#9b59b6', value: 'Art Studio', subvalue: 'Ms. Salma', subStatus: 'neutral' }
            ],
            Wednesday: [
                { title: 'History & Culture', subtitle: '8:30 AM - 9:10 AM', icon: 'ph-compass', iconBg: 'rgba(243, 156, 18, 0.10)', iconColor: '#f39c12', value: 'Room 8A', subvalue: 'Mr. Rafiq', subStatus: 'neutral' },
                { title: 'Mathematics', subtitle: '9:15 AM - 9:55 AM', icon: 'ph-calculator', iconBg: 'rgba(52, 152, 219, 0.10)', iconColor: '#3498db', value: 'Room 8A', subvalue: 'Mr. Karim', subStatus: 'neutral' },
                { title: 'Bangla Grammar', subtitle: '10:10 AM - 10:50 AM', icon: 'ph-book-open-text', iconBg: 'rgba(142,124,195,0.1)', iconColor: 'var(--brand-color)', value: 'Room 8A', subvalue: 'Ms. Shila', subStatus: 'neutral' }
            ],
            Thursday: [
                { title: 'Physical Education', subtitle: '8:30 AM - 9:10 AM', icon: 'ph-activity', iconBg: 'rgba(46, 204, 113, 0.10)', iconColor: '#2ecc71', value: 'Playground', subvalue: 'Mr. Salam', subStatus: 'neutral' },
                { title: 'English Composition', subtitle: '9:15 AM - 9:55 AM', icon: 'ph-pencil-line', iconBg: 'rgba(243, 156, 18, 0.10)', iconColor: '#f39c12', value: 'Room 8A', subvalue: 'Ms. Nipa', subStatus: 'neutral' },
                { title: 'Science Lab', subtitle: '10:10 AM - 11:30 AM', icon: 'ph-atom', iconBg: 'rgba(231, 76, 60, 0.10)', iconColor: '#e74c3c', value: 'Lab Room', subvalue: 'Mr. Hasan', subStatus: 'neutral' }
            ]
        },
        examRoutine: [
            { title: '1st Term - Bangla', subtitle: 'Sunday, 10:00 AM - 12:00 PM', icon: 'ph-clipboard-text', iconBg: 'rgba(142,124,195,0.1)', iconColor: 'var(--brand-color)', value: 'Exam Hall 1', subvalue: '100 Marks', subStatus: 'neutral' },
            { title: '1st Term - Mathematics', subtitle: 'Tuesday, 10:00 AM - 12:00 PM', icon: 'ph-calculator', iconBg: 'rgba(52, 152, 219, 0.10)', iconColor: '#3498db', value: 'Exam Hall 1', subvalue: '100 Marks', subStatus: 'neutral' },
            { title: 'Mid Term - English', subtitle: 'Thursday, 10:00 AM - 12:00 PM', icon: 'ph-pencil-line', iconBg: 'rgba(243, 156, 18, 0.10)', iconColor: '#f39c12', value: 'Exam Hall 2', subvalue: '50 Marks', subStatus: 'neutral' },
            { title: 'Final Term - Science', subtitle: 'Saturday, 10:00 AM - 12:00 PM', icon: 'ph-atom', iconBg: 'rgba(46, 204, 113, 0.10)', iconColor: '#2ecc71', value: 'Exam Hall 2', subvalue: '100 Marks', subStatus: 'neutral' }
        ],
        attendance: { total: '21', present: '19', absent: '1' },
        finance: {
            title: 'Total Fees Due', amount: 'Tk. 2,500',
            history: [
                { title: 'November - 2024', subtitle: 'Inv: 1903235135', icon: 'ph-receipt', iconBg: 'rgba(231, 76, 60, 0.1)', iconColor: '#e74c3c', value: 'Tk. 2,500.00', subvalue: 'Due', subStatus: 'due' },
                { title: 'October - 2024', subtitle: 'Inv: 1903233565', icon: 'ph-check-circle', iconBg: 'rgba(46, 204, 113, 0.1)', iconColor: '#2ecc71', value: 'Tk. 5,000.00', subvalue: 'Paid', subStatus: 'paid' }
            ]
        },
        results: {
            terms: [
                {
                    term: '1st Term', grade: 'A-', total: '438 / 500', gpa: '3.72', position: 'Class 5th', note: 'Strong performance in core subjects.',
                    subjects: [
                        { name: 'Bangla', marks: 82, gpa: 4.00, grade: 'A' },
                        { name: 'English', marks: 78, gpa: 3.50, grade: 'A-' },
                        { name: 'Mathematics', marks: 95, gpa: 5.00, grade: 'A+' },
                        { name: 'Science', marks: 88, gpa: 4.00, grade: 'A' },
                        { name: 'Religion', marks: 95, gpa: 5.00, grade: 'A+' }
                    ]
                },
                {
                    term: 'Mid Term', grade: 'A', total: '451 / 500', gpa: '3.88', position: 'Class 3rd', note: 'Improved marks in Bangla and Science.',
                    subjects: [
                        { name: 'Bangla', marks: 88, gpa: 4.00, grade: 'A' },
                        { name: 'English', marks: 84, gpa: 4.00, grade: 'A' },
                        { name: 'Mathematics', marks: 92, gpa: 5.00, grade: 'A+' },
                        { name: 'Science', marks: 90, gpa: 5.00, grade: 'A+' },
                        { name: 'Religion', marks: 97, gpa: 5.00, grade: 'A+' }
                    ]
                },
                {
                    term: 'Final Term', grade: 'A+', total: '472 / 500', gpa: '4.00', position: 'Class 1st', note: 'Excellent final term result.',
                    subjects: [
                        { name: 'Bangla', marks: 91, gpa: 5.00, grade: 'A+' },
                        { name: 'English', marks: 89, gpa: 5.00, grade: 'A+' },
                        { name: 'Mathematics', marks: 98, gpa: 5.00, grade: 'A+' },
                        { name: 'Science', marks: 94, gpa: 5.00, grade: 'A+' },
                        { name: 'Religion', marks: 100, gpa: 5.00, grade: 'A+' }
                    ]
                }
            ]
        },
        teachers: [
            { name: 'Kazi Hasan', designation: 'Headmaster', avatar: 'Hasan', phone: '01711-223344' },
            { name: 'Salma Begum', designation: 'Assistant Headmaster', avatar: 'Salma', phone: '01711-556677' },
            { name: 'Rafiqul Islam', designation: 'Senior Mathematics Teacher', avatar: 'Rafiqul', phone: '01819-889900' },
            { name: 'Shila Begum', designation: 'Bangla Teacher', avatar: 'Shila', phone: '01911-334455' },
            { name: 'Nipa Sultana', designation: 'English Teacher', avatar: 'Nipa', phone: '01552-667788' },
            { name: 'Hasan Mahmud', designation: 'Science Teacher', avatar: 'HasanM', phone: '01678-990011' }
        ],
        dash: {
            stats: [
                { label: 'Current GPA', value: '3.87', icon: 'ph-graduation-cap', color: '#8E7CC3' },
                { label: 'Attendance', value: '94%', icon: 'ph-calendar-check', color: '#2ecc71' },
                { label: 'Pending Due', value: 'Tk. 2.5K', icon: 'ph-money', color: '#e74c3c' },
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
            id: 'SCH-TEACH-045', classRole: 'Class Teacher, Grade 8', rollLabel: 'Department', roll: 'General Section',
            field1Label: "Joining Date", field1Val: "12 Jan 2015",
            field2Label: "Qualification", field2Val: "MSc in CS",
            address: 'Dhanmondi, Dhaka', phone: '01819-123456',
            nationality: 'Bangladeshi', dob: '04 Oct 1985',
            name: "Prof. Anisul Islam",
            designation: "Principal & Tech Head",
            dept: "General Section",
            level: "Class Teacher, Grade 8",
            email: "anisul.islam@edumanage.com",
            officePhone: "+880-2-998877",
            bloodGroup: "O+ (Positive)",
            joiningDate: "12 Jan 2015",
            nid: "1985263598741",
            avatarSeed: "Anisul"
        },
        classroom: {
            online: [
                { title: 'Bangla 1st Paper (Class 8)', subtitle: '38 Students Registered', icon: 'ph-video-camera', iconBg: 'rgba(142, 124, 195, 0.08)', iconColor: 'var(--brand-color)', link: 'https://meet.google.com/abc-defg-hij', time: '10:00 AM' }
            ],
            recorded: [
                { title: 'Bangla Grammar Lecture 3', subtitle: 'Uploaded 2 days ago', icon: 'ph-play-circle', iconBg: 'rgba(142, 124, 195, 0.08)', iconColor: 'var(--brand-color)', duration: '30 Mins', topic: 'Bangla' }
            ]
        },
        classRoutine: {
            Saturday: [
                { title: 'Class 8 - Bangla 1st Paper', subtitle: '8:40 AM - 9:20 AM', icon: 'ph-chalkboard-teacher', iconBg: 'rgba(142,124,195,0.1)', iconColor: 'var(--brand-color)', value: 'Room 8A', subvalue: '38 Students', subStatus: 'neutral' }
            ],
            Sunday: [
                { title: 'Class 7 - Bangla Grammar', subtitle: '9:15 AM - 9:55 AM', icon: 'ph-chalkboard', iconBg: 'rgba(46, 204, 113, 0.1)', iconColor: '#2ecc71', value: 'Room 7B', subvalue: '42 Students', subStatus: 'neutral' }
            ],
            Monday: [
                { title: 'Class 8 - Bangla 2nd Paper', subtitle: '9:15 AM - 9:55 AM', icon: 'ph-chalkboard-teacher', iconBg: 'rgba(142,124,195,0.1)', iconColor: 'var(--brand-color)', value: 'Room 8A', subvalue: '38 Students', subStatus: 'neutral' }
            ],
            Tuesday: [
                { title: 'Class 6 - Bangla Literature', subtitle: '10:10 AM - 10:50 AM', icon: 'ph-book-open-text', iconBg: 'rgba(243, 156, 18, 0.10)', iconColor: '#f39c12', value: 'Room 6A', subvalue: '35 Students', subStatus: 'neutral' }
            ],
            Wednesday: [
                { title: 'Class 8 - Bangla Grammar', subtitle: '10:10 AM - 10:50 AM', icon: 'ph-chalkboard-teacher', iconBg: 'rgba(142,124,195,0.1)', iconColor: 'var(--brand-color)', value: 'Room 8A', subvalue: '38 Students', subStatus: 'neutral' }
            ],
            Thursday: [
                { title: 'CS Staff Meeting', subtitle: '1:00 PM - 2:00 PM', icon: 'ph-users', iconBg: 'rgba(52, 152, 219, 0.10)', iconColor: '#3498db', value: 'Staff Room', subvalue: 'All Faculty', subStatus: 'neutral' }
            ]
        },
        teacherRoutine: {
            Saturday: [
                { title: 'Class 8 - Bangla 1st Paper', subtitle: '8:40 AM - 9:20 AM', icon: 'ph-chalkboard-teacher', iconBg: 'rgba(142,124,195,0.1)', iconColor: 'var(--brand-color)', value: 'Room 8A', subvalue: 'Regular Class', subStatus: 'neutral' },
                { title: 'Class 10 - Bangla Literature', subtitle: '10:10 AM - 10:50 AM', icon: 'ph-chalkboard-teacher', iconBg: 'rgba(142,124,195,0.1)', iconColor: 'var(--brand-color)', value: 'Room 10B', subvalue: 'Regular Class', subStatus: 'neutral' }
            ],
            Sunday: [
                { title: 'Class 7 - Bangla Grammar', subtitle: '9:15 AM - 9:55 AM', icon: 'ph-chalkboard', iconBg: 'rgba(46, 204, 113, 0.1)', iconColor: '#2ecc71', value: 'Room 7B', subvalue: 'Regular Class', subStatus: 'neutral' },
                { title: 'Exam Guard Duty', subtitle: '11:00 AM - 1:00 PM', icon: 'ph-shield-check', iconBg: 'rgba(231,76,60,0.1)', iconColor: '#e74c3c', value: 'Exam Hall 2', subvalue: 'Guard Duty', subStatus: 'due' }
            ],
            Monday: [
                { title: 'Class 8 - Bangla 2nd Paper', subtitle: '9:15 AM - 9:55 AM', icon: 'ph-chalkboard-teacher', iconBg: 'rgba(142,124,195,0.1)', iconColor: 'var(--brand-color)', value: 'Room 8A', subvalue: 'Regular Class', subStatus: 'neutral' },
                { title: 'Class 9 - Bangla Composition', subtitle: '11:30 AM - 12:10 PM', icon: 'ph-chalkboard-teacher', iconBg: 'rgba(142,124,195,0.1)', iconColor: 'var(--brand-color)', value: 'Room 9A', subvalue: 'Regular Class', subStatus: 'neutral' }
            ],
            Tuesday: [
                { title: 'Class 6 - Bangla Literature', subtitle: '10:10 AM - 10:50 AM', icon: 'ph-book-open-text', iconBg: 'rgba(243, 156, 18, 0.10)', iconColor: '#f39c12', value: 'Room 6A', subvalue: 'Regular Class', subStatus: 'neutral' },
                { title: 'Academic Council Meeting', subtitle: '1:00 PM - 2:00 PM', icon: 'ph-users-three', iconBg: 'rgba(52, 152, 219, 0.10)', iconColor: '#3498db', value: 'Conference Room', subvalue: 'Staff Meeting', subStatus: 'neutral' }
            ],
            Wednesday: [
                { title: 'Class 8 - Bangla Grammar', subtitle: '10:10 AM - 10:50 AM', icon: 'ph-chalkboard-teacher', iconBg: 'rgba(142,124,195,0.1)', iconColor: 'var(--brand-color)', value: 'Room 8A', subvalue: 'Regular Class', subStatus: 'neutral' },
                { title: 'Exam Guard Duty', subtitle: '11:00 AM - 1:00 PM', icon: 'ph-shield-check', iconBg: 'rgba(231,76,60,0.1)', iconColor: '#e74c3c', value: 'Exam Hall 1', subvalue: 'Guard Duty', subStatus: 'due' }
            ],
            Thursday: [
                { title: 'General Staff Meeting', subtitle: '1:00 PM - 2:00 PM', icon: 'ph-users', iconBg: 'rgba(52, 152, 219, 0.10)', iconColor: '#3498db', value: 'Staff Room', subvalue: 'All Faculty', subStatus: 'neutral' }
            ],
            Friday: [
                { title: 'Weekend (Friday)', subtitle: 'Full Day', icon: 'ph-sparkles', iconBg: 'rgba(46, 204, 113, 0.1)', iconColor: '#2ecc71', value: 'Holiday', subvalue: 'Weekend', subStatus: 'paid' }
            ]
        },
        examRoutine: [
            { title: 'Bangla Paper Review', subtitle: 'Sunday, 1:00 PM - 3:00 PM', icon: 'ph-pencil-simple', iconBg: 'rgba(231, 76, 60, 0.10)', iconColor: '#e74c3c', value: 'Exam Hall 1', subvalue: 'Class 8', subStatus: 'neutral' },
            { title: 'Math Exam Duty', subtitle: 'Tuesday, 10:00 AM - 12:00 PM', icon: 'ph-clipboard-text', iconBg: 'rgba(52, 152, 219, 0.10)', iconColor: '#3498db', value: 'Exam Hall 1', subvalue: 'Invigilator', subStatus: 'neutral' }
        ],
        attendance: { total: '21', present: '21', absent: '0' },
        finance: {
            title: 'Next Salary Date', amount: '01 Dec 2024',
            history: [
                { title: 'October - 2024', subtitle: 'Ref: SAL-OCT-45', icon: 'ph-wallet', iconBg: 'rgba(46, 204, 113, 0.1)', iconColor: '#2ecc71', value: 'Tk. 45,000.00', subvalue: 'Credited', subStatus: 'paid' },
                { title: 'September - 2024', subtitle: 'Ref: SAL-SEP-45', icon: 'ph-wallet', iconBg: 'rgba(46, 204, 113, 0.1)', iconColor: '#2ecc71', value: 'Tk. 45,000.00', subvalue: 'Credited', subStatus: 'paid' }
            ]
        },
        results: {
            terms: [
                {
                    term: '1st Term', grade: 'A', total: 'Class Avg 86%', gpa: '3.82', position: 'Section A', note: 'Homework submission was consistent.',
                    subjects: [
                        { name: 'Class 8 Bangla', marks: 'Avg 86', gpa: 3.82, grade: 'A' },
                        { name: 'Class 7 Bangla', marks: 'Avg 84', gpa: 3.70, grade: 'A-' }
                    ]
                },
                {
                    term: 'Mid Term', grade: 'A-', total: 'Class Avg 84%', gpa: '3.70', position: 'Section A', note: 'Good classroom participation.',
                    subjects: [
                        { name: 'Class 8 Bangla', marks: 'Avg 84', gpa: 3.70, grade: 'A-' },
                        { name: 'Class 7 Bangla', marks: 'Avg 85', gpa: 3.75, grade: 'A-' }
                    ]
                },
                {
                    term: 'Final Term', grade: 'A+', total: 'Class Avg 91%', gpa: '4.00', position: 'Section A', note: 'Excellent final assessment outcome.',
                    subjects: [
                        { name: 'Class 8 Bangla', marks: 'Avg 91', gpa: 4.00, grade: 'A+' },
                        { name: 'Class 7 Bangla', marks: 'Avg 89', gpa: 4.00, grade: 'A+' }
                    ]
                }
            ]
        },
        teachers: [
            { name: 'Prof. Anisul Islam', designation: 'Principal & Tech Head', avatar: 'Anisul', phone: '01712-345678' },
            { name: 'Kazi Hasan', designation: 'Headmaster', avatar: 'Hasan', phone: '01711-223344' },
            { name: 'Salma Begum', designation: 'Assistant Headmaster', avatar: 'Salma', phone: '01711-556677' }
        ],
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
