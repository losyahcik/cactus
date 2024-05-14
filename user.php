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
<?php
include 'layouts/header.php';
include 'layouts/refer.php';
include 'layouts/user_info.php';
?>
<div class="wrapp wrapp_user">
    <div class="user_info">
        <p class="user">
            <?php print_r($name)?>
        </p>
        <p class="user">
            <?php print_r($email)?>
        </p>
        <p class="user">
            <?php print_r($password)?>
        </p>
        <div class="user_basket">
            <a href="busket.php">Корзина</a>
            <a href="orders.php">Заказы</a>
            <form method="post" action="layouts/out.php" class="orders_but">
                <button type="submit" class='buy_but user_but' name="buttonn">Выйти из профиля</button>
            </form>
        </div>
    </div>
</div>
<?php include 'layouts/footer.php';?>
</body>
</html>
<?$conn=null?>