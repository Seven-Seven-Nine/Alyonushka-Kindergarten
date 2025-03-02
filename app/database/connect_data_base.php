<?php

function connect_data_base(): mysqli {
    $connect = new mysqli('localhost', 'root', '', 'alyonushka-kindergarten-db');
    $connect->set_charset("utf8mb4") or die('<p class="error-text">Ошибка кодировки БД! Кодировка должна быть utf8mb4.</p>');
    return $connect;
}