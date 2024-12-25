<?php

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

define('MAILHOST',"smtp.gmail.com");
define('USERNAME',"327hastanesibilgisistemi@gmail.com");
define('PASSWORD',"jvjk qkor afdo ptoi");
define('SEND_FROM',"info@hastane327.com");
define('SEND_FROM_NAME','327Hastanesi');
define('REPLY_TO',"info@327Hastanesi.com");
define('REPLY_TO_NAME','Ege');

function sendEmail($email,$subject,$message){
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->Host = MAILHOST;
    $mail->Username = USERNAME;
    $mail->Password = PASSWORD;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;
    $mail->setFrom(SEND_FROM,SEND_FROM_NAME);
    $mail->addAddress($email);
    $mail->addReplyTo(REPLY_TO,REPLY_TO_NAME);
    $mail->IsHTML(true);
    $mail->Subject = $subject;
    $mail->Body = $message;
    $mail->AltBody = $message;
    if(!$mail->send())
        return "Email not send, Please Try again";
    else{
        return "succes";
    }
}

?>


<?php

    

    function htmlOlustur($dKodu){
        $p1 = $dKodu[0];
        $p2 = $dKodu[1];
        $p3 = $dKodu[2];
        $p4 = $dKodu[3];
        $p5 = $dKodu[4];
        $p6 = $dKodu[5];
        $date = date('Y');
        return <<<EGE
        <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Forgot Password Email</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f4;
                margin: 0;
                padding: 0;
            }
            .container {
                max-width: 600px;
                margin: 0 auto;
                background-color: #ffffff;
                padding: 20px;
                border-radius: 10px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }
            .header {
                text-align: center;
                padding: 20px 0;
            }
            .header img {
                width: 40%; /* Logo boyutu %150 olarak ayarlandı */
                padding: 0;
            }
            .content {
                text-align: center;
            }
            .content h1 {
                color: #333333;
            }
            .content p {
                font-size: 16px;
                color: #666666;
            }
            .code-input {
                display: flex;
                justify-content: center;
                gap: 20px; /* Boşluk ekledik */
                margin-top: 20px;
            }
            .code-input input {
                width: 50px;
                padding: 10px;
                text-align: center;
                font-size: 18px;
                gap: 20px;
                border: 1px solid #cccccc;
                border-radius: 5px;
                margin-left:20px;
            }
            .btn {
                display: inline-block;
                margin-top: 20px;
                padding: 10px 20px;
                background-color: #00bfa5;
                color: #ffffff;
                text-decoration: none;
                border-radius: 5px;
            }
            .btn:hover {
                background-color: #008f7a;
            }
            .footer {
                text-align: center;
                padding: 20px;
                background-color: #00bfa5;
                color: #ffffff;
                font-size: 14px;
                border-radius: 5px;
            }
            .footer a {
                color: #ffffff;
                text-decoration: none;
            }
            .social-links img {
                width: 20px;
                margin: 0 5px;
            }
            .rights {
                font-size: 12px;
                margin-top: 10px;
                width: 100%; /* Genişliği tam yapalım */
                text-align: center; /* Yazıyı ortalayalım */
            }
            .ccontainer{
                display:flex;
                align-items: center;
                justify-content: center;
            }
        </style>
    </head>
    <body>
    <div class="container">
        <div class="header">
            <img src="https://i.ibb.co/xGzDqM9/logo.png" alt="Logo">
        </div>
        <div class="content">
            <h1>Şifremi Unuttum Bağlantısı</h1>
            <p>Bu E-Mail Talebiniz üzerine şifrenizi sıfırlamak için sistem tarafından otomatik olarak gönderilmiştir.</p>
            
        <center>
                <div class="code-input">
                <input type="text" value="$p1" disabled maxlength="1">
                <input type="text" value="$p2" disabled maxlength="1">
                <input type="text" value="$p3" disabled maxlength="1">
                <input type="text" value="$p4" disabled maxlength="1">
                <input type="text" value="$p5" disabled maxlength="1">
                <input type="text" value="$p6" disabled maxlength="1">
            </div>
        </center>
    
    
            <p>Özel 327 Hastanesi </p>
        </div>
    
        <div class="footer">
            <p>Bizi tercih ettiğiniz için teşekkür ederiz. <span>&#128525;</span></p>
            <p>Eğer şifre sıfırlamayı siz talep etmediyseniz bu e-mail'i dikkate almayınız. </p>
            <p>Sosyal medya hesaplarımız <br> <a href="">www.327hastanesi.com</a>.</p>
    
            <div class="social-links">
                <a href="https://facebook.com"><img src="https://img.icons8.com/color/48/000000/facebook.png" alt="Facebook"></a>
                <a href="https://x.com"><img src="https://img.icons8.com/color/48/000000/twitter.png" alt="Twitter"></a>
                <a href="https://linkedin.com"><img src="https://img.icons8.com/color/48/000000/linkedin.png" alt="LinkedIn"></a>
                <a href="https://instagram.com"><img src="https://img.icons8.com/color/48/000000/instagram-new.png" alt="Instagram"></a>
            </div>
    
    
           
        </div>
       <div class="ccontainer">
        <p class="rights">&copy; $date | 327 Özel Hastanesi, Tüm hakları saklıdır.</p>
       </div>
    
    </div>
    </body>
    </html>
    EGE;
    }

    function sifreUnuttum($mail){
        $dKodu = strval(rand(100001, 999999));
        $response = sendEmail($mail, "Şifre Yenileme Bağlantısı", htmlOlustur($dKodu), "Tarayıcınız HTML Template desteklemiyor. Doğrulama kodunuz : $dKodu");
        return $dKodu;
    }
?>