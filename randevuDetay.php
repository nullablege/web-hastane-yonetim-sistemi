<?php
session_start();
if((!isset($_SESSION['login']) || !isset($_SESSION['doktor'])) || !isset($_SESSION['randevu']) ){
     header("Location: login.php");
     exit();
}
require "req.php";
require "mail.php";
$conn = mysqli_connect("localhost","root","","327Hastanesi");
mysqli_set_charset($conn, "utf8mb4");

$randevuid = $_SESSION['randevu'];
$query = "update randevular set randevu_durumu ='1' where id='$randevuid';";
$result = mysqli_query($conn,$query);

$query = "SELECT * FROM randevular WHERE id = '$randevuid';";
$result = mysqli_query($conn, $query);
$result = mysqli_fetch_assoc($result);
$hastaTc = $result['hastatc'];
$randevu_tarihi = $result['randevu_tarihi'];

$hastaSikayet = $result['hasta_sikayet'];
$query = "SELECT * FROM hastalar WHERE tc = '$hastaTc';";
$result = mysqli_query($conn, $query);
$result = mysqli_fetch_assoc($result);
$hastaAdSoyad = $result['ad'] . " " . $result['soyad'];
$hastaMail = $result['mail'];
$dogumTarihi = $result['dogum'];
$dogumTarihiObj = new DateTime($dogumTarihi); 
$bugun = new DateTime();
$hastayas = $bugun->diff($dogumTarihiObj)->y; 
$cinsiyet = $result['cinsiyet'];
$hakkinda = $result['hasta_hakkinda'];

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['sonlandir'])){
    $doktor_tanisi = htmlspecialchars(trim(stripslashes($_POST['doktorTanisi'])));
    $ilaclar = htmlspecialchars(trim(stripslashes($_POST['ilaclar'])));
    $receteNo = htmlspecialchars(trim(stripslashes($_POST['receteNo'])));
    
    $query = "update randevular set randevu_durumu ='2',yazilan_ilaclar ='$ilaclar',recete_no='$receteNo',doktor_tanisi='$doktor_tanisi' where id='$randevuid';";
    $result = mysqli_query($conn,$query);
    if($result){
        randevuSon($hastaMail,$receteNo,$ilaclar,$doktor_tanisi);
        unset($_SESSION['randevu']);
        header("Location: doktor.php");
        exit();
    }
    else{
        echo '<div class="alert alert-danger mt-0 text-center">Hata oluştu. Teknik destekle iletişime geçin.</div>';
    }
    }
    
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['gelmedi'])){
        $query = "update randevular set randevu_durumu ='2',ceza='1' where id='$randevuid';";
        $result = mysqli_query($conn,$query);
        if($result){
            $query = "select count(*) from randevular where hastatc ='$hastaTc' and ceza ='1';";
            $result = mysqli_query($conn,$query);
            $result = mysqli_fetch_row($result);
            $ceza_puani = $result['0'];
            randevuGelmedi($hastaMail,$ceza_puani);  
            unset($_SESSION['randevu']);
            header("Location: doktor.php");
            exit();
        }
        else{
            echo '<div class="alert alert-danger mt-0 text-center">Hata oluştu. Teknik destekle iletişime geçin.</div>';
        }
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['randevuiptal'])){
        $query = "update randevular set kapali ='1', doktor_tanisi='randevu doktor tarafindan iptal edildi' where id='$randevuid';";
        $result = mysqli_query($conn,$query);
        if($result){
            randevuOzur($hastaMail,$randevu_tarihi);
            header("Location: doktor.php");
            exit();
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
    
<div class="container mt-5">
    <h2 class="text-center">Randevu Detayları</h2>
    <div class="card mt-4">
        <div class="card-body">
            <!-- Hasta Bilgileri -->
            <h4>Hasta Bilgileri</h4>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label font-weight-bold">Ad Soyad:</label>
                <div class="col-sm-9">
                    <p class="form-control-plaintext"><?php echo htmlspecialchars(trim(stripslashes($hastaAdSoyad))); ?></p>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label font-weight-bold">Yaş:</label>
                <div class="col-sm-9">
                    <p class="form-control-plaintext"><?php echo htmlspecialchars(trim(stripslashes($hastayas))); ?></p>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label font-weight-bold">Cinsiyet:</label>
                <div class="col-sm-9">
                    <p class="form-control-plaintext"><?php echo htmlspecialchars(trim(stripslashes($cinsiyet))); ?></p>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label font-weight-bold">Şikayet:</label>
                <div class="col-sm-9">
                    <p class="form-control-plaintext"><?php echo htmlspecialchars(trim(stripslashes($hastaSikayet))); ?></p>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label font-weight-bold">Hasta Hakkında:</label>
                <div class="col-sm-9">
                    <p class="form-control-plaintext"><?php echo htmlspecialchars(trim(stripslashes($hakkinda))); ?></p>
                </div>
            </div>
            <!-- Doktor İşlemleri -->
            <h4 class="mt-4">Doktor İşlemleri</h4>
            <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
                <!-- Hasta Randevuya Gelmedi Button -->
                <button type="submit" name="gelmedi" class="btn btn-warning mb-3">Hasta Randevuya Gelmedi</button>
                <button type="submit" name="randevuiptal" class="btn btn-danger mb-3">Randevuyu Hastane Taraflı İptal Et</button>
                <!-- Doktor Tanısı -->
                <div class="form-group">
                    <label for="doktorTanisi" class="font-weight-bold">Doktor Tanısı:</label>
                    <input type="text" class="form-control" id="doktorTanisi" name="doktorTanisi" placeholder="Tanı giriniz">
                </div>

                <div class="form-group">
                    <label for="ilaclar" class="font-weight-bold">Yazılan İlaçlar:</label>
                    <input type="text" class="form-control" id="ilaclar" name="ilaclar" placeholder="İlaç adını giriniz">
                </div>

                <!-- Reçete No ve Reçete Oluştur -->
                <div class="form-group">
                    <label for="receteNo" class="font-weight-bold">Reçete No:</label>
                    <div class="input-group">
                        <input type="text" class="form-control" disabled id="receteNo" name="receteNo" placeholder="Reçete numarası">
                    </div>
                </div>

                <!-- Randevuyu Sonlandır Button -->
                <button type="submit" name="sonlandir" class="btn btn-danger mt-1">Randevuyu Sonlandır</button>
            </form>

            <script>
                function receteNo() {
                    const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
                    let sonuc = '';
                    for (let i = 0; i < 5; i++) {
                        const rastgele = Math.floor(Math.random() * characters.length);
                        sonuc += characters.charAt(rastgele);
                    }
                    return sonuc;
                }
                document.getElementById('ilaclar').addEventListener('change', () => {
                    const ilaclarInput = document.getElementById('ilaclar');
                    const receteNoInput = document.getElementById('receteNo');
                    
                    if (ilaclarInput.value !== '') {
                        receteNoInput.value = receteNo();
                    } else {
                         receteNoInput.value = '';
                    }
                });
            </script>




</body>
</html>
<?php mysqli_close($conn); ?>