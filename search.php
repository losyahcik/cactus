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
    <header>
    <?php
    include 'layouts/header.php';
    ?>
    </header>
    <main>
        <div class="wrapp_index">
           <? include 'layouts/bd.php';
           if(isset($_POST['search'])) {
    $search = $_POST['search'];
    $stmt = $conn->prepare("SELECT * FROM cactus WHERE title LIKE :search");
    $stmt->execute(array(':search' => '%' . $search . '%'));
    // Вывод результатов поиска
    echo "<h2>Результаты поиска:</h2>";
    if ($stmt->rowCount() > 0) {
        while($row = $stmt->fetch()) {
            echo "Товар: <a href='buy.php?id=" . $row["id_cactus"] . "'>" . $row["title"] . "</a><br>";
        }
    } else {
        echo "Товар не найден.";
    }
}?>
        </div>
    </main>
    <footer>
    <?php
    include 'layouts/footer.php';
    ?>
<script>
function redirectToBuyPage(blockId) {
  window.location = "buy.php?id=" + blockId;
}
</script>
</body>
</html>