<?
include 'bd.php';
try {
    // Получение данных из таблицы "cactus"
    $sql = "SELECT cactus.*, ROUND(AVG(rating.rating)) as avg_rating
    FROM cactus
    LEFT JOIN rating ON cactus.id_cactus = rating.id_cactus
    GROUP BY cactus.id_cactus";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
if (count($result) > 0) {
    $index = 0;
    while ($index < count($result)) {
        $row = $result[$index];
        echo '<div class="cactus_wrapp" onclick="redirectToBuyPage('.$row['id_cactus'].')" id='.$row['id_cactus'].' />';
        echo '<img class="cactus_image" src="data:image/jpeg;base64,' . base64_encode($row['photo']) . '" />';
        echo '<div class="rating_index">';
        if ($row['avg_rating'] === 0) {?>
            <svg class="star_index_none star_index" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
            <p class='rating_number'>Нет отзывов</p><?
        } else {?>
            <svg class="star_index fill" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
            </svg>
            <p class='rating_number'><?=$row['avg_rating']?></p><?}
        echo '</div>';
        echo '<p class="cactus_p cactus_title">' . $row['title'] . '</p>';
        echo '<p class="cactus_p cactus_cost">' . $row['cost'] . '₽' . '</p>'; ?>
        <form class='form_basket_index' action="layouts/basket_update.php"  method='post'>
            <input type="hidden" name='hidden' value='<?=$row['id_cactus']?>'>
            <button name='buttonn_index' class="button_basket_index" type='submit'>В корзину</button>
        </form><?
        echo '</div>';
        $index++;}
    } else {
        echo "Нет записей в таблице.";
    }
} catch(PDOException $e) {
    echo "Ошибка подключения: " . $e->getMessage();
}

$conn = null;