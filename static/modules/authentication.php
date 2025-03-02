<?php
require_once '../app/Authentication.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_GET['validate'])) {
        $authentication = new Authentication();
        $authentication->validate();
    }
}
?>

<main class="authentication-page">
    <?php
        if (isset($_GET['action'])) {
            if ($_GET['action'] == 'menu') {
                require_once './modules/authentication_menu.php';
            } else if ($_GET['action'] == 'authorization') {
                require_once './modules/authorization.php';
            } else if ($_GET['action'] == 'registration') {
                require_once './modules/registration.php';
            } else {
                echo '
                    <p class="error-text">Неизвестное действие!</p>
                ';
            }
        } else {
            if (isset($_GET['validate'])) {
                echo '<p>Валидация формы!</p>';
            } else {
                echo '
                    <p class="error-text">Неправильная ссылка! Перепроверьте ссылку на наличие action.</p>
                ';
            }
        }
    ?>
</main>