<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_GET['mode']) && $_GET['mode'] == 'edit_news') {
            $news->edit_news($_GET['id_news_for_edit']);
        }
    }
?>
<div class="block-arrow-back" flex-row-center">
    <?php
        if (isset($_GET['id_news_for_edit'])) {
            echo '<a class="arrow-back" href="/static/index.php?page=admin_news&mode=edit_news">←</a>';
        } else {
            echo '<a class="arrow-back" href="/static/index.php?page=admin_news">←</a>';
        }
    ?>
</div>
<div class="news-page flex-column-center">
    <?php
        if (isset($_GET['id_news_for_edit'])) {
            echo '<h2>Редактирование новости №'. $_GET['id_news_for_edit'] .'</h2>';
        } else {
            echo '<h2>Выбор новости для редактирования</h2>';
        }

        if (isset($_GET['error_edit_news'])) {
            switch ($_GET['error_edit_news']) {
                case 'error_saving_image':
                    echo '<p class="error-text">Ошибка сохранения изображения.</p>';
                    break;
                default:
                    echo '<p class="error-text">Неизвестная ошибка.</p>';
                    break;
            }
        }

        if (isset($_GET['result_edit_news'])) {
            switch ($_GET['result_edit_news']) {
                case 'news_edited':
                    echo '<p class="result-blue-text">Новость измена.</p>';
                    break;
                default:
                    echo '<p class="error-text">Неизвестная новость.</p>';
                    break;
            }
        }
    ?>
    <div class="flex-row-center flex-wrap">
        <?php
            if (isset($_GET['id_news_for_edit'])) {
                $data_news = $news->get_data_news_for_form_edit($_GET['id_news_for_edit']);
                require_once './modules/form_for_edit_news.php';
            } else {
                $news->get_news_for_edit();
            }
        ?>
    </div>
</div>