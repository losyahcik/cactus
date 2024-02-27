<?php
            if (isset($_GET['id'])) {
                $blockId = $_GET['id'];

                
                try {
                    include 'layouts/bd.php';
                    // Установка режима отображения ошибок
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                  
                    // Получение информации из БД
                    $stmt = $conn->prepare("SELECT * FROM cactus WHERE id = :id");
                    $stmt->bindParam(':id', $blockId);
                    $stmt->execute();
                  
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                  
                    if ($row) {
                      $title = $row['title'];
                      $description = $row['description'];
                      $cost = $row['cost'];
                      $photo = base64_encode($row['photo']);
                    } else {
                      echo "Запись не найдена";
                    }
                
                  } catch(PDOException $e) {
                    echo "Ошибка подключения к базе данных: " . $e->getMessage();
                  }
                
                  $conn = null;
                } else {
                  echo "Не указан идентификатор блока";
                }