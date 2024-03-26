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
        
        session_start();
        $_SESSION['user_email']=$email;
        $_SESSION['user_name'] = $name;

    }
    
} catch(PDOException $e) {
    echo "Ошибка подключения: " . $e->getMessage();
}
$conn=null;