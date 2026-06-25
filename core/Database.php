<?php
class Database {
    private static $instance = null;
    private $pdo;

    // Private constructor prevents direct creation
    private function __construct() {
        $dbPath = __DIR__ . '/../database.sqlite';
        try {
            // Verify driver availability before attempting connection
            if (!class_exists('PDO') || !in_array('sqlite', PDO::getAvailableDrivers())) {
                throw new PDOException("SQLite PDO driver is not enabled in this PHP environment.");
            }
            // Setup SQLite PDO connection
            $this->pdo = new PDO("sqlite:" . $dbPath);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->initTables();
        } catch (PDOException $e) {
            // Fallback to null connection
            error_log("Database connection failed: " . $e->getMessage() . " Falling back to mock arrays.");
            $this->pdo = null;
        }
    }

    // Singleton getInstance method
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    // Get connection object
    public function getConnection() {
        return $this->pdo;
    }

    // Initialize sample tables and seed data automatically for the system
    private function initTables() {
        if (!$this->pdo) return;

        // Enable foreign key constraints in SQLite
        $this->pdo->exec("PRAGMA foreign_keys = ON");

        // 1. Schools table
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS schools (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            school_code TEXT UNIQUE NOT NULL,
            name TEXT NOT NULL,
            currency TEXT DEFAULT 'BDT',
            address TEXT
        )");

        // 2. Users table (authentication)
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            username TEXT UNIQUE NOT NULL,
            password TEXT NOT NULL,
            role TEXT NOT NULL CHECK(role IN ('student', 'teacher')),
            school_code TEXT NOT NULL REFERENCES schools(school_code) ON DELETE CASCADE
        )");

        // 3. Students table
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS students (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            user_id INTEGER NOT NULL REFERENCES users(id) ON DELETE CASCADE,
            uniq_id TEXT UNIQUE NOT NULL,
            full_name TEXT NOT NULL,
            nick_name TEXT,
            class_name TEXT NOT NULL,
            section_name TEXT NOT NULL,
            roll INTEGER NOT NULL,
            father_name TEXT,
            mother_name TEXT,
            guardian_name TEXT,
            guardian_phone TEXT,
            phone TEXT,
            email TEXT,
            address TEXT,
            nationality TEXT DEFAULT 'Bangladeshi',
            dob TEXT,
            nid TEXT,
            avatar TEXT
        )");

        // 4. Teachers table
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS teachers (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            user_id INTEGER NOT NULL REFERENCES users(id) ON DELETE CASCADE,
            full_name TEXT NOT NULL,
            designation TEXT NOT NULL,
            dept TEXT DEFAULT 'General Section',
            level TEXT,
            email TEXT,
            phone TEXT,
            office_phone TEXT,
            blood_group TEXT,
            joining_date TEXT,
            address TEXT,
            dob TEXT,
            nid TEXT,
            avatar TEXT
        )");

        // 5. Online Classes table
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS online_classes (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            title TEXT NOT NULL,
            subtitle TEXT,
            time TEXT NOT NULL,
            link TEXT NOT NULL,
            icon TEXT DEFAULT 'ph-video-camera',
            icon_bg TEXT DEFAULT 'rgba(142, 124, 195, 0.08)',
            icon_color TEXT DEFAULT 'var(--brand-color)',
            school_code TEXT NOT NULL REFERENCES schools(school_code) ON DELETE CASCADE
        )");

        // 6. Recorded Classes table
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS recorded_classes (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            title TEXT NOT NULL,
            subtitle TEXT,
            duration TEXT,
            topic TEXT,
            icon TEXT DEFAULT 'ph-play-circle',
            icon_bg TEXT DEFAULT 'rgba(142, 124, 195, 0.08)',
            icon_color TEXT DEFAULT 'var(--brand-color)',
            school_code TEXT NOT NULL REFERENCES schools(school_code) ON DELETE CASCADE
        )");

