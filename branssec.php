<!DOCTYPE html>
<html lang="en">

<?php
session_start();
if(!(isset($_SESSION['login']) && isset($_SESSION['sekreter']))){
    header("Location:login.php");
    exit();
}
if(!isset($_SESSION['randevu'])){
     header("Location:sekreter.php");
}

?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Özel 327 Hastanesi</title>
    <link rel="icon" href="logo.png" type="image/x-icon">

</head>

<body>
    <?php 
    require "req.php";
    $conn = mysqli_connect("localhost","root","","327Hastanesi");
    mysqli_set_charset($conn, "utf8mb4");
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['branssec'])){
        $_SESSION['brans'] = $_POST['brans'];
        header("Location: randevual.php");
        exit();
    }
    ?>
    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
        <div class="container mt-5">
            <div class="row">
                <div class="col-6">
                    <div class="mb-3">
                        <label for="" class="form-label">Brans Seç</label>
                        <select class="form-select form-select-lg" name="brans">
                            <?php
                                $q = "select * from branslar;";
                                $r = mysqli_query($conn,$q);
                                ?>
                            <?php while($row = mysqli_fetch_assoc($r)): ?>
                            <option value="<?php echo htmlspecialchars(trim(stripslashes($row['brans']))); ?>">
                                <?php echo htmlspecialchars(trim(stripslashes($row['brans']))); ?>
                            </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100" name="branssec">Brans Sec</button>
    </form>

            </div>
        </div>
    </div>
</body>

</html>
<?php mysqli_close($conn);?>