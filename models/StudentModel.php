<?php
class StudentModel {
    public static function getProfile() {
        return [
            'id' => '2026-EDU-1122',
            'classRole' => 'Class 8, Section Padma',
            'rollLabel' => 'Student Roll',
            'roll' => '14',
            'field1Label' => "Father's Name",
            'field1Val' => 'Abdul Mahmud',
            'field2Label' => "Mother's Name",
            'field2Val' => 'Salma Begum',
            'address' => 'Mirpur 10, Dhaka, Bangladesh',
            'phone' => '01712-345678',
            'nationality' => 'Bangladeshi',
            'dob' => '15 April 2011',
            'nid' => '20112695847123654'
        ];
    }

    public static function getClassroom() {
        return [
            'online' => [
                ['title' => 'Bangla 1st Paper class', 'subtitle' => 'Ms. Shila Begum', 'icon' => 'ph-video-camera', 'iconBg' => 'rgba(142, 124, 195, 0.08)', 'iconColor' => 'var(--brand-color)', 'link' => 'https://meet.google.com/abc-defg-hij', 'time' => '10:00 AM'],
                ['title' => 'Mathematics class', 'subtitle' => 'Mr. Rafiqul Islam', 'icon' => 'ph-video-camera', 'iconBg' => 'rgba(52, 152, 219, 0.08)', 'iconColor' => '#3498db', 'link' => 'https://meet.google.com/xyz-pqrs-tuv', 'time' => '11:30 AM']
            ],
            'recorded' => [
                ['title' => 'English Grammar - Parts of Speech', 'subtitle' => 'Ms. Nipa Sultana', 'icon' => 'ph-play-circle', 'iconBg' => 'rgba(243, 156, 18, 0.08)', 'iconColor' => '#f39c12', 'duration' => '24 Mins', 'topic' => 'English'],
                ['title' => 'Science - Force & Acceleration', 'subtitle' => 'Mr. Hasan Mahmud', 'icon' => 'ph-play-circle', 'iconBg' => 'rgba(231, 76, 60, 0.08)', 'iconColor' => '#e74c3c', 'duration' => '35 Mins', 'topic' => 'Physics'],
                ['title' => 'ICT - Internet Safety', 'subtitle' => 'Mr. Rahman', 'icon' => 'ph-play-circle', 'iconBg' => 'rgba(46, 204, 113, 0.08)', 'iconColor' => '#2ecc71', 'duration' => '18 Mins', 'topic' => 'ICT']
            ]
        ];
    }

