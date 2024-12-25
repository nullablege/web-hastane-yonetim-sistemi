<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "327hastanesi");
mysqli_set_charset($conn, "utf8mb4");
if(!isset($_SESSION['passed'])){
     header("location:login.php");
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

    <style>
        .bos{
            height: 100%;
            width: 100%;
        }
    </style>
</head>

<?php
$ys ="";
$ys1 = "";

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['girisbtn'])){
    $ys = htmlspecialchars(trim($_POST['ys'])); 
    $ys1 = htmlspecialchars(trim($_POST['ys1']));
    if(!($ys === $ys1)){
        echo "<div class='alert alert-danger text-center mt-0'>Şifrelerin aynı olması gerekir.</div>";
    }
    elseif(empty($ys) || empty($ys1)){
        echo "<div class='alert alert-danger text-center mt-0'>Şifrelerin ikisinin de doldurulması gerekir.</div>";
    }
    elseif(strlen($ys)<=8){
        echo "<div class='alert alert-danger text-center mt-0'>Şifrenin en az 8 karakter olması gerekir.</div>";
    }
    elseif(!preg_match('/[A-Z]/', $ys)){
        echo "<div class='alert alert-danger text-center mt-0'>Şifrenizin en az 1 Büyük harf içermesi gerekmektedir..</div>";
    }
    elseif(!preg_match('/[a-z]/', $ys)){
        echo "<div class='alert alert-danger text-center mt-0'>Şifrenizin en az 1 Küçük harf içermesi gerekmektedir..</div>";
    }
    elseif(!preg_match('/[0-9]/', $ys)){
        echo "<div class='alert alert-danger text-center mt-0'>Şifrenizin en az 1 Rakam içermesi gerekmektedir.</div>";
    }
    else{
        $conn = mysqli_connect("localhost","root","","327hastanesi");
        mysqli_set_charset($conn, "utf8mb4");
        $hashli = password_hash($ys,PASSWORD_DEFAULT);
        $query = "update ". $_SESSION['tablo']." set sifre='$hashli' where tc = '".$_SESSION['forgotPassword']."';";
        $result = mysqli_query($conn,$query);
        if($result && mysqli_affected_rows($conn)==1){
            session_destroy();
            header("location:login.php");
        }
    }
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
                    <label for="exampleInputEmail1"  class="form-label">Yeni Şifre :  </label>
                    <input type="text" class="form-control" name="ys" id="ys">
                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1"  class="form-label">Yeni Şifre Onay :  </label>
                    <input type="text" class="form-control" name="ys1" id="ys1">
                </div>

                <button type="submit" name="girisbtn" disabled id="btn" class="btn btn-success w-100">Hesabı Kurtar</button>
            </form>
        </div>
        <div class="col-3 bos"></div>
    </div>
</div>
            <?php require "req.php"?>

<script>
    ys = document.getElementById("ys");
    ys1 = document.getElementById("ys1");
    btn = document.getElementById("btn");

    ys.addEventListener("change",()=>{
        if(ys.value == ys1.value)
            btn.disabled = false;
    })
    ys1.addEventListener("change",()=>{
        if(ys.value == ys1.value)
            btn.disabled = false;
    })
</script>
</body>
</html>
<?php mysqli_close($conn); ?>