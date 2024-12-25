

<?php

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

define('MAILHOST',"mail.egeaytac.com");
define('USERNAME',"ege@egeaytac.com");
define('PASSWORD',"Muhendis13!");
define('SEND_FROM',"info@hastane327.com");
define('SEND_FROM_NAME','327Hastanesi');
define('REPLY_TO',"ege@egeaytac.com");
define('REPLY_TO_NAME','Ege');


function sendEmail($email, $subject, $message) {
    $mail = new PHPMailer(true);

    try {
        // SMTP Ayarları
        $mail->isSMTP();
        $mail->Host = MAILHOST; // SMTP sunucunuz (örneğin: mail.example.com)
        $mail->SMTPAuth = true;
        $mail->Username = USERNAME; // SMTP kullanıcı adı
        $mail->Password = PASSWOS; // SMTP şifresi
        $mail->SMTPSecure = ''; // SSL veya TLS kullanılmıyor
        $mail->Port = 25; // SSL'siz genelde 25 portu kullanılır

        // Sertifika Doğrulama Hatalarını Kapat
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer'       => false,
                'verify_peer_name'  => false,
                'allow_self_signed' => true,
            ),
        );

        // Gönderici ve Alıcı
        $mail->setFrom('your-email@example.com', 'Ege AYTAÇ');
        $mail->addAddress($email);
        $mail->addReplyTo('reply-to@example.com', 'Support');

        // İçerik
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;
        $mail->AltBody = strip_tags($message);

        $mail->send();
        echo "Mesaj başarıyla gönderildi!";
    } catch (Exception $e) {
        echo "Mesaj gönderilemedi. Hata: {$mail->ErrorInfo}";
    }
}

if(sendEmail("egenull0@gmail.com","Subject","Mesaj")){
    echo "oldu";
}
else{
    echo "olmadi";
}

?>