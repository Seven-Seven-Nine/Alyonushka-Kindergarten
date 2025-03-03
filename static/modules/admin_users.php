<?php
    require_once '../app/Account.php';

    if ($_SESSION['role'] != 'administrator') {
        header('Location: /static/index.php?page=main');        
    }

    $account = new Account();
?>

<main class="account-page flex-start-column-center">
    <?php
        if (isset($_GET['id_users'])) {
            echo '
                <div class="block-arrow-back" flex-row-center">
                    <a class="arrow-back" href="/static/index.php?page=admin_users">←</a>
                </div>      
            ';
        } else {
            echo '
                <div class="block-arrow-back" flex-row-center">
                    <a class="arrow-back" href="/static/index.php?page=account">←</a>
                </div>      
            ';
        }

        if (isset($_GET['result_users'])) {
            switch ($_GET['result_users']) {
                case 'user_deleted':
                    echo '<p class="result-red-text">Пользователь удалён.</p>';
                    break;
                default:
                    echo '<p class="error-text">Неизвестный результат.</p>';
                    break;
            }
        }
    ?>
    <?php
        if (isset($_GET['id_users'])) {
            if (isset($_GET['action_admin_users'])) {
                switch ($_GET['action_admin_users']) {
                    case 'change_user':
                        break;
                    case 'delete_user':
                        $account->delete_user_by_id($_GET['id_users']);
                        break;
                    default:
                        echo '<p class="error-text">Неизвестное действие над пользователем! Изверг!</p>';
                        break;
                }
            } else {
                echo '
                    <div class="flex-row-center panel">
                        <a href="/static/index.php?page=admin_users&id_users='. $_GET['id_users'] .'&action_admin_users=delete_user" class="button-panel button-delete">Удалить</a>
                    </div>
                ';
                echo '<div class="flex-column-center panel list-users">';
                $account->get_info_user_by_id($_GET['id_users']);
                echo '</div>';
            }
        } else {
            echo '<div class="flex-column-center panel list-users">';
            $account->get_all_list_users();
            echo '</div>';
        }
    ?>
</main>