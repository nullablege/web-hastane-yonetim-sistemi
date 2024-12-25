<?php
session_start();
if(!isset($_SESSION['kurtarma'])){
    header("location:login.php");
}
require "mail.php";
echo '<div class="alert alert-danger text-center mt-0">Sayfayı Yenilerseniz İşleme Tekrardan Başlamak Zorunda Kalırsınız !</div>';
$kurtarma = "";

if((isset($_POST['girisbtn']) && $_SERVER['REQUEST_METHOD'] == 'POST') && isset($_COOKIE['forgotPassword'])){
    
    $kurtarma = htmlspecialchars(trim(stripcslashes($_POST['kurtar'])));
    if($kurtarma == $_SESSION['kurtarma']){
        $_SESSION['passed'] = 1;
        header("location:forgotpassword3.php");
    }
    else{
        $cooldownTime = 5;
        if (isset($_SESSION['last_action'])) {
            $lastActionTime = $_SESSION['last_action'];
            $currentTime = time();
                if (($currentTime - $lastActionTime) < $cooldownTime) {
                $remainingTime = $cooldownTime - ($currentTime - $lastActionTime);
                echo "<div class='alert alert-danger text-center mt-0'>İşlemlerinizin arasına biraz süre koymanız gerekmektedir.</div>";
            }
        }
        $_SESSION['last_action'] = time();
    }
}
if(!isset($_COOKIE['forgotPassword'])){
    header("location:login.php");
}




?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>Özel 327 Hastanesi</title>
    <link rel="icon" href="logo.png" type="image/x-icon">

    <style>
        .countdown {
            font-size: 2rem;
            font-weight: bold;
            color: #007bff;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="text-center">
            <div id="countdown" class="countdown">03:00</div>
        </div>
    </div>

    <div class="container mt-5">
    <div class="row">
    <div class="header text-center mb-3">
            <img src="https://i.ibb.co/xGzDqM9/logo.png" alt="Logo">
        </div>
        <div class="col-3 bos"></div>
        <div class="col-6">
            <form action="<?php echo $_SERVER['PHP_SELF'];?>" class="text-center" method="POST">
                <div class="mb-3">
                    <label for="exampleInputEmail1"  class="form-label">Kurtarma Kodu </label>
                    <input type="text" class="form-control" name="kurtar">
                </div>

                <button type="submit" name="girisbtn" class="btn btn-success w-100">Hesabı Kurtar</button>
            </form>
        </div>
        <div class="col-3 bos"></div>
    </div>
</div>

    <script>
timeLeft = 180;

        const countdownElement = document.getElementById('countdown');
        const resetButton = document.getElementById('resetButton');

        const countdownTimer = setInterval(() => {
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            countdownElement.textContent = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;

            if (timeLeft <= 0) {
                clearInterval(countdownTimer);
                countdownElement.textContent = "Zaman Doldu!";
                resetButton.style.display = 'block'; 
            } else {
                timeLeft--;
            }
        }, 1000);


    </script>
    <?php
    require "req.php";
    ?>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
