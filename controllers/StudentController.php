<?php
class StudentController extends Controller {
    public function dashboard() {
        $data = [
            'profile' => StudentModel::getProfile(),
            'dashboard' => StudentModel::getDashboard()
        ];
        $this->render('student/dashboard', $data);
    }

    public function classroom() {
        $data = [
            'classroom' => StudentModel::getClassroom()
        ];
        $this->render('student/classroom', $data);
    }

    public function routine() {
        $data = [
            'routine' => StudentModel::getRoutine(),
            'examRoutine' => StudentModel::getExamRoutine()
        ];
        $this->render('student/routine', $data);
    }

    public function attendance() {
        $data = [
            'attendance' => StudentModel::getAttendanceStats()
        ];
        $this->render('student/attendance', $data);
    }

    public function results() {
        $data = [
            'results' => StudentModel::getResults()
        ];
        $this->render('student/results', $data);
    }

    public function fees() {
        $data = [
            'fees' => StudentModel::getFinance()
        ];
        $this->render('student/fees', $data);
    }

    public function profile() {
        $data = [
            'profile' => StudentModel::getProfile()
        ];
        $this->render('student/profile', $data);
    }

    public function academic_calendar() {
        $this->render('student/academic_calendar');
    }

    public function teachers_list() {
        $data = [
            'teachers' => StudentModel::getTeachers()
        ];
        $this->render('student/teachers_list', $data);
    }

    public function notices() {
        $data = [
            'notices' => NoticeModel::getRecentNotices()
        ];
        $this->render('student/notices', $data);
    }

    public function qr() {
        $this->render('student/qr');
    }

    public function inbox() {
        $this->render('student/inbox');
    }
}
