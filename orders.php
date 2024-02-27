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
        <div class="wrapp wrapp_user">
                <?php include 'layouts/orders_user.php';?>
        </div>
    </main>
    <footer>
    <?php
    include 'layouts/footer.php';
    ?>
    </footer>
</body>
</html>