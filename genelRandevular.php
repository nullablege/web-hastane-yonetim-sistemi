<?php
session_start();
if(!isset($_SESSION['login']) || !isset($_SESSION['sekreter'])){
    header("Location: login.php");
    exit();
}
require "req.php";
$conn = mysqli_connect("localhost","root","","327Hastanesi");
mysqli_set_charset($conn, "utf8mb4");

$query = "SELECT * FROM randevular ;";
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
        <a href="sekreter.php" class="float-start"><button class="btn btn-warning">Geri Dön</button></a>
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
                        <th scope="col">Branş</th>
                        <th scope="col">Hasta</th>
                        <th scope="col">Randevu Detayları</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($result)): ?>
                        <?php
                        $hastaTc = $row['hastatc'];
                        $doktorTc = $row['doktortc'];

                        $hastaQuery = "SELECT * FROM hastalar WHERE tc='$hastaTc';";
                        $hastaResult = mysqli_query($conn, $hastaQuery);
                        $hasta = mysqli_fetch_assoc($hastaResult);

                        $doktorQuery = "SELECT * FROM doktorlar WHERE tc='$doktorTc';";
                        $doktorResult = mysqli_query($conn, $doktorQuery);
                        $doktor = mysqli_fetch_assoc($doktorResult);
                        ?>

                        <tr 
                            <?php 
                                if ($row['kapali'] == 1) {
                                    echo "class='bg-danger'";
                                } elseif (empty($row['hastatc'])) {
                                    echo "class='bg-info'";
                                }
                            ?>
                        >
                            <th scope="row"><?php echo htmlspecialchars(trim($row['id'])); ?></th>
                            <td><?php echo isset($doktor) ? htmlspecialchars(trim($doktor['ad'] . " " . $doktor['soyad'])) : "Randevu Verilmemiş"; ?></td>
                            <td><?php echo isset($doktor) ? htmlspecialchars(trim($doktor['brans'])) : ""; ?></td>
                            <td><?php echo isset($hasta) ? htmlspecialchars(trim($hasta['ad'] . " " . $hasta['soyad'])) : "Randevu Verilmemiş"; ?></td>
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
