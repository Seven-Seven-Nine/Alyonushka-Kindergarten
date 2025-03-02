<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_GET['mode']) && $_GET['mode'] == 'create_news') {
            $news->create_news();
        }
    }
?>
<div class="block-arrow-back" flex-row-center">
    <a class="arrow-back" href="/static/index.php?page=admin_news">←</a>
</div>
<?php
    if (isset($_GET['error_create_news'])) {
        switch ($_GET['error_create_news']) {
            case 'error_saving_image':
                echo '<p class="error-text">Ошибка сохранения изображения.</p>';
                break;
            default:
                echo '<p class="error-text">Неизвестная ошибка при создании новости.</p>';
                break;
        }
    }

    if (isset($_GET['result_create_news'])) {
        switch ($_GET['result_create_news']) {
            case 'news_created':
                echo '<p class="result-green-text">Новость создана.</p>';
                break;
            default:
                echo '<p class="error-text">Неизвестный результат создания новости.</p>';
                break;
        }
    }
?>
<div class="form flex-column-center">
    <form class="flex-column-center" action="/static/index.php?page=admin_news&mode=create_news" method="POST" enctype="multipart/form-data">
        <input type="text" name="title"  placeholder="Название" required>
        <input type="file" name="file" accept=".jpg, .jpeg, .png" required>
        <textarea name="introductory-text" placeholder="Вступительный текст"></textarea>
        <textarea class="text" name="text" placeholder="Основной текст"></textarea>
        <button type="submit">Создать</button>
    </form>
</div>