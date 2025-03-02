<?php
    require_once '../app/Application.php';

    if (!isset($_SESSION['login'])) {
        header('Location: /static/index.php?page=main');        
    }

    $application = new Application();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_GET['mode'])) {
            switch ($_GET['mode']) {
                case 'create_application':
                    $application->create_application_user();
                    break;
                default:
                    echo '<p class="error-text">Неизвестный режим выполнения.</p>';
                    break;
            }
        }
    }
?>

<main class="flex-start-column-center">
    <div class="block-arrow-back" flex-row-center">
        <a class="arrow-back" href="/static/index.php?page=account">←</a>
    </div>
    <?php
        if (isset(($_GET['result_application']))) {
            switch ($_GET['result_application']) {
                case 'application_created':
                    echo '<p class="result-green-text">Заявление создано!</p>';
                    break;
                default:
                    echo '<p class="error-text">Неизвестный результат заявления.</p>';
                    break;
            }
        }

        if (isset(($_GET['error_application']))) {
            switch ($_GET['error_application']) {
                case 'the_application_has_already_been_created':
                    echo '<p class="error-text">Заявление уже создано.</p>';
                    break;
                default:
                    echo '<p class="error-text">Неизвестный результат заявления.</p>';
                    break;
            }
        }

        if ($_SESSION['login'] == 'administrator') {
            echo '<p>Заявления для админа.</p>';
        } else {
            echo '<h2>Заявление для поступления</h2>';
            require_once './modules/form_for_create_application.php';
        }
    ?>
</main>