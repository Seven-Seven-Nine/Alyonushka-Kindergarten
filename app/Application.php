<?php

require_once '../app/database/connect_data_base.php';

class Application {
    public function create_application_user(): void {
        $connect = connect_data_base();

        if ($connect->connect_errno) {
            die('<p class="error-text">Ошибка подключения к базе данных!</p>');
        } else {
            if ($this->check_application($_POST['child-name'], $_POST['child-surname'])) {
                $login = $_SESSION['login'];
                $child_name = $_POST['child-name'];
                $child_surname = $_POST['child-surname'];
                $child_patronymic = $_POST['child-patronymic'];
                $child_birthdate = $_POST['child-birthdate'];
                $parent_name = $_POST['parent-name'];
                $parent_surname = $_POST['parent-surname'];
                $parent_patronymic = $_POST['parent-patronymic'];
                $parent_phone = $_POST['parent-phone'];
                $parent_email = $_POST['parent-email'];
                $address = $_POST['address'];
                $desired_group = $_POST['desired_group'];
                $application_date = date('Y-m-d');
    
                $stmt = $connect->prepare('INSERT INTO `applications` (`login`, `child_name`, `child_surname`, `child_patronymic`, `child_birthdate`, `parent_name`, `parent_surname`, `parent_patronymic`, `parent_phone`, `parent_email`, `address`, `desired_group`, `application_date`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
    
                $stmt->bind_param('sssssssssssss', $login, $child_name, $child_surname, $child_patronymic, $child_birthdate, $parent_name, $parent_surname, $parent_patronymic, $parent_phone, $parent_email, $address, $desired_group, $application_date);
                $stmt->execute();
    
                $stmt->close();
                $connect->close();
    
                header('Location: /static/index.php?page=applications&result_application=application_created');
            } else {
                header('Location: /static/index.php?page=applications&error_application=the_application_has_already_been_created');
            }
        }
    }

    private function check_application(string $child_name, string $child_surname): bool {
        $connect = connect_data_base();

        if ($connect->connect_error) {
            die('<p class="error-text">Ошибка подключения к базе данных!</p>');
        } else {
            $stmt = $connect->prepare('SELECT `login`, `child_name`, `child_surname` FROM `applications` WHERE `login` = ? AND `child_name` = ? AND `child_surname` = ?');
            $stmt->bind_param('sss', $_SESSION['login'], $child_name, $child_surname);
            $stmt->execute();
            $result = $stmt->get_result();

            $stmt->close();
            $connect->close();

            if ($result->num_rows > 0) {
                return false;
            } else {
                return true;
            }
        }
    }
}