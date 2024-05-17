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
    <title>cereusAdmin</title>
</head>
<body>
<?
include 'layouts/header.php';
?>
<div class="admin">
    <a class="admin_href" href="admin.php"><h1>Админская панель</h1></a>
    <?
    if($id_page==1){
        include "layouts/bd.php";
        $stmt = $conn->prepare("SELECT cactus.*, ROUND((SELECT AVG(rating) FROM rating WHERE id_cactus = cactus.id_cactus)) as average_rating FROM cactus");
        $stmt->execute();
        $cactus = $stmt->fetchAll();
        ?>
        <table class="admin_table">
            <tr>
                <th class="admin_th">id товара</th>
                <th class="admin_th">Название</th>
                <th class="admin_th">рейтинг</th>
                <th class="admin_th">Описание</th>
                <th class="admin_th">цена</th>
                <th class="admin_th">Фото</th>
            </tr>
            <? foreach ($cactus as $cacti): ?>
            <tr class="tr_admin">
                <td class='td_admin'><? echo $cacti['id_cactus']; ?></td>
                <td class='td_admin'><? echo $cacti['title']; ?></td>
                <td class='td_admin'><? echo $cacti['average_rating']; ?></td>
                <td class='td_desc td_admin'><? echo $cacti['description']; ?></td>
                <td class='td_admin '><? echo $cacti['cost']; ?></td>
                <td class='td_admin'><?echo '<img class="cactus_image" src="data:image/jpeg;base64,' . base64_encode($cacti['photo']) . '" />';?></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?
    }elseif($id_page==2){
        include "layouts/bd.php";
        $stmt = $conn->prepare("SELECT * FROM cactus");
        $stmt->execute();
        $cacti = $stmt->fetchAll();
        foreach ($cacti as $cactus): ?>
        <div>
        <form action="layouts/change_delete_cactus.php" method="post" class="change_cactus" enctype="multipart/form-data">
            <input type="hidden"  name="id_cactus" value="<?= $cactus['id_cactus'] ?>">
            <input type="hidden" name="id_page" value="<?=$id_page?>">
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
            <div class="">
            <p>Фото:</p>
            <input type="file" class="file" name="photo" accept="image/png, image/jpeg">
            </div>
        </div>
        <div class='submit_buttons'>
        <div class="sb">
        <button type="submit" class='submit_admin' name="submit_admin" value="update">Обновить данные</button>
        <button type="submit" class='submit_admin' name="submit_admin" value="delete">Удалить товар</button>
        </div>
        </div>
        </form>
        <? endforeach;
    }elseif($id_page==3){  
        ?>
        <div class='wrapp_create'>
            <form action="layouts/change_delete_cactus.php" method="post" class="change_cactus_form" enctype="multipart/form-data">
                <input type="hidden" name="id_page" value="<?=$id_page?>">
                <div class="change_cactus cange">
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
                <div class='submit_buttons'>
                <button type="submit" class="submit_admin" name="submit_admin" value="create">Создать товар</button>
                </div>
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
                <th class="admin_th">ФИО заказчика</th>
                <th class="admin_th">Товар</th>
                <th class="admin_th">Количество</th>
                <th class="admin_th">Телефон заказчика</th>
                <th class="admin_th">Адрес заказчика</th>
                <th class="admin_th">Почта заказчика</th>
                <th class="admin_th">Статус</th>
                <th class="admin_th">Время заказа</th>
            </tr>
            <? foreach ($orders as $order): ?>
            <tr class="tr_admin">
                <?  $stmt = $conn->prepare("SELECT title FROM cactus WHERE id_cactus=:id_cactus");
                    $stmt->bindParam(':id_cactus', $order['id_cactus']);
                    $stmt->execute();
                    $result = $stmt->fetchColumn();?>
                <td class='td_admin'><?echo $order['id_order']; ?></td>
                <td class='td_admin'><?echo $order['id_user']; ?></td>
                <td class='td_admin'><?echo $order['fio']; ?></td>
                <td class='td_admin'><?echo $result; ?></td>
                <td class='td_admin'><?echo $order['number']; ?></td>
                <td class='td_admin'><?echo $order['tel']; ?></td>
                <td class='td_admin'><?echo $order['addres']; ?></td>
                <td class='td_admin'><?echo $order['email']; ?></td>
                <td class='td_admin'><?
                    if($order['status']==0){?>
                        <form action="layouts/change_delete_cactus.php" method="post" class="status_form">
                            <input type="hidden" name="id_page" value="<?=$id_page?>">
                            <input type="hidden" name='id_order' value='<?=$order['id_order'];?>'>
                            <button type="submit" class="submit_admin" name="submit_admin" value="status">Принять в работу</button>
                        </form><?
                    }elseif($order['status']==1){
                        echo"Заказ в работе";
                    }
                ?></td>
                <td class='td_admin'><? echo $order['time']; ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?
    }elseif($id_page==5){
        include "layouts/bd.php";
        $stmt = $conn->prepare("SELECT * FROM basket");
        $stmt->execute();
        $baskets = $stmt->fetchAll();
        ?>
        <table class="admin_table">
            <tr>
                <th class="admin_th">id корзины</th>
                <th class="admin_th">id пользователя</th>
                <th class="admin_th">Товар</th>
                <th class="admin_th">Количество</th>
            </tr>
            <?php foreach ($baskets as $basket): ?>
            <tr class="tr_admin">
                <?  $stmt = $conn->prepare("SELECT title FROM cactus WHERE id_cactus=:id_cactus");
                    $stmt->bindParam(':id_cactus', $basket['id_cactus']);
                    $stmt->execute();
                    $result = $stmt->fetchColumn();?>
                <td class='td_admin'><?php echo $basket['id_basket']; ?></td>
                <td class='td_admin'><?php echo $basket['id_user']; ?></td>
                <td class='td_admin'><?php echo $result; ?></td>
                <td class='td_admin'><?php echo $basket['number']; ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?
    }elseif($id_page==6){
        include "layouts/bd.php";
        $stmt = $conn->prepare("SELECT * FROM user");
        $stmt->execute();
        $users = $stmt->fetchAll();
        ?>
        <table class="admin_table">
            <tr>
                <th class="admin_th">id Пользователя</th>
                <th class="admin_th">Имя</th>
                <th class="admin_th">Email</th>
                <th class="admin_th">Пароль</th>
            </tr>
            <?php foreach ($users as $user): ?>
            <tr class="tr_admin">
                <td class='td_admin'><?php echo $user['id_user']; ?></td>
                <td class='td_admin'><?php echo $user['name']; ?></td>
                <td class='td_admin'><?php echo $user['email']; ?></td>
                <td class='td_admin'><?php echo $user['password']; ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?
    }elseif($id_page==7){
        include "layouts/bd.php";
        $stmt = $conn->prepare("SELECT * FROM user");
        $stmt->execute();
        $users = $stmt->fetchAll();
        foreach ($users as $user): ?>
        <div>
        <form action="layouts/change_delete_cactus.php" method="post" class="change_cactus" enctype="multipart/form-data">
            <input type="hidden"  name="id_user" value="<?= $user['id_user'] ?>">
            <input type="hidden" name="id_page" value="<?=$id_page?>">
            <div class="">
            <p>ID пользователя</p>
            <p><?= $user['id_user'] ?></p>
            </div>
            <div class="">
            <p>Имя пользователя</p>
            <input type="text" name="name" value="<?= $user['name'] ?>">
            </div>
            <div class="">
            <p>Email пользователя</p>
            <input type="text" name="email" value="<?= $user['email'] ?>">
            </div>
            <div class="">
            <p>Пароль</p>
            <input type="text" name="password" value="<?= $user['password'] ?>">
            </div>
        </div>
        <div class='submit_buttons'>
        <div class="sb sb2">
        <button type="submit" class='submit_admin' name="submit_admin" value="update_user">Обновить данные</button>
        <button type="submit" class='submit_admin' name="submit_admin" value="delete_user">Удалить пользователя</button>
        </div>
        </div>
        </form>
        <? endforeach;
    }elseif($id_page==8){ 
        ?>
        <div class='wrapp_create'>
            <form action="layouts/change_delete_cactus.php" method="post" class="change_cactus_form" enctype="multipart/form-data">
                <input type="hidden" name="id_page" value="<?=$id_page?>">
                <div class="change_cactus cange">
                <input type="hidden" name="id_page">
                <div class="">
                    <p>Имя пользователя</p>
                    <input type="text" name="name">
                </div>
                <div class="">
                    <p>Email пользователя</p>
                    <input type="text" name="email">
                </div>
                <div class="">
                    <p>Пароль</p>
                    <input type="text" name="password">
                </div>
                </div>
                <button type="submit" class="submit_admin" name="submit_admin" value="create_user">Создать пользователя</button>
            </form>
        </div><?
    }elseif($id_page==9){
        include "layouts/bd.php";?>
        <table class="admin_table">
            <tr class="tr_admin">
                <th class="admin_th">id товара</th>
                <th class="admin_th">Название</th>
                <th class="admin_th">id пользователя</th>
                <th class="admin_th">Пользователь</th>
                <th class="admin_th">Оценка</th>
                <th class="admin_th">Отзыв</th>
                <th class="admin_th">Одобрить отзыв</th>
            </tr>
            <?
            $stmt = $conn->prepare("SELECT rating.*, cactus.title as title, user.name as user_name
            FROM rating
            LEFT JOIN cactus ON rating.id_cactus = cactus.id_cactus
            LEFT JOIN user ON rating.id_user = user.id_user
            WHERE rating.status IS NULL
            AND (rating.description IS NOT NULL AND rating.description <> '')
            ");
            $stmt->execute();
            $ratings = $stmt->fetchAll();
            foreach($ratings as $rating): ?>
        <tr class="tr_admin">
            <td class='td_admin'><?= $rating['id_cactus']; ?></td>
            <td class='td_admin'><?= $rating['title']; ?></td>
            <td class='td_admin'><?= $rating['id_cactus']; ?></td>
            <td class='td_admin'><?= $rating['user_name']; ?></td>
            <td class='td_admin'><?= $rating['rating']; ?></td>
            <form method='post'action="layouts/change_delete_cactus.php">
            <input name="id_page" value="<?=$id_page?>" type="hidden">
            <input name="id_rating" value="<?=$rating['id_rating']?>" type="hidden">
            <td class='td_admin'><textarea class="text_dialog text_dialog_admin" name="rating_text"><?= $rating['description'];?></textarea></td>
            <td class='td_admin'><button type="submit" class="submit_admin" name="submit_admin" value="rating_status">Одобрить отзыв</button></td></form>
        </tr>
    <? endforeach; ?>
        </table>    
    <?}
    $conn = null;
    ?>
</div>
<?php include 'layouts/footer.php';?>
</body>
</html>