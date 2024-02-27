<?php
// Проверяем, была ли нажата кнопка submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Удаляем куки файлы "user_email" и "user_name"
    setcookie('user_name', '', time() - 3600, '/');
    setcookie('user_email', '', time() - 3600, '/');
}
