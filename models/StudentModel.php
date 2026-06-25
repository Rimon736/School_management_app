<?php
class StudentModel extends Model {
    /**
     * Retrieve logged in student profile details from database.
     */
    public static function getProfile() {
        $db = self::getDB();
        $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 1; 
        
        if ($db) {
            $stmt = $db->prepare("SELECT * FROM students WHERE user_id = :user_id");
            $stmt->execute(['user_id' => $userId]);
            $profile = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($profile) {
                return [
                    'id' => $profile['uniq_id'],
                    'classRole' => $profile['class_name'] . ', Section ' . $profile['section_name'],
                    'rollLabel' => 'Student Roll',
                    'roll' => (string)$profile['roll'],
                    'field1Label' => "Father's Name",
                    'field1Val' => $profile['father_name'],
                    'field2Label' => "Mother's Name",
                    'field2Val' => $profile['mother_name'],
                    'address' => $profile['address'],
                    'phone' => $profile['phone'],
                    'nationality' => $profile['nationality'],
                    'dob' => $profile['dob'],
                    'nid' => $profile['nid']
                ];
            }
        }
        
        // Fallback mock array if DB connection fails
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
                ['title' => 'Bangla 1st Paper class', 'subtitle' => 'Ms. Shila Begum', 'icon' => 'ph-video-camera', 'iconBg' => 'rgba(142, 124, 195, 0.08)', 'iconColor' => 'var(--brand-color)', 'link' => 'https://meet.google.com/abc-defg-hij', 'time' => '10:00 AM'],
                ['title' => 'Mathematics class', 'subtitle' => 'Mr. Rafiqul Islam', 'icon' => 'ph-video-camera', 'iconBg' => 'rgba(52, 152, 219, 0.08)', 'iconColor' => '#3498db', 'link' => 'https://meet.google.com/xyz-pqrs-tuv', 'time' => '11:30 AM']
            ],
            'recorded' => [
                ['title' => 'English Grammar - Parts of Speech', 'subtitle' => 'Ms. Nipa Sultana', 'icon' => 'ph-play-circle', 'iconBg' => 'rgba(243, 156, 18, 0.08)', 'iconColor' => '#f39c12', 'duration' => '24 Mins', 'topic' => 'English']
            ]
        ];
    }

    /**
     * Fetch class routine schedules structured by weekday.
     */
    public static function getRoutine() {
        $db = self::getDB();
        $schoolCode = isset($_SESSION['school_code']) ? $_SESSION['school_code'] : 'DHAKA100';
        
        if ($db) {
            $stmt = $db->prepare("SELECT day, title, subtitle, icon, icon_bg, icon_color, value, subvalue FROM routines WHERE school_code = :school_code AND role = 'student'");
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
        
        return [
            'Saturday' => [
                ['title' => 'Assembly & Dua', 'subtitle' => '8:15 AM - 8:35 AM', 'icon' => 'ph-church', 'iconBg' => 'rgba(46, 204, 113, 0.10)', 'iconColor' => '#2ecc71', 'value' => 'School Ground', 'subvalue' => 'All Students', 'subStatus' => 'neutral']
            ]
        ];
    }

    /**
     * Fetch exam routine schedules.
     */
    public static function getExamRoutine() {
        return [
            ['title' => '1st Term - Bangla', 'subtitle' => 'Sunday, 10:00 AM - 12:00 PM', 'icon' => 'ph-clipboard-text', 'iconBg' => 'rgba(142,124,195,0.1)', 'iconColor' => 'var(--brand-color)', 'value' => 'Exam Hall 1', 'subvalue' => '100 Marks', 'subStatus' => 'neutral'],
            ['title' => '1st Term - Mathematics', 'subtitle' => 'Tuesday, 10:00 AM - 12:00 PM', 'icon' => 'ph-calculator', 'iconBg' => 'rgba(52, 152, 219, 0.10)', 'iconColor' => '#3498db', 'value' => 'Exam Hall 1', 'subvalue' => '100 Marks', 'subStatus' => 'neutral'],
            ['title' => 'Mid Term - English', 'subtitle' => 'Thursday, 10:00 AM - 12:00 PM', 'icon' => 'ph-pencil-line', 'iconBg' => 'rgba(243, 156, 18, 0.10)', 'iconColor' => '#f39c12', 'value' => 'Exam Hall 2', 'subvalue' => '50 Marks', 'subStatus' => 'neutral'],
            ['title' => 'Final Term - Science', 'subtitle' => 'Saturday, 10:00 AM - 12:00 PM', 'icon' => 'ph-atom', 'iconBg' => 'rgba(46, 204, 113, 0.10)', 'iconColor' => '#2ecc71', 'value' => 'Exam Hall 2', 'subvalue' => '100 Marks', 'subStatus' => 'neutral']
        ];
    }

    /**
     * Compute current month attendance summary metrics.
     */
    public static function getAttendanceStats() {
        $db = self::getDB();
        $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 1;
        
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
        
        return ['total' => '10', 'present' => '8', 'absent' => '1', 'leave' => '1'];
    }

    /**
     * Fetch billing invoices and outstanding financial obligations.
     */
    public static function getFinance() {
        $db = self::getDB();
        $studentId = isset($_SESSION['student_db_id']) ? $_SESSION['student_db_id'] : 1;
        
        if ($db) {
            $stmtDue = $db->prepare("SELECT SUM(amount) as total_due FROM fees WHERE student_id = :student_id AND status = 'due'");
            $stmtDue->execute(['student_id' => $studentId]);
            $dueAmount = $stmtDue->fetchColumn();
            
            $stmtHist = $db->prepare("SELECT title, invoice_no as subtitle, status, amount, due_date FROM fees WHERE student_id = :student_id ORDER BY id DESC");
            $stmtHist->execute(['student_id' => $studentId]);
            $fees = $stmtHist->fetchAll(PDO::FETCH_ASSOC);
            
            $history = [];
            foreach ($fees as $fee) {
                $status = $fee['status'];
                $isPaid = ($status === 'paid');
                $history[] = [
                    'title' => $fee['title'],
                    'subtitle' => 'Inv: ' . $fee['subtitle'],
                    'icon' => $isPaid ? 'ph-check-circle' : 'ph-receipt',
                    'iconBg' => $isPaid ? 'rgba(46, 204, 113, 0.1)' : 'rgba(231, 76, 60, 0.1)',
                    'iconColor' => $isPaid ? '#2ecc71' : '#e74c3c',
                    'value' => 'Tk. ' . number_format($fee['amount'], 2),
                    'subvalue' => ucfirst($status),
                    'subStatus' => $status
                ];
            }
            
            return [
                'title' => 'Total Fees Due',
                'amount' => 'Tk. ' . number_format($dueAmount ? $dueAmount : 0, 0),
                'history' => $history
            ];
        }
        
        return [
            'title' => 'Total Fees Due',
            'amount' => 'Tk. 2,500',
            'history' => []
        ];
    }

    /**
     * Fetch class grade cards and detailed subject mark lists.
     */
    public static function getResults() {
        $db = self::getDB();
        $studentId = isset($_SESSION['student_db_id']) ? $_SESSION['student_db_id'] : 1;
        
        if ($db) {
            $stmtTerms = $db->prepare("SELECT * FROM term_results WHERE student_id = :student_id");
            $stmtTerms->execute(['student_id' => $studentId]);
            $terms = $stmtTerms->fetchAll(PDO::FETCH_ASSOC);
            
            $resultsList = [];
            foreach ($terms as $term) {
                $stmtSubjects = $db->prepare("SELECT subject_name as name, marks, gpa, grade FROM subject_results WHERE term_result_id = :term_result_id");
                $stmtSubjects->execute(['term_result_id' => $term['id']]);
                $subjects = $stmtSubjects->fetchAll(PDO::FETCH_ASSOC);
                
                $resultsList[] = [
                    'term' => $term['term'],
                    'grade' => $term['grade'],
                    'total' => $term['total'],
                    'gpa' => (string)number_format($term['gpa'], 2),
                    'position' => $term['position'],
                    'note' => $term['note'],
                    'subjects' => $subjects
                ];
            }
            return ['terms' => $resultsList];
        }
        
        return ['terms' => []];
    }

    /**
     * Fetch list of school faculty members.
     */
    public static function getTeachers() {
        $db = self::getDB();
        if ($db) {
            $stmt = $db->query("SELECT full_name as name, designation, avatar, phone FROM teachers");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        
        return [
            ['name' => 'Kazi Hasan', 'designation' => 'Headmaster', 'avatar' => 'Hasan', 'phone' => '01711-223344']
        ];
    }

    /**
     * Compile student landing page stats and recent activities.
     */
    public static function getDashboard() {
        $db = self::getDB();
        $studentId = isset($_SESSION['student_db_id']) ? $_SESSION['student_db_id'] : 1;
        $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 1;
        
        if ($db) {
            // Get current GPA (last recorded gpa)
            $stmtGpa = $db->prepare("SELECT gpa FROM term_results WHERE student_id = :student_id ORDER BY id DESC LIMIT 1");
            $stmtGpa->execute(['student_id' => $studentId]);
            $gpa = $stmtGpa->fetchColumn();
            
            // Get attendance stats for percentage calculation
            $currentMonth = date('Y-m');
            $stmtAtt = $db->prepare("SELECT status, COUNT(*) as count FROM attendance WHERE user_id = :user_id AND date LIKE :month GROUP BY status");
            $stmtAtt->execute(['user_id' => $userId, 'month' => "$currentMonth%"]);
            $attRows = $stmtAtt->fetchAll(PDO::FETCH_ASSOC);
            $totalDays = 0; $presentDays = 0;
            foreach ($attRows as $row) {
                $totalDays += $row['count'];
                if ($row['status'] === 'P' || $row['status'] === 'L') {
                    $presentDays += $row['count'];
                }
            }
            $attendanceRate = $totalDays > 0 ? round(($presentDays / $totalDays) * 100) : 100;
            
            // Get total pending fees
            $stmtFees = $db->prepare("SELECT SUM(amount) FROM fees WHERE student_id = :student_id AND status = 'due'");
            $stmtFees->execute(['student_id' => $studentId]);
            $dueFees = $stmtFees->fetchColumn();
            $dueFeesText = $dueFees > 0 ? ('Tk. ' . number_format($dueFees / 1000, 1) . 'K') : 'Tk. 0';
            
            return [
                'stats' => [
                    ['label' => 'Current GPA', 'value' => $gpa ? number_format($gpa, 2) : '0.00', 'icon' => 'ph-graduation-cap', 'color' => '#8E7CC3'],
                    ['label' => 'Attendance', 'value' => $attendanceRate . '%', 'icon' => 'ph-calendar-check', 'color' => '#2ecc71'],
                    ['label' => 'Pending Due', 'value' => $dueFeesText, 'icon' => 'ph-money', 'color' => '#e74c3c'],
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
        
        return [
            'stats' => [
                ['label' => 'Current GPA', 'value' => '3.87', 'icon' => 'ph-graduation-cap', 'color' => '#8E7CC3'],
                ['label' => 'Attendance', 'value' => '94%', 'icon' => 'ph-calendar-check', 'color' => '#2ecc71'],
                ['label' => 'Pending Due', 'value' => 'Tk. 2.5K', 'icon' => 'ph-money', 'color' => '#e74c3c'],
                ['label' => 'Assignments', 'value' => '3', 'icon' => 'ph-file-text', 'color' => '#3498db']
            ],
            'chartTitle' => 'Monthly Performance',
            'listTitle' => 'Recent Activity',
            'activities' => []
        ];
    }
}
