<?php
    if (!isset($_SESSION['login'])) {
        header('Location: /static/index.php?page=main');        
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