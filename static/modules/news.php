<?php
    require_once '../app/News.php';

    function check_error(): void {
        if (isset($_GET['error'])) {
            $error = $_GET['error'];
            echo '<p class="error-text">Ошибка новостей: '. $error .'</p>';
        }
    }

    function get_news(): void {
        $news = new News();
        $news->get_news();
    }

    function get_more_news(): void {
        if (isset($_GET['more_news'])) {
            $id_news = $_GET['more_news'];
            $news = new News();
            $news->get_more_news($id_news);
        } else {
            echo '
                <p class="error-text">ID новости не получен!</p>
            ';
        }
    }
?>

<main class="news-page flex-row-center flex-wrap">
    <?php
        check_error();
        if (isset($_GET['more_news'])) {
            get_more_news();
        } else {
            get_news();
        }
    ?>
</main>