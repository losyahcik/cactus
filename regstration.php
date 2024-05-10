<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="favicon.ico">
    <title>cereus</title>
</head>
<body>
    <header>
    <?php
    include 'layouts/header.php';
    ?>
    </header>
    <main class="main">
        <div class="wrapp">
            <h1>
                Регистрация
            </h1>
            <form method="post" action="user.php" name="signup-form" class="form">
            <input class="form_input" type="text" name="name" placeholder="Ваше имя" required pattern="^[А-ЯЁ][а-яё]+$" title="Только русские буквы, первая буква с заглавной">
            <input class="form_input" type="email" name="email" placeholder="Email" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$">
            <input class="form_input" type="password" id="pass1" name="password" placeholder="Пароль" required pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$" title="минимум 8 символов, 4 цифры и 4 буквы">
            <input class="form_input" type="password" id="pass2" placeholder="Повторите пароль" required>
            <p class="error">Пароли не совпадают</p>
            <button type="submit" id="submitButton" class="submit form_input" name="register" value="Зарегистрироваться">Зарегистрироваться</button>
            </form>
            <p class='error error2'><? session_start();if(isset($_SESSION['error'])){print_r($_SESSION['error']);unset( $_SESSION['error']); }?></p>
            <a href="avtoristion.php">Есть профиль? Авторизоваться</a>
        </div>
    </main>
    <footer>
    <?php
    include 'layouts/footer.php';
    ?>
    <script>
        const passwordField1 = document.querySelector('#pass1');
        const passwordField2 = document.querySelector('#pass2');
        const submitButton = document.querySelector('#submitButton');
        const error = document.querySelector('.error');
        error.style.display = 'none';

        function checkPasswords() {
        const password1 = passwordField1.value;
        const password2 = passwordField2.value;

        if (password1 !== password2) {
            submitButton.disabled = true;  // Блокируем кнопку "submit"
            error.style.display = 'block';
            submitButton.addEventListener('mouseover', function() {
                submitButton.style.cursor = 'not-allowed';
            });
            submitButton.addEventListener('mouseout', function() {
                submitButton.style.cursor = 'auto';
            });
        } else {
            submitButton.disabled = false;  // Разблокируем кнопку "submit"
            error.style.display = 'none';
            submitButton.addEventListener('mouseover', function() {
                submitButton.style.cursor = 'pointer';
            });
            submitButton.addEventListener('mouseout', function() {
                submitButton.style.cursor = 'auto';
            });
        }
    }

    passwordField1.addEventListener('input', checkPasswords);
    passwordField2.addEventListener('input', checkPasswords);
    </script>
</body>
</html>