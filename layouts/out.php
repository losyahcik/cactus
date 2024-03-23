<?php
// Проверяем, была ли нажата кнопка submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Удаляем куки файлы "user_email" и "user_name"
    setcookie('user_name', '', time() - 3600, '/');
    setcookie('user_email', '', time() - 3600, '/');
    session_start();
    unset ( $_SESSION [ 'user_email' ]); 
    unset ( $_SESSION [ 'user_name' ]); 
    session_unset();
    session_destroy();
    header("Location: ../index.php");
}
