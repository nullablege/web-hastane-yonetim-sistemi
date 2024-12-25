<?php
session_start();
if(!isset($_SESSION['register'])){
   // header("location:login.php");
}
if(isset($_COOKIE['basariliyenikod'])){
    echo "<div class='alert alert-success text-center mt-0'>Yeni kod başarıyla talep edilmiştir.</div>";
}
if(isset($_COOKIE['basarisizyenikod'])){
    echo "<div class='alert alert-success text-center mt-0'>Kod talebi başarısız.</div>";
}

require "db.php";
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['dogrulabtn'])){

     if((time() - $_SESSION['start_time']) > 180){
        echo "<div class='alert alert-danger text-center mt-0'>Kodunuzun Süresi Doldu. Lütfen yeni bir tane talep ediniz.</div>";
     }
     else{
        $dogrulama = htmlspecialchars(stripslashes(trim($_POST['dogrulama'])));
        if($dogrulama == $_SESSION['dogrulama']){
            $kullanici = $_SESSION['kullanici'];
            $ad = $kullanici[0];
            $soyad = $kullanici[1];
            $email = $kullanici[2];
            $telno = $kullanici[3];
            $dt = $kullanici[4];
            $sifre = $kullanici[5];
            $hashed = password_hash($sifre,PASSWORD_DEFAULT);
            $query = "insert into kullanicilar(eposta,sifre,ad,soyad,dogum_tarihi,telno) values('$email','$hashed','$ad','$soyad','$dt','$telno');";
            $result = mysqli_query($conn,$query);
            if($result){
                setcookie("yenikayit",$ad." ".$soyad,time()+10);
                session_destroy();
                header("location:login.php");
            }
            else{
                setcookie("basarisizkayit",$ad." ".$soyad,time()+10);
                session_destroy();
                header("location:login.php");
            }

        }
     }
}





?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kod Giriş Sayfası</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color: #f4f4f4;">
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow-lg" style="max-width: 400px; width: 100%; border-radius: 10px;">
            <div class="card-body text-center p-4">
                <img src="../img/satiyoruk.png" alt="Logo" style="width: 100px; margin-bottom: 20px;">
                <h2 class="mb-4" style="color: #333;">Doğrulama Kodu Girin</h2>
                <p class="text-muted mb-4" style="font-size: 14px;">E-posta adresinize gönderilen doğrulama kodunu girerek hesabınızı doğrulayabilirsiniz.</p>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                    <div class="mb-3">
                        <input type="text" class="form-control form-control-lg text-center" name="dogrulama" maxlength="6" placeholder="123456" style="font-size: 24px; font-weight: bold; letter-spacing: 5px;" required>
                    </div>
                    <button type="submit" name="dogrulabtn" class="btn btn-danger btn-lg w-100">Doğrula</button>
                </form>
                <p class="text-muted mt-3" style="font-size: 12px;">Kodun süresi dolduysa, <a href="yenikod.php">yeni bir kod</a> talep edin.</p>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php mysqli_close($conn); ?>