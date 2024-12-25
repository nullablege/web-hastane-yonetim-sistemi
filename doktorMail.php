<?php
session_start();

if(!(isset($_SESSION['login']) && isset($_SESSION['doktor']))){
    header("Location:login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Özel 327 Hastanesi</title>
    <link rel="icon" href="logo.png" type="image/x-icon">

</head>
<body>

<nav class="navbar bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="logout.php">
                <img src="https://i.ibb.co/xGzDqM9/logo.png" alt="Logo" width="100" height="40"
                    class="d-inline-block align-text-top">
            </a>
            <a href="doktor.php" class="float-start"><button class="btn btn-warning">Geri Dön</button></a>
        </div>
    </nav>

    
<?php

// $_SESSION['login'] = "23456789012"; //Deneme sekreter tc
$conn = mysqli_connect("localhost","root","","327Hastanesi");
mysqli_set_charset($conn, "utf8mb4");
require "req.php";
require "mail.php";
$doktorTc = $_SESSION['login'];
$q = "select * from doktorlar where tc='$doktorTc';";
$r = mysqli_query($conn,$q);
$r = mysqli_fetch_assoc($r);
$doktorMail = $r['mail'];
?>

<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Başlık</th>
      <th scope="col">Tarih</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $q = "select * from mail where email='$doktorMail';";
    $r = mysqli_query($conn,$q);
    ?>
    <?php while($row = mysqli_fetch_assoc($r)):?>
    <tr>
      <th scope="row"><?php echo htmlspecialchars(trim(stripslashes($row['id'])))?></th>
      <td><?php echo htmlspecialchars(trim(stripslashes($row['subject'])))?></td>
      <td><?php echo htmlspecialchars(trim(stripslashes($row['tarih'])))?></td>
    </tr>
    <?php endwhile; ?>
  </tbody>
</table>

<?php
if(isset($_POST['mailgonder']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
    $subject = htmlspecialchars(trim(stripslashes($_POST['subject'])));
    $recipient = htmlspecialchars(trim(stripslashes($_POST['recipient'])));
    $message_content = htmlspecialchars(trim(stripslashes($_POST['message_content'])));
    $sender = $doktorMail;
    if(mailGonder($recipient,$subject,$sender,$recipient,$message_content)){
        header("Location:doktor.php");
        exit();
        
    }
}

?>


<div class="container mt-5">
        <h2 class="text-center mb-4">Mail Gönder</h2>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <div class="mb-3">
                <label for="mail" class="form-label">Mail</label>
                <input type="email" class="form-control" value="327hastanesibilgisistemi@gmail.com" disabled id="mail" name="mail" required>
            </div>
            <div class="mb-3">
                <label for="subject" class="form-label">Konu</label>
                <input type="text" class="form-control" id="subject" name="subject" required>
            </div>
            <div class="mb-3">
                <label for="sender" class="form-label" >Gönderen</label>
                <input type="text" class="form-control" disabled value="<?php echo htmlspecialchars(trim(stripslashes($doktorMail))); ?>"  id="sender" name="sender" required>
            </div>
            <div class="mb-3">
                <label for="recipient" class="form-label">Alıcı</label>
                <input type="email" class="form-control" id="recipient" name="recipient" required>
            </div>
            <div class="mb-3">
                <label for="message_content" class="form-label">Mesaj İçeriği</label>
                <textarea class="form-control" id="message_content" name="message_content" rows="5" required></textarea>
            </div>
            <button type="submit" name="mailgonder" class="btn btn-primary">Gönder</button>
        </form>
    </div>

</body>
</html>