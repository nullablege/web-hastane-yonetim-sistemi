<?php
require "req.php";
require "mail.php";
$conn = mysqli_connect("localhost","root","","327Hastanesi");
mysqli_set_charset($conn, "utf8mb4");
session_start();
if(!(isset($_SESSION['randevu']) && $_SESSION['brans']) && !isset($_SESSION['doktor'])) {
    header("Location: sekreter.php");
}
$doktortc = $_SESSION['doktor'];
$hastatc = $_SESSION['randevu'];

// Hastanın bugünkü randevularını al
$query = "SELECT * FROM randevular WHERE hastatc='$hastatc' AND DATE(randevu_tarihi) = DATE(NOW());";
$result = mysqli_query($conn, $query);
$randevulari = [];
while($rrow = mysqli_fetch_assoc($result)) {
    $randevulari[] = $rrow['randevu_tarihi'];
}

// Randevular için sadece geçerli saatleri al
$randevuSaatleri = implode("', '", array_map('mysqli_real_escape_string', array_column($randevulari, 0)));
$q = "SELECT id, TIME(randevu_tarihi) 
      FROM randevular 
      WHERE doktortc = '$doktortc' 
      AND DATE(randevu_tarihi) = CURDATE() 
      AND TIME(randevu_tarihi) > CURTIME() 
      AND hastatc = '' 
      AND kapali = '0' 
      AND TIME(randevu_tarihi) NOT IN ('$randevuSaatleri');"; 
$r = mysqli_query($conn, $q);

if (isset($_POST['randevuolustur']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $sikayet = htmlspecialchars(trim(stripslashes($_POST['sikayet'])));
    $tarih = $_POST['saat'];

    $q = "UPDATE randevular SET hastatc='$hastatc', hasta_sikayet='$sikayet' WHERE id=$tarih";
    $r = mysqli_query($conn, $q);
    if ($r) {
        // Başarılı
        $q = "SELECT * FROM hastalar WHERE tc='$hastatc';";
        $r = mysqli_query($conn, $q);
        $r = mysqli_fetch_assoc($r);
        $hasta_mail = $r['mail'];
        $hasta_ad = $r['ad'];
        $hasta_soyad = $r['soyad'];
        $hakkinda = $r['hasta_hakkinda'];
        $q = "SELECT * FROM doktorlar WHERE tc='$doktortc';";
        $r = mysqli_query($conn, $q);
        $r = mysqli_fetch_assoc($r);
        $doktor_mail = $r['mail'];
        $q = "SELECT * FROM randevular WHERE id='$tarih';";
        $r = mysqli_query($conn, $q);
        $r = mysqli_fetch_assoc($r);
        $randevuTarihi = $r['randevu_tarihi'];
        randevuBildir($hasta_mail, $hasta_ad, $hasta_soyad, $sikayet, $hakkinda, $randevuTarihi, $_SESSION['brans']);
        randevuBildir($doktor_mail, $hasta_ad, $hasta_soyad, $sikayet, $hakkinda, $randevuTarihi, $_SESSION['brans']);
        unset($_SESSION['randevu']);
        unset($_SESSION['brans']);
        unset($_SESSION['doktor']);
        header("Location: sekreter.php");
        exit();
    } else {
        // Başarısız
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
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
    <div class="container mt-5">
        <div class="row">
            <div class="col-6">
                <div class="mb-3">
                    <h1>Saat Seç</h1>
                    <select id="saat" class="form-select form-select-lg mt-5" name="saat">
                        <?php while ($row = mysqli_fetch_row($r)): ?>
                            <option value="<?php echo $row[0]; ?>">
                                <?php echo $row[1]; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
            </div>
            <div class="col-6">
                <h1>Hasta Şikayeti</h1>
                <div class="mb-3">
                    <label for="" class="form-label">Hasta Şikayeti</label>
                    <textarea class="form-control" required name="sikayet" rows="2"></textarea>
                </div>
            </div>
            <button type="submit" class="btn btn-primary w-100" name="randevuolustur">Randevu Oluştur</button>
        </div>
    </div>
</form>

</body>
</html>
<?php mysqli_close($conn); ?>
