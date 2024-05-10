<?php
session_start();

// Проверяем, если данные были отправлены из формы
if (isset($_POST['id_cactus']) && isset($_POST['rating'])) {
    // Получаем данные из формы
    $id_cactus = $_POST['id_cactus'];
    $rating = $_POST['rating'];

    try {

        include 'bd.php';

        // Получаем id_user из таблицы user, сопоставляя сессионный email
        $email = $_SESSION['user_email'];
        $stmt = $conn->prepare("SELECT id_user FROM user WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $id_user = $row['id_user'];

        // Проверяем, существует ли запись в таблице rating для данного пользователя и кактуса
        $stmt = $conn->prepare("SELECT * FROM rating WHERE id_user = :id_user AND id_cactus = :id_cactus");
        $stmt->bindParam(':id_user', $id_user);
        $stmt->bindParam(':id_cactus', $id_cactus);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            // Если запись существует, обновляем ее
            $stmt = $conn->prepare("UPDATE rating SET rating = :rating WHERE id_user = :id_user AND id_cactus = :id_cactus");
            $stmt->bindParam(':rating', $rating);
            $stmt->bindParam(':id_user', $id_user);
            $stmt->bindParam(':id_cactus', $id_cactus);
            $stmt->execute();
        } else {
            // Если запись не существует, создаем новую
            $stmt = $conn->prepare("INSERT INTO rating (id_user, id_cactus, rating) VALUES (:id_user, :id_cactus, :rating)");
            $stmt->bindParam(':id_user', $id_user);
            $stmt->bindParam(':id_cactus', $id_cactus);
            $stmt->bindParam(':rating', $rating);
            $stmt->execute();
        }

    } catch(PDOException $e) {
        echo "Ошибка: " . $e->getMessage();
    }

    // Закрываем соединение с базой данных
    $conn = null;
}
header("Location: ../buy.php?id=" . urlencode($id_cactus));
