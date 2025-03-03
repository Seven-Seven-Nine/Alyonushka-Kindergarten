<?php

require_once '../app/database/connect_data_base.php';

class Account {
    public function exit_account(): void {
        if (isset($_GET['exit_account'])) {
            session_destroy();
            header('Location: /static/index.php?page=main');
        }
    }

    public function get_list_applications_user(): void {
        $connect = connect_data_base();

        if ($connect->connect_errno) {
            die('<p class="error-text">Ошибка подключения к базе данных!</p>');
        } else {
            $login = $_SESSION['login'];

            $stmt = $connect->prepare('SELECT `id`, `child_name`, `child_surname`, `child_patronymic`, `application_date`, `status` FROM `applications` WHERE `login` = ?');
            $stmt->bind_param('s', $login);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '
                        <a class="application-button" title="Рассмотреть заявление №'. $row['id'] .'" href="/static/index.php?page=applications&consider_the_application='. $row['id'] .'">'. $row['child_name'] .' '. $row['child_surname'] .' '. $row['child_patronymic'] .' | Дата: '. $row['application_date'] .' | Статус: '. $row['status'] .'</a>
                    ';
                }
            } else {
                echo '
                    <p>У вас нет заявлений.</p>
                ';
            }

            
            $stmt->close();
            $connect->close();
        }
    }

    public function get_all_list_users(): void {
        $connect = connect_data_base();

        if ($connect->connect_errno) {
            die('<p class="error-text">Ошибка подключения к базе данных!</p>');
        } else {
            $stmt = $connect->prepare('SELECT `id`, `login`, `role`, `email` FROM `users`');
            $stmt->execute();
            $result = $stmt->get_result();

            $stmt->close();
            $connect->close();

            while ($row = $result->fetch_assoc()) {
                if ($row['role'] != 'administrator') {
                    echo '
                        <a title="Просмотреть|Удалить|Изменить пользователя №'. $row['id'] .'" class="application-button" href="/static/index.php?page=admin_users&id_users='. $row['id'] .'">'. $row['login'] .' | '. $row['role'] .' | '. $row['email'] .'</a>
                    ';
                }
            }
        }
    }

    public function get_info_user_by_id(string $id_user): void {
        $connect = connect_data_base();

        if ($connect->connect_errno) {
            die('<p class="error-text">Ошибка подключения к базе данных!</p>');
        } else {
            $stmt = $connect->prepare('SELECT `id`, `login`, `role`, `email` FROM `users` WHERE `id` = ?');
            $stmt->bind_param('s', $id_user);
            $stmt->execute();
            $result = $stmt->get_result();

            $stmt->close();
            $connect->close();

            while ($row = $result->fetch_assoc()) {
                if ($row['role'] != 'administrator') {
                    echo '
                        <h2>Пользователь: '. $row['login'] .' | Роль: '. $row['role'] .'</h2>
                        <hr>
                        <p>Почта: '. $row['email'] .'</p>
                    ';
                    $this->get_all_application_user_by_login($row['login']);
                }
            }
        }
    }

    private function get_all_application_user_by_login(string $login): void {
        $connect = connect_data_base();

        if ($connect->connect_errno) {
            die('<p class="error-text">Ошибка подключения к базе данных!</p>');
        } else {
            $stmt = $connect->prepare('SELECT `id`, `child_name`, `child_surname`, `child_patronymic`, `application_date`, `status` FROM `applications` WHERE `login` = ?');
            $stmt->bind_param('s', $login);
            $stmt->execute();
            $result = $stmt->get_result();
            
            $stmt->close();
            $connect->close();

            while ($row = $result->fetch_assoc()) {
                echo '
                    <a class="application-button" title="Рассмотреть заявление №'. $row['id'] .'" href="/static/index.php?page=applications&consider_the_application='. $row['id'] .'">'. $row['child_name'] .' '. $row['child_surname'] .' '. $row['child_patronymic'] .' | Дата: '. $row['application_date'] .' | Статус: '. $row['status'] .'</a>
                ';
            }
        }
    }

    public function delete_user_by_id(string $id_user): void {
        $connect = connect_data_base();

        if ($connect->connect_errno) {
            die('<p class="error-text">Ошибка подключения к базе данных!</p>');
        } else {
            $stmt = $connect->prepare('DELETE FROM `users` WHERE `id` = ?');
            $stmt->bind_param('s', $id_user);
            $stmt->execute();

            $stmt->close();
            $connect->close();

            $this->delete_applications_user_by_id($id_user);

            header('Location: /static/index.php?page=admin_users&result_users=user_deleted');
        }
    }

    private function delete_applications_user_by_id(string $id_user): void {
        $connect = connect_data_base();

        if ($connect->connect_errno) {
            die('<p class="error-text">Ошибка подключения к базе данных!</p>');
        } else {
            $stmt = $connect->prepare('SELECT `login` FROM `users` WHERE `id` = ?');
            $stmt->bind_param('s', $id_user);
            $stmt->execute();
            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc()) {
                $stmt->prepare('DELETE FROM `applications` WHERE `login` = ?');
                $stmt->bind_param('s', $row['login']);
                $stmt->execute();
            }

            $stmt->close();
            $connect->close();
        }
    }
}
