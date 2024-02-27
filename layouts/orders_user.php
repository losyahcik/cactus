<?

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['buttonn'])) {
    if (isset($_COOKIE['user_name']) ||  isset($_COOKIE['user_email'])) {
        
        include 'bd.php';

        $sql = "SELECT basket, orders FROM user WHERE name = :name AND email = :email";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':name', $_COOKIE['user_name']);
        $stmt->bindValue(':email', $_COOKIE['user_email']);
        $stmt->execute();
        $user = $stmt->fetch();

        $basketString = $user['basket'];
        $orderString = $user['orders'];
        if (!empty($orderString) || !($orderString == null)){
            $basketString = explode(',', $basketString);
            $orderString = explode(',', $orderString);
            $merged_list = array_merge($basketString, $orderString);
            $merged_list = array_unique($merged_list);
            $orderString = implode(',', $merged_list);
            $basketString ="";  

            $sql = "UPDATE user SET orders = :orders, basket = :basket WHERE name = :name AND email = :email";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':orders', $orderString);
            $stmt->bindParam(':basket', $basketString);
            $stmt->bindValue(':name', $_COOKIE['user_name']);
            $stmt->bindValue(':email',$_COOKIE['user_email']);
            $stmt->execute();

        }else{
            $sql = "UPDATE user SET orders = basket, basket = '' WHERE name = :name AND email = :email";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':name', $_COOKIE['user_name']);
            $stmt->bindValue(':email',$_COOKIE['user_email']);
            $stmt->execute(); 
        }

        
        order_user();
    } 
}else{
        order_user();
    }

function order_user(){
    include 'bd.php';

$sql = "SELECT * FROM user WHERE name = :name AND email = :email";
$stmt = $conn->prepare($sql);
$stmt->bindValue(':name', $_COOKIE['user_name']);
$stmt->bindValue(':email', $_COOKIE['user_email']);
$stmt->execute();
$user = $stmt->fetch(); 

if (!$user) {
    die("Пользователь не найден");
}

if($user['orders'] !== null){
$basketArray = explode(',', $user['orders']);

foreach ($basketArray as $productId) {
    // Поиск записи товара в таблице cactus
    $sql = "SELECT * FROM cactus WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':id', $productId);
    $stmt->execute();
    $product = $stmt->fetch();

    // Проверка наличия записи товара
    if (!$product) {
        continue;
    }
    
    // Формирование информации о товаре
    echo '<div class="cactus_wrapp_user" />';
    echo '<div class="cactus_wrapp_img" />';
    echo '<img class="cactus_image" src="data:image/jpeg;base64,' . base64_encode($product['photo']) . '" />';
    echo '</div>';
    echo '<div class="desc">';
    echo '<p class="cactus_p cactus_title">' . $product['title'] . '</p>';
    echo '<p class="cactus_p cactus_cost">' . $product['cost'] .'₽'. '</p>';
    echo '<p class="cactus_p"> Заказ в работе</p>';
    echo '<form method="POST" action="" class="basket_form busket_bus">';          
    echo '</form>';          
    echo '</div>';
    echo '</div>';
}
}
}

