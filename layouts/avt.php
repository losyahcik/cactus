<?php
require 'bd.php';
try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST["email"];
        $password = $_POST["password"];
        if ($email == 'admin' && $password=='admin123'){
            header("Location: admin.php");
            session_start();
            $_SESSION['admin']='admin';
            exit;
        }
        
        $stmt = $conn->prepare('SELECT name FROM user WHERE password = :password AND email = :email');
        
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $result = $stmt->fetch();

        if ($result) {
            $name = $result['name'];
            session_start();
            $_SESSION['user_email']=$email;
            $_SESSION['user_name'] = $name;
        } else {
            $name="Пользователя с такими данными не сущутсвует, повторите попытку";
            $email="";
            $password="";
        }
    }
} catch(PDOException $e) {
    echo "Ошибка подключения: " . $e->getMessage();
}

$conn=null;
