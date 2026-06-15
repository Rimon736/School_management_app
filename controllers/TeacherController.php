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

    public function mark_entry() {
        $data = [
            'students' => TeacherModel::getStudents(),
            'tests' => TeacherModel::getMarkEntryTests()
        ];
        $this->render('teacher/mark_entry', $data);
    }

    public function student_attendance() {
        $data = [
            'students' => TeacherModel::getStudents()
        ];
        $this->render('teacher/student_attendance', $data);
    }

    public function student_list() {
        $data = [
            'students' => TeacherModel::getStudents()
        ];
        $this->render('teacher/student_list', $data);
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

    public function qr() {
        $this->render('teacher/qr');
    }

    public function inbox() {
        $this->render('teacher/inbox');
    }
}
