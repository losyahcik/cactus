<?php
require 'bd.php';
try {
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST["name"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        
        $stmt = $conn->prepare("INSERT INTO user (name, email, password) VALUES (:name, :email, :password)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->execute();
        
        // echo "Данные успешно сохранены в таблицу 'user'.";
//создание куки
        setcookie("user_name", $name, 0, '/');
        setcookie("user_email", $email, 0, '/');
    }
    
} catch(PDOException $e) {
    echo "Ошибка подключения: " . $e->getMessage();
}
$conn=null;