    public static function getRoutine() {
        return [
            'Saturday' => [
                ['title' => 'Assembly & Dua', 'subtitle' => '8:15 AM - 8:35 AM', 'icon' => 'ph-church', 'iconBg' => 'rgba(46, 204, 113, 0.10)', 'iconColor' => '#2ecc71', 'value' => 'School Ground', 'subvalue' => 'All Students', 'subStatus' => 'neutral'],
                ['title' => 'Bangla 1st Paper', 'subtitle' => '8:40 AM - 9:20 AM', 'icon' => 'ph-book-open-text', 'iconBg' => 'rgba(142,124,195,0.1)', 'iconColor' => 'var(--brand-color)', 'value' => 'Room 8A', 'subvalue' => 'Ms. Shila Begum', 'subStatus' => 'neutral'],
                ['title' => 'Mathematics', 'subtitle' => '9:25 AM - 10:05 AM', 'icon' => 'ph-calculator', 'iconBg' => 'rgba(52, 152, 219, 0.10)', 'iconColor' => '#3498db', 'value' => 'Room 8A', 'subvalue' => 'Mr. Rafiqul Islam', 'subStatus' => 'neutral']
            ],
            'Sunday' => [
                ['title' => 'English Grammar', 'subtitle' => '8:30 AM - 9:10 AM', 'icon' => 'ph-spell-check', 'iconBg' => 'rgba(243, 156, 18, 0.10)', 'iconColor' => '#f39c12', 'value' => 'Room 8A', 'subvalue' => 'Ms. Nipa Sultana', 'subStatus' => 'neutral'],
                ['title' => 'General Science', 'subtitle' => '9:15 AM - 9:55 AM', 'icon' => 'ph-flask', 'iconBg' => 'rgba(231, 76, 60, 0.10)', 'iconColor' => '#e74c3c', 'value' => 'Lab Room', 'subvalue' => 'Mr. Hasan Mahmud', 'subStatus' => 'neutral'],
                ['title' => 'Religion & Ethics', 'subtitle' => '10:10 AM - 10:50 AM', 'icon' => 'ph-book-bookmark', 'iconBg' => 'rgba(46, 204, 113, 0.10)', 'iconColor' => '#2ecc71', 'value' => 'Room 8B', 'subvalue' => 'Moulvi Sahab', 'subStatus' => 'neutral']
            ],
            'Monday' => [
                ['title' => 'ICT Core', 'subtitle' => '8:30 AM - 9:10 AM', 'icon' => 'ph-desktop', 'iconBg' => 'rgba(52, 152, 219, 0.10)', 'iconColor' => '#3498db', 'value' => 'Computer Lab', 'subvalue' => 'Mr. Rahman', 'subStatus' => 'neutral'],
                ['title' => 'Bangla 2nd Paper', 'subtitle' => '9:15 AM - 9:55 AM', 'icon' => 'ph-book-open-text', 'iconBg' => 'rgba(142,124,195,0.1)', 'iconColor' => 'var(--brand-color)', 'value' => 'Room 8A', 'subvalue' => 'Ms. Shila Begum', 'subStatus' => 'neutral'],
                ['title' => 'Mathematics', 'subtitle' => '10:10 AM - 10:50 AM', 'icon' => 'ph-calculator', 'iconBg' => 'rgba(52, 152, 219, 0.10)', 'iconColor' => '#3498db', 'value' => 'Room 8A', 'subvalue' => 'Mr. Rafiqul Islam', 'subStatus' => 'neutral']
            ],
            'Tuesday' => [
                ['title' => 'General Science', 'subtitle' => '8:30 AM - 9:10 AM', 'icon' => 'ph-flask', 'iconBg' => 'rgba(231, 76, 60, 0.10)', 'iconColor' => '#e74c3c', 'value' => 'Lab Room', 'subvalue' => 'Mr. Hasan Mahmud', 'subStatus' => 'neutral'],
                ['title' => 'English Literature', 'subtitle' => '9:15 AM - 9:55 AM', 'icon' => 'ph-book-open', 'iconBg' => 'rgba(243, 156, 18, 0.10)', 'iconColor' => '#f39c12', 'value' => 'Room 8A', 'subvalue' => 'Ms. Nipa Sultana', 'subStatus' => 'neutral'],
                ['title' => 'Arts & Crafts', 'subtitle' => '10:10 AM - 10:50 AM', 'icon' => 'ph-palette', 'iconBg' => 'rgba(155, 89, 182, 0.10)', 'iconColor' => '#9b59b6', 'value' => 'Art Studio', 'subvalue' => 'Ms. Salma Begum', 'subStatus' => 'neutral']
            ],
            'Wednesday' => [
                ['title' => 'History & Culture', 'subtitle' => '8:30 AM - 9:10 AM', 'icon' => 'ph-compass', 'iconBg' => 'rgba(243, 156, 18, 0.10)', 'iconColor' => '#f39c12', 'value' => 'Room 8A', 'subvalue' => 'Mr. Kazi Hasan', 'subStatus' => 'neutral'],
                ['title' => 'Mathematics', 'subtitle' => '9:15 AM - 9:55 AM', 'icon' => 'ph-calculator', 'iconBg' => 'rgba(52, 152, 219, 0.10)', 'iconColor' => '#3498db', 'value' => 'Room 8A', 'subvalue' => 'Mr. Rafiqul Islam', 'subStatus' => 'neutral'],
                ['title' => 'Bangla Grammar', 'subtitle' => '10:10 AM - 10:50 AM', 'icon' => 'ph-book-open-text', 'iconBg' => 'rgba(142,124,195,0.1)', 'iconColor' => 'var(--brand-color)', 'value' => 'Room 8A', 'subvalue' => 'Ms. Shila Begum', 'subStatus' => 'neutral']
            ],
            'Thursday' => [
                ['title' => 'Physical Education', 'subtitle' => '8:30 AM - 9:10 AM', 'icon' => 'ph-activity', 'iconBg' => 'rgba(46, 204, 113, 0.10)', 'iconColor' => '#2ecc71', 'value' => 'Playground', 'subvalue' => 'Mr. Salam', 'subStatus' => 'neutral'],
                ['title' => 'English Composition', 'subtitle' => '9:15 AM - 9:55 AM', 'icon' => 'ph-pencil-line', 'iconBg' => 'rgba(243, 156, 18, 0.10)', 'iconColor' => '#f39c12', 'value' => 'Room 8A', 'subvalue' => 'Ms. Nipa Sultana', 'subStatus' => 'neutral'],
                ['title' => 'Science Lab', 'subtitle' => '10:10 AM - 11:30 AM', 'icon' => 'ph-atom', 'iconBg' => 'rgba(231, 76, 60, 0.10)', 'iconColor' => '#e74c3c', 'value' => 'Lab Room', 'subvalue' => 'Mr. Hasan Mahmud', 'subStatus' => 'neutral']
            ],
            'Friday' => [] // Weekend
        ];
    }

