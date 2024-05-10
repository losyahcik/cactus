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
?>
<div class="wrapp_bus">
<div class="wrapp_user_bus">
    <?
    include "layouts/busket_user.php";
    ?>  
</div>
<?if(isset($_SESSION['has_basket'])){?>
    <div class="cost_bus has_basket ">
        <p>Ваша корзина пуста</p>
        <a class="has_basket_a" href="index.php">Купить кактусы</a>
    </div>
    <?}else{?>
<div class="cost_bus">
    <p>Итого:<?php include 'layouts/cost_count.php'?>₽</p>
    <form method="post" action="orders.php" class="orders_but">
        <button type="submit" class='buy_but but_bus' name="buttonn">Заказать</button>
    </form>
</div><?}?>
</div>
<?php include 'layouts/footer.php';?>
</body>
</html>