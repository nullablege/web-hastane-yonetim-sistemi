<?php
session_start();
if((!isset($_SESSION['login']) || !isset($_SESSION['randevu']))){
    header("Location: login.php");
    exit();
}

require "req.php";
require "mail.php";
$conn = mysqli_connect("localhost", "root", "", "327Hastanesi");
mysqli_set_charset($conn, "utf8mb4");

$randevuid = $_SESSION['randevu'];
$query = "SELECT * FROM randevular WHERE id = '$randevuid';";
$result = mysqli_query($conn, $query);
$randevu = mysqli_fetch_assoc($result);

$hastaTc = $randevu['hastatc'] ?? 'Bilinmiyor';
$randevu_tarihi = $randevu['randevu_tarihi'] ?? 'Bilinmiyor';
$hastaSikayet = $randevu['hasta_sikayet'] ?? 'Belirtilmemiş';
$doktorTanisi = $randevu['doktor_tanisi'] ?? 'Tanı Yok';
$ilaclar = $randevu['yazilan_ilaclar'] ?? 'Yazılmamış';
$receteNo = $randevu['recete_no'] ?? 'Yok';

$query = "SELECT * FROM hastalar WHERE tc = '$hastaTc';";
$result = mysqli_query($conn, $query);
$hasta = mysqli_fetch_assoc($result);

$hastaAdSoyad = isset($hasta['ad'], $hasta['soyad']) ? $hasta['ad'] . " " . $hasta['soyad'] : 'Bilinmiyor';
$hastaMail = $hasta['mail'] ?? 'Belirtilmemiş';
$dogumTarihi = $hasta['dogum'] ?? null;
$hastayas = 'Bilinmiyor';

if ($dogumTarihi) {
    $dogumTarihiObj = new DateTime($dogumTarihi);
    $bugun = new DateTime();
    $hastayas = $bugun->diff($dogumTarihiObj)->y;
}

$cinsiyet = $hasta['cinsiyet'] ?? 'Bilinmiyor';
$hakkinda = $hasta['hasta_hakkinda'] ?? 'Belirtilmemiş';

if (isset($_POST['geri']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    unset($_SESSION['randevu']);
    $redirectPage = isset($_SESSION['doktor']) ? "doktorunRandevulari.php" : "sekreter.php";
    header("Location: $redirectPage");
    exit();
}

if (isset($_POST['randevuyuduzenle']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    header("Location: randevuDuzenle.php");
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
            <img src="https://i.ibb.co/xGzDqM9/logo.png" alt="Logo" width="100" height="40" class="d-inline-block align-text-top">
        </a>
       <?php if(isset($_SESSION['doktor'])): ?>
        <a href="sekreter.php" class="float-start"><button class="btn btn-warning">Geri Dön</button></a>
        <?php else:?>
            <a href="doktorunRandevulari.php" class="float-start"><button class="btn btn-warning">Geri Dön</button></a>
            <?php endif;?>
    </div>
</nav>

<div class="container mt-5">
    <h2 class="text-center">Tamamlanmış Randevu Detayları</h2>
    <div class="card mt-4">
        <div class="card-body">
            <h4>Hasta Bilgileri</h4>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label font-weight-bold">Ad Soyad:</label>
                <div class="col-sm-9">
                    <p class="form-control-plaintext"><?php echo htmlspecialchars(trim($hastaAdSoyad)); ?></p>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label font-weight-bold">Yaş:</label>
                <div class="col-sm-9">
                    <p class="form-control-plaintext"><?php echo htmlspecialchars(trim($hastayas)); ?></p>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label font-weight-bold">Cinsiyet:</label>
                <div class="col-sm-9">
                    <p class="form-control-plaintext"><?php echo htmlspecialchars(trim($cinsiyet)); ?></p>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label font-weight-bold">Şikayet:</label>
                <div class="col-sm-9">
                    <p class="form-control-plaintext"><?php echo htmlspecialchars(trim($hastaSikayet)); ?></p>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label font-weight-bold">Hasta Hakkında:</label>
                <div class="col-sm-9">
                    <p class="form-control-plaintext"><?php echo htmlspecialchars(trim($hakkinda)); ?></p>
                </div>
            </div>

            <h4 class="mt-4">Doktor İşlemleri</h4>
            <form>
                <div class="form-group">
                    <label for="doktorTanisi" class="font-weight-bold">Doktor Tanısı:</label>
                    <input type="text" class="form-control" id="doktorTanisi" name="doktorTanisi" value="<?php echo htmlspecialchars(trim($doktorTanisi)); ?>" disabled>
                </div>

                <div class="form-group">
                    <label for="ilaclar" class="font-weight-bold">Yazılan İlaçlar:</label>
                    <input type="text" class="form-control" id="ilaclar" name="ilaclar" value="<?php echo htmlspecialchars(trim($ilaclar)); ?>" disabled>
                </div>

                <div class="form-group">
                    <label for="receteNo" class="font-weight-bold">Reçete No:</label>
                    <input type="text" class="form-control" id="receteNo" name="receteNo" value="<?php echo htmlspecialchars(trim($receteNo)); ?>" disabled>
                </div>
            </form>
            <?php if (!isset($_SESSION['sekreter'])): ?>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                <input type="hidden" name="randevuId" value="<?php echo htmlspecialchars(trim($_SESSION['randevu'])); ?>">
                <button type="submit" name="randevuyuduzenle" class="btn btn-primary mt-3">Randevuyu Düzenle</button>
            </form>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>
</html>
<?php mysqli_close($conn); ?>
