<?php
session_start();
if (!isset($_SESSION['login']) || !isset($_SESSION['doktor'])) {
    header("Location:login.php");
    exit();


}
$class = "";
require "req.php";
$doktorTc = $_SESSION['login'];
$conn = mysqli_connect("localhost", "root", "", "327Hastanesi");
mysqli_set_charset($conn, "utf8mb4");

$query = "SELECT * FROM randevular WHERE doktortc='$doktorTc';";
$result = mysqli_query($conn, $query);



if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['detayGoster'])){
    $_SESSION['randevu'] = $_POST['randevu_id'];
     header("Location:randevularDetay.php");
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
            <img src="https://i.ibb.co/xGzDqM9/logo.png" alt="Logo" width="100" height="40" class="d-inline-block align-text-top">
        </a>
        <a href="doktor.php" class="float-start"><button class="btn btn-warning">Geri Dön</button></a>
    </div>
</nav>

<div class="container">
    <div class="row">
        <div class="col-12">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Doktor</th>
                        <th scope="col">Brans</th>
                        <th scope="col">Hasta</th>
                        <th scope="col">Randevu Detayları</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <?php
                    $hastaTc = $row['hastatc'];
                    $doktorTc = $row['doktortc'];

                    $hastaQuery = "SELECT * FROM hastalar WHERE tc='$hastaTc';";
                    $hastaResult = mysqli_query($conn, $hastaQuery);
                    $hastaData = mysqli_fetch_assoc($hastaResult);

                    $doktorQuery = "SELECT * FROM doktorlar WHERE tc='$doktorTc';";
                    $doktorResult = mysqli_query($conn, $doktorQuery);
                    $doktorData = mysqli_fetch_assoc($doktorResult);


                    $hastaAd = isset($hastaData['ad']) ? htmlspecialchars(trim($hastaData['ad'])) : 'Randevu Verilmedi';
                    $hastaSoyad = isset($hastaData['soyad']) ? htmlspecialchars(trim($hastaData['soyad'])) : 'Randevu Verilmedi';
                    $doktorAd = isset($doktorData['ad']) ? htmlspecialchars(trim($doktorData['ad'])) : 'Randevu Verilmedi';
                    $doktorSoyad = isset($doktorData['soyad']) ? htmlspecialchars(trim($doktorData['soyad'])) : 'Randevu Verilmedi';
                    $doktorBrans = isset($doktorData['brans']) ? htmlspecialchars(trim($doktorData['brans'])) : 'Randevu Verilmedi';
                    ?>
                    <tr>
                        <th scope="row"><?php echo htmlspecialchars(trim(stripslashes($row['id']))); ?></th>
                        <td><?php echo htmlspecialchars(trim(stripslashes($doktorAd))) . ' ' . htmlspecialchars(trim(stripslashes($doktorSoyad))); ?></td>
                        <td><?php echo htmlspecialchars(trim(stripslashes($doktorBrans))); ?></td>
                        <td><?php echo htmlspecialchars(trim(stripslashes($hastaAd))) . ' ' . htmlspecialchars(trim(stripslashes($hastaSoyad))); ?></td>
                        <td>

                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" style="display: inline;">
                                    <input type="hidden" name="randevu_id" value="<?php echo htmlspecialchars(trim(stripslashes($row['id']))); ?>">
                                    <button type="submit" name="detayGoster" class="btn btn-primary">Detay</button>
                                </form>                       
                         </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>
<?php mysqli_close($conn); ?>