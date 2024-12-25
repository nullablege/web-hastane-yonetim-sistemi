<?php

ini_set('max_execution_time', 120);
session_start();
$conn = mysqli_connect("localhost","root","","327Hastanesi");
mysqli_set_charset($conn, "utf8mb4");
$display = "none";
$disabled = "disabled";
$display1 = "none";
$disabled1 = "disabled";
require "mail.php";
 if(!isset($_SESSION['login']) || !isset($_SESSION['yonetici'])){
      header("Location:login.php");
 }
else{
    //admin kısmına sekreter yada doktor hesabıyla giriş yapılırsa kendi sayfasına gönderme işlemi
    //Bu kısmı yazdığım zaman henüz doktor,sekreter,yonetici olarak session belirlememiştim suan bu kısma gerek yok fakat kalsın zararı da yok.
    $tc = $_SESSION['login'];
    $conn = mysqli_connect("localhost","root","","327hastanesi");
    mysqli_set_charset($conn, "utf8mb4");
    $query = "select * from yonetici where kadi='".$tc."';";
    $result = mysqli_query($conn,$query);
    if(!($result && mysqli_affected_rows($conn)==1)){
        $query = "select * from  doktorlar where tc='".$tc."';";
        $result = mysqli_query($conn,$query);
        if($result && mysqli_affected_rows($conn)==1){
            header("location:doktor.php");
        }
        else{
            $query = "select * from sekreterler where tc='".$tc."';";
            $result = mysqli_query($conn,$query);
            if($result && mysqli_affected_rows($conn)==1){
                header("location:sekreter.php");
            }
            else{
                header("location:login.php");
            }
        }
    }
}

