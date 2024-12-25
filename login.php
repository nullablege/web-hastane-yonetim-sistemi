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

    <link rel="icon" href="logo.png" type="image/x-icon">
    <style>
        .bos{
            height: 100%;
            width: 100%;
        }
    </style>
</head>
<body>
<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['girisbtn'])) {
    $tc = trim(stripslashes(htmlspecialchars($_POST['tc'])));
    $sifre = trim(stripslashes(htmlspecialchars($_POST['sifre'])));

    $conn = mysqli_connect("localhost", "root", "", "327hastanesi");
    mysqli_set_charset($conn, "utf8mb4");
    $query = "SELECT * FROM doktorlar WHERE tc = '$tc'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($sifre, $user['sifre'])) {

            $_SESSION['login'] = $tc;
            $_SESSION['doktor'] = 1;
            header("location:doktor.php");
            exit();
        }
    }
    $query = "SELECT * FROM sekreterler WHERE tc = '$tc'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($sifre, $user['sifre'])) {

            $_SESSION['login'] = $tc;
            $_SESSION['sekreter'] = 1;
            header("location:sekreter.php");
            exit();
        }
    }
    $query = "SELECT * FROM yonetici WHERE kadi = '$tc'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($sifre, $user['sifre'])) {

            $_SESSION['login'] = $tc;
            $_SESSION['yonetici'] = 1;
            header("location:admin.php");
            exit();
        }
    }

    echo '<div class="alert alert-danger text-center mt-0">Hatalı Giriş Denemesi</div>';
    mysqli_close($conn);
}



?>

    
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
                    <input type="text" class="form-control" name="tc" id="tc" aria-describedby="emailHelp">
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1"  class="form-label">Şifre</label>
                    <input type="password" name="sifre" class="form-control" id="exampleInputPassword1">
                </div>

                <button type="submit" name="girisbtn" class="btn btn-primary w-100">Giriş</button>
                <button type="button" id="recovery" class="btn btn-primary mt-2 w-100">Şifremi Unuttum</button>
            </form>
        </div>
        <div class="col-3 bos"></div>
    </div>
</div>

<?php



?>

<?php require "req.php";?>
<script>

        document.getElementById("recovery").addEventListener("click",()=>{
            window.location = "forgotpassword.php";
            const input = document.getElementById("tc").value;
            if (input.trim() !== "") {
                const cookieName = "tc";
                const cookieValue = input;
                const expirationTime = 10;
                
                const d = new Date();
                d.setTime(d.getTime() + (expirationTime * 1000)); 
                const expires = "expires=" + d.toUTCString();

                document.cookie = `${cookieName}=${cookieValue}; ${expires}; path=/`;
                
            }
        })

</script>
</body>
</html>