        // 7. Routines table (for class routines and teacher routine schedules)
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS routines (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            day TEXT NOT NULL,
            title TEXT NOT NULL,
            subtitle TEXT,
            icon TEXT,
            icon_bg TEXT,
            icon_color TEXT,
            value TEXT,
            subvalue TEXT,
            role TEXT CHECK(role IN ('student', 'teacher')),
            username TEXT, -- Specific student roll or teacher email/username if applicable, NULL for global class
            school_code TEXT NOT NULL REFERENCES schools(school_code) ON DELETE CASCADE
        )");

        // 8. Attendance table
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS attendance (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            user_id INTEGER NOT NULL REFERENCES users(id) ON DELETE CASCADE,
            date TEXT NOT NULL,
            status TEXT NOT NULL CHECK(status IN ('P', 'A', 'L')),
            late_time TEXT,
            comments TEXT,
            UNIQUE(user_id, date)
        )");

        // 9. Notices table
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS notices (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            title TEXT NOT NULL,
            date TEXT NOT NULL,
            file_name TEXT,
            file_size TEXT,
            uploader TEXT,
            category TEXT,
            icon TEXT DEFAULT 'ph-megaphone',
            color TEXT DEFAULT '#8E7CC3',
            school_code TEXT NOT NULL REFERENCES schools(school_code) ON DELETE CASCADE
        )");

        // 10. Fees table (for student fee tracking)
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS fees (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            student_id INTEGER NOT NULL REFERENCES students(id) ON DELETE CASCADE,
            title TEXT NOT NULL,
            invoice_no TEXT UNIQUE NOT NULL,
            amount REAL NOT NULL,
            status TEXT NOT NULL CHECK(status IN ('due', 'paid')),
            due_date TEXT NOT NULL,
            paid_date TEXT
        )");

        // 11. Term Results table (summary card data)
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS term_results (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            student_id INTEGER NOT NULL REFERENCES students(id) ON DELETE CASCADE,
            term TEXT NOT NULL,
            grade TEXT,
            total TEXT,
            gpa REAL,
            position TEXT,
            note TEXT
        )");

        // 12. Subject Results table (individual exam marks)
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS subject_results (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            term_result_id INTEGER NOT NULL REFERENCES term_results(id) ON DELETE CASCADE,
            subject_name TEXT NOT NULL,
            marks INTEGER NOT NULL,
            gpa REAL NOT NULL,
            grade TEXT NOT NULL
        )");

        // 13. Tests table (for teachers entering marks)
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS tests (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            category TEXT NOT NULL,
            term TEXT NOT NULL,
            school_code TEXT NOT NULL REFERENCES schools(school_code) ON DELETE CASCADE
        )");

        // 14. Student Marks table (dynamic grading entry database storage)
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS student_marks (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            student_id INTEGER NOT NULL REFERENCES students(id) ON DELETE CASCADE,
            test_id INTEGER NOT NULL REFERENCES tests(id) ON DELETE CASCADE,
            marks INTEGER DEFAULT 0,
            remarks TEXT,
            UNIQUE(student_id, test_id)
        )");

