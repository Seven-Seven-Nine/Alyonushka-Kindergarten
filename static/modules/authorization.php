<div class="flex-column-center authentication">
    <div class="block-arrow-back" flex-row-center">
        <a class="arrow-back" href="/static/index.php?page=authentication&action=menu">←</a>
    </div>
    <?php
        if (isset($_GET['error'])) {
            switch ($_GET['error']) {
                case 'problem_login':
                    echo '<p class="error-text">Проблемы с логином, длина логина должна быть больше 3.</p>';
                    break;
                case 'problem_password':
                    echo '<p class="error-text">Проблемы с паролем, длина пароля должна быть больше 3.</p>';
                    break;
                case 'user_not_found':
                    echo '<p class="error-text">Пользователь не найден.</p>';
                    break;
                case 'incorrect_password':
                    echo '<p class="error-text">Неправильный пароль.</p>';
                    break;
                default:
                    break;
            }
        }
    ?>
    <form action="/static/index.php?page=authentication&validate=authorization" method="post" class="flex-column-center">
        <input type="text" name="login" placeholder="Логин" required>
        <input type="password" name="password" placeholder="Пароль" required>
        <button type="submit"><img src="./icons/icon-authorization-50px.png" alt="icon-authorization"></button>
    </form>
    <div>
        <p>Забыл пароль? <a href="">Восстанови его!</a></p>
    </div>
</div>