    public static function getExamRoutine() {
        return [
            ['title' => '1st Term - Bangla', 'subtitle' => 'Sunday, 10:00 AM - 12:00 PM', 'icon' => 'ph-clipboard-text', 'iconBg' => 'rgba(142,124,195,0.1)', 'iconColor' => 'var(--brand-color)', 'value' => 'Exam Hall 1', 'subvalue' => '100 Marks', 'subStatus' => 'neutral'],
            ['title' => '1st Term - Mathematics', 'subtitle' => 'Tuesday, 10:00 AM - 12:00 PM', 'icon' => 'ph-calculator', 'iconBg' => 'rgba(52, 152, 219, 0.10)', 'iconColor' => '#3498db', 'value' => 'Exam Hall 1', 'subvalue' => '100 Marks', 'subStatus' => 'neutral'],
            ['title' => 'Mid Term - English', 'subtitle' => 'Thursday, 10:00 AM - 12:00 PM', 'icon' => 'ph-pencil-line', 'iconBg' => 'rgba(243, 156, 18, 0.10)', 'iconColor' => '#f39c12', 'value' => 'Exam Hall 2', 'subvalue' => '50 Marks', 'subStatus' => 'neutral'],
            ['title' => 'Final Term - Science', 'subtitle' => 'Saturday, 10:00 AM - 12:00 PM', 'icon' => 'ph-atom', 'iconBg' => 'rgba(46, 204, 113, 0.10)', 'iconColor' => '#2ecc71', 'value' => 'Exam Hall 2', 'subvalue' => '100 Marks', 'subStatus' => 'neutral']
        ];
    }

    public static function getAttendanceStats() {
        return ['total' => '21', 'present' => '19', 'absent' => '1', 'leave' => '1'];
    }

    public static function getFinance() {
        return [
            'title' => 'Total Fees Due',
            'amount' => 'Tk. 2,500',
            'history' => [
                ['title' => 'November - 2024', 'subtitle' => 'Inv: 1903235135', 'icon' => 'ph-receipt', 'iconBg' => 'rgba(231, 76, 60, 0.1)', 'iconColor' => '#e74c3c', 'value' => 'Tk. 2,500.00', 'subvalue' => 'Due', 'subStatus' => 'due'],
                ['title' => 'October - 2024', 'subtitle' => 'Inv: 1903233565', 'icon' => 'ph-check-circle', 'iconBg' => 'rgba(46, 204, 113, 0.1)', 'iconColor' => '#2ecc71', 'value' => 'Tk. 5,000.00', 'subvalue' => 'Paid', 'subStatus' => 'paid']
            ]
        ];
    }

