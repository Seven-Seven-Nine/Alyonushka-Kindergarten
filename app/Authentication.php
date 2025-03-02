<?php

require_once '../app/database/connect_data_base.php';

class Authentication {
    public function validate(): void {
        if ($_GET['validate'] == 'authorization') {
            $this->validate_authorization_form();
        } else if ($_GET['validate'] == 'registration') {
            $this->validate_registration_form();
        } else {
            echo '<p class="text-error">Ошибка валидации формы – неизвестный параметр для валидации.</p>';
        }
    }

    private function validate_authorization_form(): void {
        $login = $this->validate_input('login', $_POST['login']);
        $password = $this->validate_input('password', $_POST['password']);

        if ($login == false) {
            header('Location: /static/index.php?page=authentication&action=authorization&error=problem_login');
        } else if ($password == false) {
            header('Location: /static/index.php?page=authentication&action=authorization&error=problem_password');
        } else {
            $this->authorization_user();
        }
    }

    private function validate_registration_form(): void {
        $login = $this->validate_input('login', $_POST['login']);
        $email = $this->validate_input('email', $_POST['email']);
        $password = $this->validate_input('password', $_POST['password']);
        $re_password = $this->validate_input('re-password', $_POST['password'], $_POST['re-password']);

        if ($login == false) {
            header('Location: /static/index.php?page=authentication&action=registration&error=problem_login');
        } else if ($email == false) {
            header('Location: /static/index.php?page=authentication&action=registration&error=problem_email');
        } else if ($password == false) {
            header('Location: /static/index.php?page=authentication&action=registration&error=problem_password');
        } else if ($re_password == false) {
            header('Location: /static/index.php?page=authentication&action=registration&error=problem_re-password');
        } else {
            $this->registration_user();
        }
    }

    private function validate_input(string $type_input, string $input, string $re_password = 'none'): bool {
        switch ($type_input) {
            case 'login':
                if (strlen($input) < 3) {
                    return false;
                } else {
                    return true;
                }
            case 'email':
                if (strlen($input) < 5) {
                    return false;
                } else {
                    return true;
                }
            case 'password':
                if (strlen($input) < 3) {
                    return false;
                } else {
                    return true;
                }
            case 're-password':
                if ($re_password != 'none') {
                    if ($re_password == $input) {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    return true;
                }
            default:
                return false;
        }
    }

    private function authorization_user(): void {
        $connect = connect_data_base();
        $stmt = $connect->prepare('SELECT `login`, `role`, `email`, `password` FROM `users` WHERE `login` = ?');
        $stmt->bind_param('s', $_POST['login']);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $login = $_POST['login'];
            $role = '';
            $email = '';
            $password = $_POST['password'];
            $password_hash = '';

            while ($row = $result->fetch_assoc()) {
                $role = $row['role'];
                $email = $row['email'];
                $password_hash = $row['password'];
            }

            if (password_verify($password, $password_hash)) {
                $stmt->close();
                $connect->close();
 
                $this->add_authorization_user_session($login, $role, $email);
            } else {
                $stmt->close();
                $connect->close();
                header('Location: /static/index.php?page=authentication&action=authorization&error=incorrect_password');
            }
        } else {
            $stmt->close();
            $connect->close();
            header('Location: /static/index.php?page=authentication&action=authorization&error=user_not_found');
        }
    }

    private function add_authorization_user_session(string $login, string $role, string $email): void {
        $_SESSION['login'] = $login;
        $_SESSION['role'] = $role;
        $_SESSION['email'] = $email;
        
        header('Location: /static/index.php?page=account');
    }

    private function registration_user(): void {
        $connect = connect_data_base();
        $stmt = $connect->prepare('SELECT `login`, `email` FROM `users` WHERE `login` = ? AND `email` = ?');
        $stmt->bind_param('ss', $_POST['login'], $_POST['email']);
        $stmt->execute();
        
        $result = $stmt->get_result();

        if ($result->num_rows == 0) {
            $login = $_POST['login'];
            $role = 'user';
            $email = $_POST['email'];
            $password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);

            $stmt->prepare('INSERT INTO `users` (`login`, `role`, `email`, `password`) VALUES (?, ?, ?, ?)');
            $stmt->bind_param('ssss', $login, $role, $email, $password_hash);
            $stmt->execute();

            $stmt->close();
            $connect->close();

            $this->add_registered_user_session($login, $role, $email);
        } else {
            $stmt->close();
            $connect->close();
            header('Location: /static/index.php?page=authentication&action=registration&error=user_already_registered');
        }
    }

    private function add_registered_user_session(string $login, $role, $email): void {
        $_SESSION['login'] = $login;
        $_SESSION['role'] = $role;
        $_SESSION['email'] = $email;
        
        header('Location: /static/index.php?page=account');
    }
}