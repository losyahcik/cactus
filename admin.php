<?
session_start();
if (!isset($_SESSION['admin'])){
    echo"ВЫ не авторизованы";
    die();
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="favicon.ico">
    <title>cereusAdmin</title>
</head>
<body>
<?php
include 'layouts/header.php';
?>
<div class="admin">
    <h1>Админская панель</h1>
    <div class="admin_wrapp">
        <div class="admin_menu_wrapp">
            <p class="title_admin">Управление товарами</p>
            <p class="admin_select" onclick=redirectToAdmin(1)>Просмотреть товары</p>
            <p class="admin_select" onclick=redirectToAdmin(9)>Отзывы на товары</p>
            <p class="admin_select" onclick=redirectToAdmin(2)>Редактировать/Удалить товары</p>
            <p class="admin_select" onclick=redirectToAdmin(3)>Добавить товары</p>
        </div>
        <div class="admin_menu_wrapp">
            <p class="title_admin">Управление заказами</p>
            <p class="admin_select" onclick=redirectToAdmin(4)>Просмотреть заказы/Изменить статус заказа</p>
        </div>
        <div class="admin_menu_wrapp">
            <p class="title_admin">Управление корзинами</p>
            <p class="admin_select" onclick=redirectToAdmin(5)>Просмотр корзин</p>
        </div>
        <div class="admin_menu_wrapp">
            <p class="title_admin">Управление аккаунтами</p>
            <p class="admin_select" onclick=redirectToAdmin(6)>Просмотреть аккаунты</p>
            <p class="admin_select" onclick=redirectToAdmin(7)>Редактировать/Удалить аккаунты</p>
            <p class="admin_select" onclick=redirectToAdmin(8)>Добавить аккаунт</p>
        </div>
    </div>
    <form method="post" action="layouts/out.php" class="orders_but">
        <button type="submit" class='buy_but user_but' name="buttonn">Выйти из профиля</button>
    </form>
</div>
<?php include 'layouts/footer.php';?>
<script>
function redirectToAdmin(page_id) {
  window.location = "admin_panel.php?id="+page_id;
}
</script>
</body>
</html>