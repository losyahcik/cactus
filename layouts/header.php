<? session_start()?>
<div class="header">
    <div class="logo logo_header">
        <a href="index.php">CEREUS</a>
    </div>
    <div class="user_hrefs">
    <div class="basket">
        <div class="cost">
            <p><? include 'cost_count.php';?>₽</p>
        </div>
        <a href='<? if(!isset($_SESSION['user_email'])){print_r('avtoristion.php');}else{print_r('busket.php');}?>' class="basket_href"><img src="img/basket.svg" class="basket_svg" alt="basket"></a>
    </div>
    <a href="<?  if(!isset($_SESSION['user_email'])){print_r('avtoristion.php');}else{print_r('user.php');}?>">
        <img src="img/profile.png" class="img_prof" alt="profile">
    </a>
    </div>
</div>