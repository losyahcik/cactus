<?
if (isset($_COOKIE['user_name']) || isset($_COOKIE['user_email'])){
    include 'bd.php';
    $sql = "SELECT * FROM user WHERE name = :user_name AND email = :user_email";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['user_name' => $_COOKIE['user_name'], 'user_email' => $_COOKIE['user_email']]);
    
    if ($stmt->rowCount() > 0) {
        // Получение данных найденной записи
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row['basket'] !== null){
        $basket = explode(',', $row['basket']);
    
        // Суммирование стоимости товаров
        $total_cost = 0;
        foreach ($basket as $item_id) {
            // Подготовка и выполнение запроса для получения стоимости товара
            $sql = "SELECT cost FROM cactus WHERE id = :item_id";
            $stmt = $conn->prepare($sql);
            $stmt->execute(['item_id' => $item_id]);
        
            if ($stmt->rowCount() > 0) {
                $item_row = $stmt->fetch(PDO::FETCH_ASSOC);
                $total_cost += $item_row['cost'];
            }
        }
        
    
        // Вывод суммарной стоимости на экран
        echo "$total_cost";
    }else{
        echo'0.00';
    }
    } else {
        echo "Запись не найдена.";
    }
}else{
    echo'0.00';
}


// Закрытие соединения с базой данных
$pdo = null;