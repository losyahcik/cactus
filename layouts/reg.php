<?php
require 'bd.php';
try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST["name"];
        $email = $_POST["email"];
        $password = $_POST["password"];

        // Проверка наличия пользователя с таким же email в базе данных
        $stmt_check = $conn->prepare("SELECT * FROM user WHERE email = :email");
        $stmt_check->bindParam(':email', $email);
        $stmt_check->execute();
        $result = $stmt_check->fetch();
        
        if ($result) {
            // Если пользователь с таким email уже существует, выведите сообщение об ошибке
             session_start();
             $_SESSION['error']='Пользователя с таким Email уже существует';
             header("Location: regstration.php");
             die();
        } else {
            // Хеширование пароля
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            // Добавление нового пользователя, если пользователя с таким email нет в базе
            $stmt_insert = $conn->prepare("INSERT INTO user (name, email, password) VALUES (:name, :email, :password)");
            $stmt_insert->bindParam(':name', $name);
            $stmt_insert->bindParam(':email', $email);
            $stmt_insert->bindParam(':password', $hashed_password);
            $stmt_insert->execute();
            
            // Установка сессионных переменных
            session_start();
            $_SESSION['user_email'] = $email;
            $_SESSION['user_name'] = $name;
            $_SESSION['password'] = $password;
        }
    }
    
} catch(PDOException $e) {
    echo "Ошибка подключения: " . $e->getMessage();
}
$conn = null;
