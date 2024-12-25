<?php
session_start();
if (!isset($_SESSION['login']) || !isset($_SESSION['doktor']) || !isset($_SESSION['randevu'])) {
    header("Location: login.php");
    exit();
}

require "req.php";
$conn = mysqli_connect("localhost", "root", "", "327Hastanesi");
mysqli_set_charset($conn, "utf8mb4");

$randevuId = $_SESSION['randevu'];

$query = "SELECT * FROM randevular WHERE id = '$randevuId';";
$result = mysqli_query($conn, $query);
$randevuData = mysqli_fetch_assoc($result);

$hastaTc = $randevuData['hastatc'];
$queryHasta = "SELECT * FROM hastalar WHERE tc = '$hastaTc';";
$resultHasta = mysqli_query($conn, $queryHasta);
$hastaData = mysqli_fetch_assoc($resultHasta);

$hastaAdSoyad = $hastaData['ad'] . " " . $hastaData['soyad'];
$dogumTarihi = new DateTime($hastaData['dogum']);
$bugun = new DateTime();
$hastayas = $bugun->diff($dogumTarihi)->y;
$cinsiyet = $hastaData['cinsiyet'];
$hastaSikayet = $randevuData['hasta_sikayet'];
$hakkinda = $hastaData['hasta_hakkinda'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $doktorTanisi = htmlspecialchars(trim($_POST['doktorTanisi']));
    $ilaclar = htmlspecialchars(trim($_POST['ilaclar']));
    $receteNo = htmlspecialchars(trim($_POST['receteNo']));

    $updateQuery = "UPDATE randevular SET doktor_tanisi='$doktorTanisi', yazilan_ilaclar='$ilaclar', recete_no='$receteNo' WHERE id='$randevuId';";
    if (mysqli_query($conn, $updateQuery)) {
        echo "<div class='alert alert-success'>Randevu başarıyla güncellendi!</div>";
        unset($_SESSION['randevu']);
        header("Location: doktor.php");
        exit();
    } else {
        echo "<div class='alert alert-danger'>Güncelleme sırasında bir hata oluştu.</div>";
    }
}

?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Özel 327 Hastanesi</title>
    <link rel="icon" href="logo.png" type="image/x-icon">

</head>
<body>

<div class="container mt-5">
    <h2 class="text-center">Randevu Düzenleme</h2>
    <form method="POST">
        <h4>Hasta Bilgileri</h4>
        <p>Ad Soyad: <?php echo htmlspecialchars(trim(stripslashes($hastaAdSoyad))); ?></p>
        <p>Yaş: <?php echo htmlspecialchars(trim(stripslashes($hastayas))); ?></p>
        <p>Cinsiyet: <?php echo htmlspecialchars(trim(stripslashes($cinsiyet))); ?></p>
        <p>Şikayet: <?php echo htmlspecialchars(trim(stripslashes($hastaSikayet))); ?></p>

        <h4 class="mt-4">Doktor İşlemleri</h4>
        <div class="form-group">
            <label for="doktorTanisi">Doktor Tanısı:</label>
            <input type="text" class="form-control" id="doktorTanisi" name="doktorTanisi" value="<?php echohtmlspecialchars(trim(stripslashes( $randevuData['doktor_tanisi']))); ?>">
        </div>
        <div class="form-group">
            <label for="ilaclar">Yazılan İlaçlar:</label>
            <input type="text" class="form-control" id="ilaclar" name="ilaclar" value="<?php echo htmlspecialchars(trim(stripslashes($randevuData['yazilan_ilaclar']))); ?>">
        </div>
        <div class="form-group">
            <label for="receteNo">Reçete No:</label>
            <input type="text" class="form-control" id="receteNo" name="receteNo" value="<?php echo htmlspecialchars(trim(stripslashes($randevuData['recete_no']))); ?>">
        </div>
        
        <button type="submit" name="update" class="btn btn-primary mt-3">Güncelle</button>
    </form>
</div>

</body>
</html>
<?php mysqli_close($conn); ?>