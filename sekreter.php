<?php require "req.php"; 
session_start();
require "mail.php";
if(!isset($_SESSION['login']) || !isset($_SESSION['sekreter'])){
    header("Location:login.php");
    exit();
}

$conn = mysqli_connect("localhost","root","","327Hastanesi");
mysqli_set_charset($conn, "utf8mb4");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['randevuolustur'])) {
    $_SESSION['randevu'] = $_POST['randevuolustur'];
    header("Location: branssec.php"); 
    exit();
}

?>

<?php
//NOrmalde bu kısımdan sekreterlerden bırının sıstme gırmesıyle tum doktorlara o gun ıcın randevu olusturulacaktı fakat onun yerıne doktorun sıstemınden button'a basmasıyla kendısının otomatık olarak olusturması daha mantıklı dıye dusundugum ıcın o sısteme gecıs yaptım fakat bu kodlar da duruyor olsun ıstenırse bu da aktıf edılebılır.

//corn job olmadıgından dolayı localhostta burada randevuların olup olmadıgı kontrol edılıp eger yoksa herhangı bır sekreterın sısteme gırıs yapmasıyla randevuların olusturulması tetıklenıyor.
//Sayfada sekreterlerin sürekli submit / refresh işlemi yapması sistemde bir yoğunluk oluşturacaktır.
//Bu kontrol çok tutarlı olmayabilir. Sisteme gün içerisinde yeni doktor eklenirse randevu verilemez gibi istisnalar olabilir
// $conn = mysqli_connect("localhost","root","","327Hastanesi");
// $query = "SELECT * FROM randevular WHERE DATE(randevu_tarihi) = DATE(NOW());";
// $result = mysqli_query($conn,$query);
// if($result && mysqli_num_rows($result) == 0){
//     $randevular = [
//         "09:00:00", "09:30:00", "10:00:00", "10:30:00",
//         "11:00:00", "11:30:00", "12:00:00", "12:30:00",
//         "13:00:00", "13:30:00", "14:00:00", "14:30:00",
//         "15:00:00", "15:30:00", "16:00:00", "16:30:00"
//     ];
//     $doktor_tcler = []; 
//     $query = "select * from doktorlar";
//     $result = mysqli_query($conn,$query);
//     while($row = mysqli_fetch_assoc($result)){
//         $doktor_tcler[] = $row['tc']; 
//     }
//     //Doktorların tcleri yuklendi 
//     $bugun = date("Y-m-d");
    
//     // Doktorlara randevuları ekle
//     foreach ($doktor_tcler as $tc ) {
//         foreach ($randevular as $randevu ) {
//             $randevu_tarihi = $bugun . " " . $randevu;
//             $query = "INSERT INTO randevular (randevu_tarihi, doktortc) VALUES ('$randevu_tarihi', '$tc')";
//             if(mysqli_query($conn,$query)){
//                 // echo "Ekleme basarili";
//             }
//             else{
//                 // echo "Ekleme basarisiz";
//             }


//         }
//     }

// }
// else {
//     // Randevular var fakat gün içerisinde yeni eklenen bir doktor veya randevu oluşturulmamış bir doktor var mı? 

//     $doktor_tcler = []; // Doktor TC'leri
//     $query = "SELECT * FROM doktorlar";
//     $result = mysqli_query($conn, $query);
//     while ($row = mysqli_fetch_assoc($result)) {
//         $doktor_tcler[] = $row['tc']; 
//     }

//     foreach ($doktor_tcler as $doktor_tc) {
//         // Randevu sayısını kontrol et
//         $query = "SELECT COUNT(*) FROM randevular WHERE doktortc = '$doktor_tc' AND DATE(randevu_tarihi) = DATE(NOW())";
//         $result = mysqli_query($conn, $query);
//         $result = mysqli_fetch_row($result);

//         if ($result[0] < 16) {
//             // Randevu var mı kontrol et
//             $query = "SELECT * FROM randevular WHERE doktortc = '$doktor_tc' AND hastatc IS NOT NULL AND DATE(randevu_tarihi) = DATE(NOW())";
//             $result = mysqli_query($conn, $query);

//             if (mysqli_num_rows($result) > 0) {
//                 // Randevusu olan doktorun randevuları silinemez.
//                 echo '<div class="alert alert-danger text-center mt-0">Bilgi - İşlem departmanıyla iletişime geçin, bir problem meydana geldi. </div>';
//             } else {
//                 // Randevuları sil
//                 $query = "DELETE FROM randevular WHERE doktortc = '$doktor_tc' AND DATE(randevu_tarihi) = DATE(NOW())";
//                 mysqli_query($conn, $query);

//                 $current_time = date("H:i:s");