        // Seed data if empty
        $this->seedDatabase();
    }

    private function seedDatabase() {
        // Seed schools
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM schools");
        if ($stmt->fetchColumn() == 0) {
            $this->pdo->exec("INSERT INTO schools (school_code, name, currency, address) VALUES
                ('DHAKA100', 'EduManage High School (Dhaka)', 'BDT', 'Mirpur 10, Dhaka, Bangladesh'),
                ('CTG200', 'Chattogram Model Academy', 'BDT', 'Chawkbazar, Chattogram, Bangladesh')
            ");
        }

        // Seed users
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM users");
        if ($stmt->fetchColumn() == 0) {
            // Password hashes are plain text for simplicity as per requirement "keep id and pass same"
            $this->pdo->exec("INSERT INTO users (id, username, password, role, school_code) VALUES
                (1, 'EDU-STU-001', 'EDU-STU-001', 'student', 'DHAKA100'),
                (2, 'EDU-TEA-001', 'EDU-TEA-001', 'teacher', 'DHAKA100'),
                (3, 'EDU-STU-002', 'EDU-STU-002', 'student', 'DHAKA100'),
                (4, 'EDU-STU-003', 'EDU-STU-003', 'student', 'DHAKA100'),
                (5, 'EDU-STU-004', 'EDU-STU-004', 'student', 'DHAKA100'),
                (6, 'EDU-STU-005', 'EDU-STU-005', 'student', 'DHAKA100')
            ");

            // Seed students
            $this->pdo->exec("INSERT INTO students (user_id, uniq_id, full_name, nick_name, class_name, section_name, roll, father_name, mother_name, guardian_name, guardian_phone, phone, email, address, dob, nid, avatar) VALUES
                (1, '2026-EDU-1122', 'Anisur Rahman', 'Anis', 'Class 8', 'Padma', 14, 'Abdul Mahmud', 'Salma Begum', 'Abdul Mahmud', '01712-345678', '01712-345678', 'anisur@edumanage.com', 'Mirpur 10, Dhaka, Bangladesh', '15 April 2011', '20112695847123654', 'Rahman'),
                (3, '2026-EDU-1123', 'Fatema Khatun', 'Fatema', 'Class 8', 'Padma', 2, 'Rafiqul Islam', 'Jahanara Begum', 'Rafiqul Islam', '01711-556677', '01711-556677', 'fatema@edumanage.com', 'Dhanmondi, Dhaka, Bangladesh', '12 October 2011', '20112695847123655', 'Fatema'),
                (4, '2026-EDU-1124', 'Jamil Mahmud', 'Jamil', 'Class 8', 'Padma', 3, 'Farid Mahmud', 'Rehana Sultana', 'Farid Mahmud', '01712-345678', '01712-345678', 'jamil@edumanage.com', 'Uttara, Dhaka, Bangladesh', '05 March 2011', '20112695847123656', 'Jamil'),
                (5, '2026-EDU-1125', 'Tariqul Islam', 'Tariq', 'Class 8', 'Padma', 4, 'Hasanul Islam', 'Nazma Begum', 'Hasanul Islam', '01819-889900', '01819-889900', 'tariqul@edumanage.com', 'Gulshan, Dhaka, Bangladesh', '25 December 2011', '20112695847123657', 'Tariqul'),
                (6, '2026-EDU-1126', 'Sadia Sultana', 'Sadia', 'Class 8', 'Padma', 5, 'Kazi Jalal', 'Bina Begum', 'Kazi Jalal', '01911-334455', '01911-334455', 'sadia@edumanage.com', 'Banani, Dhaka, Bangladesh', '14 June 2011', '20112695847123658', 'Sadia')
            ");

            // Seed teachers
            $this->pdo->exec("INSERT INTO teachers (user_id, full_name, designation, dept, level, email, phone, office_phone, blood_group, joining_date, address, dob, nid, avatar) VALUES
                (2, 'Prof. Anisul Islam', 'Principal & Tech Head', 'General Section', 'Class Teacher, Grade 8', 'anisul.islam@edumanage.com', '01819-123456', '+880-2-998877', 'O+ (Positive)', '12 Jan 2015', 'Dhanmondi, Dhaka, Bangladesh', '04 Oct 1985', '1985263598741', 'Anisul')
            ");
        }

        // Seed online classes
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM online_classes");
        if ($stmt->fetchColumn() == 0) {
            $this->pdo->exec("INSERT INTO online_classes (title, subtitle, time, link, school_code) VALUES
                ('Bangla 1st Paper class', 'Ms. Shila Begum', '10:00 AM', 'https://meet.google.com/abc-defg-hij', 'DHAKA100'),
                ('Mathematics class', 'Mr. Rafiqul Islam', '11:30 AM', 'https://meet.google.com/xyz-pqrs-tuv', 'DHAKA100')
            ");
        }

        // Seed recorded classes
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM recorded_classes");
        if ($stmt->fetchColumn() == 0) {
            $this->pdo->exec("INSERT INTO recorded_classes (title, subtitle, duration, topic, school_code) VALUES
                ('English Grammar - Parts of Speech', 'Ms. Nipa Sultana', '24 Mins', 'English', 'DHAKA100'),
                ('Science - Force & Acceleration', 'Mr. Hasan Mahmud', '35 Mins', 'Physics', 'DHAKA100'),
                ('ICT - Internet Safety', 'Mr. Rahman', '18 Mins', 'ICT', 'DHAKA100')
            ");
        }

        // Seed routines
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM routines");
        if ($stmt->fetchColumn() == 0) {
            $this->pdo->exec("INSERT INTO routines (day, title, subtitle, icon, icon_bg, icon_color, value, subvalue, role, school_code) VALUES
                ('Saturday', 'Assembly & Dua', '8:15 AM - 8:35 AM', 'ph-church', 'rgba(46, 204, 113, 0.10)', '#2ecc71', 'School Ground', 'All Students', 'student', 'DHAKA100'),
                ('Saturday', 'Bangla 1st Paper', '8:40 AM - 9:20 AM', 'ph-book-open-text', 'rgba(142,124,195,0.1)', 'var(--brand-color)', 'Room 8A', 'Ms. Shila Begum', 'student', 'DHAKA100'),
                ('Saturday', 'Mathematics', '9:25 AM - 10:05 AM', 'ph-calculator', 'rgba(52, 152, 219, 0.10)', '#3498db', 'Room 8A', 'Mr. Rafiqul Islam', 'student', 'DHAKA100'),
                
                ('Sunday', 'English Grammar', '8:30 AM - 9:10 AM', 'ph-spell-check', 'rgba(243, 156, 18, 0.10)', '#f39c12', 'Room 8A', 'Ms. Nipa Sultana', 'student', 'DHAKA100'),
                ('Sunday', 'General Science', '9:15 AM - 9:55 AM', 'ph-flask', 'rgba(231, 76, 60, 0.10)', '#e74c3c', 'Lab Room', 'Mr. Hasan Mahmud', 'student', 'DHAKA100'),
                ('Sunday', 'Religion & Ethics', '10:10 AM - 10:50 AM', 'ph-book-bookmark', 'rgba(46, 204, 113, 0.10)', '#2ecc71', 'Room 8B', 'Moulvi Sahab', 'student', 'DHAKA100'),
                
                ('Monday', 'ICT Core', '8:30 AM - 9:10 AM', 'ph-desktop', 'rgba(52, 152, 219, 0.10)', '#3498db', 'Computer Lab', 'Mr. Rahman', 'student', 'DHAKA100'),
                ('Monday', 'Bangla 2nd Paper', '9:15 AM - 9:55 AM', 'ph-book-open-text', 'rgba(142,124,195,0.1)', 'var(--brand-color)', 'Room 8A', 'Ms. Shila Begum', 'student', 'DHAKA100'),
                ('Monday', 'Mathematics', '10:10 AM - 10:50 AM', 'ph-calculator', 'rgba(52, 152, 219, 0.10)', '#3498db', 'Room 8A', 'Mr. Rafiqul Islam', 'student', 'DHAKA100'),
                
                ('Tuesday', 'General Science', '8:30 AM - 9:10 AM', 'ph-flask', 'rgba(231, 76, 60, 0.10)', '#e74c3c', 'Lab Room', 'Mr. Hasan Mahmud', 'student', 'DHAKA100'),
                ('Tuesday', 'English Literature', '9:15 AM - 9:55 AM', 'ph-book-open', 'rgba(243, 156, 18, 0.10)', '#f39c12', 'Room 8A', 'Ms. Nipa Sultana', 'student', 'DHAKA100'),
                ('Tuesday', 'Arts & Crafts', '10:10 AM - 10:50 AM', 'ph-palette', 'rgba(155, 89, 182, 0.10)', '#9b59b6', 'Art Studio', 'Ms. Salma Begum', 'student', 'DHAKA100'),
                
                ('Wednesday', 'History & Culture', '8:30 AM - 9:10 AM', 'ph-compass', 'rgba(243, 156, 18, 0.10)', '#f39c12', 'Room 8A', 'Mr. Kazi Hasan', 'student', 'DHAKA100'),
                ('Wednesday', 'Mathematics', '9:15 AM - 9:55 AM', 'ph-calculator', 'rgba(52, 152, 219, 0.10)', '#3498db', 'Room 8A', 'Mr. Rafiqul Islam', 'student', 'DHAKA100'),
                ('Wednesday', 'Bangla Grammar', '10:10 AM - 10:50 AM', 'ph-book-open-text', 'rgba(142,124,195,0.1)', 'var(--brand-color)', 'Room 8A', 'Ms. Shila Begum', 'student', 'DHAKA100'),
                
                ('Thursday', 'Physical Education', '8:30 AM - 9:10 AM', 'ph-activity', 'rgba(46, 204, 113, 0.10)', '#2ecc71', 'Playground', 'Mr. Salam', 'student', 'DHAKA100'),
                ('Thursday', 'English Composition', '9:15 AM - 9:55 AM', 'ph-pencil-line', 'rgba(243, 156, 18, 0.10)', '#f39c12', 'Room 8A', 'Ms. Nipa Sultana', 'student', 'DHAKA100'),
                ('Thursday', 'Science Lab', '10:10 AM - 11:30 AM', 'ph-atom', 'rgba(231, 76, 60, 0.10)', '#e74c3c', 'Lab Room', 'Mr. Hasan Mahmud', 'student', 'DHAKA100'),
                
                ('Saturday', 'Class 8 - Bangla 1st Paper', '8:40 AM - 9:20 AM', 'ph-chalkboard-teacher', 'rgba(142,124,195,0.1)', 'var(--brand-color)', 'Room 8A', 'Regular Class', 'teacher', 'DHAKA100'),
                ('Saturday', 'Class 10 - Bangla Literature', '10:10 AM - 10:50 AM', 'ph-chalkboard-teacher', 'rgba(142,124,195,0.1)', 'var(--brand-color)', 'Room 10B', 'Regular Class', 'teacher', 'DHAKA100'),
                
                ('Sunday', 'Class 7 - Bangla Grammar', '9:15 AM - 9:55 AM', 'ph-chalkboard', 'rgba(46, 204, 113, 0.1)', '#2ecc71', 'Room 7B', 'Regular Class', 'teacher', 'DHAKA100'),
                ('Sunday', 'Exam Guard Duty', '11:00 AM - 1:00 PM', 'ph-shield-check', 'rgba(231,76,60,0.1)', '#e74c3c', 'Exam Hall 2', 'Guard Duty', 'teacher', 'DHAKA100'),
                
                ('Monday', 'Class 8 - Bangla 2nd Paper', '9:15 AM - 9:55 AM', 'ph-chalkboard-teacher', 'rgba(142,124,195,0.1)', 'var(--brand-color)', 'Room 8A', 'Regular Class', 'teacher', 'DHAKA100'),
                ('Monday', 'Class 9 - Bangla Composition', '11:30 AM - 12:10 PM', 'ph-chalkboard-teacher', 'rgba(142,124,195,0.1)', 'var(--brand-color)', 'Room 9A', 'Regular Class', 'teacher', 'DHAKA100'),
                
                ('Tuesday', 'Class 6 - Bangla Literature', '10:10 AM - 10:50 AM', 'ph-book-open-text', 'rgba(243, 156, 18, 0.10)', '#f39c12', 'Room 6A', 'Regular Class', 'teacher', 'DHAKA100'),
                ('Tuesday', 'Academic Council Meeting', '1:00 PM - 2:00 PM', 'ph-users-three', 'rgba(52, 152, 219, 0.10)', '#3498db', 'Conference Room', 'Staff Meeting', 'teacher', 'DHAKA100'),
                
                ('Wednesday', 'Class 8 - Bangla Grammar', '10:10 AM - 10:50 AM', 'ph-chalkboard-teacher', 'rgba(142,124,195,0.1)', 'var(--brand-color)', 'Room 8A', 'Regular Class', 'teacher', 'DHAKA100'),
                ('Wednesday', 'Exam Guard Duty', '11:00 AM - 1:00 PM', 'ph-shield-check', 'rgba(231,76,60,0.1)', '#e74c3c', 'Exam Hall 1', 'Guard Duty', 'teacher', 'DHAKA100'),
                
                ('Thursday', 'General Staff Meeting', '1:00 PM - 2:00 PM', 'ph-users', 'rgba(52, 152, 219, 0.10)', '#3498db', 'Staff Room', 'All Faculty', 'teacher', 'DHAKA100'),
                ('Friday', 'Weekend (Friday)', 'Full Day', 'ph-sparkles', 'rgba(46, 204, 113, 0.1)', '#2ecc71', 'Holiday', 'Weekend', 'teacher', 'DHAKA100')
            ");
        }

        // Seed notices
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM notices");
        if ($stmt->fetchColumn() == 0) {
            $this->pdo->exec("INSERT INTO notices (title, date, file_name, file_size, uploader, category, icon, color, school_code) VALUES
                ('SSC Exam Registration 2026 Guidelines', '10 June 2026', 'ssc_registration_guidelines_2026.pdf', '324 KB', 'Headmaster Kazi Hasan', 'Exam', 'ph-megaphone', '#e74c3c', 'DHAKA100'),
                ('Mid-Term Syllabus & Exam Routine (Class 6-10)', '05 June 2026', 'midterm_routine_syllabus_2026.pdf', '450 KB', 'Salma Begum (Asst. Headmaster)', 'Routine', 'ph-megaphone', '#8E7CC3', 'DHAKA100'),
                ('Government Holiday Notice - Buddha Purnima', '26 May 2026', 'holiday_notice_buddha_purnima.pdf', '120 KB', 'General Admin', 'Holiday', 'ph-megaphone', '#f39c12', 'DHAKA100'),
                ('Rain Warning & Special Class Rescheduling', '20 May 2026', 'special_notice_weather_reschedule.pdf', '180 KB', 'Principal Prof. Anisul Islam', 'Emergency', 'ph-megaphone', '#e74c3c', 'DHAKA100'),
                ('Inter-Class Sports & Cultural Week 2026 Schedule', '15 May 2026', 'cultural_sports_week_schedule.pdf', '520 KB', 'Physical Ed. Dept.', 'Event', 'ph-megaphone', '#2ecc71', 'DHAKA100')
            ");
        }

        // Seed attendance
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM attendance");
        if ($stmt->fetchColumn() == 0) {
            // Seed student attendance logs for the current month
            $currentMonth = date('Y-m');
            $this->pdo->exec("INSERT INTO attendance (user_id, date, status, late_time, comments) VALUES
                (1, '$currentMonth-01', 'P', NULL, NULL),
                (1, '$currentMonth-02', 'P', NULL, NULL),
                (1, '$currentMonth-03', 'P', NULL, NULL),
                (1, '$currentMonth-04', 'L', '15 mins', 'Late due to traffic at Farmgate'),
                (1, '$currentMonth-05', 'P', NULL, NULL),
                (1, '$currentMonth-06', 'A', NULL, 'Sick Leave (Fever)'),
                (1, '$currentMonth-07', 'P', NULL, NULL),
                (1, '$currentMonth-08', 'P', NULL, NULL),
                (1, '$currentMonth-09', 'P', NULL, NULL),
                (1, '$currentMonth-10', 'P', NULL, NULL)
            ");

            // Seed teacher attendance logs
            $this->pdo->exec("INSERT INTO attendance (user_id, date, status, late_time, comments) VALUES
                (2, '$currentMonth-01', 'P', NULL, NULL),
                (2, '$currentMonth-02', 'P', NULL, NULL),
                (2, '$currentMonth-03', 'P', NULL, NULL),
                (2, '$currentMonth-04', 'P', NULL, NULL),
                (2, '$currentMonth-05', 'P', NULL, NULL)
            ");
        }

        // Seed fees
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM fees");
        if ($stmt->fetchColumn() == 0) {
            $this->pdo->exec("INSERT INTO fees (student_id, title, invoice_no, amount, status, due_date, paid_date) VALUES
                (1, 'November - 2024 Fees', 'Inv-1903235135', 2500.00, 'due', '2024-11-20', NULL),
                (1, 'October - 2024 Fees', 'Inv-1903233565', 5000.00, 'paid', '2024-10-20', '2024-10-18')
            ");
        }

        // Seed term results
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM term_results");
        if ($stmt->fetchColumn() == 0) {
            $this->pdo->exec("INSERT INTO term_results (id, student_id, term, grade, total, gpa, position, note) VALUES
                (1, 1, '1st Term', 'A-', '438 / 500', 3.72, 'Class 5th', 'Strong performance in core subjects.'),
                (2, 1, 'Mid Term', 'A', '451 / 500', 3.88, 'Class 3rd', 'Improved marks in Bangla and Science.'),
                (3, 1, 'Final Term', 'A+', '472 / 500', 5.00, 'Class 1st', 'Excellent final term result.')
            ");

            // Seed subject results
            $this->pdo->exec("INSERT INTO subject_results (term_result_id, subject_name, marks, gpa, grade) VALUES
                (1, 'Bangla', 82, 4.00, 'A'),
                (1, 'English', 78, 3.50, 'A-'),
                (1, 'Mathematics', 95, 5.00, 'A+'),
                (1, 'Science', 88, 4.00, 'A'),
                (1, 'Religion', 95, 5.00, 'A+'),

                (2, 'Bangla', 88, 4.00, 'A'),
                (2, 'English', 84, 4.00, 'A'),
                (2, 'Mathematics', 92, 5.00, 'A+'),
                (2, 'Science', 90, 5.00, 'A+'),
                (2, 'Religion', 97, 5.00, 'A+'),

                (3, 'Bangla', 91, 5.00, 'A+'),
                (3, 'English', 89, 5.00, 'A+'),
                (3, 'Mathematics', 98, 5.00, 'A+'),
                (3, 'Science', 94, 5.00, 'A+'),
                (3, 'Religion', 100, 5.00, 'A+')
            ");
        }

        // Seed tests
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM tests");
        if ($stmt->fetchColumn() == 0) {
            $this->pdo->exec("INSERT INTO tests (id, name, category, term, school_code) VALUES
                (1, 'Class Test 1', 'Class Test', '1st Term', 'DHAKA100'),
                (2, 'Class Test 2', 'Class Test', '1st Term', 'DHAKA100'),
                (3, 'Mid Term Quiz', 'Model Test', 'Mid Term', 'DHAKA100'),
                (4, 'Final Exam Bangla', 'Term Exam', 'Final Term', 'DHAKA100')
            ");

            // Seed student marks
            $this->pdo->exec("INSERT INTO student_marks (student_id, test_id, marks, remarks) VALUES
                (1, 1, 18, 'Very good effort'),
                (2, 1, 19, 'Excellent'),
                (3, 1, 15, 'Good progress'),
                (4, 1, 12, 'Needs improvement'),
                (5, 1, 17, 'Great job')
            ");
        }
    }
}
