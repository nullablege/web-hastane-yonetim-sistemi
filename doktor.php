<?php
session_start();
if( !isset($_SESSION['login']) || !isset($_SESSION['doktor'])){
    header("Location: login.php");
    exit();
}
$doktorTc = $_SESSION['login'];
require "req.php";
$conn = mysqli_connect("localhost","root","","327Hastanesi");
mysqli_set_charset($conn, "utf8mb4");

$dq = "select * from doktorlar where tc='$doktorTc';";
$dr = mysqli_query($conn,$dq);
$dr = mysqli_fetch_assoc($dr);
$doktorAd = $dr['ad']." ".$dr['soyad'];
$doktorTc = $_SESSION['login'];
$query = "select * from doktorgiris where gun = CURDATE() and doktortc = '$doktorTc';";
$result = mysqli_query($conn,$query);
if(!($result && mysqli_num_rows($result))>0){
    $query = "insert into doktorgiris(doktortc) values('$doktorTc');";
    $result = mysqli_query($conn,$query);
    if(!$result){
        echo '<div class="alert alert-danger text-center mt-0"> Problemle karşılaşıldı. Teknik birimle iletişime geçin.</div>';
    }
    else{
        echo '<div class="alert alert-success text-center mt-0">Sayın Doktor, Sisteme hoşgeldiniz. Otomatik olarak randevularınız yüklenmiştir. Kolay gelsin.</div>';
        $randevular = ["09:00:00","09:30:00","10:00:00","10:30:00","11:00:00","11:30:00","12:00:00","13:00:00","13:30:00","14:00:00","14:30:00","15:00:00","15:30:00","16:00:00","16:30:00","17:00:00"];
        $saat = date("H:i:s");
        foreach ($randevular as $randevu) {
            if($randevu>$saat){
                $query = "insert into randevular(randevu_tarihi,doktortc) values('".date("Y-m-d")." ".$randevu."','$doktorTc');";
                $result = mysqli_query($conn,$query);
            }
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['kapat']) && isset($_POST['randevu_ids'])) {
    $randevuIds = $_POST['randevu_ids'];

    $ids = implode(',', array_map('intval', $randevuIds)); 

    $updateQuery = "UPDATE randevular SET kapali = 1 WHERE id IN ($ids)";

    if (mysqli_query($conn, $updateQuery)) {
        echo '<div class="alert alert-success">Seçilen randevular kapatıldı.</div>';
        header("location:".$_SERVER['PHP_SELF']);
        exit();
    } 
    else {
        echo '<div class="alert alert-danger">Hata: ' . mysqli_error($conn) . '</div>';
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['geri_ac']) && isset($_POST['randevu_ids'])) {
    $randevu_ids = $_POST['randevu_ids'];
    
    $id_list = implode(',', array_map('intval', $randevu_ids)); 


    $query = "UPDATE randevular SET kapali = '0' WHERE id IN ($id_list);";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo '<div class="alert alert-success text-center">Seçilen randevular başarıyla geri açıldı.</div>';
        header("location:".$_SERVER['PHP_SELF']);
        exit();
    } else {
        echo '<div class="alert alert-danger text-center">Bir hata oluştu, lütfen tekrar deneyin.</div>';
        header("location:".$_SERVER['PHP_SELF']);
        exit();
    }
}

