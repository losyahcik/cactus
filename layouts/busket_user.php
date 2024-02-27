<?
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['buttonn'])) {
    if (isset($_COOKIE['user_name']) ||  isset($_COOKIE['user_email'])) {
        
        include 'bd.php';

        $sql = "SELECT * FROM user WHERE name = :name AND email = :email";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':name', $_COOKIE['user_name']);
        $stmt->bindValue(':email', $_COOKIE['user_email']);
        $stmt->execute();
        $user = $stmt->fetch();

        $basketArray = explode(',', $user['basket']);

        $index = array_search($_POST['form_id'], $basketArray);

        if ($index !== false) {
            unset($basketArray[$index]);
        }

        $basketString = implode(',', $basketArray);

        $sql = "UPDATE user SET basket = :basket WHERE name = :name AND email = :email";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':basket', $basketString);
        $stmt->bindValue(':name', $_COOKIE['user_name']);
        $stmt->bindValue(':email',$_COOKIE['user_email']);
        $stmt->execute();
        busket_user();
    } 
}else{
        busket_user();
    }

function busket_user(){
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

$basketArray = explode(',', $user['basket']);

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
    echo '<form method="POST" action="" class="basket_form busket_bus">';
    echo '<button type="submit" onclick="reloadPage()" id='. $product['id'].' class="buy_but but_bus" name="buttonn">Удалить</button>';
    echo '<input type="hidden" name="form_id" value='. $product['id'].'>';              
    echo '</form>';          
    echo '</div>';
    echo '</div>';
}

}