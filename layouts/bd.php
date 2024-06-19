
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cereus2";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Успешное подключение к базе данных Cereus через PDO";
} catch(PDOException $e) {
    // echo "Ошибка подключения: " . $e->getMessage();  
}
?>