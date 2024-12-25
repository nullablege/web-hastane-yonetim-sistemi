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
define('SEND_FROM',"ege1@egeaytac.com");
define('SEND_FROM_NAME','Ege');
define('REPLY_TO',"ege2@egeaytac.com");
define('REPLY_TO_NAME','Ege');

function sendEmail($email,$subject,$message){
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->Host = MAILHOST;
    $mail->Username = USERNAME;
    $mail->Password = PASSWORD;
    $mail->SMTPSecure = ''; // SSL veya TLS devre dışı bırakıldı
    $mail->Port = 25; // SSL olmadan genelde 25 portu kullanılır
    $mail->setFrom(SEND_FROM, SEND_FROM_NAME);
    $mail->SMTPOptions = [
        'ssl' => [
            'verify_peer'       => false,
            'verify_peer_name'  => false,
            'allow_self_signed' => true,
        ],
    ];
    $mail->addAddress($email);
    $mail->addReplyTo(REPLY_TO, REPLY_TO_NAME);
    $mail->IsHTML(true);
    $mail->Subject = $subject;
    $mail->Body = $message;
    $mail->AltBody = $message;
    if(!$mail->send())
        return 0;
    else {
        return 1;
    }
}

if(sendEmail("egenull0@gmail.com","Subject","mesaj")){
    echo "sa";
}
else{
    echo "as";
}


?>