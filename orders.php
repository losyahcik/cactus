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
    <?include 'layouts/header.php';?>
    </header>
    <main>
        <div class="wrapp wrapp_orders">
                <? include 'layouts/orders_user.php';?>
                <?if(isset($_SESSION['has_basket'])){?>
            <div class="cost_bus has_basket has_basket2">
            <p>У вас нет заказов</p>
            <a class='has_basket_a' href="busket.php">В корзину</a><?}?>
        </div>
        </div>
    </main>
    <footer>
    <?include 'layouts/footer.php';?>
    </footer>
</body>
</html>
<?$conn=null?>