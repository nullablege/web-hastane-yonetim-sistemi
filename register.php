
<?php
                session_start();
                if(isset($_SESSION['login'])){
                    header("location:index.php");
                }
                $ad = "";
                $soyad = "";
                $email = "";
                $telno = "";
                $dt = "";
                require "db.php";
                require "mail.php";
                if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['kayit'])) {
                    $ad = htmlspecialchars(stripslashes(trim($_POST['ad'])));
                    $soyad = htmlspecialchars(stripslashes(trim($_POST['soyad'])));
                    $email = htmlspecialchars(stripslashes(trim($_POST['email'])));
                    $telno = htmlspecialchars(stripslashes(trim($_POST['telno'])));
                    $dt = htmlspecialchars(stripslashes(trim($_POST['dt'])));
                    $sifre = htmlspecialchars(stripslashes(trim($_POST['sifre'])));
                    $sifreOnay = htmlspecialchars(stripslashes(trim($_POST['sifreOnay'])));
                
                    // Şifre kontrolü
                    if ($sifre != $sifreOnay) {
                        echo "<div class='alert alert-danger text-center mt-0'>Şifreler uyuşmuyor!</div>";
                    } elseif (strlen($sifre) < 8) {
                        echo "<div class='alert alert-danger text-center mt-0'>Şifre en az 8 karakter olmalıdır!</div>";
                    } else {
                        // E-posta kontrolü
                        $query = "SELECT * FROM kullanicilar WHERE eposta = '$email';";
                        $result = mysqli_query($conn, $query);
                        
                        if (mysqli_num_rows($result) > 0) {
                            echo "<div class='alert alert-danger text-center mt-0'>Kullanıcı Zaten Mevcut</div>";
                        } else {
                            // E-posta doğrulama
                            if ((strpos($email, "@hotmail.com") || strpos($email, "@gmail.com")) || 
                                (strpos($email, "@outlook.com") || strpos($email, "@yandex.com")) || 
                                strpos($email, "@icloud.com")) {
                                
                                if (strlen($ad) > 2 && strlen($soyad) > 2) {
                                    // Tarihi DateTime nesnesine dönüştür
                                    $tarih = new DateTime($dt);
                                    
                                    // Yaş hesaplama: Geçerli yıl ile doğum yılı farkını al
                                    if (date('Y') - $tarih->format('Y') > 16) {
                                        // Kayıt işlemine başla
                                        $_SESSION['register'] = $email;
                                        $_SESSION['kullanici'] = [$ad, $soyad, $email, $telno, $dt, $sifre];
                                        $_SESSION['start_time'] = time();
                                        
                                        // Doğrulama kodu üret ve gönder
                                        $dogrulama = random_int(100000, 999999);
                                        $_SESSION['dogrulama'] = $dogrulama;
                                        dogrulamaYolla($email, $dogrulama);
                                        
                                        // Bir sonraki sayfaya yönlendir
                                        header("Location: register2.php");
                                        exit; // header sonrası script çalıştırmayı durdurmak için
                                    } else {
                                        echo "<div class='alert alert-danger text-center mt-0'>Sisteme 16 Yaşından Küçük Kullanıcılar Kayıt Olamaz</div>";
                                    }
                                } else {
                                    echo "<div class='alert alert-danger text-center mt-0'>Ad ve Soyadı Düzeltin</div>";
                                }
                            } else {
                                echo "<div class='alert alert-danger text-center mt-0'>Geçersiz e-posta adresi!</div>";
                            }
                        }
                    }
                }
                
                

            ?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kayıt Ol</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #ff4e50;
        }
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .register-container {
            max-width: 500px;
            margin: 40px auto;
            padding: 20px;
        }
        .register-logo {
            width: 120px;
            margin-bottom: 30px;
        }
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        .btn-primary:hover {
            background-color: #ff3e40;
            border-color: #ff3e40;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="register-container">
            <div class="text-center">
                <img src="img/satiyoruk.png" alt="Logo" class="register-logo">
            </div>
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-center mb-4">Kayıt Ol</h4>
                    <form id="registerForm" action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
                        <div class="mb-3">
                            <label for="firstName" class="form-label">Ad</label>
                            <input type="text" value="<?php echo $ad; ?>" class="form-control" id="firstName" name="ad" required>
                        </div>
                        <div class="mb-3">
                            <label for="lastName" class="form-label">Soyad</label>
                            <input type="text" value="<?php echo $soyad; ?>" class="form-control" id="lastName" name="soyad" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">E-posta</label>
                            <input type="email" value="<?php echo $email; ?>" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="sifre" class="form-label">Şifre</label>
                            <input type="password" value="" class="form-control" id="sifre" name="sifre" required>
                        </div>
                        <div class="mb-3">
                            <label for="sifreOnay" class="form-label">Şifre Onayla</label>
                            <input type="password" value="" class="form-control" id="sifreOnay" name="sifreOnay" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Telefon Numarası</label>
                            <input type="tel" value="<?php echo $telno; ?>" class="form-control" id="phone" name="telno" required>
                        </div>
                        <div class="mb-3">
                            <label for="birthDate" class="form-label">Doğum Tarihi</label>
                            <input type="date" value="<?php echo $dt; ?>" class="form-control" name="dt" id="birthDate" required>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="terms" required>
                            <label class="form-check-label" for="terms">Kullanım şartlarını kabul ediyorum</label>
                        </div>
                        <button type="submit" name="kayit" class="btn btn-primary w-100">Kayıt Ol</button>
                    </form>
                </div>
            </div>
            
            <div class="text-center mt-3">
                Zaten hesabınız var mı? <a href="/login.html" class="text-decoration-none">Giriş yap</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php mysqli_close($conn); ?>