if(isset($_POST['bilgigetir']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
    $q3 = "select * from doktorlar where id ='".$_POST['bilgigetir']."';";
    $result3 = mysqli_query($conn,$q3);
    $row3 = mysqli_fetch_assoc($result3);
    $gercekId = $row3['id'];
    $display="block";
    $disabled = "";
}
if(isset($_POST['cikart']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
    //Doktor işten çıkart
    $q4 = "select * from doktorlar where id='".$_POST['cikart']."';";
    $r4 = mysqli_query($conn,$q4);
    $r4 = mysqli_fetch_assoc($r4);
    $mail = $r4['mail'];
    $q4 = "delete from doktorlar where id ='".$_POST['cikart']."';";
    $result4 = mysqli_query($conn,$q4);
    if($result4 && mysqli_affected_rows($conn)==1){
         header("location:".$_SERVER['PHP_SELF']);
         istenCikar($mail);
    }
}

if(isset($_POST['cikarts']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
    //Sekreter işten çıkart
    $q4 = "select * from sekreterler where id='".$_POST['cikarts']."';";
    $r4 = mysqli_query($conn,$q4);
    $r4 = mysqli_fetch_assoc($r4);
    $mail = $r4['mail'];
    $q8 = "delete from sekreterler where id ='".$_POST['cikarts']."';";
    $result8 = mysqli_query($conn,$q8);
    if($result8 && mysqli_affected_rows($conn)==1){
         header("location:".$_SERVER['PHP_SELF']);
         istenCikar($mail);
    }
}

if(isset($_POST['guncelle']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
    //doktor guncelle
    $ad = htmlspecialchars(trim(stripslashes($_POST['ad'])));
    $soyad = htmlspecialchars(trim(stripslashes($_POST['soyad'])));
    $tc = htmlspecialchars(trim(stripslashes($_POST['tc'])));
    $mail = htmlspecialchars(trim(stripslashes($_POST['mail'])));
    $telno = htmlspecialchars(trim(stripslashes($_POST['telno'])));
    $adres = htmlspecialchars(trim(stripslashes($_POST['adres'])));
    $dogum = htmlspecialchars(trim(stripslashes($_POST['dogum'])));
    $brans = htmlspecialchars(trim(stripslashes($_POST['brans'])));
     $sq = "select * from doktorlar where tc='$tc';";
     $sr = mysqli_query($conn,$sq);
     $sr = mysqli_fetch_assoc($sr);  
     $id = htmlspecialchars(trim(stripslashes($sr['id'])));
     $q5 = "UPDATE doktorlar SET ad ='$ad',soyad='$soyad',tc='$tc',mail='$mail',telno='$telno',adres='$adres',dogum='$dogum',brans='$brans' where id='$id';";
     $result5 = mysqli_query($conn,$q5);
     if($result5 && mysqli_affected_rows($conn)==1){
         header("location:".$_SERVER['PHP_SELF']);
     }
    echo $ad,$soyad,$tc,$mail,$telno,$adres,$dogum,$brans,$id;
}

if(isset($_POST['bilgigetirs']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
    $disabled1 = "";
    $display1 = "block";
    $q6 = "select * from sekreterler where id='".$_POST['bilgigetirs']."';";
    $result6 = mysqli_query($conn,$q6);
    $row6 = mysqli_fetch_assoc($result6);
}

if (isset($_POST['guncelles']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    //sekreter guncelle
    // Verileri temizle
    $ad = htmlspecialchars(trim(stripslashes($_POST['ad'])));
    $soyad = htmlspecialchars(trim(stripslashes($_POST['soyad'])));
    $tc = htmlspecialchars(trim(stripslashes($_POST['tc'])));
    $mail = htmlspecialchars(trim(stripslashes($_POST['mail'])));
    $telno = htmlspecialchars(trim(stripslashes($_POST['telno'])));
    $adres = htmlspecialchars(trim(stripslashes($_POST['adres'])));
    $dogum = htmlspecialchars(trim(stripslashes($_POST['dogum'])));
    $id = $_POST['guncelles'];
    $q7 = "UPDATE sekreterler SET 
        ad='$ad',
        soyad='$soyad',
        tc='$tc',
        mail='$mail',
        telno='$telno',
        adres='$adres',
        dogum='$dogum' 
    WHERE id=$id";
    $result7 = mysqli_query($conn, $q7);
    
    if ($result7 && mysqli_affected_rows($conn) == 1) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit; 
    } else {
        echo "Güncelleme işlemi sırasında bir hata oluştu: " . mysqli_error($conn);
    }
}


if(isset($_POST['doktorkayit']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
    //Doktor işe al
    $ad = htmlspecialchars(trim(stripslashes($_POST['ad'])));
    $soyad = htmlspecialchars(trim(stripslashes($_POST['soyad'])));
    $tc = htmlspecialchars(trim(stripslashes($_POST['tc'])));
    $mail = htmlspecialchars(trim(stripslashes($_POST['mail'])));
    $telno = htmlspecialchars(trim(stripslashes($_POST['telno'])));
    $adres = htmlspecialchars(trim(stripslashes($_POST['adres'])));
    $dogum = htmlspecialchars(trim(stripslashes($_POST['dogum'])));
    $brans = htmlspecialchars(trim(stripslashes($_POST['brans'])));
    $sifre = htmlspecialchars(trim(stripslashes($_POST['sifre'])));
    $sifre = password_hash($sifre,PASSWORD_DEFAULT);
    $q10 = "INSERT INTO doktorlar (ad, soyad, tc, mail, telno, adres, dogum, brans, sifre) VALUES ('$ad', '$soyad', '$tc', '$mail', '$telno', '$adres', '$dogum', '$brans', '$sifre');";
    $result10 = mysqli_query($conn,$q10);
    if($result10 && mysqli_affected_rows($conn)==1){
        header("location:".$_SERVER['PHP_SELF']);
        exit;
    }
}

if(isset($_POST['sekreterkayit']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
    //Sekreter İşe al
    $ad = htmlspecialchars(trim(stripslashes($_POST['ad'])));
    $soyad = htmlspecialchars(trim(stripslashes($_POST['soyad'])));
    $tc = htmlspecialchars(trim(stripslashes($_POST['tc'])));
    $mail = htmlspecialchars(trim(stripslashes($_POST['mail'])));
    $telno = htmlspecialchars(trim(stripslashes($_POST['telno'])));
    $adres = htmlspecialchars(trim(stripslashes($_POST['adres'])));
    $dogum = htmlspecialchars(trim(stripslashes($_POST['dogum'])));
    $sifre = htmlspecialchars(trim(stripslashes($_POST['sifre'])));
    $sifre = password_hash($sifre,PASSWORD_DEFAULT);
    $q11 = "INSERT INTO sekreterler (ad, soyad, tc, mail, telno, adres, dogum, sifre) VALUES ('$ad', '$soyad', '$tc', '$mail', '$telno', '$adres', '$dogum', '$sifre');";
    $result11 = mysqli_query($conn, $q11);
    if ($result11 && mysqli_affected_rows($conn) == 1) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit; 
    } else {
        echo "Güncelleme işlemi sırasında bir hata oluştu: " . mysqli_error($conn);
    }
}


if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['gonderd'])){
    // $conn = mysqli_connect("localhost","root","","327Hastanesi");
    $hangiDoktor = "select * from doktorlar where id='".$_POST['eleman']."';";
    $hangiDoktor = mysqli_query($conn,$hangiDoktor);
    $hangiDoktor = mysqli_fetch_assoc($hangiDoktor);
    $baslik = htmlspecialchars(trim(stripslashes($_POST['mailbaslik'])));
    $icerik = htmlspecialchars(trim(stripslashes($_POST['mailicerik'])));
    if(calisanaMesaj($hangiDoktor['mail'],$baslik,$icerik)){
        echo '<div class="alert alert-success text-center mt-0">Mail Yollandı.</div>';
    }
    else{
        echo '<div class="alert alert-danger text-center mt-0">Mail Yollama Esnasında Hata.</div>';
    }
}

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['gonderdt'])){
    $baslik = htmlspecialchars(trim(stripslashes($_POST['mailbaslik'])));
    $icerik = htmlspecialchars(trim(stripslashes($_POST['mailicerik'])));

    if(doktorlaraDuyuru($baslik,$icerik)){
        echo '<div class="alert alert-success text-center mt-0">Mail Yollandı.</div>';
    }
    else{
        //echo '<div class="alert alert-danger text-center mt-0">Mail Yollama Esnasında Hata.</div>';
    }
}



if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['gonders'])){
    $hangiDoktor = "select * from sekreterler where id='".$_POST['eleman']."';";
    $hangiDoktor = mysqli_query($conn,$hangiDoktor);
    $hangiDoktor = mysqli_fetch_assoc($hangiDoktor);
    $baslik = htmlspecialchars(trim(stripslashes($_POST['mailbaslik'])));
    $icerik = htmlspecialchars(trim(stripslashes($_POST['mailicerik'])));
    if(calisanaMesaj($hangiDoktor['mail'],$baslik,$icerik)){
        echo '<div class="alert alert-success text-center mt-0">Mail Yollandı.</div>';
    }
    else{
        echo '<div class="alert alert-danger text-center mt-0">Mail Yollama Esnasında Hata.</div>';
    }
}

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['gonderst'])){
    $baslik = htmlspecialchars(trim(stripslashes($_POST['mailbaslik'])));
    $icerik = htmlspecialchars(trim(stripslashes($_POST['mailicerik'])));

    if(sekreterlereTopluDuyuru($baslik,$icerik)){
        echo '<div class="alert alert-success text-center mt-0">Mail Yollandı.</div>';
    }
    else{
        //echo '<div class="alert alert-danger text-center mt-0">Mail Yollama Esnasında Hata.</div>';
    }
}

