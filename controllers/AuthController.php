<?php
class AuthController extends Controller {
    public function login() {
        $this->render('auth/login');
    }

    public function process() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $role = isset($_POST['role']) ? trim($_POST['role']) : 'student';
            if ($role === 'teacher') {
                $_SESSION['role'] = 'teacher';
                header('Location: index.php?controller=teacher&action=dashboard');
            } else {
                $_SESSION['role'] = 'student';
                header('Location: index.php?controller=student&action=dashboard');
            }
            exit;
        }
        header('Location: index.php?controller=auth&action=login');
        exit;
    }

    public function switch() {
        if (isset($_SESSION['role'])) {
            $_SESSION['role'] = ($_SESSION['role'] === 'student') ? 'teacher' : 'student';
            header('Location: index.php?controller=' . $_SESSION['role'] . '&action=dashboard');
        } else {
            header('Location: index.php?controller=auth&action=login');
        }
        exit;
    }

    public function logout() {
        unset($_SESSION['role']);
        session_destroy();
        header('Location: index.php?controller=auth&action=login');
        exit;
    }
}
