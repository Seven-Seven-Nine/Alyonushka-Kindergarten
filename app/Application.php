<?php

require_once '../app/database/connect_data_base.php';

class Application {
    public function create_application_user(): void {
        $connect = connect_data_base();

        if ($connect->connect_errno) {
            die('<p class="error-text">Ошибка подключения к базе данных!</p>');
        } else {
            

            $stmt = $connect->prepare('');
        }
    }
}