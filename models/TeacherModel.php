<?php
class TeacherModel extends Model {
    /**
     * Retrieve details of logged in teacher profile.
     */
    public static function getProfile() {
        $db = self::getDB();
        $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 2;
        
        if ($db) {
            $stmt = $db->prepare("SELECT * FROM teachers WHERE user_id = :user_id");
            $stmt->execute(['user_id' => $userId]);
            $profile = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($profile) {
                return [
                    'name' => $profile['full_name'],
                    'designation' => $profile['designation'],
                    'dept' => $profile['dept'],
                    'level' => $profile['level'],
                    'email' => $profile['email'],
                    'phone' => $profile['phone'],
                    'officePhone' => $profile['office_phone'],
                    'bloodGroup' => $profile['blood_group'],
                    'joiningDate' => $profile['joining_date'],
                    'address' => $profile['address'],
                    'dob' => $profile['dob'],
                    'nid' => $profile['nid'],
                    'avatarSeed' => $profile['avatar']
                ];
            }
        }
        
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

    /**
     * Fetch upcoming online classes and recorded lectures.
     */
    public static function getClassroom() {
        $db = self::getDB();
        $schoolCode = isset($_SESSION['school_code']) ? $_SESSION['school_code'] : 'DHAKA100';
        
        if ($db) {
            $stmtOnline = $db->prepare("SELECT title, subtitle, time, link, icon, icon_bg, icon_color FROM online_classes WHERE school_code = :school_code");
            $stmtOnline->execute(['school_code' => $schoolCode]);
            $online = $stmtOnline->fetchAll(PDO::FETCH_ASSOC);

            $stmtRecorded = $db->prepare("SELECT title, subtitle, duration, topic, icon, icon_bg, icon_color FROM recorded_classes WHERE school_code = :school_code");
            $stmtRecorded->execute(['school_code' => $schoolCode]);
            $recorded = $stmtRecorded->fetchAll(PDO::FETCH_ASSOC);
            
            return [
                'online' => $online,
                'recorded' => $recorded
            ];
        }
        
        return [
            'online' => [
                ['title' => 'Bangla 1st Paper (Class 8)', 'subtitle' => '38 Students Registered', 'icon' => 'ph-video-camera', 'iconBg' => 'rgba(142, 124, 195, 0.08)', 'iconColor' => 'var(--brand-color)', 'link' => 'https://meet.google.com/abc-defg-hij', 'time' => '10:00 AM']
            ],
            'recorded' => [
                ['title' => 'Bangla Grammar Lecture 3', 'subtitle' => 'Uploaded 2 days ago', 'icon' => 'ph-play-circle', 'iconBg' => 'rgba(142, 124, 195, 0.08)', 'iconColor' => 'var(--brand-color)', 'duration' => '30 Mins', 'topic' => 'Bangla']
            ]
        ];
    }

    /**
     * Fetch teacher daily duty routine structured by weekday.
     */
    public static function getRoutine() {
        $db = self::getDB();
        $schoolCode = isset($_SESSION['school_code']) ? $_SESSION['school_code'] : 'DHAKA100';
        
        if ($db) {
            $stmt = $db->prepare("SELECT day, title, subtitle, icon, icon_bg, icon_color, value, subvalue FROM routines WHERE school_code = :school_code AND role = 'teacher'");
            $stmt->execute(['school_code' => $schoolCode]);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            $routine = [
                'Saturday' => [],
                'Sunday' => [],
                'Monday' => [],
                'Tuesday' => [],
                'Wednesday' => [],
                'Thursday' => [],
                'Friday' => []
            ];
            
            foreach ($rows as $row) {
                $day = $row['day'];
                if (isset($routine[$day])) {
                    $routine[$day][] = [
                        'title' => $row['title'],
                        'subtitle' => $row['subtitle'],
                        'icon' => $row['icon'],
                        'iconBg' => $row['icon_bg'],
                        'iconColor' => $row['icon_color'],
                        'value' => $row['value'],
                        'subvalue' => $row['subvalue'],
                        'subStatus' => 'neutral'
                    ];
                }
            }
            return $routine;
        }
        
        return [];
    }

    /**
     * Fetch teacher personal attendance summary statistics.
     */
    public static function getAttendanceStats() {
        $db = self::getDB();
        $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 2;
        
        if ($db) {
            $currentMonth = date('Y-m');
            $stmt = $db->prepare("SELECT status, COUNT(*) as count FROM attendance WHERE user_id = :user_id AND date LIKE :month GROUP BY status");
            $stmt->execute([
                'user_id' => $userId,
                'month' => "$currentMonth%"
            ]);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            $stats = ['total' => 0, 'present' => 0, 'absent' => 0, 'leave' => 0];
            foreach ($rows as $row) {
                if ($row['status'] === 'P') {
                    $stats['present'] = (int)$row['count'];
                } elseif ($row['status'] === 'A') {
                    $stats['absent'] = (int)$row['count'];
                } elseif ($row['status'] === 'L') {
                    $stats['leave'] = (int)$row['count'];
                }
            }
            $stats['total'] = $stats['present'] + $stats['absent'] + $stats['leave'];
            return [
                'total' => (string)$stats['total'],
                'present' => (string)$stats['present'],
                'absent' => (string)$stats['absent'],
                'leave' => (string)$stats['leave']
            ];
        }
        
        return ['total' => '5', 'present' => '5', 'absent' => '0', 'leave' => '0'];
    }

    /**
     * Fetch financial payroll history.
     */
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

    /**
     * Compile teacher dashboard statistics and pending updates.
     */
    public static function getDashboard() {
        $db = self::getDB();
        if ($db) {
            $totalStudents = self::num_of_rows('students');
            
            // Student attendance summary rate
            $currentMonth = date('Y-m');
            $stmtAtt = $db->prepare("SELECT status, COUNT(*) as count FROM attendance WHERE date LIKE :month GROUP BY status");
            $stmtAtt->execute(['month' => "$currentMonth%"]);
            $attRows = $stmtAtt->fetchAll(PDO::FETCH_ASSOC);
            $totalDays = 0; $presentDays = 0;
            foreach ($attRows as $row) {
                $totalDays += $row['count'];
                if ($row['status'] === 'P' || $row['status'] === 'L') {
                    $presentDays += $row['count'];
                }
            }
            $attendanceRate = $totalDays > 0 ? round(($presentDays / $totalDays) * 100) : 95;
            
            return [
                'stats' => [
                    ['label' => 'Total Students', 'value' => (string)$totalStudents, 'icon' => 'ph-users-three', 'color' => '#8E7CC3'],
                    ['label' => 'Avg Attendance', 'value' => $attendanceRate . '%', 'icon' => 'ph-chart-line-up', 'color' => '#2ecc71'],
                    ['label' => 'To Grade', 'value' => '5', 'icon' => 'ph-exam', 'color' => '#e74c3c'],
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
        
        return [
            'stats' => [
                ['label' => 'Classes Today', 'value' => '4', 'icon' => 'ph-users-three', 'color' => '#8E7CC3'],
                ['label' => 'Avg Attend', 'value' => '88%', 'icon' => 'ph-chart-line-up', 'color' => '#2ecc71'],
                ['label' => 'To Grade', 'value' => '25', 'icon' => 'ph-exam', 'color' => '#e74c3c'],
                ['label' => 'Next Pay', 'value' => 'Dec 1', 'icon' => 'ph-calendar', 'color' => '#3498db']
            ],
            'chartTitle' => 'Class Attendance Average',
            'listTitle' => 'Recent Tasks',
            'activities' => []
        ];
    }

    /**
     * Retrieve directory lists of students in classes.
     */
    public static function getStudents() {
        $db = self::getDB();
        if ($db) {
            $stmt = $db->query("SELECT id, uniq_id, roll, full_name as name, phone, avatar FROM students ORDER BY roll ASC");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        
        return [
            ['id' => 1, 'uniq_id' => 'EDU-STU-001', 'roll' => 1, 'name' => 'Anisur Rahman', 'phone' => '01711-223344', 'avatar' => 'Rahman']
        ];
    }

    /**
     * Retrieve exam tests assignments lists.
     */
    public static function getMarkEntryTests() {
        $db = self::getDB();
        $schoolCode = isset($_SESSION['school_code']) ? $_SESSION['school_code'] : 'DHAKA100';
        
        if ($db) {
            $stmt = $db->prepare("SELECT id, name, category, term FROM tests WHERE school_code = :school_code");
            $stmt->execute(['school_code' => $schoolCode]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        
        return [
            ['id' => 1, 'name' => 'Class Test 1', 'category' => 'Class Test', 'term' => '1st Term']
        ];
    }
}
