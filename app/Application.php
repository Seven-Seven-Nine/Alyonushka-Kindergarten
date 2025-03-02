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

    public function consider_the_application(string $id_application): void {
        $connect = connect_data_base();

        if ($connect->connect_error) {
            die('<p class="error-text">Ошибка подключения к базе данных!</p>');
        } else {
            if ($this->checking_the_existence_application($id_application)) {
                $stmt = $connect->prepare('SELECT `id`, `child_name`, `child_surname`, `child_patronymic`, `child_birthdate`, `parent_name`, `parent_surname`, `parent_patronymic`, `parent_phone`, `parent_email`, `address`, `desired_group`, `application_date`, `status` FROM `applications` WHERE `id` = ?');
                $stmt->bind_param('s', $id_application);
                $stmt->execute();
                $result = $stmt->get_result();

                while ($row = $result->fetch_assoc()) {
                    $class_application = '';
                    
                    switch ($row['status']) {
                        case 'не рассмотрено':
                            $class_application = '';
                            break;
                        case 'принято':
                            $class_application = 'accepted';
                            break;
                        case 'отклонено':
                            $class_application = 'rejected';
                            break;
                        default:
                            $class_application = '';
                            break;
                    }

                    echo '
                        <div class="panel '. $class_application .'">
                            <h3>Заявление №'. $row['id'] .' | '. $row['application_date'] .' | '. $row['status'] .'</h3>
                            <hr>
                            <p>Имя ребёнка: '. $row['child_name'] .'</p>
                            <p>Фамилия ребёнка: '. $row['child_surname'] .'</p>
                            <p>Отчество ребёнка: '. ($row['child_patronymic'] == '' ? '-' : $row['child_patronymic']) .'</p>
                            <p>Дата рождения ребёнка: '. $row['child_birthdate'] .'</p>
                            <hr>
                            <p>Имя родителя: '. $row['parent_name'] .'</p>
                            <p>Фамилия родителя: '. $row['parent_surname'] .'</p>
                            <p>Отчество родителя: '. ($row['parent_patronymic'] == '' ? '-' : $row['parent_patronymic']) .'</p>
                            <p>Номер телефона родителя: '. $row['parent_phone'] .'</p>
                            <p>Почта родителя: '. $row['parent_email'] .'</p>
                            <p>Адрес: '. $row['address'] .'</p>
                            <p>Группа: '. $row['desired_group'] .'</p>
                        </div>
                    ';
                }
            } else {
                header('Location: /static/index.php?page=applications&&error_application=the_application_does_not_exist');
            }
        }
    }

    private function checking_the_existence_application(string $id_application): bool {
        $connect = connect_data_base();

        if ($connect->connect_error) {
            die('<p class="error-text">Ошибка подключения к базе данных!</p>');
        } else {
            $stmt = $connect->prepare('SELECT `id` FROM `applications` WHERE `id` = ?');
            $stmt->bind_param('s', $id_application);
            $stmt->execute();
            $result = $stmt->get_result();

            $stmt->close();
            $connect->close();

            if ($result->num_rows > 0) {
                return true;
            } else {
                return false;
            }
        }
    }
}