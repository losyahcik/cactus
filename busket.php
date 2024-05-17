<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="favicon.ico">
    <title>cereus</title>
</head>
<body class="buy_body">
<div id="dialog" class="dialog">
        <div class="dialog_wrapp">
            <p class="p_dialog">Заполните форму для доставки</p>
            <form method="post" action="orders.php" class="orders_but">
            <input placeholder="ФИО..." class="text_dialog text_dialog_input" type="text" id="name" name="name" required>
            <textarea placeholder="Полный адрес(город, улица, дом, квартира)" class="text_dialog" id="address" name="address" required></textarea>
            <input placeholder="Телефон в формате +7 999 999 99 99 " class="text_dialog text_dialog_input" type="tel" id="phone" name="phone" required>
            <input placeholder="Email" class="text_dialog text_dialog_input" type="email" id="email" name="email" required>
            <button type="submit" class='buy_but but_bus' name="buttonn">Оформить заказ</button>
            <p class="close_form">Закрыть форму</p>
            </form>
        </div>
    </div>
<?include 'layouts/header.php';?>
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
    <p>Итого:<? include 'layouts/cost_count.php'?>₽</p>
    <div class="orders_but">
        <button type="submit" id="create_order" class='buy_but but_bus' name="buttonn">Заказать</button>
    </div>
</div><?}?>
</div>
<? include 'layouts/footer.php';?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const order = document.getElementById('create_order');
    const dialogElement = document.getElementById('dialog');
    const close = document.querySelector('.close_form');
    order.addEventListener('click', () => {
        dialogElement.style.display = 'flex';
        document.body.style.overflow = 'hidden';
        document.body.style.maxHeight = '100%';
        window.scrollTo({
        top: 0,
    });
    });
    close.addEventListener('click', () => {
        dialogElement.style.display = 'none';
        document.body.style.overflow = 'auto';
        document.body.style.maxHeight = '';
    });
});
</script>
</body>
</html>
<?$conn=null?>