<?
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['buttonn'])) {
    if (!isset($_COOKIE['user_name']) || !isset($_COOKIE['user_email'])) {
        header("Location: regstration.php");
        exit;
    } else {
    include "bd.php";
    $id = $_GET['id'];
    $sql = "SELECT * FROM user WHERE name = :name AND email = :email";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':name', $_COOKIE['user_name']);
    $stmt->bindParam(':email', $_COOKIE['user_email']);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        // Получение значения столбца basket
        $basket = $row['basket'];
    
        // Проверка, является ли ячейка пустой или равной null
        if (empty($basket) || $basket == null) {
            // Создание массива с записью id страницы
            $basket_array = array($id);
    
            // Преобразование массива в строку
            $basket_string = implode(',', $basket_array);
    
            // Обновление значения столбца basket
            $sql = "UPDATE user SET basket = :basket WHERE name = :name AND email = :email";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':basket', $basket_string);
            $stmt->bindParam(':name', $user_name);
            $stmt->bindParam(':email', $user_email);
            $stmt->execute();
        } else {
            // Преобразование строки из ячейки в массив
            $basket_array = explode(',', $basket);
            
            // Проверка наличия id страницы в массиве
            if (!in_array($id, $basket_array)) {
                // Добавление id страницы в массив
                $basket_array[] = $id;
    
                // Преобразование массива в строку
                $basket_string = implode(',', $basket_array);
    
                // Обновление значения столбца basket
                $sql = "UPDATE user SET basket = :basket WHERE name = :name AND email = :email";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':basket', $basket_string);
                $stmt->bindParam(':name', $_COOKIE['user_name']);
                $stmt->bindParam(':email',  $_COOKIE['user_email']);
                $stmt->execute();
            }
        }
    }
    }
}
