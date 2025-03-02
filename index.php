<?php
header('Content-type: application/html');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    header('Location: ./static/index.php?page=main');
} else {
    echo '
        <main>
            <p>Неправильный метод запроса.</p>
        </main>
    ';
}
