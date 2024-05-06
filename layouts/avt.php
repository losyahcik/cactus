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
        
        $stmt = $conn->prepare('SELECT name,password FROM user WHERE email = :email');
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $row = $stmt->fetch();

        if ($row) {
            if(password_verify($password, $row['password'])) {
            $name = $row['name'];
            session_start();
            $_SESSION['password']=$password;
            $_SESSION['user_email']=$email;
            $_SESSION['user_name'] = $name;
            }
        } else {
            session_start();
            $_SESSION['error']='Пользователя с такими данными не существует';
            header('Location: avtoristion.php');
            die();
        }
    }
} catch(PDOException $e) {
    echo "Ошибка подключения: " . $e->getMessage();
}

$conn=null;
