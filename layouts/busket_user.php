<?if (isset($_COOKIE['user_name']) ||  isset($_COOKIE['user_email'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['buttonn'])) {
        include "bd.php";

        $id_basket = $_POST['form_id'];
        $sql = "SELECT number FROM basket WHERE id_basket = :id_basket";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_basket', $id_basket);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row['number'] == 1) {
            $delete_query = "DELETE FROM basket WHERE id_basket = :id_basket";
            $stmt_delete = $conn->prepare($delete_query);
            $stmt_delete->bindParam(':id_basket', $id_basket);
            $stmt_delete->execute();
        } else {
            $update_query = "UPDATE basket SET number = number - 1 WHERE id_basket = :id_basket";
            $stmt_update = $conn->prepare($update_query);
            $stmt_update->bindParam(':id_basket', $id_basket);
            $stmt_update->execute();
        }
    }else{
}
}
basket_update();
$conn=null;


function basket_update(){
    include 'bd.php';
    $user_name = $_COOKIE['user_name'];
    $user_email = $_COOKIE['user_email'];

    $query_user = "SELECT id_user FROM user WHERE name = :name AND email = :email";
    $stmt_user = $conn->prepare($query_user);
    $stmt_user->bindParam(':name', $user_name);
    $stmt_user->bindParam(':email', $user_email);
    $stmt_user->execute();
    $user = $stmt_user->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $user_id = $user['id_user'];

        $query_basket = "SELECT id_basket, number, id_cactus FROM basket WHERE id_user = :user_id";
        $stmt_basket = $conn->prepare($query_basket);
        $stmt_basket->bindParam(':user_id', $user_id);
        $stmt_basket->execute();

        while ($row_basket = $stmt_basket->fetch(PDO::FETCH_ASSOC)) {
            $id_cactus = $row_basket['id_cactus'];
            
            // $number = $row_basket['number'];

            $query_product = "SELECT * FROM cactus WHERE id_cactus = :id_cactus";
            $stmt_product = $conn->prepare($query_product);
            $stmt_product->bindParam(':id_cactus', $id_cactus);
            $stmt_product->execute();
            $row_product = $stmt_product->fetch(PDO::FETCH_ASSOC);
    // Формирование информации о товаре
    echo '<div class="cactus_wrapp_user" />';
    echo '<div class="cactus_wrapp_img" />';
    echo '<img class="cactus_image" src="data:image/jpeg;base64,' . base64_encode($row_product['photo']) . '" />';
    echo '</div>';
    echo '<div class="desc">';
    echo '<p class="cactus_p cactus_title">' . $row_product['title'] . '</p>';
    echo '<p class="cactus_p cactus_cost">' . $row_product['cost'] .'₽'. '</p>';
    echo '<p class="cactus_p cactus_cost">' . $row_basket['number'] .'шт.'. '</p>';
    echo '<form method="POST" action="" class="basket_form busket_bus">';
    echo '<button type="submit" onclick="reloadPage()"class="buy_but but_bus" name="buttonn">Удалить</button>';
    echo '<input type="hidden" name="form_id" value='.$row_basket['id_basket'].'>';              
    echo '</form>';          
    echo '</div>';
    echo '</div>';
}
}
}