if(isset($_POST['randevubtn']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
    $_SESSION['randevu'] = $_POST['randevubtn'];
    header("Location: randevuDetay.php");
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
        <a href="doktorMail.php" class="btn btn-secondary mb-3">Kurum İçi Mailleşme</a>

        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                <?php echo "Hoşgeldiniz, " . htmlspecialchars(trim(stripslashes($doktorAd))); ?>
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <li><a class="dropdown-item" href="bilgiGuncelle.php">Bilgilerimi Güncelle</a></li>
                <li><a class="dropdown-item" href="doktorunRandevulari.php">Gunluk Randevular</a></li>
            </ul>
        </div>
    </div>
</nav>  
<div class="container">
    <center><h1>Randevular</h1></center>
    <div class="row">
        <div class="col-12">
        
        <table class="table">
        <thead>
            <tr>
            <th scope="col">#</th>
            <th scope="col">TC</th>
            <th scope="col">Ad Soyad</th>
            <th scope="col">Randevu Tarihi</th>
            <th scope="col">Randevuya Gir</th>
            </tr>
        </thead>
        <tbody>
            
            <?php
                $query = "SELECT * FROM randevular 
                WHERE doktortc ='$doktorTc' 
                AND hastatc != '' 
                AND kapali = '0' 
                AND randevu_durumu = '0' 
                AND randevu_tarihi > NOW()";                 
                $result = mysqli_query($conn,$query);
                if (!$result) {
                    echo "Hata : " . mysqli_error($conn);
                } else {
                    if (mysqli_num_rows($result) === 0) {
                        echo "Herhangi bir randevu yok";
                    }}
            ?>
            <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
            <?php while($row = mysqli_fetch_assoc($result)):?>
            <tr>
                <?php
                $hastaTc = htmlspecialchars(trim(stripslashes($row['hastatc'])));
                $hquery = "select * from hastalar where tc = '$hastaTc'; ";
                $hresult = mysqli_query($conn,$hquery);
                $hresult = mysqli_fetch_assoc($hresult);
                ?>
            <th scope="row"><?php echo htmlspecialchars(trim(stripslashes($row['id']))); ?></th>
            <td><?php echo htmlspecialchars(trim(stripslashes($row['hastatc']))); ?></td>
            <td><?php echo htmlspecialchars(trim(stripslashes($hresult['ad']))) . " " . htmlspecialchars(trim(stripslashes($hresult['soyad']))); ?></td>
            <td><?php echo htmlspecialchars(trim(stripslashes($row['randevu_tarihi']))); ?></td>
            <td><button type="submit" name="randevubtn" class="btn btn-primary" value="<?php echo htmlspecialchars(trim(stripslashes($row['id'])));?>">Randevuya Gir</button></td>
            </tr>
            <?php endwhile; ?>
            </form>

            <?php

            
            ?>
        </tbody>
        </table>



        </div>
    </div>


</div>

<div class="container mt-5">
    <h2>Randevu Listesi</h2>
    
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Seç</th>
                    <th>Randevu ID</th>
                    <th>Tarih</th>
                    <th>Saat</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $q1 = "select id,DATE_FORMAT(randevu_tarihi, '%Y-%m-%d'),DATE_FORMAT(randevu_tarihi, '%H:%i') from randevular where doktortc ='$doktorTc' and kapali='0' and hastatc = '' ;";
                $r1 = mysqli_query($conn,$q1);
                ?>
                <?php while($row = mysqli_fetch_row($r1)):?>
                <tr>
                    <td>
                    <input type="checkbox" name="randevu_ids[]" value="<?php echo htmlspecialchars(trim(stripslashes($row[0]))); ?>">
                    </td>
                    <td><?php echo htmlspecialchars(trim(stripslashes($row[0])));?></td>
                    <td><?php echo htmlspecialchars(trim(stripslashes($row[1])));?></td>
                    <td><?php echo htmlspecialchars(trim(stripslashes($row[2])));?></td>
                </tr>
                <?php endwhile;?>
            </tbody>
        </table>
        <button type="submit" name="kapat" class="btn btn-primary">Seçilen Randevuları Kapat</button>
    </form>



    <div class="container mt-5">
    <h2>Kapatılmış Randevu Listesi</h2>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Seç</th>
                    <th>Randevu ID</th>
                    <th>Tarih</th>
                    <th>Saat</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $q2 = "SELECT id, DATE_FORMAT(randevu_tarihi, '%Y-%m-%d') as tarih, DATE_FORMAT(randevu_tarihi, '%H:%i') as saat 
                        FROM randevular 
                        WHERE doktortc ='$doktorTc'  
                        AND kapali = '1' 
                        AND randevu_tarihi > NOW()"; 
                $r2 = mysqli_query($conn, $q2);
                ?>
                <?php while ($row = mysqli_fetch_row($r2)): ?>
                <tr>
                    <td>
                        <input type="checkbox" name="randevu_ids[]" value="<?php echo htmlspecialchars(trim(stripslashes($row[0]))); ?>">
                    </td>
                    <td><?php echo htmlspecialchars(trim(stripslashes($row[0]))); ?></td>
                    <td><?php echo htmlspecialchars(trim(stripslashes($row[1]))); ?></td>
                    <td><?php echo htmlspecialchars(trim(stripslashes($row[2]))); ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <button type="submit" name="geri_ac" class="btn btn-success">Seçilen Randevuları Geri Aç</button>
    </form>
</div>

</div>



</body>
</html>
<?php mysqli_close($conn); ?>