    public static function getResults() {
        return [
            'terms' => [
                [
                    'term' => '1st Term', 'grade' => 'A-', 'total' => '438 / 500', 'gpa' => '3.72', 'position' => 'Class 5th', 'note' => 'Strong performance in core subjects.',
                    'subjects' => [
                        ['name' => 'Bangla', 'marks' => 82, 'gpa' => 4.00, 'grade' => 'A'],
                        ['name' => 'English', 'marks' => 78, 'gpa' => 3.50, 'grade' => 'A-'],
                        ['name' => 'Mathematics', 'marks' => 95, 'gpa' => 5.00, 'grade' => 'A+'],
                        ['name' => 'Science', 'marks' => 88, 'gpa' => 4.00, 'grade' => 'A'],
                        ['name' => 'Religion', 'marks' => 95, 'gpa' => 5.00, 'grade' => 'A+']
                    ]
                ],
                [
                    'term' => 'Mid Term', 'grade' => 'A', 'total' => '451 / 500', 'gpa' => '3.88', 'position' => 'Class 3rd', 'note' => 'Improved marks in Bangla and Science.',
                    'subjects' => [
                        ['name' => 'Bangla', 'marks' => 88, 'gpa' => 4.00, 'grade' => 'A'],
                        ['name' => 'English', 'marks' => 84, 'gpa' => 4.00, 'grade' => 'A'],
                        ['name' => 'Mathematics', 'marks' => 92, 'gpa' => 5.00, 'grade' => 'A+'],
                        ['name' => 'Science', 'marks' => 90, 'gpa' => 5.00, 'grade' => 'A+'],
                        ['name' => 'Religion', 'marks' => 97, 'gpa' => 5.00, 'grade' => 'A+']
                    ]
                ],
                [
                    'term' => 'Final Term', 'grade' => 'A+', 'total' => '472 / 500', 'gpa' => '5.00', 'position' => 'Class 1st', 'note' => 'Excellent final term result.',
                    'subjects' => [
                        ['name' => 'Bangla', 'marks' => 91, 'gpa' => 5.00, 'grade' => 'A+'],
                        ['name' => 'English', 'marks' => 89, 'gpa' => 5.00, 'grade' => 'A+'],
                        ['name' => 'Mathematics', 'marks' => 98, 'gpa' => 5.00, 'grade' => 'A+'],
                        ['name' => 'Science', 'marks' => 94, 'gpa' => 5.00, 'grade' => 'A+'],
                        ['name' => 'Religion', 'marks' => 100, 'gpa' => 5.00, 'grade' => 'A+']
                    ]
                ]
            ]
        ];
    }

    public static function getTeachers() {
        return [
            ['name' => 'Kazi Hasan', 'designation' => 'Headmaster', 'avatar' => 'Hasan', 'phone' => '01711-223344'],
            ['name' => 'Salma Begum', 'designation' => 'Assistant Headmaster', 'avatar' => 'Salma', 'phone' => '01711-556677'],
            ['name' => 'Rafiqul Islam', 'designation' => 'Senior Mathematics Teacher', 'avatar' => 'Rafiqul', 'phone' => '01819-889900'],
            ['name' => 'Shila Begum', 'designation' => 'Bangla Teacher', 'avatar' => 'Shila', 'phone' => '01911-334455'],
            ['name' => 'Nipa Sultana', 'designation' => 'English Teacher', 'avatar' => 'Nipa', 'phone' => '01552-667788'],
            ['name' => 'Hasan Mahmud', 'designation' => 'Science Teacher', 'avatar' => 'HasanM', 'phone' => '01678-990011']
        ];
    }

    public static function getDashboard() {
        return [
            'stats' => [
                ['label' => 'Current GPA', 'value' => '3.87', 'icon' => 'ph-graduation-cap', 'color' => '#8E7CC3'],
                ['label' => 'Attendance', 'value' => '94%', 'icon' => 'ph-calendar-check', 'color' => '#2ecc71'],
                ['label' => 'Pending Due', 'value' => 'Tk. 2.5K', 'icon' => 'ph-money', 'color' => '#e74c3c'],
                ['label' => 'Assignments', 'value' => '3', 'icon' => 'ph-file-text', 'color' => '#3498db']
            ],
            'chartTitle' => 'Monthly Performance',
            'listTitle' => 'Recent Activity',
            'activities' => [
                ['title' => 'Math Assignment', 'subtitle' => 'Submitted', 'icon' => 'ph-check-circle', 'iconBg' => 'rgba(46, 204, 113, 0.1)', 'iconColor' => '#2ecc71', 'value' => 'On Time', 'subvalue' => 'Today', 'subStatus' => 'paid'],
                ['title' => 'Library Book', 'subtitle' => 'Due in 2 days', 'icon' => 'ph-books', 'iconBg' => 'rgba(243, 156, 18, 0.1)', 'iconColor' => '#f39c12', 'value' => 'Physics', 'subvalue' => 'Pending', 'subStatus' => 'neutral']
            ]
        ];
    }
}