//                 $randevular = [
//                     "09:00:00", "09:30:00", "10:00:00", "10:30:00",
//                     "11:00:00", "11:30:00", "12:00:00", "12:30:00",
//                     "13:00:00", "13:30:00", "14:00:00", "14:30:00",
//                     "15:00:00", "15:30:00", "16:00:00", "16:30:00"
//                 ];

//                 foreach ($randevular as $randevu) {
//                     if ($randevu > $current_time) { 
//                         // Randevu ekle
//                         $query = "INSERT INTO randevular (randevu_tarihi, doktortc) VALUES ('$randevu', '$doktor_tc')";
//                         $result = mysqli_query($conn, $query);

//                         if (!$result) {
//                             echo "Hata: " . mysqli_error($conn);
//                         }
//                     }
//                 }
//             }
//         }
//     }
// } 

 ?>

<?php
$randevu = "disabled";
$hastaListe = "none";
$sodisabled = "disabled";
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['ara'])){
    $ad = htmlspecialchars(trim(stripslashes($_POST['ad'])));
    $soyad = htmlspecialchars(trim(stripslashes($_POST['soyad'])));
    $tc = htmlspecialchars(trim(stripslashes($_POST['tc'])));
    if(!empty($_POST['tc'])){
        $query = "select * from hastalar where tc= '$tc'";
    }
    elseif (!empty($_POST['ad'])) {
        if(!empty($_POST['soyad'])){
            $query = "select * from hastalar where ad='$ad' and soyad='$soyad';";
        }
        else{
            $query = "select * from hastalar where ad='$ad';";
        }
    }
    elseif (!empty($_POST['soyad'])) {
        $query = "select * from hastalar where ad='$soyad';";
    }
    $result = mysqli_query($conn,$query);
    if($result && mysqli_num_rows($result)>0){
        $randevu = "";
        $hastaListe = "block";
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

    <style>
        .randevu{
    
        }
    </style>
</head>
<!-- eski navbarı none yaptım -->
<body>
    <nav class="navbar bg-body-tertiary"  style="display:none"> 
        <div class="container-fluid">
            <a class="navbar-brand" href="logout.php">
                <img src="https://i.ibb.co/xGzDqM9/logo.png" alt="Logo" width="100" height="40"
                    class="d-inline-block align-text-top">
            </a>
            <?php
            $sekreterTc = $_SESSION['login'];
            $dq = "select * from sekreterler where tc='$sekreterTc';";
            $conn = mysqli_connect("localhost","root","","327Hastanesi");
            mysqli_set_charset($conn, "utf8mb4");
            $dr = mysqli_query($conn,$dq);
            $dr = mysqli_fetch_assoc($dr);
            $sekreterAd = $dr['ad']." ".$dr['soyad'];
            ?>
            <b><?php echo "Hosgeldiniz, ".htmlspecialchars(trim(stripslashes($sekreterAd))); ?></b>
        </div>
    </nav>

    <nav class="navbar bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="logout.php">
            <img src="https://i.ibb.co/xGzDqM9/logo.png" alt="Logo" width="100" height="40" class="d-inline-block align-text-top">
        </a>

        <!-- Dropdown Menu -->
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                <?php echo "Hoşgeldiniz, " . htmlspecialchars(trim(stripslashes(htmlspecialchars($sekreterAd)))); ?>
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <li><a class="dropdown-item" href="bilgiGuncelle.php">Bilgilerimi Güncelle</a></li>
            </ul>
        </div>
    </div>
</nav> 

    <div class="container">
        <div class="row mt-3">
            <div class="col-6 randevu">
                <center>
                    <h1>Randevu Oluştur</h1>
                </center>
                <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <div class="d-flex gap-2 mb-3">
                        <div class="flex-fill">
                            <label class="form-label">Ad</label>
                            <input type="text" name="ad" class="form-control">
                        </div>
                        <div class="flex-fill">
                            <label class="form-label">Soyad</label>
                            <input type="text" name="soyad" class="form-control">
                        </div>
                    </div>
                    <div class="d-flex gap-2 mb-3">
                        <div class="flex-fill">
                            <label class="form-label">TC</label>
                            <input type="number" name="tc" class="form-control">
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <div class="container">
                            <div class="row">
                                <div class="col-12 mt-2">
                                <button type="submit" name="ara" class="btn btn-primary w-100">Hasta Ara</button>
                                </div>
                                <div class="col-12 mt-2">
                                <a href="aktifRandevular.php"><button type="button" class="btn btn-info w-100">Aktif Randevular</button></a>
                                </div>
                                <div class="col-12 mt-2">
                                <a href="sekreterMail.php"><button type="button" class="btn btn-warning w-100">Mail Kutusu</button></a>
                                </div>
                                <div class="col-12 mt-2">
                                <a href="gunlukRandevular.php"><button type="button" class="btn btn-danger w-100">Günlük Randevu Listesi</button></a>
                                </div>
                                <div class="col-12 mt-2">
                                <a href="genelRandevular.php"><button type="button" class="btn btn-danger w-100">Toplu Randevu Listesi</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>




                
            </div>

            
            <div class="col-6">
                <center>
                    <h1>Yeni Hasta Kaydı</h1>
                </center>


                
                    <?php
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['hastakaydet'])){
    $cinsiyet = $_POST['cinsiyet'];
    $hasta_hakkinda = htmlspecialchars(stripslashes(trim($_POST['hasta_hakkinda'])));
    $mail = htmlspecialchars(stripslashes(trim($_POST['mail'])));
    $tel = htmlspecialchars(stripslashes(trim($_POST['tel'])));
    $dogum = htmlspecialchars(stripslashes(trim($_POST['dogum'])));
    $soyad = htmlspecialchars(stripslashes(trim($_POST['soyad'])));
    $ad = htmlspecialchars(stripslashes(trim($_POST['ad'])));
    $tc = htmlspecialchars(stripslashes(trim($_POST['tc'])));
    $query = "INSERT INTO hastalar (tc, ad, soyad, dogum, tel, mail, hasta_hakkinda, cinsiyet) 
          VALUES ('$tc', '$ad', '$soyad', '$dogum', '$tel', '$mail', '$hasta_hakkinda', '$cinsiyet')";
    $conn = mysqli_connect("localhost","root","","327Hastanesi");
    $result = mysqli_query($conn,$query);
    if($result){
        iseAlim($mail,$ad,$soyad);
    }
}

