<?php
    if ($_SESSION['role'] != 'administrator') {
        header('Location: /static/index.php?page=main');        
    }
?>

<main class="flex-start-column-center">
    <div class="block-arrow-back" flex-row-center">
        <a class="arrow-back" href="/static/index.php?page=account">←</a>
    </div>
    <p>Тута все пользователи и т.д.</p>
</main>