<?php
class TeacherController extends Controller {
    public function dashboard() {
        $data = [
            'profile' => TeacherModel::getProfile(),
            'dashboard' => TeacherModel::getDashboard()
        ];
        $this->render('teacher/dashboard', $data);
    }

    public function profile() {
        $data = [
            'profile' => TeacherModel::getProfile()
        ];
        $this->render('teacher/profile', $data);
    }

    public function online_class() {
        $data = [
            'classroom' => TeacherModel::getClassroom()
        ];
        $this->render('teacher/online_class', $data);
    }

    public function schedule_class_process() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = isset($_POST['title']) ? trim($_POST['title']) : '';
            $time = isset($_POST['time']) ? trim($_POST['time']) : '';
            $link = isset($_POST['link']) ? trim($_POST['link']) : '';
            $schoolCode = isset($_SESSION['school_code']) ? $_SESSION['school_code'] : 'DHAKA100';

            $db = Database::getInstance()->getConnection();
            if ($db && !empty($title) && !empty($time) && !empty($link)) {
                $stmt = $db->prepare("INSERT INTO online_classes (title, subtitle, time, link, school_code) VALUES (:title, 'Teacher Class', :time, :link, :school_code)");
                $stmt->execute([
                    'title' => $title,
                    'time' => $time,
                    'link' => $link,
                    'school_code' => $schoolCode
                ]);
            }
        }
        header('Location: index.php?controller=teacher&action=online_class');
        exit;
    }

    public function delete_class() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $db = Database::getInstance()->getConnection();
        if ($db && $id > 0) {
            $stmt = $db->prepare("DELETE FROM online_classes WHERE id = :id");
            $stmt->execute(['id' => $id]);
        }
        header('Location: index.php?controller=teacher&action=online_class');
        exit;
    }

    public function mark_entry() {
        $db = Database::getInstance()->getConnection();
        $marks = [];
        if ($db) {
            $stmt = $db->query("SELECT student_id, test_id, marks, remarks FROM student_marks");
            $marks = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        $data = [
            'students' => TeacherModel::getStudents(),
            'tests' => TeacherModel::getMarkEntryTests(),
            'marks' => $marks
        ];
        $this->render('teacher/mark_entry', $data);
    }

    public function save_marks_ajax() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $json = file_get_contents('php://input');
            $data = json_decode($json, true);
            
            if ($data && isset($data['marks'])) {
                $db = Database::getInstance()->getConnection();
                if ($db) {
                    $testId = isset($data['test_id']) ? $data['test_id'] : 1;
                    
                    foreach ($data['marks'] as $m) {
                        $stmtStu = $db->prepare("SELECT id FROM students WHERE roll = :roll LIMIT 1");
                        $stmtStu->execute(['roll' => $m['roll']]);
                        $stu = $stmtStu->fetch();
                        
                        if ($stu) {
                            $stmtMark = $db->prepare("INSERT INTO student_marks (student_id, test_id, marks, remarks) 
                                                      VALUES (:student_id, :test_id, :marks, :remarks)
                                                      ON CONFLICT(student_id, test_id) 
                                                      DO UPDATE SET marks = :marks, remarks = :remarks");
                            $stmtMark->execute([
                                'student_id' => $stu['id'],
                                'test_id' => $testId,
                                'marks' => (int)$m['marks'],
                                'remarks' => $m['remarks']
                            ]);
                        }
                    }
                    echo json_encode(['success' => true]);
                    exit;
                }
            }
        }
        echo json_encode(['success' => false]);
        exit;
    }

    public function add_test_ajax() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $json = file_get_contents('php://input');
            $data = json_decode($json, true);
            
            if ($data && !empty($data['name'])) {
                $db = Database::getInstance()->getConnection();
                if ($db) {
                    $schoolCode = isset($_SESSION['school_code']) ? $_SESSION['school_code'] : 'DHAKA100';
                    $stmt = $db->prepare("INSERT INTO tests (name, category, term, school_code) VALUES (:name, :category, :term, :school_code)");
                    $stmt->execute([
                        'name' => $data['name'],
                        'category' => $data['category'],
                        'term' => $data['term'],
                        'school_code' => $schoolCode
                    ]);
                    $id = $db->lastInsertId();
                    echo json_encode(['success' => true, 'id' => $id]);
                    exit;
                }
            }
        }
        echo json_encode(['success' => false]);
        exit;
    }

    public function student_attendance() {
        $class = isset($_GET['class']) ? trim($_GET['class']) : '';
        $section = isset($_GET['section']) ? trim($_GET['section']) : '';
        $date = isset($_GET['date']) ? trim($_GET['date']) : date('Y-m-d');
        
        $students = [];
        if (!empty($class) && !empty($section)) {
            $db = Database::getInstance()->getConnection();
            if ($db) {
                // Fetch students of this class and section
                $stmt = $db->prepare("SELECT id, user_id, roll, full_name, avatar FROM students WHERE class_name = :class AND section_name = :section ORDER BY roll ASC");
                $stmt->execute(['class' => $class, 'section' => $section]);
                $studentsList = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                // Fetch attendance status for each student on this date
                foreach ($studentsList as $s) {
                    $stmtAtt = $db->prepare("SELECT status, comments FROM attendance WHERE user_id = :user_id AND date = :date");
                    $stmtAtt->execute(['user_id' => $s['user_id'], 'date' => $date]);
                    $att = $stmtAtt->fetch(PDO::FETCH_ASSOC);
                    
                    $s['status'] = $att ? $att['status'] : 'P';
                    $s['comments'] = $att ? $att['comments'] : '';
                    $students[] = $s;
                }
            }
        }

        $data = [
            'students' => $students,
            'selectedClass' => $class,
            'selectedSection' => $section,
            'selectedDate' => $date
        ];
        $this->render('teacher/student_attendance', $data);
    }

    public function save_attendance_process() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $date = isset($_POST['date']) ? trim($_POST['date']) : date('Y-m-d');
            $class = isset($_POST['class']) ? trim($_POST['class']) : '';
            $section = isset($_POST['section']) ? trim($_POST['section']) : '';
            $attendanceData = isset($_POST['attendance']) ? $_POST['attendance'] : [];
            $commentsData = isset($_POST['comments']) ? $_POST['comments'] : [];

            $db = Database::getInstance()->getConnection();
            if ($db) {
                foreach ($attendanceData as $userId => $status) {
                    $comment = isset($commentsData[$userId]) ? trim($commentsData[$userId]) : '';
                    
                    $stmt = $db->prepare("INSERT INTO attendance (user_id, date, status, comments) 
                                          VALUES (:user_id, :date, :status, :comments)
                                          ON CONFLICT(user_id, date) 
                                          DO UPDATE SET status = :status, comments = :comments");
                    $stmt->execute([
                        'user_id' => $userId,
                        'date' => $date,
                        'status' => $status,
                        'comments' => empty($comment) ? null : $comment
                    ]);
                }
                $_SESSION['toast'] = "Attendance saved successfully for $class - $section.";
            }
        }
        header("Location: index.php?controller=teacher&action=student_attendance&date=$date&class=$class&section=$section");
        exit;
    }

    public function student_list() {
        $class = isset($_GET['class']) ? trim($_GET['class']) : '';
        $section = isset($_GET['section']) ? trim($_GET['section']) : '';
        
        $students = [];
        if (!empty($class) && !empty($section)) {
            $db = Database::getInstance()->getConnection();
            if ($db) {
                $stmt = $db->prepare("SELECT id, uniq_id, roll, full_name, phone, avatar FROM students WHERE class_name = :class AND section_name = :section ORDER BY roll ASC");
                $stmt->execute(['class' => $class, 'section' => $section]);
                $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        }
        
        $data = [
            'students' => $students,
            'selectedClass' => $class,
            'selectedSection' => $section
        ];
        $this->render('teacher/student_list', $data);
    }

    public function edit_student_process() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
            $name = isset($_POST['name']) ? trim($_POST['name']) : '';
            $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
            $class = isset($_POST['class']) ? trim($_POST['class']) : '';
            $section = isset($_POST['section']) ? trim($_POST['section']) : '';

            $db = Database::getInstance()->getConnection();
            if ($db && $id > 0 && !empty($name) && !empty($phone)) {
                $stmt = $db->prepare("UPDATE students SET full_name = :name, phone = :phone WHERE id = :id");
                $stmt->execute(['name' => $name, 'phone' => $phone, 'id' => $id]);
                $_SESSION['toast'] = "Student information updated successfully.";
            }
        }
        header("Location: index.php?controller=teacher&action=student_list&class=$class&section=$section");
        exit;
    }

    public function routine() {
        $data = [
            'routine' => TeacherModel::getRoutine()
        ];
        $this->render('teacher/routine', $data);
    }

    public function personal_attendance() {
        $data = [
            'attendance' => TeacherModel::getAttendanceStats()
        ];
        $this->render('teacher/personal_attendance', $data);
    }

    public function academic_calendar() {
        $this->render('teacher/academic_calendar');
    }

    public function notices() {
        $data = [
            'notices' => NoticeModel::getRecentNotices()
        ];
        $this->render('teacher/notices', $data);
    }

    public function qr() {
        $this->render('teacher/qr');
    }

    public function inbox() {
        $this->render('teacher/inbox');
    }
}
