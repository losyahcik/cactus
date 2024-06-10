<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="Keywords" content="кактусы, купить кактусы, магазин кактусов, кактус, кактус онлайн, смотреть кактусы, алоэ, цереус, купить алоэ.">
    <meta name="description" content="Интернет магазин кактусов">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="favicon.ico">
    <title>cereus</title>
</head>
<body>
    <header>
    <?
    include 'layouts/header.php';
    include 'layouts/out.php';
    ?>
    </header>
    <main>
    <div class="slider_wrapp">
    <div class="slider">
    <? include "layouts/bd.php" ?>
    <div class="slides">
        <div class="slide slide1"><?
        $orders = $conn->query('SELECT id_cactus FROM orders')->fetchAll(PDO::FETCH_ASSOC);
        $cactusCount = array_count_values(array_column($orders, 'id_cactus'));
        arsort($cactusCount);
        $popularCactusId = key($cactusCount);
        $stmt = $conn->prepare('SELECT cactus.*, ROUND(AVG(rating.rating)) as avg_rating
        FROM cactus
        LEFT JOIN rating ON cactus.id_cactus = rating.id_cactus
        WHERE cactus.id_cactus = :id
        GROUP BY cactus.id_cactus');
        $stmt->bindParam(':id', $popularCactusId);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        echo '<div class="cactus_wrapp_slide" onclick="redirectToBuyPage('.$row['id_cactus'].')" id='.$row['id_cactus'].' />';
        echo '<img class="cactus_image_slide" src="data:image/jpeg;base64,' . base64_encode($row['photo']) . '" />';?>
        <div class="slide_content1">
        <h2 class="h2_slide">Лидер продаж</h2><?
        echo '<p class="cactus_p cactus_title">' . $row['title'] . '</p>';?>
        <?echo '<div class="rating_index">';
        if ($row['avg_rating'] === 0) {?>
            <svg class="star_index_none star_index" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
            <p class='rating_number'>Нет отзывов</p><?
        } else {?>
            <svg class="star_index fill" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
            </svg>
            <p class='rating_number'><?=$row['avg_rating']?></p><?}
        echo '</div>';
        echo '<p class="cactus_p cactus_cost">' . $row['cost'] . '₽' . '</p></div>'; 
        $description = $row['description'];
            $clean_description = mb_convert_encoding($description, 'UTF-8', 'UTF-8');   
            if (mb_strlen($clean_description) > 250) {
                $clean_description = mb_substr($clean_description, 0, 247) . '...';
            }
        echo '<p class="cactus_p cactus_desc">' . $clean_description . '</p>';
        echo '</div>';?></div>
        <div class="slide slide2"><?
        $orders = $conn->query('SELECT id_cactus FROM orders')->fetchAll(PDO::FETCH_ASSOC);
        $cactusCount = array_count_values(array_column($orders, 'id_cactus'));
        arsort($cactusCount);
        $popularCactusId = key($cactusCount);
        $stmt = $conn->prepare('SELECT cactus.*, ROUND(AVG(rating.rating)) as avg_rating
        FROM cactus
        LEFT JOIN rating ON cactus.id_cactus = rating.id_cactus
        WHERE cactus.id_cactus = (SELECT id_cactus FROM cactus ORDER BY id_cactus DESC LIMIT 1)
        GROUP BY cactus.id_cactus');
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        echo '<div class="cactus_wrapp_slide" onclick="redirectToBuyPage('.$row['id_cactus'].')" id='.$row['id_cactus'].' />';
        echo '<img class="cactus_image_slide" src="data:image/jpeg;base64,' . base64_encode($row['photo']) . '" />';?>
        <div class="slide_content1">
        <h2 class="h2_slide">Новинка</h2><?
        echo '<p class="cactus_p cactus_title">' . $row['title'] . '</p>';?>
        <?echo '<div class="rating_index">';
        if ($row['avg_rating'] === 0) {?>
            <svg class="star_index_none star_index" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
            <p class='rating_number'>Нет отзывов</p><?
        } else {?>
            <svg class="star_index fill" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
            </svg>
            <p class='rating_number'><?=$row['avg_rating']?></p><?}
        echo '</div>';
        echo '<p class="cactus_p cactus_cost">' . $row['cost'] . '₽' . '</p></div>'; 
        $description = $row['description'];
            $clean_description = mb_convert_encoding($description, 'UTF-8', 'UTF-8');   
            if (mb_strlen($clean_description) > 250) {
                $clean_description = mb_substr($clean_description, 0, 247) . '...';
            }
        echo '<p class="cactus_p cactus_desc">' . $clean_description . '</p>';
        echo '</div>';?></div>
        <div class="slide slide3">
            <div class="cactus_wrapp_slide cactus_wrapp_slide3">
                <h2 class="h2_slide">Послдение отзывы</h2><?
                $stmt = $conn->prepare('SELECT cactus.title, cactus.photo, user.name, rating.description
                FROM cactus
                JOIN rating ON cactus.id_cactus = rating.id_cactus
                JOIN user ON rating.id_user = user.id_user
                WHERE rating.status = 1
                ORDER BY rating.id_rating DESC
                LIMIT 3');
                $stmt->execute();
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {?>
                <div class="rew_wrapp">
                   <p class="slide_p3_title"><?echo  $row['title'].'</p>';
                    echo '<img class="cactus_image_slide cactus_image_slide3" src="data:image/jpeg;base64,' . base64_encode($row['photo']) . '" />';?>
                    <p class="slide_p3_title"><?echo $row['name'].'</p>';
                    $description = $row['description'];
                    $clean_description = mb_convert_encoding($description, 'UTF-8', 'UTF-8');   
                    if (mb_strlen($clean_description) > 70) {
                        $clean_description = mb_substr($clean_description, 0, 67) . '...';
                    }?>
                    <p class="slide_p3"><?echo  $clean_description.'</p>'.'</div>';
                }?>
            </div>
        </div>
    </div>
    <button class="prev">&#10094;</button>
    <button class="next">&#10095;</button>
    </div>
    </div>
    <div class="cont"><p>Все товары</p></div>
        <div class="wrapp_index">
           <?
             include 'layouts/content.php';
            ?> 
        </div>
    </main>
    <footer>
    <?php
    include 'layouts/footer.php';
    ?>
<script src="script.js"></script>
<script>
let slideIndex = 1;
showSlide(slideIndex);
function changeSlide(n) {
    showSlide(slideIndex += n);
}
function showSlide(n) {
    let slides = document.getElementsByClassName("slide");
    if (n > slides.length) {
        slideIndex = 1;
    }
    if (n < 1) {
        slideIndex = slides.length;
    }
    for (let i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }
    slides[slideIndex - 1].style.display = "block";
}
document.querySelector(".prev").addEventListener('click', () => {
    changeSlide(-1);
})
document.querySelector(".next").addEventListener('click', () => {
    changeSlide(1);
})
function redirectToBuyPage(blockId) {
  window.location = "buy.php?id=" + blockId;
}
</script>
</body>
</html>
<?$conn=null?>