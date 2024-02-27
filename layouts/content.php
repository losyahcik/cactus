<?
include 'bd.php';
try {
    // Получение данных из таблицы "cactus"
    $sql = "SELECT * FROM cactus";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($result) > 0) {
        // Вывод данных в виде <div> с <p> для "title" и "cost" и <img> для "photo"
        foreach ($result as $row) {
            echo '<div class="cactus_wrapp" onclick="redirectToBuyPage('.$row['id'].')" id='.$row['id'].' />';
            echo '<img class="cactus_image" src="data:image/jpeg;base64,' . base64_encode($row['photo']) . '" />';
            echo '<p class="cactus_p cactus_title">' . $row['title'] . '</p>';
            echo '<p class="cactus_p cactus_cost">' . $row['cost'] .'₽'. '</p>';
            echo '</div>';
        }
    } else {
        echo "Нет записей в таблице.";
    }
} catch(PDOException $e) {
    echo "Ошибка подключения: " . $e->getMessage();
}

$conn = null;