<?php
    require_once '../application/News.php';

    if ($_SESSION['role'] != 'administrator') {
        header('Location: /static/index.php?page=main');        
    }

    $news = new News();
?>

<main class="admin-news-page flex-start-column-center">
    <?php
        if (!isset($_GET['mode'])) {
            echo '
                <div class="block-arrow-back" flex-row-center">
                    <a class="arrow-back" href="/static/index.php?page=account">←</a>
                </div>
                <div class="menu-admin-news flex-row-center">
                    <a href="/static/index.php?page=admin_news&mode=create_news">
                        <div class="button-menu create-news flex-column-center">
                            <img src="./icons/icon-create-50px.png" alt="icon-create">
                            <p>Создать новость</p>
                        </div>
                    </a>
                    <a href="/static/index.php?page=admin_news&mode=edit_news">
                        <div class="button-menu editor-news flex-column-center">
                            <img src="./icons/icon-editor-50px.png" alt="icon-editing">
                            <p>Редактирование новости</p>
                        </div>
                    </a>
                </div>
            ';
        } else {
            switch ($_GET['mode']) {
                case 'create_news':
                    require_once './modules/create_news.php';
                    break;
                case 'edit_news':
                    require_once './modules/edit_news.php';
                    break;
                default:
                    echo '<p class="error-text">Неизвестный режим!</p>';
                    break;
            }
        }
    ?>
</main>