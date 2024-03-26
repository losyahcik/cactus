<?
session_start();
if(!isset($_SESSION['admin'])){
    header("Location: ../index.php");
    die();
}
// Обновление данных в таблице 'cactus'
if($_POST['submit_admin'] == 'update'){
    include 'bd.php';
    $id_cactus = $_POST['id_cactus'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $cost = $_POST['cost'];

    if(isset($_FILES['photo']['tmp_name']) && $_FILES['photo']['tmp_name'] != ''){
        $photo_tmp = $_FILES['photo']['tmp_name'];
        $photo = '../img_cactus/' . $_FILES['photo']['name'];

        move_uploaded_file($photo_tmp, $photo);

        // Получение содержимого изображения и экранирование для записи в БД
        $photo_content = file_get_contents($photo);
        $photo_content = $conn->quote($photo_content);

        // Обновление данных с фото в формате BLOB
        $stmt = $conn->prepare("UPDATE cactus SET title = :title, description = :description, cost = :cost, photo = $photo_content WHERE id_cactus = :id_cactus");
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':cost', $cost);
        $stmt->bindParam(':id_cactus', $id_cactus);
        $stmt->execute();
    } else {
        // Обновление данных без изменения фото
        $stmt = $conn->prepare("UPDATE cactus SET title = :title, description = :description, cost = :cost WHERE id_cactus = :id_cactus");
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':cost', $cost);
        $stmt->bindParam(':id_cactus', $id_cactus);
        $stmt->execute();
    }
}elseif($_POST['submit_admin'] == 'delete'){
    include 'bd.php';
    $id_cactus = $_POST['id_cactus'];

    $stmt = $conn->prepare("DELETE FROM cactus WHERE id_cactus = :id");
    $stmt->bindParam(':id', $id_cactus);
    $stmt->execute();
}elseif($_POST['submit_admin'] == 'create'){
    include 'bd.php'; 
    $title = $_POST['title'];
    $description = $_POST['description'];
    $cost = $_POST['cost'];
    $photo_tmp = $_FILES['photo']['tmp_name'];
    $photo_name = $_FILES['photo']['name'];
    $photo_path = '../img_cactus/' . $photo_name;
    move_uploaded_file($photo_tmp, $photo_path);
    $photo_content = file_get_contents($photo_path);
    
    $stmt = $conn->prepare("INSERT INTO cactus (title, description, cost, photo) VALUES (:title, :description, :cost, :photo)");
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':cost', $cost);
    $stmt->bindParam(':photo', $photo_content, PDO::PARAM_LOB); // Указываем параметр PDO::PARAM_LOB для записи в формате longblob
    $stmt->execute();
}elseif($_POST['submit_admin'] == 'status'){
    include 'bd.php'; 
    $id_order=$_POST['id_order'];
    $sql = "UPDATE orders SET status = 1 WHERE id_order = :id_order";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_order', $id_order);
    $stmt->execute();
    $conn = null;
    header("Location: ../admin_panel.php?id=4");
    exit();
}
$conn = null;
header("Location: ../admin_panel.php?id=2");
