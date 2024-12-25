
<?php
session_start();
$conn = mysqli_connect("localhost","root","","327Hastanesi");
mysqli_set_charset($conn, "utf8mb4");
require "req.php";
if(!(isset($_SESSION['randevu']) && $_SESSION['brans'])){
    header("Location: sekreter.php");
}

if(isset($_POST['doktorsec']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
    $_SESSION['doktor'] = $_POST['doktor'];
    header("Location:tarihsec.php");
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
<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
        <div class="container mt-5">
            <div class="row">
                <div class="col-6">
                    <div class="mb-3">
                        <label for="" class="form-label">Doktor Seç</label>
                        <select class="form-select form-select-lg" name="doktor">
                            <?php
                                $brans = $_SESSION['brans'];
                                $q = "select * from doktorlar where brans = '$brans';";
                                $r = mysqli_query($conn,$q);
                                ?>
                            <?php while($row = mysqli_fetch_assoc($r)): ?>
                            <option value="<?php echo htmlspecialchars(trim(stripslashes($row['tc']))); ?>">
                                <?php echo htmlspecialchars(trim(stripslashes($row['ad']." ".$row['soyad']))); ?>
                            </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100" name="doktorsec">Doktor Seç</button>
    </form>
</body>
</html>

<?php mysqli_close($conn); ?>