if(isset($_POST['gondert']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
    $baslik = htmlspecialchars(trim(stripslashes($_POST['mailbaslik'])));
    $icerik = htmlspecialchars(trim(stripslashes($_POST['mailicerik'])));
    if(topluDuyuru($baslik,$icerik)){
        echo '<div class="alert alert-success text-center mt-0">Mail Yollandı.</div>';
    }
    else{
        //echo '<div class="alert alert-danger text-center mt-0">Mail Yollama Esnasında Hata.</div>';
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
        .btn-link-as-a {
    background: none;
    border: none;
    color: blue;
    text-decoration: underline;
    cursor: pointer;
    padding: 0;
    font: inherit;
}
.btn-link-as-a:hover {
    color: darkblue;
}
.bgetir{
    white-space: nowrap;
}

    </style>
</head>
<body>
<nav class="navbar bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="logout.php">
      <img src="https://i.ibb.co/xGzDqM9/logo.png" alt="Logo" width="100" height="40" class="d-inline-block align-text-top">
    </a>
  </div>
</nav>
    
   <div class="container">
        <div class="row">
        <center><h1>Doktor Listesi : </h1></center>
            <div class="col-6">

            <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST" id="doktor">

            <table class="table mt-3" >
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Ad</th>
                    <th scope="col">Soyad</th>
                    <th scope="col">Branş</th>
                    <th scope="col">Randevuları</th>
                    <th scope="col" class="bgetir">Bilgileri Getir</th>
                    </tr>
                </thead>
                <?php
                $query = "select * from doktorlar;";
                $result = mysqli_query($conn,$query);
                ?>
                <?php while($row = mysqli_fetch_assoc($result)):?>
                <tbody>
                    <tr>
                    <th scope="row"><?php echo $row['id'];?></th>
                    <td><?php echo htmlspecialchars(stripslashes(trim($row['ad'])));?></td>
                    <td><?php echo htmlspecialchars(stripslashes(trim($row['soyad'])));?></td>
                    <td><?php echo htmlspecialchars(stripslashes(trim($row['brans'])));?></td>
                    <?php
                    $randevu_sayisi = 0;
                    $q2 = "SELECT COUNT(*) FROM randevular WHERE doktortc = '{$row['tc']}' AND kapali = '0' AND DATE(randevu_tarihi) = CURDATE()";                  
                    $result2 = mysqli_query($conn,$q2);
                    $result2 = mysqli_fetch_row($result2);
                    $randevu_sayisi = $result2[0];
                    ?>
                    <td><?php echo $randevu_sayisi;?></td>
                    <td><button type="submit" value="<?php echo htmlspecialchars(stripslashes(trim($row['id'])));?>" name="bilgigetir" id="bilgigetir" class="btn-link-as-a bgetir">Bilgileri Getir</button></td>
                    </tr>
                </tbody>
                <?php endwhile; ?>
            </table>
            
            </form>

            </div>
            <div class="col-6 guncelle" id="guncelle" style="display:<?php echo htmlspecialchars(stripslashes(trim($display)));?>">
            <form method="POST" action="<?php echo htmlspecialchars(stripslashes(trim($_SERVER['PHP_SELF'])));?>" >
            <fieldset <?php echo htmlspecialchars(stripslashes(trim($disabled)));?> id="fs">
                <legend>Doktor Bilgi Güncelleme : </legend>



                <div class="mb-3">
                <label class="form-label">TC :</label>
                <input type="text" class="form-control" value="<?php echo htmlspecialchars(stripslashes(trim($row3['tc'])));?>" name="tc">
                <label class="form-label">Ad :</label>
                <input type="text" class="form-control" value="<?php echo htmlspecialchars(stripslashes(trim($row3['ad'])));?>" name="ad">
                <label class="form-label">Soyad :</label>
                <input type="text" class="form-control" value="<?php echo htmlspecialchars(stripslashes(trim($row3['soyad'])));?>" name="soyad">
                <label class="form-label">Mail :</label>
                <input type="text" class="form-control" value="<?php echo htmlspecialchars(stripslashes(trim($row3['mail'])));?>" name="mail">
                <label class="form-label">Tel No :</label>
                <input type="text" class="form-control" value="<?php echo htmlspecialchars(stripslashes(trim($row3['telno'])));?>" name="telno">
                <label class="form-label">Adres :</label>
                <input type="text" class="form-control" value="<?php echo htmlspecialchars(stripslashes(trim($row3['adres'])));?>" name="adres">
                <label class="form-label">Dogum (YYYY/AA/GG):</label>
                <input type="text" class="form-control" value="<?php echo htmlspecialchars(stripslashes(trim($row3['dogum'])));?>"  name="dogum">
                <label class="form-label">Brans :</label>
                <input type="text" class="form-control" value="<?php echo htmlspecialchars(stripslashes(trim($row3['brans'])));?>" name="brans">
                <input type="hidden" class="form-control" value="<?php echo htmlspecialchars(stripslashes(trim($row3['id']))); ?>" name="id">
                </div>
               
                    

                       
                <button type="submit" name="guncelle" value="<?php echo htmlspecialchars(stripslashes(trim($row3['id']))); ?>" class="btn btn-primary">Guncelle</button>
                <button type="button" class="btn btn-danger" value="<?php echo $row3?>" data-bs-toggle="modal" data-bs-target=".modal">İşten Çıkar</button> 
            </fieldset>
                </form>



            <div class="modal" tabindex="-1">
            <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Onaylıyor Musunuz ?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><?php echo htmlspecialchars(stripslashes(trim($row3['ad'])))." ".htmlspecialchars(stripslashes(trim($row3['soyad'])))." İsimli çalışanın işine son vermeyi onaylıyor musunuz ?";?></p>
            </div>
                    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">

                    <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                <button type="submit" name="cikart" value="<?php echo htmlspecialchars(stripslashes(trim($row3['id'])))?>" class="btn btn-danger">Onaylıyorum</button>
            </div>
                    </form>
            </div>
        </div>


        </div>
    </div>



            </div>
            </div>
                        


        </div>
   </div>

   <div class="container">
        <div class="row">
        <center><h1>Sekreter Listesi : </h1></center>
            <div class="col-6">

            <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST" id="sekreter">
            <table class="table mt-3" >
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Ad</th>
                    <th scope="col">Soyad</th>
                    <th scope="col">Bilgileri Getir</th>
                    </tr>
                </thead>
                <?php
                $query = "select * from sekreterler;";
                $result = mysqli_query($conn,$query);
                ?>
                <?php while($row = mysqli_fetch_assoc($result)):?>
                <tbody>
                    <tr>
                    <th scope="row"><?php echo htmlspecialchars(stripslashes(trim($row['id'])));?></th>
                    <td><?php echo htmlspecialchars(stripslashes(trim($row['ad'])));?></td>
                    <td><?php echo htmlspecialchars(stripslashes(trim($row['soyad'])));?></td>
                    <td><button type="submit" value="<?php echo htmlspecialchars(stripslashes(trim($row['id'])));?>" name="bilgigetirs" id="bilgigetirs" class="btn-link-as-a">Bilgileri Getir</button></td>
                    </tr>
                </tbody>
                <?php endwhile; ?>
            </table>
            
            </form>

            </div>
            <div class="col-6 guncelle" id="guncelle" style="display:<?php echo htmlspecialchars(stripslashes(trim($display1)))?>">
            <form method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>" >
            <fieldset <?php echo htmlspecialchars(stripslashes(trim($disabled1)));?> >
                <legend>Sekreter Bilgi Güncelleme : </legend>



                <div class="mb-3">
                <label class="form-label">TC :</label>
                <input type="text" class="form-control" value="<?php echo htmlspecialchars(stripslashes(trim($row6['tc'])));?>" name="tc">
                <label class="form-label">Ad :</label>
                <input type="text" class="form-control" value="<?php echo htmlspecialchars(stripslashes(trim($row6['ad'])));?>" name="ad">
                <label class="form-label">Soyad :</label>
                <input type="text" class="form-control" value="<?php echo htmlspecialchars(stripslashes(trim($row6['soyad'])))?>" name="soyad">
                <label class="form-label">Mail :</label>
                <input type="text" class="form-control" value="<?php echo htmlspecialchars(stripslashes(trim($row6['mail'])));?>" name="mail">
                <label class="form-label">Tel No :</label>
                <input type="text" class="form-control" value="<?php echo htmlspecialchars(stripslashes(trim($row6['telno'])));?>" name="telno">
                <label class="form-label">Adres :</label>
                <input type="text" class="form-control" value="<?php echo htmlspecialchars(stripslashes(trim($row6['adres'])));?>" name="adres">
                <label class="form-label">Dogum (YYYY/AA/GG):</label>
                <input type="text" class="form-control" value="<?php echo htmlspecialchars(stripslashes(trim($row6['dogum'])));?>"  name="dogum">
                <input type="hidden" disabled class="form-control" value="<?php echo htmlspecialchars(stripslashes(trim($row6['id']))); ?>" name="id">
                </div>
               
                    

                       
                <button type="submit" name="guncelles" value="<?php echo htmlspecialchars(stripslashes(trim($row6['id']))); ?>" class="btn btn-primary">Guncelle</button>
<button type="button" class="btn btn-danger" value="<?php echo htmlspecialchars(stripslashes(trim($row6['id']))) ?>" data-bs-toggle="modal" data-bs-target="#modal-<?php echo htmlspecialchars(stripslashes(trim($row6['id']))); ?>">İşten Çıkar</button> 
</fieldset>
</form>

<div class="modal fade" id="modal-<?php echo htmlspecialchars(stripslashes(trim($row6['id']))); ?>" tabindex="-1" aria-labelledby="modalLabel-<?php echo htmlspecialchars(stripslashes(trim($row6['id'])));; ?>" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel-<?php echo htmlspecialchars(stripslashes(trim($row6['id']))); ?>">Onaylıyor Musunuz ?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><?php echo htmlspecialchars(stripslashes(trim($row6['ad'])))." ".htmlspecialchars(stripslashes(trim($row6['soyad'])))." İsimli çalışanın işine son vermeyi onaylıyor musunuz ?";?></p>
            </div>
            <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                    <button type="submit" name="cikarts" value="<?php echo htmlspecialchars(stripslashes(trim($row6['id'])))?>" class="btn btn-danger">Onaylıyorum</button>
                </div>
            </form>
        </div>
    </div>
</div>


        </div>
    </div>



            </div>
            </div>
                        


        </div>
   </div>

   


<div class="container">
    <div class="row">
        <div class="col-6">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                <fieldset>
                    <legend>Yeni Doktor Kaydı</legend>
                    <div class="mb-3">
                    <label class="form-label">TC</label>
                    <input type="text" class="form-control" name="tc">
                    </div>
                    <div class="mb-3">
                    <label class="form-label">Ad</label>
                    <input type="text" class="form-control" name="ad">
                    </div>
                    <div class="mb-3">
                    <label class="form-label">Soyad</label>
                    <input type="text" class="form-control" name="soyad">
                    </div>
                    <div class="mb-3">
                    <label class="form-label">Sifre</label>
                    <input type="text" class="form-control" name="sifre">
                    </div>
                    <div class="mb-3">
                    <label class="form-label">Mail</label>
                    <input type="text" class="form-control" name="mail">
                    </div>
                    <div class="mb-3">
                    <label class="form-label">Tel No</label>
                    <input type="text" class="form-control" name="telno">
                    </div>
                    <div class="mb-3">
                    <label class="form-label">Adres</label>
                    <input type="text" class="form-control" name="adres">
                    </div>
                    <div class="mb-3">
                    <label class="form-label">Dogum (YYYY/AA/GG)</label>
                    <input type="text" class="form-control" name="dogum">
                    </div>
                    <div class="mb-3">
                    <label  class="form-label">Branş</label>
                    <?php
                    //branslar
                    $q9 = "select * from branslar;";
                    $result9 = mysqli_query($conn,$q9);
                    ?>
                    <select  class="form-select" name="brans">
                     <?php while($row9 = mysqli_fetch_assoc($result9)):?>
                        <option value="<?php echo htmlspecialchars(stripslashes(trim($row9['brans'])));?>"><?php echo htmlspecialchars(stripslashes(trim($row9['brans']))); ?></option>
                    <?php endwhile; ?>
                    </select>
                    </div>

                    <button type="submit" name="doktorkayit" class="btn btn-primary">Kaydet</button>
                </fieldset>
            </form>
        </div>



        <div class="col-6">
             <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                <fieldset>
                    <legend>Yeni Sekreter Kaydı</legend>
                    <div class="mb-3">
                    <label class="form-label">TC</label>
                    <input type="text" class="form-control" name="tc">
                    </div>
                    <div class="mb-3">
                    <label class="form-label">Ad</label>
                    <input type="text" class="form-control" name="ad">
                    </div>
                    <div class="mb-3">
                    <label class="form-label">Soyad</label>
                    <input type="text" class="form-control" name="soyad">
                    </div>
                    <div class="mb-3">
                    <label class="form-label">Sifre</label>
                    <input type="text" class="form-control" name="sifre">
                    </div>
                    <div class="mb-3">
                    <label class="form-label">Mail</label>
                    <input type="text" class="form-control" name="mail">
                    </div>
                    <div class="mb-3">
                    <label class="form-label">Tel No</label>
                    <input type="text" class="form-control" name="telno">
                    </div>
                    <div class="mb-3">
                    <label class="form-label">Adres</label>
                    <input type="text" class="form-control" name="adres">
                    </div>
                    <div class="mb-3">
                    <label class="form-label">Dogum (YYYY/AA/GG)</label>
                    <input type="text" class="form-control" name="dogum">
                    </div>

                    <button type="submit" name="sekreterkayit" class="btn btn-primary">Kaydet</button>
                </fieldset>
            </form>
        </div>



    </div>
</div>


<div class="container mt-5">
    <div class="row">
        <div class="col-6">
            <h2>Doktor'a Mail Gönder</h2>
            <form  action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
            <div class="form-floating">
                <textarea class="form-control" name="mailbaslik"></textarea>
                <label for="floatingTextarea" >Mail Başlığı</label>
            </div>
            <div class="form-floating mt-3">
                <textarea class="form-control" name="mailicerik" ></textarea>
                <label for="floatingTextarea">Mail İçeriği</label>
            </div>
            <select class="form-select mt-2" name="eleman" aria-label="Default select example">
                <?php
                $query = "select * from doktorlar;";
                $qresult = mysqli_query($conn,$query);
                ?>
                <?php while($row = mysqli_fetch_assoc($qresult)):?>
                <option value="<?php echo htmlspecialchars(stripslashes(trim($row['id']))); ?>"><?php echo htmlspecialchars(stripslashes(trim($row['ad'])))." ".htmlspecialchars(stripslashes(trim($row['soyad'])))." - ".htmlspecialchars(stripslashes(trim($row['brans']))); ?></option>
                <?php endwhile; ?>
            </select>
            <button type="submit" name="gonderdt" class="btn btn-primary text-center w-50 mt-2 float-end" >Tüm Doktorlara Gonder</button>
            <button type="submit" name="gonderd" class="btn btn-success text-center w-50 mt-2" >Mail Gonder</button>
            </form>
        </div>

        <div class="col-6">
            <h2>Sekretere'e Mail Gönder</h2>
            <form  action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
            <div class="form-floating">
                <textarea class="form-control" name="mailbaslik"></textarea>
                <label for="floatingTextarea" >Mail Başlığı</label>
            </div>
            <div class="form-floating mt-3">
                <textarea class="form-control" name="mailicerik" ></textarea>
                <label for="floatingTextarea">Mail İçeriği</label>
            </div>
            <select class="form-select mt-2" name="eleman" aria-label="Default select example">
            <?php
                $query = "select * from sekreterler;";
                $qresult = mysqli_query($conn,$query);
                ?>
                <?php while($row = mysqli_fetch_assoc($qresult)):?>
                <option value="<?php echo htmlspecialchars(stripslashes(trim($row['id']))); ?>"><?php echo htmlspecialchars(stripslashes(trim($row['ad'])))." ".htmlspecialchars(stripslashes(trim($row['soyad']))); ?></option>
                <?php endwhile; ?>
            </select>
            <button type="submit" name="gonderst" class="btn btn-primary text-center w-50 mt-2" >Tüm Sekreterlere Gonder</button>
            <button type="submit" name="gonders" class="btn btn-success text-center w-50 mt-2 float-end" >Mail Gonder</button>
            </form>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-12">
            <center><h1 class="mt-3">Toplu Mail Yolla</h1></center>
        <form  action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
            <div class="form-floating">
                <textarea class="form-control" name="mailbaslik"></textarea>
                <label for="floatingTextarea" >Mail Başlığı</label>
            </div>
            <div class="form-floating mt-3">
                <textarea class="form-control" name="mailicerik" ></textarea>
                <label for="floatingTextarea">Mail İçeriği</label>
            </div>
            <button type="submit" name="gondert" class="btn btn-warning text-center w-100 mt-2 float-end" >Toplu Mail Gonder</button>
            <a href="smtp.php"><button type="button" name="gondert" class="btn btn-danger text-center w-100 mt-3 float-end" >SMTP Ayarlarını Yapılandır</button></a>
            <a href="istatistik.php"><button type="button" name="gondert" class="btn btn-info text-center w-100 mt-3 float-end" >İstatistik Görüntüle</button></a>

            </form>
        </div>
    </div>
</div>



   <?php require "req.php" ?>

</body>
</html>

<?php
mysqli_close($conn);
?>