?>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                        <div class="form-group">
                            <label for="tc">TC Kimlik No:</label>
                            <input type="text" class="form-control" id="tc" name="tc" required>
                        </div>
                        <div class="form-group">
                            <label for="ad">Ad:</label>
                            <input type="text" class="form-control" id="ad" name="ad" required>
                        </div>
                        <div class="form-group">
                            <label for="soyad">Soyad:</label>
                            <input type="text" class="form-control" id="soyad" name="soyad" required>
                        </div>
                        <div class="form-group">
                            <label for="dogum">Doğum Tarihi: (YYYY/AA/GG) </label>
                            <input type="text" class="form-control" id="dogum" name="dogum" required>
                        </div>
                        <div class="form-group">
                            <label for="tel">Telefon:</label>
                            <input type="tel" class="form-control" id="tel" name="tel" required>
                        </div>
                        <div class="form-group">
                            <label for="mail">E-posta:</label>
                            <input type="email" class="form-control" id="mail" name="mail" required>
                        </div>
                        <div class="form-group">
                            <label for="hasta_hakkinda">Hasta Hakkında:</label>
                            <textarea class="form-control" id="hasta_hakkinda" name="hasta_hakkinda"
                                rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Cinsiyet:</label>
                            <select class="form-control" name="cinsiyet" required>
                                <option value="">Seçiniz</option>
                                <option value="Erkek">Erkek</option>
                                <option value="Kadın">Kadın</option>
                            </select>
                        </div>

                        <button type="submit" name="hastakaydet" class="btn btn-primary mt-2">Kaydı Tamamla</button>
                    </form>


               



            </div>
            <div class="col-12" style="display: <?php echo htmlspecialchars(trim(stripslashes($hastaListe))); ?>;">
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <table class="table mt-3">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Ad</th>
                    <th scope="col">Soyad</th>
                    <th scope="col">Doğum Tarihi</th>
                    <th scope="col">TC</th>
                    <th scope="col">Randevu Oluştur</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <th scope="row"><?php echo htmlspecialchars(trim(stripslashes($row['id']))); ?></th>
                    <td><?php echo htmlspecialchars(trim(stripslashes($row['ad']))); ?></td>
                    <td><?php echo htmlspecialchars(trim(stripslashes($row['soyad']))); ?></td>
                    <td><?php echo htmlspecialchars(trim(stripslashes($row['dogum']))); ?></td>
                    <td><?php echo htmlspecialchars(trim(stripslashes($row['tc']))); ?></td>
                    <td>
                        <button type="submit" class="btn btn-primary btn-sm mt-0" name="randevuolustur"
                            value="<?php echo htmlspecialchars(trim(stripslashes($row['tc']))); ?>">Randevu Oluştur</button>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </form>
</div>




        </div>
    </div>

    
    </div>
</div>

</body>

</html>
<?php mysqli_close($conn);?>