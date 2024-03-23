<?
session_start();
if (isset($_SESSION['user_name'])) {
    include 'bd.php';
    $user_email = $_SESSION['user_email'];
    $user_name = $_SESSION['user_name'];

    $query = "SELECT id_user FROM user WHERE email = :user_email AND name = :user_name";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':user_email', $user_email);
    $stmt->bindParam(':user_name', $user_name);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $id_user = $user['id_user'];

        $sql = "SELECT basket.number AS number, basket.number * cactus.cost AS total_cost
                FROM basket
                JOIN cactus ON basket.id_cactus = cactus.id_cactus
                WHERE basket.id_user = :id_user";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_user', $id_user);
        $stmt->execute();

        $total_cost = 0;
        $total_count = 0;
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($result) {
            foreach ($result as $row) {
                $total_cost += $row['total_cost'];
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
$conn = null;