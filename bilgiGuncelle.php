<?php
session_start();
if(!isset($_SESSION['login']) || !(isset($_SESSION['doktor']) || isset($_SESSION['sekreter']))){
    header("Location: login.php");
}
$conn = mysqli_connect("localhost","root","","327Hastanesi");
if(isset($_SESSION['doktor'])){
    $tablo = "doktorlar";
}
if(isset($_SESSION['sekreter'])){
    $tablo = "sekreterler";
}
$kimlikno = $_SESSION['login'];
$query = "select * from $tablo where tc='$kimlikno';";
$result = mysqli_query($conn,$query);
$result = mysqli_fetch_assoc($result);

require "req.php";


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['sifreGuncelle'])) {
    $eskiSifre = htmlspecialchars(stripslashes(trim($_POST['oldPassword'])));
    $yeniSifre = htmlspecialchars(trim(stripslashes($_POST['newPassword'])));
    $yeniSifreDogrula = trim(stripslashes(htmlspecialchars($_POST['confirmPassword'])));

    $veritabaniEskiSifreHash = $result['sifre'];
    $kullaniciId = $result['id'];

    if (password_verify($eskiSifre, $veritabaniEskiSifreHash)) {
        
        if ($yeniSifre === $yeniSifreDogrula) {
            
            $buyukHarfVarMi = preg_match('/[A-Z]/', $yeniSifre);
            $kucukHarfVarMi = preg_match('/[a-z]/', $yeniSifre);
            $sayiVarMi = preg_match('/[0-9]/', $yeniSifre);
            $gecerliUzunluk = strlen($yeniSifre) >= 8;

            if ($buyukHarfVarMi && $kucukHarfVarMi && $sayiVarMi && $gecerliUzunluk) {

                $yeniSifreHash = password_hash($yeniSifre, PASSWORD_DEFAULT);

                $sql = "UPDATE $tablo SET sifre = '$yeniSifreHash' WHERE id = $kullaniciId";

                if (mysqli_query($conn, $sql)) {
                    echo '<div class="alert alert-success text-center mt-0">Şifreniz başarıyla güncellendi.</div>';
                } else {
                    echo '<div class="alert alert-success text-center mt-0">Şifre güncellenirken bir hata oluştu: .'.mysqli_error($baglanti).'</div>';
                }
            } else {
                echo '<div class="alert alert-danger mt-0 text-center">Yeni şifre en az bir büyük harf, bir küçük harf, bir sayı içermeli ve en az 8 karakter uzunluğunda olmalıdır.</div>';
            }

        } else {
            echo '<div class="alert alert-danger mt-0 text-center">Yeni şifreler eşleşmiyor</div>';
        }

    } else {
        echo '<div class="alert alert-danger mt-0 text-center">Eski şifre yanlış</div>';
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['bilgiGuncelle'])) {
    $tc = trim(htmlspecialchars(stripslashes($_POST['tc'])));
    $ad = trim(htmlspecialchars(stripslashes($_POST['firstName'])));
    $soyad = trim(htmlspecialchars(stripslashes($_POST['lastName'])));
    $adres = trim(htmlspecialchars(stripslashes($_POST['address'])));
    $telefon = trim(htmlspecialchars(stripslashes($_POST['phone'])));
    $email = trim(htmlspecialchars(stripslashes($_POST['email'])));

    if (!preg_match('/^[0-9]{11}$/', $tc)) {
       echo "<div class='alert alert-danger text-center mt-0'>TC Kimlik Numarası 11 haneli olmalıdır.</div>";
    }
    elseif (!preg_match('/^05[0-9]{9}$/', $telefon)) {
        echo "<div class='alert alert-danger text-center mt-0'>Telefon numarası geçerli bir formatta değil.</div>";
    }
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
       echo  "<div class='alert alert-danger text-center mt-0'>Geçerli bir e-posta adresi giriniz.</div>";
    }
    else{

    
    $sql = "UPDATE $tablo SET 
                tc = '$tc', 
                ad = '$ad', 
                soyad = '$soyad', 
                adres = '$adres', 
                telno = '$telefon', 
                mail = '$email' 
            WHERE id = {$result['id']}";

    if (mysqli_query($conn, $sql)) {
        echo "<div class='alert alert-success text-center mt-0'>Bilgiler başarıyla güncellendi.</div>";
    } 
    else {
        echo '<div class="alert alert-success text-center mt-0">Şifre güncellenirken bir hata oluştu: .'.mysqli_error($baglanti).'</div>';
    }
}
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
            <?php if($tablo == 'doktorlar'): ?>
            <a href="doktor.php" class="float-start"><button class="btn btn-warning">Geri Dön</button></a>
            <?php else: ?>
            <a href="sekreter.php" class="float-start"><button class="btn btn-warning">Geri Dön</button></a>
            <?php endif; ?>
        </div>
    </nav>
    

<div class="container mt-5">
        <h2 class="mb-4">Kullanıcı Bilgileri</h2>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <div class="mb-3">
                <label for="tc" class="form-label">TC Kimlik Numarası</label>
                <input type="text" class="form-control" value="<?php echo htmlspecialchars(trim(stripslashes($result['tc']))); ?>" name="tc" placeholder="12345678901" maxlength="11" required>
                </div>
            
            <div class="mb-3">
                <label for="firstName" class="form-label">Ad</label>
                <input type="text" class="form-control" name="firstName" value="<?php echo htmlspecialchars(trim(stripslashes( $result['ad']))); ?>" placeholder="Adınız" required>
            </div>

             <div class="mb-3">
                <label for="lastName" class="form-label">Soyad</label>
                <input type="text" class="form-control" name="lastName" value="<?php echo htmlspecialchars(trim(stripslashes( $result['soyad']))); ?>" placeholder="Soyadınız" required>
            </div>

            <div class="mb-3">
                <label for="address" class="form-label">Adres</label>
                <textarea class="form-control" name="address" rows="3"  placeholder="Adresiniz" required><?php echo htmlspecialchars(trim(stripslashes( $result['adres']))); ?> </textarea>
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label">Telefon Numarası</label>
                <input type="tel" class="form-control" name="phone" value="<?php echo htmlspecialchars(trim(stripslashes( $result['telno']))); ?>"" placeholder="05XX XXX XX XX" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">E-posta</label>
                <input type="email" class="form-control" value="<?php echo htmlspecialchars(trim(stripslashes( $result['mail']))); ?>"" name="email" placeholder="ornek@mail.com" required>
            </div>
            <button type="submit" name="bilgiGuncelle" class="btn btn-primary mt-3">Bilgileri Güncelle</button>
        </form>

        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <h2 class="mt-5 mb-4">Şifre Güncelleme</h2>

            <div class="mb-3">
                <label for="oldPassword" class="form-label">Eski Şifre</label>
                <input type="password" class="form-control" name="oldPassword" placeholder="Eski şifrenizi giriniz" required>
            </div>

            <div class="mb-3">
                <label for="newPassword" class="form-label">Yeni Şifre</label>
                <input type="password" class="form-control" name="newPassword" placeholder="Yeni şifrenizi giriniz" required>
            </div>

            <div class="mb-3">
                <label for="confirmPassword" class="form-label">Yeni Şifre (Tekrar)</label>
                <input type="password" class="form-control" name="confirmPassword" placeholder="Yeni şifrenizi tekrar giriniz" required>
            </div>
            <button type="submit" name="sifreGuncelle" class="btn btn-primary mt-3">Bilgileri Güncelle</button>
            </form>

    </div>


</body>
</html>

<?php mysqli_close($conn); ?>