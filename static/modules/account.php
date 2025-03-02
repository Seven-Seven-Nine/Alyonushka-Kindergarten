<?php
require_once '../app/Account.php';

$account = new Account();

if (isset($_GET['exit_account'])) {
    $account->exit_account();
}

if (isset($_SESSION['login']) && isset($_SESSION['role']) && isset($_SESSION['email'])) {
    $login = $_SESSION['login'];
    $role = $_SESSION['role'];
    $email = $_SESSION['email'];
} else {
    $_GET['error'] = 'session_issue';
}
?>

<main class="flex-column-center account-page">
    <?php
        if (isset($_GET['error'])) {
            switch ($_GET['error']) {
                case 'session_issue':
                    echo '<p class="error-text">Ошибка сессии.</p>';
                    break;
                default:
                    break;
            }
        }

        if (isset($login) && isset($role) && isset($email)) {
            echo '
                <div class="data-account">
                    <p>Пользователь: '. $login .'</p>
                    <p>Роль: '. $role .'</p>
                    <p>Почта: '. $email .'</p>
                </div>
            ';

            if ($role == 'administrator') {
                echo '
                    <div class="panel flex-row-center flex-wrap">
                        <a class="button-panel" title="Добавить|Изменить|Удалить новости" class="flex-row-center" href="/static/index.php?page=admin_news">Новости</a>
                        <a class="button-panel" title="Одобрение|Отклонение|Удаление заявлений" class="flex-row-center" href="/static/index.php?page=applications">Заявления</a>
                        <a class="button-panel" title="Просмотр|Изменение|Удаление пользователей" class="flex-row-center" href="/static/index.php?page=admin_users">Пользователи</a>
                    </div>
                ';
            } else {
                echo '<div class="panel flex-column-center">';
                echo '<h3>Ваши заявления:</h3>';
                $account->get_list_applications_user();
                echo '</div>';
            }
        } else {
            echo '
                <p class="error-text">Сессия не найдена!</p>
            ';
        }
    ?>
</main>