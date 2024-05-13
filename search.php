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
    <main>
        <div class=" wrapp_search wrapp_index">
           <? include 'layouts/bd.php';
           if(isset($_POST['search'])) {
            $search = $_POST['search'];
            $sql = "SELECT cactus.*, ROUND(AVG(rating.rating)) as avg_rating
                FROM cactus
                LEFT JOIN rating ON cactus.id_cactus = rating.id_cactus
                WHERE title LIKE :search
                GROUP BY cactus.id_cactus";
            $stmt = $conn->prepare($sql);
            $stmt->execute(array(':search' => '%' . $search . '%'));
    // Вывод результатов поиска
    echo "<h2>Результаты поиска:</h2>";
    if ($stmt->rowCount() > 0) {
        while($row = $stmt->fetch()) {
            echo '<div class="cactus_wrapp_search cactus_wrapp " onclick="redirectToBuyPage('.$row['id_cactus'].')" id='.$row['id_cactus'].' />';
            echo '<img class="cactus_image" src="data:image/jpeg;base64,' . base64_encode($row['photo']) . '" />';
            echo '<p class="cactus_p cactus_title cactus_title_search">' . $row['title'] . '</p>';
            $description = $row['description'];
            $clean_description = mb_convert_encoding($description, 'UTF-8', 'UTF-8');   
            if (mb_strlen($clean_description) > 100) {
                $clean_description = mb_substr($clean_description, 0, 97) . '...';
            }
            echo '<p class="cactus_p cactus_desc">' . $clean_description . '</p>';
            echo '<div class="rating_index">';
            if($row['avg_rating'] === 0){?>
                <svg class="star_index_none star_index" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                <p class='rating_number'>Нет отзывов</p><?
            }else{?>
                <svg class="star_index fill" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                <p class='rating_number'><?=$row['avg_rating']?></p><?
            }   
            echo '</div>';
            
            echo '<p class="cactus_p cactus_cost">' . $row['cost'] .'₽'. '</p>';
            echo '</div>';
        }
    } else {?>
           <div class="cost_bus none_search">
            <p>Ничего не найдено</p>
            <a class="has_basket_a" href="index.php">На главную</a>
            </div><?
    }
}?>
        </div>
    </main>
    <footer>
    <?php
    include 'layouts/footer.php';
    ?>
<script>
function redirectToBuyPage(blockId) {
  window.location = "buy.php?id=" + blockId;
}
</script>
</body>
</html>
<?$conn=null?>