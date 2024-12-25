<?php
session_start();

if(isset($_SESSION['login'])){
    if(isset($_SESSION['doktor'])){
        header("Location:doktor.php");
        exit();
    }
    if(isset($_SESSION['sekreter'])){
        header("Location:sekreter.php");
        exit();
    }
    if(isset($_SESSION['yonetici'])){
        header("Location:admin.php");
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

<?php
require "mail.php";
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['girisbtn'])){
    $tc = trim(stripslashes(htmlspecialchars($_POST['tc'])));
    $conn = mysqli_connect("localhost","root","","327hastanesi");
    mysqli_set_charset($conn, "utf8mb4");
    $query = "select * from doktorlar where tc='$tc'";
    $result = mysqli_query($conn,$query);
    if($result && mysqli_affected_rows($conn)==1){
        setcookie("forgotPassword",$tc,time()+600);
        $row = mysqli_fetch_assoc($result);
        $email = $row['mail'];
        $_SESSION['forgotPassword'] = $tc;
        $_SESSION['tablo'] = "doktorlar";
        $_SESSION['kurtarma'] =  sifreUnuttum($email);  
        header("location:forgotpassword2.php");
    }
    else{
        $query = "select * from sekreterler where tc='$tc'";
        $result = mysqli_query($conn,$query);
        if($result && mysqli_affected_rows($conn)==1){
        setcookie("forgotPassword",$tc,time()+600);
        $row = mysqli_fetch_assoc($result);
        $email = $row['mail'];
        $_SESSION['forgotPassword'] = $tc;
        $_SESSION['tablo'] = 'sekreterler';
        $_SESSION['kurtarma'] =  sifreUnuttum($email);
        header("location:forgotpassword2.php");
        }
        else{
            echo "<div class='alert alert-danger text-center mt-0'>Hatalı TC</div>";
        }
    }
    mysqli_close($conn);
}
?>

<?php
$ck = "";
if(isset($_COOKIE['tc'])){
    $ck = $_COOKIE['tc'];
}
?>
<body>
<div class="container mt-5">
    <div class="row">
    <div class="header text-center mb-3">
            <img src="https://i.ibb.co/xGzDqM9/logo.png" alt="Logo">
        </div>
        <div class="col-3 bos"></div>
        <div class="col-6">
            <form action="<?php echo $_SERVER['PHP_SELF'];?>" class="text-center" method="POST">
                <div class="mb-3">
                    <label for="exampleInputEmail1"  class="form-label">TC</label>
                    <input type="text" class="form-control" value="<?php echo htmlspecialchars(trim(stripslashes($ck))); ?>" name="tc" id="exampleInputEmail1" aria-describedby="emailHelp">
                </div>

                <button type="submit" name="girisbtn" class="btn btn-danger w-100">Şifre Sıfırlama Bağlantısı Yolla</button>
            </form>
        </div>
        <div class="col-3 bos"></div>
    </div>
</div>
<?php require "req.php";?>
</body>
</html>