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

            $stmt = $connect->prepare('SELECT `id` `child_name`, `child_surname`, `child_patronymic`, `application_date`, `status` FROM `applications` WHERE `login` = ?');
            $stmt->bind_param('s', $login);
            $stmt->execute();
            $result = $stmt->get_result();

            $stmt->close();
            $connect->close();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '
                        <a class="application-button" title="Рассмотреть заявление №'. $row['id'] .'" class="flex-row-center" href="/static/index.php?page=admin_news">Новости</a>
                    ';
                }
            } else {
                echo '
                    <p>У вас нет заявлений.</p>
                ';
            }
        }
    }
}
