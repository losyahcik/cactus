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
    include 'layouts/content_buy.php';
    include 'layouts/basket_update.php';
    ?>
    </header>
    <main>
        <div class="buy_wrapp">
            <div class="buy_photo">
                <img class="cactus_image_buy" src="data:image/jpeg;base64, <?php print_r($photo)?>"/>
                <form method="POST" action="" class="basket_form">
                    <button type="submit" class='buy_but' name="buttonn">Добавить в корзину</button>
                </form>
            </div>
            <div class="buy_description">
                <h1><?php print_r($title)?></h1>
                <p class="p_description"><?php print_r($description)?></p>
                <p class="p_cost"><?php print_r($cost)?> ₽</p>
            </div>
        </div>
    </main>
    <footer>
    <?php
    include 'layouts/footer.php';
    ?>
    </footer>
</body>
</html>