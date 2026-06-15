<?php
class TeacherModel {
    public static function getProfile() {
        return [
            'name' => 'Prof. Anisul Islam',
            'designation' => 'Principal & Tech Head',
            'dept' => 'General Section',
            'level' => 'Class Teacher, Grade 8',
            'email' => 'anisul.islam@edumanage.com',
            'phone' => '01819-123456',
            'officePhone' => '+880-2-998877',
            'bloodGroup' => 'O+ (Positive)',
            'joiningDate' => '12 Jan 2015',
            'address' => 'Dhanmondi, Dhaka, Bangladesh',
            'dob' => '04 Oct 1985',
            'nid' => '1985263598741',
            'avatarSeed' => 'Anisul'
        ];
    }

    public static function getClassroom() {
        return [
            'online' => [
                ['title' => 'Bangla 1st Paper (Class 8)', 'subtitle' => '38 Students Registered', 'icon' => 'ph-video-camera', 'iconBg' => 'rgba(142, 124, 195, 0.08)', 'iconColor' => 'var(--brand-color)', 'link' => 'https://meet.google.com/abc-defg-hij', 'time' => '10:00 AM']
            ],
            'recorded' => [
                ['title' => 'Bangla Grammar Lecture 3', 'subtitle' => 'Uploaded 2 days ago', 'icon' => 'ph-play-circle', 'iconBg' => 'rgba(142, 124, 195, 0.08)', 'iconColor' => 'var(--brand-color)', 'duration' => '30 Mins', 'topic' => 'Bangla']
            ]
        ];
    }

    public static function getRoutine() {
        return [
            'Saturday' => [
                ['title' => 'Class 8 - Bangla 1st Paper', 'subtitle' => '8:40 AM - 9:20 AM', 'icon' => 'ph-chalkboard-teacher', 'iconBg' => 'rgba(142,124,195,0.1)', 'iconColor' => 'var(--brand-color)', 'value' => 'Room 8A', 'subvalue' => 'Regular Class', 'subStatus' => 'neutral'],
                ['title' => 'Class 10 - Bangla Literature', 'subtitle' => '10:10 AM - 10:50 AM', 'icon' => 'ph-chalkboard-teacher', 'iconBg' => 'rgba(142,124,195,0.1)', 'iconColor' => 'var(--brand-color)', 'value' => 'Room 10B', 'subvalue' => 'Regular Class', 'subStatus' => 'neutral']
            ],
            'Sunday' => [
                ['title' => 'Class 7 - Bangla Grammar', 'subtitle' => '9:15 AM - 9:55 AM', 'icon' => 'ph-chalkboard', 'iconBg' => 'rgba(46, 204, 113, 0.1)', 'iconColor' => '#2ecc71', 'value' => 'Room 7B', 'subvalue' => 'Regular Class', 'subStatus' => 'neutral'],
                ['title' => 'Exam Guard Duty', 'subtitle' => '11:00 AM - 1:00 PM', 'icon' => 'ph-shield-check', 'iconBg' => 'rgba(231,76,60,0.1)', 'iconColor' => '#e74c3c', 'value' => 'Exam Hall 2', 'subvalue' => 'Guard Duty', 'subStatus' => 'due']
            ],
            'Monday' => [
                ['title' => 'Class 8 - Bangla 2nd Paper', 'subtitle' => '9:15 AM - 9:55 AM', 'icon' => 'ph-chalkboard-teacher', 'iconBg' => 'rgba(142,124,195,0.1)', 'iconColor' => 'var(--brand-color)', 'value' => 'Room 8A', 'subvalue' => 'Regular Class', 'subStatus' => 'neutral'],
                ['title' => 'Class 9 - Bangla Composition', 'subtitle' => '11:30 AM - 12:10 PM', 'icon' => 'ph-chalkboard-teacher', 'iconBg' => 'rgba(142,124,195,0.1)', 'iconColor' => 'var(--brand-color)', 'value' => 'Room 9A', 'subvalue' => 'Regular Class', 'subStatus' => 'neutral']
            ],
            'Tuesday' => [
                ['title' => 'Class 6 - Bangla Literature', 'subtitle' => '10:10 AM - 10:50 AM', 'icon' => 'ph-book-open-text', 'iconBg' => 'rgba(243, 156, 18, 0.10)', 'iconColor' => '#f39c12', 'value' => 'Room 6A', 'subvalue' => 'Regular Class', 'subStatus' => 'neutral'],
                ['title' => 'Academic Council Meeting', 'subtitle' => '1:00 PM - 2:00 PM', 'icon' => 'ph-users-three', 'iconBg' => 'rgba(52, 152, 219, 0.10)', 'iconColor' => '#3498db', 'value' => 'Conference Room', 'subvalue' => 'Staff Meeting', 'subStatus' => 'neutral']
            ],
            'Wednesday' => [
                ['title' => 'Class 8 - Bangla Grammar', 'subtitle' => '10:10 AM - 10:50 AM', 'icon' => 'ph-chalkboard-teacher', 'iconBg' => 'rgba(142,124,195,0.1)', 'iconColor' => 'var(--brand-color)', 'value' => 'Room 8A', 'subvalue' => 'Regular Class', 'subStatus' => 'neutral'],
                ['title' => 'Exam Guard Duty', 'subtitle' => '11:00 AM - 1:00 PM', 'icon' => 'ph-shield-check', 'iconBg' => 'rgba(231,76,60,0.1)', 'iconColor' => '#e74c3c', 'value' => 'Exam Hall 1', 'subvalue' => 'Guard Duty', 'subStatus' => 'due']
            ],
            'Thursday' => [
                ['title' => 'General Staff Meeting', 'subtitle' => '1:00 PM - 2:00 PM', 'icon' => 'ph-users', 'iconBg' => 'rgba(52, 152, 219, 0.10)', 'iconColor' => '#3498db', 'value' => 'Staff Room', 'subvalue' => 'All Faculty', 'subStatus' => 'neutral']
            ],
            'Friday' => [
                ['title' => 'Weekend (Friday)', 'subtitle' => 'Full Day', 'icon' => 'ph-sparkles', 'iconBg' => 'rgba(46, 204, 113, 0.1)', 'iconColor' => '#2ecc71', 'value' => 'Holiday', 'subvalue' => 'Weekend', 'subStatus' => 'paid']
            ]
        ];
    }

