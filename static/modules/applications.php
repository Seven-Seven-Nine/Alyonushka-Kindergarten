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

<main class="application flex-start-column-center">
    <?php
        if (isset($_GET['id_for_application_processing'])) {
            echo '
                    <div class="block-arrow-back" flex-row-center">
                        <a class="arrow-back" href="/static/index.php?page=applications">←</a>
                    </div>
            ';
        } else {
            echo '
                    <div class="block-arrow-back" flex-row-center">
                        <a class="arrow-back" href="/static/index.php?page=account">←</a>
                    </div>
            ';
        }

        if (isset(($_GET['result_application']))) {
            switch ($_GET['result_application']) {
                case 'application_created':
                    echo '<p class="result-green-text">Заявление создано!</p>';
                    break;
                case 'application_accepted':
                    echo '<p class="result-green-text">Заявление принято.</p>';
                    break;
                case 'application_rejected':
                    echo '<p class="result-red-text">Заявление отклонено.</p>';
                    break;
                case 'application_deleted':
                    echo '<p class="result-red-text">Заявление удалено.</p>';
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
                case 'the_application_does_not_exist':
                    echo '<p class="error-text">Заявление не существует.</p>';
                    break;
                default:
                    echo '<p class="error-text">Неизвестный результат заявления.</p>';
                    break;
            }
        }

        if (isset(($_GET['consider_the_application']))) {
            echo '<h2>Заявление №'. $_GET['consider_the_application'] .'</h2>';
            $application->consider_the_application($_GET['consider_the_application']);
        } else {
            switch ($_SESSION['role']) {
                case 'administrator':
                    if (isset($_GET['id_for_application_processing'])) {
                        if (isset($_GET['action_application'])) {
                            switch ($_GET['action_application']) {
                                case 'accepted':
                                    $application->acceptance_application($_GET['id_for_application_processing']);
                                    break;
                                case 'rejected':
                                    $application->reject_application($_GET['id_for_application_processing']);
                                    break;
                                case 'deleted':
                                    $application->remove_application($_GET['id_for_application_processing']);
                                    break;
                                default:
                                    echo '<p class="Неизвестное действие для обработки заявления."></p>';
                                    break;
                            }
                        } else {
                            echo '
                                <div class="panel flex-row-center flex-wrap">
                                    <a href="/static/index.php?page=applications&id_for_application_processing='. $_GET['id_for_application_processing'] .'&action_application=accepted" class="button-panel">Принять</a>
                                    <a href="/static/index.php?page=applications&id_for_application_processing='. $_GET['id_for_application_processing'] .'&action_application=rejected" class="button-panel">Отклонить</a>
                                    <a href="/static/index.php?page=applications&id_for_application_processing='. $_GET['id_for_application_processing'] .'&action_application=deleted" class="button-panel button-delete">Удалить</a>
                                </div>
                            ';
                            $application->processing_of_applications($_GET['id_for_application_processing']);
                        }
                    } else {
                        echo '<div class="flex-row-center flex-wrap">';
                        $application->get_application_carts_for_admin();
                        echo '</div>';
                    }
                    break;
                default:
                    echo '<h2>Заявление для поступления</h2>';
                    require_once './modules/form_for_create_application.php';
                    break;
            }   
        }
    ?>
</main>