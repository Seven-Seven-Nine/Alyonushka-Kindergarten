<?php
    // require_once '../';

    if (!isset($_SESSION['login'])) {
        header('Location: /static/index.php?page=main');        
    }

    // $application = 

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_GET['mode'])) {
            switch ($_GET['mode']) {
                case 'create_application':
                    # code...
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
        if ($_SESSION['login'] == 'administrator') {
            echo '<p>Заявления для админа.</p>';
        } else {
            echo '<h2>Заявление для поступления</h2>';
            require_once './modules/form_for_create_application.php';
        }
    ?>
</main>