<?php
session_start();

if(!isset($_SESSION['login']) || !isset($_SESSION['yonetici'])){
    header("Location:login.php");
    exit();
}

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require "req.php";
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$conn = mysqli_connect("localhost","root","","327Hastanesi");
$smtpq = "select * from smtp where id='1';";
$smtpr = mysqli_query($conn,$smtpq);
$smtpr = mysqli_fetch_assoc($smtpr); 
$mailhostsql = htmlspecialchars(trim(stripslashes($smtpr['mailhost']))); 
$usernamesql = htmlspecialchars(trim(stripslashes($smtpr['username']))); 
$passwordsql = htmlspecialchars(trim(stripslashes($smtpr['password']))); 
$send_fromsql = htmlspecialchars(trim(stripslashes($smtpr['send_from']))); 
$send_from_namesql = htmlspecialchars(trim(stripslashes($smtpr['send_from_name']))); 
$reply_tosql = htmlspecialchars(trim(stripslashes($smtpr['reply_to']))); 
$reply_to_namesql = htmlspecialchars(trim(stripslashes($smtpr['reply_to_name']))); 

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['smtpayarla'])){


    $mailhost = htmlspecialchars(stripslashes(trim($_POST['mailhost'])));
    $username = htmlspecialchars(stripslashes(trim($_POST['username'])));
    $password = htmlspecialchars(stripslashes(trim($_POST['password'])));
    $send_from = htmlspecialchars(stripslashes(trim($_POST['send_from'])));
    $send_from_name = htmlspecialchars(stripslashes(trim($_POST['send_from_name'])));
    $reply_to = htmlspecialchars(stripslashes(trim($_POST['reply_to'])));
    $reply_to_name = htmlspecialchars(stripslashes(trim($_POST['reply_to_name'])));

    function denemeMail($email, $subject, $message, $mailhost, $username, $password, $send_from, $send_from_name, $reply_to, $reply_to_name) {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->SMTPAuth = true;
            $mail->Host = $mailhost;
            $mail->Username = $username;
            $mail->Password = $password;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
    
            $mail->setFrom($send_from, $send_from_name);
            $mail->addAddress($email);
            $mail->addReplyTo($reply_to, $reply_to_name);
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $message;
            $mail->AltBody = $message;
    
            $mail->send();
            return 1;
        } catch (Exception $e) {
            return 0; 
        }
    }

    if (denemeMail("egenull0@gmail.com", "subject", "message", $mailhost, $username, $password, $send_from, $send_from_name, $reply_to, $reply_to_name)){
    $query = "update smtp set mailhost='$mailhost', username='$username', password='$password', send_from='$send_from', send_from_name='$send_from_name', reply_to='$reply_to', reply_to_name='$reply_to_name' where id='1';";
    $result = mysqli_query($conn,$query);
    if($result)
     {
        echo "<div class='alert alert-success text-center mt-0'>SMTP Sunucusu Başarılı.</div>";
        header("Location:".$_SERVER['PHP_SELF']);
        exit();
     }
    else{
        echo "<div class='alert alert-warning text-center mt-0'>SMTP Sunucusu Başarılı fakat SMTP tablosuna erişim sağlanamadı.</div>";
        header("Location:".$_SERVER['PHP_SELF']);
        exit();
    }

}
else{
    echo "<div class='alert alert-danger text-center mt-0'>SMTP Sunucusunda problem oluştuğu için kaydedilmedi.</div>";
}
}


?>
<title>Özel 327 Hastanesi</title>
<link rel="icon" href="logo.png" type="image/x-icon">


<nav class="navbar bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="logout.php">
                <img src="https://i.ibb.co/xGzDqM9/logo.png" alt="Logo" width="100" height="40"
                    class="d-inline-block align-text-top">
            </a>
            <a href="admin.php" class="float-start"><button class="btn btn-warning">Geri Dön</button></a>
        </div>
    </nav>

<div class="container mt-5">
        <h1 class="text-center">SMTP Ayarları</h1>
        <form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
            <div class="form-group">
                <label for="mailhost">SMTP Sunucu:</label>
                <input type="text" class="form-control" value="<?php echo htmlspecialchars(trim(stripslashes($mailhostsql))) ?>" id="mailhost" name="mailhost" required>
            </div>
            <div class="form-group">
                <label for="username">Kullanıcı Adı:</label>
                <input type="text" class="form-control" value="<?php echo htmlspecialchars(trim(stripslashes($usernamesql))) ?>" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Şifre:</label>
                <input type="text" class="form-control" value="<?php echo htmlspecialchars(trim(stripslashes($passwordsql))) ?>" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="send_from">Gönderen E-posta:</label>
                <input type="email" class="form-control" value="<?php echo htmlspecialchars(trim(stripslashes($send_fromsql))) ?>" id="send_from" name="send_from" required>
            </div>
            <div class="form-group">
                <label for="send_from_name">Gönderen Adı:</label>
                <input type="text" class="form-control" value="<?php echo  htmlspecialchars(trim(stripslashes($send_from_namesql))) ?>" id="send_from_name" name="send_from_name" required>
            </div>
            <div class="form-group">
                <label for="reply_to">Yanıt E-posta:</label>
                <input type="email" class="form-control" value="<?php echo htmlspecialchars(trim(stripslashes($reply_tosql))) ?>" id="reply_to" name="reply_to" required>
            </div>
            <div class="form-group">
                <label for="reply_to_name">Yanıt Adı:</label>
                <input type="text" class="form-control" value="<?php echo htmlspecialchars(trim(stripslashes($reply_to_namesql))) ?>" id="reply_to_name" name="reply_to_name" required>
            </div>
            <button type="submit" name="smtpayarla" class="btn btn-primary btn-block">Ayarları Kaydet</button>
        </form>
    </div>