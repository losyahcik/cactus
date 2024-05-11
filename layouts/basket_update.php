<?
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['user_name']) || !isset($_SESSION['user_email'])) {
        header("Location: ../regstration.php");
        exit;
    } else {
        $id_cactus = $_POST['hidden'];
        if (isset($_SESSION['user_name']) && isset($_POST['buttonn'])){
            basket_update($id_cactus);
            header('Location: ../buy.php?id='.$id_cactus);
            exit();
        }elseif(isset($_SESSION['user_name']) && isset($_POST['buttonn_index'])){
            basket_update($id_cactus);
            header('Location: ../index.php');
        }
    }
}
$conn=null;
function basket_update($id_cactus) {
include 'bd.php';

$user_name = $_SESSION['user_name'];
$user_email = $_SESSION['user_email'];
$stmt = $conn->prepare("SELECT id_user FROM user WHERE name = :name AND email = :email");
$stmt->bindParam(':name', $user_name);
$stmt->bindParam(':email', $user_email);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

$id_user = $row['id_user'];
$query = "SELECT * FROM basket WHERE id_user = :id_user AND id_cactus = :id_cactus";
$stmt = $conn->prepare($query);
$stmt->bindParam(':id_user', $id_user);
$stmt->bindParam(':id_cactus', $id_cactus);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $number = $row['number'] + 1;
    $sql = "UPDATE basket SET number = :number WHERE id_user = :id_user AND id_cactus = :id_cactus";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':number', $number);
    $stmt->bindParam(':id_user', $id_user);
    $stmt->bindParam(':id_cactus', $id_cactus);
    $stmt->execute();
} else {
    $sql = "INSERT INTO basket (id_user, id_cactus, number) VALUES (:id_user, :id_cactus, 1)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_user', $id_user);
    $stmt->bindParam(':id_cactus', $id_cactus);
    $stmt->execute();
}
}