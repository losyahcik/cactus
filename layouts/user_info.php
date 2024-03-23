<?php
session_start();
include "bd.php";
$stmt = $conn->prepare('SELECT password, name, email FROM user WHERE name = :name  AND email = :email');

$stmt->bindParam(':email', $_SESSION['user_email'], PDO::PARAM_STR);
$stmt->bindParam(':name', $_SESSION['user_name'], PDO::PARAM_STR);
$stmt->execute();

$result = $stmt->fetch();

if ($result) {
    $password = $result['password'];
    $name = $result['name'];
    $email = $result['email'];

} else {
    // Запись не найдена, обработайте этот случай
}
$conn=null;