<?
session_start();
if (isset($_SESSION['user_name']) || isset($_SESSION['user_email'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['buttonn'])) {
    include 'bd.php';
    $user_email = $_SESSION['user_email'];
    $user_name = $_SESSION['user_name'];
    
    $query = "SELECT id_user FROM user WHERE name = :user_name AND email = :user_email";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':user_name', $user_name);
    $stmt->bindParam(':user_email', $user_email);
    $stmt->execute();
    $user_result = $stmt->fetch(PDO::FETCH_ASSOC);
    $id_user = $user_result['id_user'];
    
    $basket_query = $conn->prepare("SELECT * FROM basket WHERE id_user = :id_user");
    $basket_query->bindParam(':id_user', $id_user);
    $basket_query->execute();
    
    while($basket_row = $basket_query->fetch(PDO::FETCH_ASSOC)){
        $id_cactus = $basket_row['id_cactus'];
        $number = $basket_row['number'];
        $time = new DateTime();
        $time = $time->format('Y-m-d H:i');
    
        $insert_query = "INSERT INTO orders (id_user, id_cactus, number, status, time) VALUES (:id_user, :id_cactus, :number, 0, :time)";
        $stmt = $conn->prepare($insert_query);
        $stmt->bindParam(':id_user', $id_user);
        $stmt->bindParam(':id_cactus', $id_cactus);
        $stmt->bindParam(':number', $number);
        $stmt->bindParam(':time', $time);
        $stmt->execute();
    
        $delete_query = "DELETE FROM basket WHERE id_user = :id_user";
        $stmt = $conn->prepare($delete_query);
        $stmt->bindParam(':id_user', $id_user);
        $stmt->execute();
    }}}

order_user();
$conn = null;

function order_user(){
    include 'bd.php';
    $user_name = $_SESSION['user_name'];
    $user_email = $_SESSION['user_email'];

    $query_user = "SELECT id_user FROM user WHERE name = :name AND email = :email";
    $stmt_user = $conn->prepare($query_user);
    $stmt_user->bindParam(':name', $user_name);
    $stmt_user->bindParam(':email', $user_email);
    $stmt_user->execute();
    $user = $stmt_user->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $user_id = $user['id_user'];

        $query_basket = "SELECT id_order, number,status, id_cactus  FROM orders WHERE id_user = :user_id";
        $stmt_basket = $conn->prepare($query_basket);
        $stmt_basket->bindParam(':user_id', $user_id);
        $stmt_basket->execute();
        if ($stmt_basket->rowCount() > 0) {

        while ($row_basket = $stmt_basket->fetch(PDO::FETCH_ASSOC)) {
            $id_cactus = $row_basket['id_cactus'];
            $status = $row_basket['status'];
            $status_info = '';
            if ($status == 0){
                $status_info = 'Ожидает подтверждения';
            }elseif($status == 1){
                $status_info = 'Заказ в работе';
            };
            
            // $number = $row_basket['number'];

            $query_product = "SELECT * FROM cactus WHERE id_cactus = :id_cactus";
            $stmt_product = $conn->prepare($query_product);
            $stmt_product->bindParam(':id_cactus', $id_cactus);
            $stmt_product->execute();
            $row_product = $stmt_product->fetch(PDO::FETCH_ASSOC);
    
    // Формирование информации о товаре
    echo '<div class="cactus_wrapp cactus_wrapp_orders" />';
    echo '<div class="cactus_image_basket" />';
    echo '<img class="cactus_image" src="data:image/jpeg;base64,' . base64_encode($row_product['photo']) . '" />';
    echo '</div>';
    echo '<div class="desc">';
    echo '<p class="cactus_p cactus_title">' . $row_product['title'] . '</p>';
    echo '<p class="cactus_p cactus_cost">' . $row_product['cost'] .'₽'.'(1 шт.)'. '</p>';
    echo '<p class="cactus_p cactus_cost">' . $row_basket['number'] .'шт.'. '</p>';
    echo '<p class="cactus_p">'.$status_info.'</p>';
    echo '<form method="POST" action="" class="basket_form busket_bus">';          
    echo '</form>';          
    echo '</div>';
    echo '</div>';
}session_start();
unset( $_SESSION['has_basket']);
}else{
    session_start();
    $_SESSION['has_basket']=0;
}
}
}

