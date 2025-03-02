<?php
    session_start();
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/style.css">
    <link rel="preload" href="images/bg.webp" as="image">
    <link rel="shortcut icon" href="icons/icon-sun-32px.png" type="image/x-icon">
    <title>Alyonushka Kindergarten</title>
</head>
<body>
    <header id="header" class="flex-row-center">
        <div>
            <a title="Лого" href="/static/index.php?page=main">
                <img class="logo" src="./icons/logo.png" alt="icon-logo">
            </a>
        </div>
        <nav class="flex-row-center">
            <a href="/static/index.php?page=main">Главная</a>
            <a href="/static/index.php?page=news">Новости</a>
            <a href="/static/index.php?page=contact">Контакты</a>
            <?php
                if (isset($_SESSION['login'])) {
                    if ($_SESSION['role'] == 'administrator') {
                        echo '<a href="/static/index.php?page=applications">Заявления</a>';
                    } else {
                        echo '<a href="/static/index.php?page=applications">Подать заявление</a>';
                    }
                }
            ?>
        </nav>
        <?php
            if (isset($_SESSION['login'])) {
                echo '
                    <div class="flex-row-center">
                        <a title="Аккаунт" href="/static/index.php?page=account">
                            <img class="button-link" src="./icons/icon-account-32px.png" alt="icon-account">
                        </a>
                        <a title="Выйти" href="/static/index.php?page=account&exit_account=exit">
                            <img class="button-link" src="./icons/icon-exit-30px.png" alt="icon-exit">
                        </a>
                    </div>
                ';
            } else {
                echo '
                    <div>
                        <a title="Регистрация/авторизация" href="/static/index.php?page=authentication&action=menu">
                            <img class="button-link" src="./icons/light-icon-login-30px.png" alt="icon-authentication">
                        </a>
                    </div>
                ';
            } 
        ?>
    </header>
    <?php
        if ($_GET['page'] == 'main') {
            require_once './modules/main.php';
        } else if ($_GET['page'] == 'news') {
            require_once './modules/news.php';
        } else if ($_GET['page'] == 'contact') {
            require_once './modules/contact.php';
        } else if ($_GET['page'] == 'applications') {
            require_once './modules/applications.php';
        } else if ($_GET['page'] == 'authentication') {
            require_once './modules/authentication.php';
        } else if ($_GET['page'] == 'account') {
            require_once './modules/account.php';
        } else if ($_GET['page'] == 'admin_news') {
            require_once './modules/admin_news.php';
        } else if ($_GET['page'] == 'admin_users') {
            require_once './modules/admin_users.php';
        } else {
            echo '
                <main>
                    <p class="error-text">Неизвестный модуль!</p>
                </main>
            ';
        }
    ?>
    <footer class="flex-row-center">
        <p>©Мария Наконечникова</p>
    </footer>
</body>
</html>