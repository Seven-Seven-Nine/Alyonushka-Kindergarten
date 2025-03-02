<div class="form flex-column-center">
    <form class="flex-column-center" action="/static/index.php?page=admin_news&mode=edit_news&id_news_for_edit=<?php echo $data_news['id']; ?>" method="POST" enctype="multipart/form-data">
        <input type="text" name="title" placeholder="Название" value="<?php echo $data_news['title']; ?>" required>
        <input type="file" name="file" accept=".jpg, .jpeg, .png">
        <textarea name="introductory-text" placeholder="Вступительный текст"><?php echo $data_news['introductory_text']; ?></textarea>
        <textarea class="text" name="text" placeholder="Основной текст"><?php echo $data_news['text']; ?></textarea>
        <button type="submit">Изменить</button>
    </form>
</div>