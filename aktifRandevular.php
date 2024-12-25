<?php
session_start();
if(!(isset($_SESSION['login']) && isset($_SESSION['sekreter']))){
    header("Location: login.php");
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
            <a href="sekreter.php" class="float-start"><button class="btn btn-warning">Geri Dön</button></a>
        </div>
    </nav>

    
<?php

$conn = mysqli_connect("localhost","root","","327Hastanesi");
mysqli_set_charset($conn, "utf8mb4");
require "req.php";
require "mail.php";
?>
<div class="container">
    <div class="row">
        <div class="col-12">
            <center><h1 class="mt-3">Aktif Randevular</h1></center>
            <?php
            $q = "
                SELECT r.id, r.randevu_tarihi, h.ad AS hasta_ad, h.soyad AS hasta_soyad, 
                       d.ad AS doktor_ad, d.soyad AS doktor_soyad, d.brans 
                FROM randevular r
                JOIN hastalar h ON r.hastatc = h.tc
                JOIN doktorlar d ON r.doktortc = d.tc
                WHERE r.kapali = '0' AND r.hastatc IS NOT NULL;
            ";
            $result = mysqli_query($conn, $q);
            ?>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Hasta Adı</th>
                        <th scope="col">Doktor Adı</th>
                        <th scope="col">Branş</th>
                        <th scope="col">Randevu Tarihi</th>
                        <th scope="col">Randevu İptali</th>
                    </tr>
                </thead>
                <tbody>
                                <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">

                                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                <tr>
                                    <th scope="row"><?php echo htmlspecialchars(trim(stripslashes($row['id']))); ?></th>
                                    <td><?php echo htmlspecialchars(trim(stripslashes($row['hasta_ad']))) . " " . htmlspecialchars(trim(stripslashes($row['hasta_soyad']))); ?></td>
                                    <td><?php echo htmlspecialchars(trim(stripslashes($row['doktor_ad']))) . " " . htmlspecialchars(trim(stripslashes($row['doktor_soyad']))); ?></td>
                                    <td><?php echo htmlspecialchars(trim(stripslashes($row['brans']))); ?></td>
                                    <td><?php echo htmlspecialchars(trim(stripslashes($row['randevu_tarihi']))); ?></td>
                                    <td><button type="submit" class="btn btn-danger" name="iptal" value="<?php echo htmlspecialchars(trim(stripslashes($row['id']))) ?>">Randevuyu İptal Et</button></td>
                                </tr>
                                <?php endwhile; ?>
                                </form>
                    <?php
                    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['iptal'])){
                        $silinecek = $_POST['iptal'];
                        $query1 = "select * from randevular where id='$silinecek';";
                        $result = mysqli_query($conn,$query1);
                        $result = mysqli_fetch_assoc($result);
                        $doktorTc = $result['doktortc'];
                        $hastaTc = $result['hastatc'];
                        $sikayet = $result['hasta_sikayet'];
                        $query1 = "select * from hastalar where tc='$hastaTc';";
                        $result = mysqli_query($conn,$query1);
                        $result = mysqli_fetch_assoc($result);
                        $ad = $result['ad'];
                        $soyad = $result['soyad'];
                        $hastaMail = $result['mail'];
                        $hakkinda = $result['hasta_hakkinda'];
                        $query1 = "select * from doktorlar where tc='$doktorTc';";
                        $result = mysqli_query($conn,$query1);
                        $result = mysqli_fetch_assoc($result);
                        $doktorMail = $result['mail'];
                        $doktorAd = $result['ad'];
                        $doktorSoyad = $result['soyad'];
                        $query1 = "update randevular set hastatc ='', hasta_sikayet = NULL where id='$silinecek';";
                        $result = mysqli_query($conn,$query1);
                        if($result){
                            randevuIptalBildir($hastaMail,$ad,$soyad,$sikayet,$hakkinda);
                            randevuIptalBildir($doktorMail,$doktorAd,$doktorSoyad,$sikayet,$hakkinda);
                            header("Location:sekreter.php");
                            exit();
                        }
                    }
                    
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


</body>
</html>
<?php mysqli_close($conn); ?>