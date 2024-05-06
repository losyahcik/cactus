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
                Авторизация
            </h1>
            <form method="post" action="user.php" name="signup-form" class="form form_avt">
            <input class="form_input" type="text" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" placeholder="Email" required>
            <input class="form_input" pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$" title="минимум 8 символов, 4 цифры и 4 буквы" type="password" name="password" placeholder="Пароль" required>    
            <button type="submit" class="submit form_input" name="register" value="Авторизоваться">Авторизоваться</button>
            </form>
            <p class='error'><? session_start();if(isset($_SESSION['error'])){print_r($_SESSION['error']);unset( $_SESSION['error']); }?></p>
            <a href="regstration.php">Нет профиля? Зарегистрироваться</a>
        </div>
    </main>
    <footer>
    <?php
    include 'layouts/footer.php';
    ?>
</body>
</html>