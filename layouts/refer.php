<?php
if(isset($_SERVER['HTTP_REFERER'])){
    $referer = $_SERVER['HTTP_REFERER'];
    
    if(strpos($referer, "regstration.php") !== false){
        include 'layouts/reg.php';
    }
    elseif(strpos($referer, "avtoristion.php") !== false){
        include "layouts/avt.php";
    }
    else{
        // Обработка других случаев
        // echo 'что то пошло не так';
    }
}
else{
    // Обработка случая, когда отсутствует информация о referer
    echo "Что то пошло не так ";
}