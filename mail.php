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

function mailLog($email,$subject,$basari){
    $conn = mysqli_connect("localhost","root","","327Hastanesi");
    mysqli_set_charset($conn, "utf8mb4");
    $query = "INSERT INTO mail(email, subject, basari) VALUES ('$email', '$subject', $basari);";
    $result = mysqli_query($conn,$query);
    if($result){
        return 1;
    }
    else{
        return 0;
    }
    mysqli_close($conn);
}

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
        return mailLog($email,$subject,0);
    else{
        return mailLog($email,$subject,1);
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
                width: 40%;
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
                gap: 20px;
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
                width: 100%; 
                text-align: center; 
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

    function iseAlim($mail,$ad,$soyad){
        $start_date = date('Y-m-d');
        $date = date('Y');
        $html = <<<EGE
        <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>İşe Alım Bildirimi</title>
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
            width: 40%;
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
            width: 100%;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <img src="https://i.ibb.co/xGzDqM9/logo.png" alt="Logo">
    </div>
    <div class="content">
        <h1>Kayıt Bildirimi</h1>
        <h3>Sayın $ad $soyad </h3>
        <p>Bu e-posta, 327 Özel Hastanesi'nde kaydınız oluşturulduğunu bildirmek için otomatik olarak gönderilmiştir.</p>
        
        <p>Başlangıç Tarihi: <strong>$start_date</strong></p>
        
        <p>Bizimle çalışacağınız için çok mutluyuz! Daha fazla bilgi almak için İnsan Kaynakları departmanımızla iletişime geçebilirsiniz.</p>
        
        <p>Özel 327 Hastanesi</p>
    </div>

    <div class="footer">
        <p>Bizimle çalışmaya başladığınız için teşekkür ederiz! <span>&#128525;</span></p>
        <p>Herhangi bir sorunuz varsa, lütfen iletişime geçin.</p>
        <p>Sosyal medya hesaplarımız <br> <a href="">www.327hastanesi.com</a>.</p>

        <div class="social-links">
            <a href="https://facebook.com"><img src="https://img.icons8.com/color/48/000000/facebook.png" alt="Facebook"></a>
            <a href="https://x.com"><img src="https://img.icons8.com/color/48/000000/twitter.png" alt="Twitter"></a>
            <a href="https://linkedin.com"><img src="https://img.icons8.com/color/48/000000/linkedin.png" alt="LinkedIn"></a>
            <a href="https://instagram.com"><img src="https://img.icons8.com/color/48/000000/instagram-new.png" alt="Instagram"></a>
        </div>
    </div>
    <div class="rights">
        <p>&copy; $date | 327 Özel Hastanesi, Tüm hakları saklıdır.</p>
    </div>
</div>
</body>
</html>
EGE;
    
        if(sendEmail($mail,"327 Hastanesine Hosgeldiniz !",$html)){
            return 1;
        }
        else{
            return 0;
        }
}


function istenCikar($mail){
    $date = date('Y');
    $termination_date = date('Y-m-d');
    $html = 
    <<<EGE

    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>İşten Çıkarma Bildirimi</title>
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
            width: 40%;
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
            width: 100%;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <img src="https://i.ibb.co/xGzDqM9/logo.png" alt="Logo">
    </div>
    <div class="content">
        <h1>İşten Çıkarma Bildirimi</h1>
        <p>Bu e-posta, 327 Özel Hastanesi'nde çalıştığınız pozisyondan ayrılma kararınızı bildirmek için otomatik olarak gönderilmiştir.</p>
        
        <p>İşten çıkarılma tarihiniz: <strong>$termination_date</strong></p>
        
        <p>Bu süreçte yaşanan tüm katkılarınız için teşekkür ederiz. Herhangi bir sorunuz varsa, lütfen İnsan Kaynakları departmanımızla iletişime geçin.</p>
        
        <p>Özel 327 Hastanesi</p>
    </div>

    <div class="footer">
        <p>Bizi tercih ettiğiniz için teşekkür ederiz. <span>&#128525;</span></p>
        <p>Bu e-posta hakkında daha fazla bilgi için lütfen iletişime geçin.</p>
        <p>Sosyal medya hesaplarımız <br> <a href="">www.327hastanesi.com</a>.</p>

        <div class="social-links">
            <a href="https://facebook.com"><img src="https://img.icons8.com/color/48/000000/facebook.png" alt="Facebook"></a>
            <a href="https://x.com"><img src="https://img.icons8.com/color/48/000000/twitter.png" alt="Twitter"></a>
            <a href="https://linkedin.com"><img src="https://img.icons8.com/color/48/000000/linkedin.png" alt="LinkedIn"></a>
            <a href="https://instagram.com"><img src="https://img.icons8.com/color/48/000000/instagram-new.png" alt="Instagram"></a>
        </div>
    </div>
    <div class="rights">
        <p>&copy; $date | 327 Özel Hastanesi, Tüm hakları saklıdır.</p>
    </div>
</div>
</body>
</html>


EGE;
 if(sendEmail($mail,"Bizimle calistiginiz icin tesekkur ederiz.",$html)){
    return 1;
 }
 else{
    return 0;
 }
}

function mailGonder($mail,$subject,$sender,$recipient,$message_content){
    $date = date('Y');
    $html = 
    <<<EGE

    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kurum İçi E-Posta</title>
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
            width: 40%; 
            padding: 0;
        }
        .content {
            text-align: left;
            margin-top: 20px;
        }
        .content h1 {
            color: #333333;
        }
        .content p {
            font-size: 16px;
            color: #666666;
        }
        .info {
            margin-top: 20px;
            padding: 0 20px;
        }
        .info p {
            margin: 5px 0;
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
        .rights {
            font-size: 12px;
            margin-top: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <img src="https://i.ibb.co/xGzDqM9/logo.png" alt="Kurum Logo">
    </div>
    <div class="content">
        <center><h1>$subject</h1></center>
        <div class="info">
            <center><p><strong>Gönderici:</strong> $sender</p></center>
            <center><p><strong>Alıcı:</strong> $recipient</p></center>
        </div>
        
        <center><h2>Mesaj İçeriği:</h2></center>
        <center><p>$message_content</p></center>
        
        <p>İyi çalışmalar dileriz!</p>
    </div>

    <div class="footer">
        <p>Kurum içi iletişiminiz için teşekkür ederiz. <span>&#128525;</span></p>
        <p>Herhangi bir sorunuz varsa, lütfen iletişime geçin.</p>

        <div class="rights">
            <p>&copy; $date | Kurum Adı, Tüm hakları saklıdır.</p>
        </div>
    </div>
</div>
</body>
</html>
EGE;
sendEmail($mail,"Kurum Ici Mail !",$html);
}

// function randevuBildir($mail,$ad,$soyad,$sikayet,$hakkinda,$randevuTarihi){
//     $date = date('Y');
//     $html =
//     <<<EGE

//     <!DOCTYPE html>
// <html lang="en">
// <head>
//     <meta charset="UTF-8">
//     <meta http-equiv="X-UA-Compatible" content="IE=edge">
//     <meta name="viewport" content="width=device-width, initial-scale=1.0">
//     <title>Randevu Bilgisi</title>
//     <style>
//         body {
//             font-family: Arial, sans-serif;
//             background-color: #f4f4f4;
//             margin: 0;
//             padding: 0;
//         }
//         .container {
//             max-width: 600px;
//             margin: 0 auto;
//             background-color: #ffffff;
//             padding: 20px;
//             border-radius: 10px;
//             box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
//         }
//         .header {
//             text-align: center;
//             padding: 20px 0;
//         }
//         .header img {
//             width: 40%;
//         }
//         .content {
//             text-align: center;
//         }
//         .content h1 {
//             color: #333333;
//         }
//         .content p {
//             font-size: 16px;
//             color: #666666;
//         }
//         .info {
//             text-align: left;
//             margin-top: 20px;
//             padding: 0 20px;
//         }
//         .info p {
//             margin: 5px 0;
//         }
//         .footer {
//             text-align: center;
//             padding: 20px;
//             background-color: #00bfa5;
//             color: #ffffff;
//             font-size: 14px;
//             border-radius: 5px;
//         }
//         .footer a {
//             color: #ffffff;
//             text-decoration: none;
//         }
//         .social-links img {
//             width: 20px;
//             margin: 0 5px;
//         }
//         .rights {
//             font-size: 12px;
//             margin-top: 10px;
//             width: 100%;
//             text-align: center;
//         }
//         .hastainfo {
//             text-align: center;
//             padding: 20px;
//             background-color: red;
//             color: #ffffff;
//             font-size: 14px;
//             border-radius: 5px;
//         }
//         .hastainfo a {
//             color: #ffffff;
//             text-decoration: none;
//         }
//         .hastainfo p {
//             color: black;
//         }
//         .calendar-buttons {
//             text-align: center;
//             margin-top: 20px;
//         }
//         .calendar-buttons a {
//             display: inline-flex;
//             align-items: center;
//             padding: 10px 20px;
//             margin: 10px;
//             color: #ffffff;
//             text-decoration: none;
//             border-radius: 5px;
//         }
//         .calendar-buttons img {
//             width: 20px;
//             margin-right: 10px;
//         }
//         .google-btn {
//             background-color: #4285F4;
//         }
//         .outlook-btn {
//             background-color: #0072C6;
//         }
//     </style>
// </head>
// <body>
// <div class="container">
//     <div class="header">
//         <img src="https://i.ibb.co/xGzDqM9/logo.png" alt="Logo">
//     </div>
//     <div class="content">
//         <h1>Yeni Randevu Bilgisi</h1>
//         <p>Bu e-posta, 327 Özel Hastanesi'nde bir hasta için yeni bir randevu eklendiğini bildirmek amacıyla otomatik olarak gönderilmiştir.</p>
        
//         <div class="hastainfo">
//             <p><strong>Hasta Adı Soyadı:</strong> $patient_name</p>
//             <p><strong>Hasta Şikayeti:</strong> $patient_complaint</p>
//             <p><strong>Hasta Hakkında:</strong> $patient_info</p>
//             <p><strong>Randevu Tarihi:</strong> $appointment_date</p>
//         </div>

//         <!-- Google ve Outlook Takvim düğmeleri -->
//         <div class="calendar-buttons">
//             <a href="https://calendar.google.com/calendar/u/0/r/eventedit?text=Randevu%20Bilgisi&dates=20241030T090000Z/20241030T100000Z&details=Randevu%20detayları:%20Hastane%20ABC,%20Oda%20101&location=Hastane%20ABC" target="_blank" class="google-btn">
//                 <img src="https://img.icons8.com/color/48/000000/google-logo.png" alt="Google Logo">
//                 Google Takvimine Ekle
//             </a>
//             <a href="https://outlook.live.com/calendar/0/deeplink/compose?path=/calendar/action/compose&subject=Randevu%20Bilgisi&startdt=2024-10-30T09:00:00&enddt=2024-10-30T10:00:00&body=Randevu%20detayları:%20Hastane%20ABC,%20Oda%20101&location=Hastane%20ABC" target="_blank" class="outlook-btn">
//                 <img src="https://img.icons8.com/?size=100&id=22989&format=png&color=000000" alt="Outlook Logo">
//                 Outlook Takvimine Ekle
//             </a>
//         </div>

//         <p>Randevuyla ilgili daha fazla bilgi için İnsan Kaynakları departmanımızla iletişime geçebilirsiniz.</p>
        
//         <p>Özel 327 Hastanesi</p>
//     </div>

//     <div class="footer">
//         <p>Bizimle çalıştığınız için teşekkür ederiz! <span>&#128525;</span></p>
//         <p>Herhangi bir sorunuz varsa, lütfen iletişime geçin.</p>
//         <p>Sosyal medya hesaplarımız <br> <a href="">www.327hastanesi.com</a>.</p>

//         <div class="social-links">
//             <a href="https://facebook.com"><img src="https://img.icons8.com/color/48/000000/facebook.png" alt="Facebook"></a>
//             <a href="https://x.com"><img src="https://img.icons8.com/color/48/000000/twitter.png" alt="Twitter"></a>
//             <a href="https://linkedin.com"><img src="https://img.icons8.com/color/48/000000/linkedin.png" alt="LinkedIn"></a>
//             <a href="https://instagram.com"><img src="https://img.icons8.com/color/48/000000/instagram-new.png" alt="Instagram"></a>
//         </div>
//     </div>
//     <div class="rights">
//         <p>&copy; $date | 327 Özel Hastanesi, Tüm hakları saklıdır.</p>
//     </div>
// </div>
// </body>
// </html>



// EGE;
// sendEmail($mail,"Yeni Randevu Bildirimi !",$html);
// }


function randevuBildir($mail, $ad, $soyad, $sikayet, $hakkinda, $randevuTarihi, $brans) {
    // Tarih formatlamaları
    $date = date('Y');
    $startDateGoogle = date("Ymd\THis\Z", strtotime($randevuTarihi));
    $endDateGoogle = date("Ymd\THis\Z", strtotime($randevuTarihi . ' +30 minutes'));
    
    $startDateOutlook = date("Y-m-d\TH:i:s", strtotime($randevuTarihi));
    $endDateOutlook = date("Y-m-d\TH:i:s", strtotime($randevuTarihi . ' +30 minutes'));

    // Event ismi ve detayları
    $eventName = "Özel 327 Hastanesi, $brans randevusu";
    $eventDetails = "Randevu detayları: Özel 327 Hastanesi, $brans randevusu";
    $location = "Özel 327 Hastanesi";

    // HTML içeriği
    $html = <<<EGE
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Randevu Bilgisi</title>
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
            width: 40%;
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
        .info {
            text-align: left;
            margin-top: 20px;
            padding: 0 20px;
        }
        .info p {
            margin: 5px 0;
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
            width: 100%;
            text-align: center;
        }
        .hastainfo {
            text-align: center;
            padding: 20px;
            background-color: red;
            color: #ffffff;
            font-size: 14px;
            border-radius: 5px;
        }
        .hastainfo a {
            color: #ffffff;
            text-decoration: none;
        }
        .hastainfo p {
            color: black;
        }
        .calendar-buttons {
            text-align: center;
            margin-top: 20px;
        }
        .calendar-buttons a {
            display: inline-flex;
            align-items: center;
            padding: 10px 20px;
            margin: 10px;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
        }
        .calendar-buttons img {
            width: 20px;
            margin-right: 10px;
        }
        .google-btn {
            background-color: #4285F4;
        }
        .outlook-btn {
            background-color: #0072C6;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <img src="https://i.ibb.co/xGzDqM9/logo.png" alt="Logo">
    </div>
    <div class="content">
        <h1>Yeni Randevu Bilgisi</h1>
        <p>Bu e-posta, 327 Özel Hastanesi'nde bir hasta için yeni bir randevu eklendiğini bildirmek amacıyla otomatik olarak gönderilmiştir.</p>
        
        <div class="hastainfo">
            <p><strong>Hasta Adı Soyadı:</strong> $ad $soyad</p>
            <p><strong>Hasta Şikayeti:</strong> $sikayet</p>
            <p><strong>Hasta Hakkında:</strong> $hakkinda</p>
            <p><strong>Randevu Tarihi:</strong> $randevuTarihi</p>
        </div>

        <!-- Google ve Outlook Takvim düğmeleri -->
        <div class="calendar-buttons">
            <a href="https://calendar.google.com/calendar/u/0/r/eventedit?text={$eventName}&dates={$startDateGoogle}/{$endDateGoogle}&details={$eventDetails}&location={$location}" target="_blank" class="google-btn">
                <img src="https://img.icons8.com/color/48/000000/google-logo.png" alt="Google Logo">
                Google Takvimine Ekle
            </a>
            <a href="https://outlook.live.com/calendar/0/deeplink/compose?path=/calendar/action/compose&subject={$eventName}&startdt={$startDateOutlook}&enddt={$endDateOutlook}&body={$eventDetails}&location={$location}" target="_blank" class="outlook-btn">
                <img src="https://img.icons8.com/?size=100&id=22989&format=png&color=000000" alt="Outlook Logo">
                Outlook Takvimine Ekle
            </a>
        </div>

        <p>Randevuyla ilgili daha fazla bilgi için İnsan Kaynakları departmanımızla iletişime geçebilirsiniz.</p>
        
        <p>Özel 327 Hastanesi</p>
    </div>

    <div class="footer">
        <p>Bizimle çalıştığınız için teşekkür ederiz! <span>&#128525;</span></p>
        <p>Herhangi bir sorunuz varsa, lütfen iletişime geçin.</p>
        <p>Sosyal medya hesaplarımız <br> <a href="">www.327hastanesi.com</a>.</p>

        <div class="social-links">
            <a href="https://facebook.com"><img src="https://img.icons8.com/color/48/000000/facebook.png" alt="Facebook"></a>
            <a href="https://x.com"><img src="https://img.icons8.com/color/48/000000/twitter.png" alt="Twitter"></a>
            <a href="https://linkedin.com"><img src="https://img.icons8.com/color/48/000000/linkedin.png" alt="LinkedIn"></a>
            <a href="https://instagram.com"><img src="https://img.icons8.com/color/48/000000/instagram-new.png" alt="Instagram"></a>
        </div>
    </div>
    <div class="rights">
        <p>&copy; $date | 327 Özel Hastanesi, Tüm hakları saklıdır.</p>
    </div>
</div>
</body>
</html>

EGE;

    sendEmail($mail, "Yeni $brans Randevu Bildirimi!", $html);
}



function topluDuyuru($baslik,$icerik){
    $date = date('Y');
    $tarih = date('Y-m-d');
    $html = 
    <<<EGE

    <!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Duyuru Bildirimi</title>
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
            width: 40%;
        }
        .content {
            text-align: left;
        }
        .content h1 {
            color: #333333;
        }
        .content p {
            font-size: 16px;
            color: #666666;
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
        .rights {
            font-size: 12px;
            margin-top: 10px;
            width: 100%;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <img src="https://i.ibb.co/xGzDqM9/logo.png" alt="Logo">
    </div>
    <div class="content">
        <h1>Duyuru</h1>
        <p>Sayın Çalışanlar,</p>
        <p>Aşağıda belirtilen önemli bir duyuru ile ilgili bilgileri paylaşmak istiyoruz:</p>

        <p><strong>Duyuru Başlığı:</strong> $baslik</p>
        <p><strong>Duyuru İçeriği:</strong> $icerik</p>
        <p><strong>Tarih:</strong> $tarih </p>

        <p>Duyurumuz ile ilgili herhangi bir sorunuz veya geri bildiriminiz varsa, lütfen İnsan Kaynakları departmanımızla iletişime geçin.</p>
    </div>

    <div class="footer">
        <p>Göstermiş olduğunuz ilgi için teşekkür ederiz! <span>&#128525;</span></p>
        <p>İletişim için: <a href="mailto:info@327hastanesi.com">info@327hastanesi.com</a></p>
    </div>
    <div class="rights">
        <p>&copy; <?php echo date('Y'); ?> | 327 Özel Hastanesi, Tüm hakları saklıdır.</p>
    </div>
</div>
</body>
</html>

EGE;

$conn = mysqli_connect("localhost","root","","327Hastanesi");
mysqli_set_charset($conn, "utf8mb4");
$query = "select mail from doktorlar";
$maillerd = mysqli_query($conn,$query);
$mailList = [];
while($row = mysqli_fetch_assoc($maillerd)){
    $mailList[] = $row['mail'];
}
$query = "select mail from sekreterler";
$maillerd = mysqli_query($conn,$query);
while($row = mysqli_fetch_assoc($maillerd)){
    $mailList[] = $row['mail'];
}

foreach ($mailList as $mail ) {
    sendEmail($mail,"Toplu Duyuru",$html);
}
mysqli_close($conn);
}


function calisanaMesaj($mail,$baslik,$icerik){ 
    $tarih = date('Y-m-d');
    $date = date('Y');
    $html =
    <<<EGE

    <!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Duyuru Bildirimi</title>
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
            width: 40%;
        }
        .content {
            text-align: left;
        }
        .content h1 {
            color: #333333;
        }
        .content p {
            font-size: 16px;
            color: #666666;
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
        .rights {
            font-size: 12px;
            margin-top: 10px;
            width: 100%;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <img src="https://i.ibb.co/xGzDqM9/logo.png" alt="Logo">
    </div>
    <div class="content">
        <h1>$baslik</h1>
        <p>Sayın Çalışan,</p>
        <p>Sistemden size bir mesaj var :</p>

        <p><strong>Mesaj İçeriği:</strong> $icerik</p>
        <p><strong>Tarih:</strong> $tarih </p>

        <p>Duyurumuz ile ilgili herhangi bir sorunuz veya geri bildiriminiz varsa, lütfen İnsan Kaynakları departmanımızla iletişime geçin.</p>
    </div>

    <div class="footer">
        <p>Göstermiş olduğunuz ilgi için teşekkür ederiz! <span>&#128525;</span></p>
        <p>İletişim için: <a href="mailto:info@327hastanesi.com">info@327hastanesi.com</a></p>
    </div>
    <div class="rights">
        <p>&copy; $date | 327 Özel Hastanesi, Tüm hakları saklıdır.</p>
    </div>
</div>
</body>
</html>
EGE;

if(sendEmail($mail,"Sistemden Size Mesaj",$html)){
    return 1;
}
else{
    return 0;
}

}
function doktorlaraDuyuru($baslik,$icerik){
    $date = date('Y');
    $tarih = date('Y-m-d');
    $html = 
    <<<EGE

    <!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Duyuru Bildirimi</title>
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
            width: 40%;
        }
        .content {
            text-align: left;
        }
        .content h1 {
            color: #333333;
        }
        .content p {
            font-size: 16px;
            color: #666666;
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
        .rights {
            font-size: 12px;
            margin-top: 10px;
            width: 100%;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <img src="https://i.ibb.co/xGzDqM9/logo.png" alt="Logo">
    </div>
    <div class="content">
        <h1>Duyuru</h1>
        <p>Sayın Çalışanlar,</p>
        <p>Aşağıda belirtilen önemli bir duyuru ile ilgili bilgileri paylaşmak istiyoruz:</p>

        <p><strong>Duyuru Başlığı:</strong> $baslik</p>
        <p><strong>Duyuru İçeriği:</strong> $icerik</p>
        <p><strong>Tarih:</strong> $tarih </p>

        <p>Duyurumuz ile ilgili herhangi bir sorunuz veya geri bildiriminiz varsa, lütfen İnsan Kaynakları departmanımızla iletişime geçin.</p>
    </div>

    <div class="footer">
        <p>Göstermiş olduğunuz ilgi için teşekkür ederiz! <span>&#128525;</span></p>
        <p>İletişim için: <a href="mailto:info@327hastanesi.com">info@327hastanesi.com</a></p>
    </div>
    <div class="rights">
        <p>&copy; <?php echo date('Y'); ?> | 327 Özel Hastanesi, Tüm hakları saklıdır.</p>
    </div>
</div>
</body>
</html>

EGE;

$conn = mysqli_connect("localhost","root","","327Hastanesi");
mysqli_set_charset($conn, "utf8mb4");
$query = "select mail from doktorlar";
$maillerd = mysqli_query($conn,$query);
$mailList = [];
while($row = mysqli_fetch_assoc($maillerd)){
    $mailList[] = $row['mail'];
}

foreach ($mailList as $mail ) {
    sendEmail($mail,"Doktorlara Toplu Duyuru",$html);
}
mysqli_close($conn);
}


function sekreterlereTopluDuyuru($baslik,$icerik){
    $date = date('Y');
    $tarih = date('Y-m-d');
    $html = 
    <<<EGE

    <!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Duyuru Bildirimi</title>
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
            width: 40%;
        }
        .content {
            text-align: left;
        }
        .content h1 {
            color: #333333;
        }
        .content p {
            font-size: 16px;
            color: #666666;
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
        .rights {
            font-size: 12px;
            margin-top: 10px;
            width: 100%;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <img src="https://i.ibb.co/xGzDqM9/logo.png" alt="Logo">
    </div>
    <div class="content">
        <h1>Duyuru</h1>
        <p>Sayın Çalışanlar,</p>
        <p>Aşağıda belirtilen önemli bir duyuru ile ilgili bilgileri paylaşmak istiyoruz:</p>

        <p><strong>Duyuru Başlığı:</strong> $baslik</p>
        <p><strong>Duyuru İçeriği:</strong> $icerik</p>
        <p><strong>Tarih:</strong> $tarih </p>

        <p>Duyurumuz ile ilgili herhangi bir sorunuz veya geri bildiriminiz varsa, lütfen İnsan Kaynakları departmanımızla iletişime geçin.</p>
    </div>

    <div class="footer">
        <p>Göstermiş olduğunuz ilgi için teşekkür ederiz! <span>&#128525;</span></p>
        <p>İletişim için: <a href="mailto:info@327hastanesi.com">info@327hastanesi.com</a></p>
    </div>
    <div class="rights">
        <p>&copy; <?php echo date('Y'); ?> | 327 Özel Hastanesi, Tüm hakları saklıdır.</p>
    </div>
</div>
</body>
</html>

EGE;

$conn = mysqli_connect("localhost","root","","327Hastanesi");
mysqli_set_charset($conn, "utf8mb4");
$mailList = [];
$query = "select mail from sekreterler";
$maillerd = mysqli_query($conn,$query);
while($row = mysqli_fetch_assoc($maillerd)){
    $mailList[] = $row['mail'];
}

foreach ($mailList as $mail ) {
    sendEmail($mail,"Sekreterlere Toplu Duyuru",$html);
}
mysqli_close($conn);
}


function randevuIptalBildir($mail,$ad,$soyad,$sikayet,$hakkinda){
    $date = date('Y');
    $randevuTarihi = date('Y-m-d');
    $html =
    <<<EGE

    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Randevu Bilgisi</title>
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
            width: 40%;
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
        .info {
            text-align: left;
            margin-top: 20px;
            padding: 0 20px;
        }
        .info p {
            margin: 5px 0;
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
            width: 100%;
            text-align: center;
        }
        .hastainfo {
            text-align: center;
            padding: 20px;
            background-color: red;
            color: #ffffff;
            font-size: 14px;
            border-radius: 5px;
        }
        .hastainfo a {
            color: #ffffff;
            text-decoration: none;
        }
        .hastainfo p{
            color: black;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <img src="https://i.ibb.co/xGzDqM9/logo.png" alt="Logo">
    </div>
    <div class="content">
        <h1>Randevu İptal Bilgisi</h1>
        <p>Bu e-posta, 327 Özel Hastanesi'nde bir randevu iptal edildiğini bildirmek amacıyla otomatik olarak gönderilmiştir.</p>
        
        <div class="hastainfo">
            <p><strong>Hasta Adı Soyadı:</strong> $ad $soyad</p>
            <p><strong>Hasta Şikayeti:</strong> $sikayet</p>
            <p><strong>Hasta Hakkında:</strong> $hakkinda</p>
            <p><strong>Randevu Tarihi:</strong> $randevuTarihi</p>
        </div>

        <p>İptal ilgili daha fazla bilgi için İnsan Kaynakları departmanımızla iletişime geçebilirsiniz.</p>
        
        <p>Özel 327 Hastanesi</p>
    </div>

    <div class="footer">
        <p>Bizimle çalıştığınız için teşekkür ederiz! <span>&#128525;</span></p>
        <p>Herhangi bir sorunuz varsa, lütfen iletişime geçin.</p>
        <p>Sosyal medya hesaplarımız <br> <a href="">www.327hastanesi.com</a>.</p>

        <div class="social-links">
            <a href="https://facebook.com"><img src="https://img.icons8.com/color/48/000000/facebook.png" alt="Facebook"></a>
            <a href="https://x.com"><img src="https://img.icons8.com/color/48/000000/twitter.png" alt="Twitter"></a>
            <a href="https://linkedin.com"><img src="https://img.icons8.com/color/48/000000/linkedin.png" alt="LinkedIn"></a>
            <a href="https://instagram.com"><img src="https://img.icons8.com/color/48/000000/instagram-new.png" alt="Instagram"></a>
        </div>
    </div>
    <div class="rights">
        <p>&copy; $date | 327 Özel Hastanesi, Tüm hakları saklıdır.</p>
    </div>
</div>
</body>
</html>


EGE;
sendEmail($mail,"Randevu Iptal Bildirimi !",$html);
}

function randevuSon($mail,$recete_no,$yazilan_ilaclar,$doktor_tanisi){
     $date = date('Y');
     $html = 
     <<<EGE
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Randevu Sonlandırma Bildirimi</title>
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
            width: 40%;
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
        .footer {
            text-align: center;
            padding: 20px;
            background-color: #00bfa5;
            color: #ffffff;
            font-size: 14px;
            border-radius: 5px;
        }
        .rights {
            font-size: 12px;
            margin-top: 10px;
            width: 100%;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <img src="https://i.ibb.co/xGzDqM9/logo.png" alt="Logo">
    </div>
    <div class="content">
        <h1>Randevu Sonlandırma Bildirimi</h1>
        <p>Randevunuz başarıyla sonlandırılmıştır.</p>
        
        <p>Reçete No: <strong>$recete_no</strong></p>
        <p>Yazılan İlaçlar: <strong>$yazilan_ilaclar</strong></p>
        <p>Doktorun Tanısı: <strong>$doktor_tanisi</strong></p>
        
        <p>Sağlığınız için dikkatli olmanızı öneririz. Başka bir sorunuz olursa, lütfen bizimle iletişime geçin.</p>
        
        <p>Özel 327 Hastanesi</p>
    </div>

    <div class="footer">
        <p>Sağlıklı günler dileriz!</p>
        <p>Herhangi bir sorunuz varsa, lütfen iletişime geçin.</p>
    </div>
    <div class="rights">
        <p>&copy; $date | 327 Özel Hastanesi, Tüm hakları saklıdır.</p>
    </div>
</div>
</body>
</html>
EGE;
sendEmail($mail,"Randevu Raporu. Gemiş Olsun !",$html);
}

function randevuGelmedi($mail,$ceza_puani){
    $date = date('Y');
    $html = 
    <<<EGE

    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ceza Puanı Bildirimi</title>
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
            width: 40%;
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
        .footer {
            text-align: center;
            padding: 20px;
            background-color: #00bfa5;
            color: #ffffff;
            font-size: 14px;
            border-radius: 5px;
        }
        .rights {
            font-size: 12px;
            margin-top: 10px;
            width: 100%;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <img src="https://i.ibb.co/xGzDqM9/logo.png" alt="Logo">
    </div>
    <div class="content">
        <h1>Ceza Puanı Bildirimi</h1>
        <p>Üzgünüz, randevunuza gelmediğiniz için ceza puanı aldınız.</p>
        
        <p>Ceza Puanı: <strong>$ceza_puani</strong></p>
        
        <p>Bu tür durumların tekrarlanmaması adına, randevularınıza zamanında gelmenizi öneririz. Aksi takdirde hastanemizde yer bulamayabilirsiniz.</p>
        
        <p>Özel 327 Hastanesi</p>
    </div>

    <div class="footer">
        <p>Sağlıklı günler dileriz!</p>
        <p>Herhangi bir sorunuz varsa, lütfen iletişime geçin.</p>
    </div>
    <div class="rights">
        <p>&copy; $date | 327 Özel Hastanesi, Tüm hakları saklıdır.</p>
    </div>
</div>
</body>
</html>


EGE;
sendEmail($mail,"Randevuya Gelmediniz !",$html);
}

function randevuOzur($mail,$randevu_tarihi){
    $date = date('Y');
    $html = 
    <<<EGE

    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Randevu İptali Bildirimi</title>
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
            width: 40%;
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
        .rights {
            font-size: 12px;
            margin-top: 10px;
            width: 100%;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <img src="https://i.ibb.co/xGzDqM9/logo.png" alt="Logo">
    </div>
    <div class="content">
        <h1>Randevu İptali Bildirimi</h1>
        <p>Sayın Hastamız,</p>
        <p>Randevunuz, beklenmeyen bir durum nedeniyle iptal edilmiştir. Anlayışınız için teşekkür ederiz.</p>
        
        <p>Randevu Tarihi: <strong>$randevu_tarihi</strong></p>
        
        <p>Randevunuzun yeniden planlanması için lütfen bizimle iletişime geçiniz. Size yardımcı olmaktan mutluluk duyarız.</p>
        
        <p>Özel 327 Hastanesi</p>
    </div>

    <div class="footer">
        <p>Yaşadığınız aksaklık için özür dileriz! <span>&#128525;</span></p>
        <p>Herhangi bir sorunuz varsa, lütfen iletişime geçin.</p>
        <p>Sosyal medya hesaplarımız <br> <a href="">www.327hastanesi.com</a>.</p>
    </div>
    <div class="rights">
        <p>&copy; $date | 327 Özel Hastanesi, Tüm hakları saklıdır.</p>
    </div>
</div>
</body>
</html>


EGE;
sendEmail($mail,"Cok Uzgunuz...",$html);
}


?>