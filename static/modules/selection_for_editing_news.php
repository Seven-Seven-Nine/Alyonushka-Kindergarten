<div class="panel flex-row-center flex-wrap">
    <a href="/static/index.php?page=admin_news&mode=edit_news&id_news_for_edit=<?php echo $_GET['id_news_for_edit'] ?>&action_edit_news=edit" class="button-panel">Редактировать новость</a>
    <a href="/static/index.php?page=admin_news&mode=edit_news&id_news_for_edit=<?php echo $_GET['id_news_for_edit'] ?>&action_edit_news=delete" class="button-panel button-delete">Удалить новость</a>
</div>
<?php
    $news->get_more_news_for_edit($_GET['id_news_for_edit']);
?>