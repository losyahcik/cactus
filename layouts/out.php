<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();
    unset ( $_SESSION [ 'user_email' ]); 
    unset ( $_SESSION [ 'user_name' ]); 
    unset ( $_SESSION['password']); 
    session_unset();
    session_destroy();
    header("Location: ../index.php");
}
