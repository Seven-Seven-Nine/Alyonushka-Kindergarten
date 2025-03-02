<?php
require_once '../application/database/connect_data_base.php';

class News {
    public function get_news(): void {
        $connection = connect_data_base();
        
        if ($connection->connect_errno) {
            die('<p class="error-text">Ошибка подключения к базе данных!</p>');
        } else {
            $stmt = $connection->prepare('SELECT `id`, `title`, `data`, `image_src`, `introductory_text` FROM `news`');
            $stmt->execute();
            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc()) {
                echo '
                    <a title="Открыть новость \''. $row['title'] .'\'" href="/static/index.php?page=news&more_news='. $row['id'] .'">
                        <div class="news-cart">
                            <h3>'. $row['title'] .'</h3>
                            <p class="data">'. $row['data'] .'</p>
                            <img src="'. $row['image_src'] .'" alt="image_news">
                            <p>'. $row['introductory_text'] .'</p>
                        </div>
                    </a>
                ';
            }

            $stmt->close();
        }

        $connection->close();
    }

    public function get_more_news(int $id_news): void {
        $connection = connect_data_base();

        if ($connection->connect_errno) {
            die('<p class="error-text">Ошибка подключения к базе данных!</p>');
        } else {
            $stmt = $connection->prepare('SELECT `id`, `title`, `data`, `image_src`, `text` FROM `news` WHERE `id`=?');
            $stmt->bind_param('i', $id_news);
            $stmt->execute();
            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc()) {
                echo '
                    <div class="block-arrow-back" flex-row-center">
                        <a class="arrow-back" href="/static/index.php?page=news">←</a>
                    </div>
                    <div class="more-news flex-column-center">
                        <h2>'. $row['title'] .'</h2>
                        <p class="data">'. $row['data'] .'</p>
                        <img src="'. $row['image_src'] .'" alt="image_news">
                        <p class="text-news">'.nl2br($row['text']) .'</p>
                    </div>
                ';
            }
        }
    }

    public function create_news(): void {
        if (isset($_SESSION['login'])) {
            $connection = connect_data_base();

            if ($connection->connect_errno) {
                die('<p class="error-text">Ошибка подключения к базе данных!</p>');
            } else {
                $title = $_POST['title'];
                $data = date('Y-m-d');
                $file_name = basename($_FILES['file']['name']);
                $upload_file_path = $_SERVER['DOCUMENT_ROOT'] . '/application/images/news/' . $file_name;
                $src_image = '/application/images/news/' . $file_name;
                $introductory_text = $_POST['introductory-text'];
                $text = $_POST['text'];

                if (move_uploaded_file($_FILES['file']['tmp_name'], $upload_file_path)) {
                    $stmt = $connection->prepare('INSERT INTO `news` (`title`, `data`, `image_src`, `introductory_text`, `text`) VALUES (?, ?, ?, ?, ?)');
                    $stmt->bind_param('sssss', $title, $data, $src_image, $introductory_text, $text);
                    $stmt->execute();

                    header('Location: /static/index.php?page=admin_news&mode=create_news&result_create_news=news_created');
                } else {
                    header('Location: /static/index.php?page=admin_news&mode=create_news&error_create_news=error_saving_image');
                }
            }
        } else {
            header('Location: /static/index.php?page=news&error=user_not_found');
        }
    }

    public function get_news_for_edit(): void {
        $connection = connect_data_base();
        
        if ($connection->connect_errno) {
            die('<p class="error-text">Ошибка подключения к базе данных!</p>');
        } else {
            $stmt = $connection->prepare('SELECT `id`, `title`, `data`, `image_src`, `introductory_text` FROM `news`');
            $stmt->execute();
            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc()) {
                echo '
                    <a href="/static/index.php?page=admin_news&mode=edit_news&id_news_for_edit='. $row['id'] .'">
                        <div class="news-cart">
                            <h3>'. $row['title'] .'</h3>
                            <p class="data">'. $row['data'] .'</p>
                            <img src="'. $row['image_src'] .'" alt="image_news">
                            <p>'. $row['introductory_text'] .'</p>
                        </div>
                    </a>
                ';
            }

            $stmt->close();
        }

        $connection->close();
    }

    public function get_data_news_for_form_edit(string $id_news): array {
        $connection = connect_data_base();

        if ($connection->connect_errno) {
            die('<p class="error-text">Ошибка подключения к базе данных!</p>');
        } else {
            $stmt = $connection->prepare('SELECT `id`, `title`, `introductory_text`, `text` FROM `news` WHERE `id` = ?');
            $stmt->bind_param('s', $id_news);
            $stmt->execute();
            $result = $stmt->get_result();

            $array_data_news = [];

            while ($row = $result->fetch_assoc()) {
                $array_data_news = $row;
            }

            $stmt->close();
            $connection->close();

            return $array_data_news;
        }
    }

    public function edit_news(string $id_news): void {
        $connection = connect_data_base();

        if ($connection->connect_errno) {
            die('<p class="error-text">Ошибка подключения к базе данных!</p>');
        } else {
            $title = $_POST['title'];
            $data = date('Y-m-d');
            $introductory_text = $_POST['introductory-text'];
            $text = $_POST['text'];

            if (isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
                $file_name = basename($_FILES['file']['name']);
                $upload_file_path = $_SERVER['DOCUMENT_ROOT'] . '/application/images/news/' . $file_name;
                $image_src = '/application/images/news/' . $file_name;

                if (move_uploaded_file($_FILES['file']['tmp_name'], $upload_file_path)) {
                    $stmt = $connection->prepare('UPDATE `news` SET `title` = ?, `data` = ?, `image_src` = ?, `introductory_text` = ?, `text` = ? WHERE `id` = ?');
                    $stmt->bind_param('ssssss', $title, $data, $image_src, $introductory_text, $text, $id_news);
                    $stmt->execute();

                    $stmt->close();
                    $connection->close();

                    header('Location: /static/index.php?page=admin_news&mode=edit_news&id_news_for_edit=7&result_edit_news=news_edited');
                } else {
                    header('Location: /static/index.php?page=admin_news&mode=edit_news&id_news_for_edit=7&error_edit_news=error_saving_image');
                }
            } else {
                $stmt = $connection->prepare('UPDATE `news` SET `title` = ?, `data` = ?, `introductory_text` = ?, `text` = ? WHERE `id` = ?');
                $stmt->bind_param('sssss', $title, $data, $introductory_text, $text, $id_news);
                $stmt->execute();

                $stmt->close();
                $connection->close();

                header('Location: /static/index.php?page=admin_news&mode=edit_news&id_news_for_edit=7&result_edit_news=news_edited');
            }
        }
    }
}