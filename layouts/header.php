<? session_start()?>
<div class="header">
    <div class="logo logo_header">
        <a href="index.php">CEREUS</a>
    </div>
    <form method="post" class='form_search' action="search.php"> 
        <input class="input_search" type="text" autocomplete="off" name="search" autocomplete="none" required title="Введите название" placeholder="Найти...">
        <button class="submit_search" type="submit"><img class="search_but" src="img/search.png" alt="Найти"></button>
    </form>
    <div class="user_hrefs">
    <div class="basket">
        <div class="cost">
            <p><? include 'cost_count.php';?>₽</p>
        </div>
        <a href='<? if(!isset($_SESSION['user_email'])){print_r('avtoristion.php');}else{print_r('busket.php');}?>' class="basket_href"><img src="img/basket.png" class="basket_svg" alt="basket"></a>
    </div>
    <a href="<?  if(!isset($_SESSION['user_email'])){print_r('avtoristion.php');}else{print_r('user.php');}?>">
        <img src="img/profile.png" class="img_prof" alt="profile">
    </a>
    </div>
</div>