    public static function getAttendanceStats() {
        return ['total' => '21', 'present' => '21', 'absent' => '0', 'leave' => '0'];
    }

    public static function getFinance() {
        return [
            'title' => 'Next Salary Date',
            'amount' => '01 Dec 2024',
            'history' => [
                ['title' => 'October - 2024', 'subtitle' => 'Ref: SAL-OCT-45', 'icon' => 'ph-wallet', 'iconBg' => 'rgba(46, 204, 113, 0.1)', 'iconColor' => '#2ecc71', 'value' => 'Tk. 45,000.00', 'subvalue' => 'Credited', 'subStatus' => 'paid'],
                ['title' => 'September - 2024', 'subtitle' => 'Ref: SAL-SEP-45', 'icon' => 'ph-wallet', 'iconBg' => 'rgba(46, 204, 113, 0.1)', 'iconColor' => '#2ecc71', 'value' => 'Tk. 45,000.00', 'subvalue' => 'Credited', 'subStatus' => 'paid']
            ]
        ];
    }

    public static function getDashboard() {
        return [
            'stats' => [
                ['label' => 'Classes Today', 'value' => '4', 'icon' => 'ph-users-three', 'color' => '#8E7CC3'],
                ['label' => 'Avg Attend', 'value' => '88%', 'icon' => 'ph-chart-line-up', 'color' => '#2ecc71'],
                ['label' => 'To Grade', 'value' => '25', 'icon' => 'ph-exam', 'color' => '#e74c3c'],
                ['label' => 'Next Pay', 'value' => 'Dec 1', 'icon' => 'ph-calendar', 'color' => '#3498db']
            ],
            'chartTitle' => 'Class Attendance Average',
            'listTitle' => 'Recent Tasks',
            'activities' => [
                ['title' => 'CS101 Midterms', 'subtitle' => 'Grading Published', 'icon' => 'ph-check-circle', 'iconBg' => 'rgba(46, 204, 113, 0.1)', 'iconColor' => '#2ecc71', 'value' => '45/45', 'subvalue' => 'Done', 'subStatus' => 'paid'],
                ['title' => 'Leave Request', 'subtitle' => 'For Nov 25', 'icon' => 'ph-clock', 'iconBg' => 'rgba(243, 156, 18, 0.1)', 'iconColor' => '#f39c12', 'value' => 'Pending', 'subvalue' => 'HR Review', 'subStatus' => 'neutral']
            ]
        ];
    }

    public static function getStudents() {
        return [
            ['id' => 'EDU-STU-001', 'roll' => 1, 'name' => 'Anisur Rahman', 'phone' => '01711-223344', 'avatar' => 'Rahman'],
            ['id' => 'EDU-STU-002', 'roll' => 2, 'name' => 'Fatema Khatun', 'phone' => '01711-556677', 'avatar' => 'Fatema'],
            ['id' => 'EDU-STU-003', 'roll' => 3, 'name' => 'Jamil Mahmud', 'phone' => '01712-345678', 'avatar' => 'Jamil'],
            ['id' => 'EDU-STU-004', 'roll' => 4, 'name' => 'Tariqul Islam', 'phone' => '01819-889900', 'avatar' => 'Tariqul'],
            ['id' => 'EDU-STU-005', 'roll' => 5, 'name' => 'Sadia Sultana', 'phone' => '01911-334455', 'avatar' => 'Sadia']
        ];
    }

    public static function getMarkEntryTests() {
        return [
            ['id' => 't1', 'name' => 'Class Test 1', 'category' => 'Class Test', 'term' => '1st Term'],
            ['id' => 't2', 'name' => 'Class Test 2', 'category' => 'Class Test', 'term' => '1st Term'],
            ['id' => 't3', 'name' => 'Mid Term Quiz', 'category' => 'Model Test', 'term' => 'Mid Term'],
            ['id' => 't4', 'name' => 'Final Exam Bangla', 'category' => 'Term Exam', 'term' => 'Final Term']
        ];
    }
}
