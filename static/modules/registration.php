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
                case 'problem_email':
                    echo '<p class="error-text">Проблемы с почтой, длина почты должна быть больше 3.</p>';
                    break;
                case 'problem_password':
                    echo '<p class="error-text">Проблемы с паролем, длина пароля должна быть больше 3.</p>';
                    break;
                case 'problem_re-password':
                    echo '<p class="error-text">Пароли не совпадают.</p>';
                    break;
                case 'user_already_registered':
                    echo '<p class="error-text">Такой пользователь уже зарегистрирован.</p>';
                    break;
                default:
                    break;
            }
        }
    ?>
    <form action="/static/index.php?page=authentication&validate=registration" method="post" class="flex-column-center">
        <input type="text" name="login" placeholder="Логин" required>
        <input type="email" name="email" placeholder="Почта" required>
        <input type="password" name="password" placeholder="Пароль" required>
        <input type="password" name="re-password" placeholder="Повторите пароль" required>
        <button type="submit"><img src="./icons/icon-registration-50px.png" alt="icon-authorization"></button>
    </form>
</div>