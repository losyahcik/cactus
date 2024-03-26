<?
session_start();
if (!isset($_SESSION['admin'])){
    echo"ВЫ не авторизованы";
    die();
}else{
    $id_page=$_GET['id'];
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="favicon.ico">
    <title>cereus</title>
</head>
<body>
<?php
include 'layouts/header.php';
?>
<div class="admin">
    <a class="admin_href" href="admin.php"><h1>Админская панель</h1></a>
    <?
    if($id_page==1){
        echo"<div class='wrapp_index'>";
        include_once "layouts/content.php";
        echo"</div>";
    }elseif($id_page==2){
        include "layouts/bd.php";
        $stmt = $conn->prepare("SELECT * FROM cactus");
        $stmt->execute();
        $cacti = $stmt->fetchAll();
        foreach ($cacti as $cactus): ?>
        <div>
        <form action="layouts/change_delete_cactus.php" method="post" class="change_cactus" enctype="multipart/form-data">
            <input type="hidden"  name="id_cactus" value="<?= $cactus['id_cactus'] ?>">
            <input type="hidden" name="id_page" value="<?$id_page?>">
            <?echo'<img class="cactus_image" src="data:image/jpeg;base64,' . base64_encode($cactus['photo']) . '" />';?>
            <div class="">
            <p>Название</p>
            <input type="text" name="title" value="<?= $cactus['title'] ?>">
            </div>
            <div class="">
            <p>Описание</p>
            <textarea class="admin_input"name="description" rows="10" cols="50"><?= $cactus['description'] ?></textarea>
            </div>
            <div class="">
            <p>Цена</p>
            <input type="text" name="cost" value="<?= $cactus['cost'] ?>">
            </div>
            <input type="file" placeholder="Введите ваше название файла" class="file" name="photo" accept="image/png, image/jpeg">
        </div>
        <button type="submit" name="submit_admin" value="update">Обновить данные</button>
        <button type="submit" name="submit_admin" value="delete">Удалить товар</button>
        </form>
        <?php endforeach;
    }elseif($id_page==3){
        include "layouts/bd.php";   
        ?>
        <div class='wrapp_create'>
            <form action="layouts/change_delete_cactus.php" method="post" class="change_cactus_form" enctype="multipart/form-data">
                <div class="change_cactus">
                <input type="hidden"  name="id_cactus">
                <input type="hidden" name="id_page">
                <div class="">
                    <p>Фото</p>
                    <input type="file" placeholder="Введите ваше название файла" class="file" name="photo" accept="image/png, image/jpeg">
                </div>
                <div class="">
                    <p>Название</p>
                    <input type="text" name="title">
                </div>
                <div class="">
                    <p>Описание</p>
                    <textarea class="admin_input"name="description" rows="10" cols="50"></textarea>
                </div>
                <div class="">
                    <p>Цена</p>
                    <input type="text" name="cost">
                </div>
                </div>
                <button type="submit" class="sub_create" name="submit_admin" value="create">Создать товар</button>
            </form>
        </div><?
    }elseif($id_page==4){
        include "layouts/bd.php";
        $stmt = $conn->prepare("SELECT * FROM orders");
        $stmt->execute();
        $orders = $stmt->fetchAll();
        ?>
        <table class="admin_table">
            <tr>
                <th class="admin_th">id заказа</th>
                <th class="admin_th">id пользователя</th>
                <th class="admin_th">Товар</th>
                <th class="admin_th">Количество</th>
                <th class="admin_th">Статус</th>
                <th class="admin_th">Время заказа</th>
            </tr>
            <?php foreach ($orders as $order): ?>
            <tr class="tr_admin">
                <?  $stmt = $conn->prepare("SELECT title FROM cactus WHERE id_cactus=:id_cactus");
                    $stmt->bindParam(':id_cactus', $order['id_cactus']);
                    $stmt->execute();
                    $result = $stmt->fetchColumn();?>
                <td class='td_admin'><?php echo $order['id_order']; ?></td>
                <td class='td_admin'><?php echo $order['id_user']; ?></td>
                <td class='td_admin'><?php echo $result; ?></td>
                <td class='td_admin'><?php echo $order['number']; ?></td>
                <td class='td_admin'><?
                    if($order['status']==0){?>
                        <form action="layouts/change_delete_cactus.php" method="post" class="status_form">
                            <input type="hidden" name='id_order' value='<?=$order['id_order'];?>'>
                            <button type="submit" class="" name="submit_admin" value="status">Принять в работу</button>
                        </form><?
                    }elseif($order['status']==1){
                        echo"Заказ в работе";
                    }
                ?></td>
                <td class='td_admin'><?php echo $order['time']; ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php
        
    }elseif($id_page==5){
        echo"11";
    }elseif($id_page==6){
        echo"11";
    }elseif($id_page==7){
        echo"11";
    }elseif($id_page==8){
        echo"11";
    }elseif($id_page==9){
        echo"11";
    }
    $conn = null;
    ?>
</div>
<?php include 'layouts/footer.php';?>
</body>
</html>