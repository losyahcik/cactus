<?php
require 'bd.php';
try {
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST["email"];
        $password = $_POST["password"];
        if ($email == 'admin' && $password=='admin123'){
            header("Location: admin.php");
            exit;
        }
        
        $stmt = $conn->prepare('SELECT name FROM user WHERE password = :password AND email = :email');
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->execute();
        $result = $stmt->fetch();
        //создание куки

        if ($result) {
            $name = $result['name'];
            session_start();
            $_SESSION['user_email']=$email;
            $_SESSION['user_name'] = $name;
            // setcookie("user_name", $name, 0, '/');
            // setcookie("user_email", $email, 0, '/');
        } else {
            echo'(';
        }
    }
} catch(PDOException $e) {
    echo "Ошибка подключения: " . $e->getMessage();
}

$conn=null;
