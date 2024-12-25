<?php
session_start();
require "mail.php";
if(!isset($_SESSION['register'])){
    header("location:login.php");
}
     if((time() - $_SESSION['start_time']) > 180){
        $dogrulama = random_int(100000, 999999);
        $_SESSION['dogrulama'] = $dogrulama;
        dogrulamaYolla($_SESSION['register'],$dogrulama);
        $_SESSION['start_time'] = time();
        setcookie("basariliyenikod",1,time()+10);
        if(isset($_SESSION['fp'])){
            header("location:forgotPassword2.php");
        }
        else{
            header("location:register2.php");
        }
    }
     else{
        setcookie("basarisizyenikod",1,time()+10);
        if(isset($_SESSION['fp'])){
            header("location:forgotPassword2.php");
        }
        else{
            header("location:register2.php");
        }
     }

?>