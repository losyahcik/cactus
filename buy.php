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
    <?
    include 'layouts/header.php';
    include 'layouts/content_buy.php';
    ?>
    </header>
    <main>
        <div class="buy_wrapp">
            <div class="buy_photo">
                <img class="cactus_image_buy" src="data:image/jpeg;base64, <?php print_r($photo)?>"/>
                <form method="POST" action="layouts/basket_update.php" class="basket_form">
                    <input type="hidden" name="hidden" value="<?php echo $_GET['id'] ?>">
                    <button type="submit" class='buy_but' name="buttonn">Добавить в корзину</button>
                </form>
            </div>
            <div class="buy_description">
                <h1><? print_r($title)?></h1>
                <div class="rating">
                <span class="p_description">Рейтинг товара:</span>
                <? if (isset($_SESSION['user_email'])){
                    include 'layouts/bd.php';
                    $userEmail = $_SESSION['user_email'];
                    $stmt = $conn->prepare("SELECT id_user FROM user WHERE email = :email");
                    $stmt->bindParam(':email', $userEmail);
                    $stmt->execute();
                    $user = $stmt->fetch(PDO::FETCH_ASSOC);
                    $userId = $user['id_user']; 
                    // Проверяем запись в таблице orders
                    $orderId = $_GET['id'];
                    $stmt = $conn->prepare("SELECT * FROM orders WHERE id_user = :userId AND id_cactus = :cactusId AND status = 1");
                        $stmt->bindParam(':userId', $userId);
                        $stmt->bindParam(':cactusId', $orderId);
                        $stmt->execute();
                        $order = $stmt->fetch(PDO::FETCH_ASSOC);

                        $stmt = $conn->prepare("SELECT * FROM rating WHERE id_user = :id_user AND id_cactus = :id_cactus");
                        $stmt->bindParam(':id_user', $userId);
                        $stmt->bindParam(':id_cactus', $orderId);
                        $stmt->execute();
                        $user_rate = $stmt->fetch(PDO::FETCH_ASSOC);
                        if ($order && !$user_rate){?><form class="form_action" method="post" action="layouts/rating.php"><input type="hidden" name='id_cactus' value="<?echo $_GET['id'] ?>"><input type="hidden" value="1" name="rating"><button name='button_rating' class="button_rating"><svg class="star" data-value="1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg></button></form>
                        <form class="form_action" method="post" action="layouts/rating.php"><input type="hidden" name='id_cactus' value="<?echo $_GET['id'] ?>"><input type="hidden" value="2" name="rating"><button name='button_rating' class="button_rating"><svg class="star" data-value="2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg></button></form>
                        <form class="form_action" method="post" action="layouts/rating.php"><input type="hidden" name='id_cactus' value="<?echo $_GET['id'] ?>"><input type="hidden" value="3" name="rating"><button name='button_rating' class="button_rating"><svg class="star" data-value="3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg></button></form>
                        <form class="form_action" method="post" action="layouts/rating.php"><input type="hidden" name='id_cactus' value="<?echo $_GET['id'] ?>"><input type="hidden" value="4" name="rating"><button name='button_rating' class="button_rating"><svg class="star" data-value="4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg></button></form>
                        <form class="form_action" method="post" action="layouts/rating.php"><input type="hidden" name='id_cactus' value="<?echo $_GET['id'] ?>"><input type="hidden" value="5" name="rating"><button name='button_rating' class="button_rating"><svg class="star" data-value="5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg></button></form>    
                        <span class="p_description">(Оцените товар)</span>
                <?}else{?>
                        <div class="form_action"><?
                        avgRate();?>
                        </div><span class="p_description">(Ваша оценка:<?
                        $stmt = $conn->prepare("SELECT * FROM rating WHERE id_user = :id_user AND id_cactus = :id_cactus");
                        $stmt->bindParam(':id_user', $userId);
                        $stmt->bindParam(':id_cactus', $orderId);
                        $stmt->execute();
                        $user_rate = $stmt->fetch(PDO::FETCH_ASSOC);
                        echo $user_rate['rating'];
                        ?>)</span><?
                }; }else{
                    ?>
                        <div class="form_action"><?
                    avgRate();?></div><?
                     
                }?>
                </div>
                <p class="p_description"><? print_r($description)?></p>
                <p class="p_cost"><? print_r($cost)?>₽</p>       
            </div>
        </div>
    </main>
    <footer>
    <?php
    include 'layouts/footer.php';
    ?>
    </footer>
    <script>document.addEventListener('DOMContentLoaded', function() {
    const stars = document.querySelectorAll('.star');
    stars.forEach((star, index) => {
        star.addEventListener('mouseover', function() {
            stars.forEach((s, i) => {
                if (i <= index) {
                    s.classList.add('filled');
                } else {
                    s.classList.remove('filled');
                }
            });
        });
    });
});</script>
</body>
</html>
<?
function avgRate() {
    include 'layouts/bd.php';
    $id_cactus = $_GET['id'];

    // Подготавливаем запрос для получения рейтинга по id_cactus
    $stmt = $conn->prepare("SELECT rating FROM rating WHERE id_cactus = :id_cactus");
    $stmt->bindParam(':id_cactus', $id_cactus);
    $stmt->execute();
                    
    // Инициализируем переменные для хранения суммы рейтинга и количества записей
    $totalRating = 0;
    $ratingCount = 0;
                    
    // Считаем общий рейтинг и количество записей
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $totalRating += $row['rating'];
        $ratingCount++;
    }
    
    // Вычисляем средний рейтинг
    $averageRating = $ratingCount > 0 ? $totalRating / $ratingCount : 0;
    for ($i = 1; $i <= 5; $i++) {
        // Генерируем SVG-элемент
        $svg = '<svg class="star_unuser';
        if ($i <= $averageRating) {
            $svg .= ' fill';
        }
        $svg .= '" data-value="1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>';
        echo $svg;
    }
                     
}
$conn=null ?>