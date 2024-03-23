<?php
session_start();
// Проверяем существование 
if (!isset($_SESSION['user_name']) || !isset($_SESSION['user_email'])) {
    echo 'regstration.php';
} else {
    
    include 'bd.php';
    // Считываем значения из куки-файлов
    $user_name = $_SESSION['user_name'];
    $user_email = $_SESSION['user_email'];
    // Выполняем SQL-запрос для поиска записи в таблице user
    $stmt = $conn->prepare('SELECT * FROM user WHERE name = :name AND email = :email');
    $stmt->bindParam(':name', $user_name);
    $stmt->bindParam(':email', $user_email);
    $stmt->execute();
    $result = $stmt->fetch();

    if ($result) {
        echo 'user.php';
    } else {
        echo 'regstration.php';
    }
    $conn=null;
}
