<?php
session_start();
if(!isset($_SESSION['login']) && !isset($_SESSION['yonetici'])){
    header("Location: login.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "327Hastanesi";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "
    SELECT doktorlar.brans AS branch_name, COUNT(randevular.id) AS reservation_count 
    FROM randevular 
    JOIN doktorlar ON randevular.doktortc = doktorlar.tc 
    WHERE randevular.hastatc <> '' 
    GROUP BY doktorlar.brans";

$result = $conn->query($sql);
$data = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            "branch" => $row["branch_name"],
            "count" => (int)$row["reservation_count"]
        ];
    }
}

$conn->close();

$data_json = json_encode($data);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Özel 327 Hastanesi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="text-center mb-4">Branş Randevu İstatistikleri</h2>

    <div class="d-flex justify-content-end mb-3">
        <button id="toggleChart" class="btn btn-secondary me-2">Grafiği Değiştir</button>
        <a href="admin.php" class="btn btn-primary">Ana Menüye Dön</a>
    </div>

    <div class="card">
        <div class="card-body">
            <canvas id="chart"></canvas>
        </div>
    </div>
</div>

<script>
    let chartType = 'bar'; 
    let chart; 

     const data = <?php echo $data_json; ?>;
    
    const labels = data.map(item => item.branch);
    const counts = data.map(item => item.count);

    function renderChart() {
        if (chart) {
            chart.destroy();
        }
        
        const ctx = document.getElementById('chart').getContext('2d');
        chart = new Chart(ctx, {
            type: chartType,
            data: {
                labels: labels,
                datasets: [{
                    label: 'Günlük Randevu Sayısı',
                    data: counts,
                    backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b', '#858796', '#1cc88a', '#fd7e14', '#20c997'],
                    borderColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b', '#858796', '#1cc88a', '#fd7e14', '#20c997'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    }

    document.getElementById('toggleChart').addEventListener('click', function() {
        chartType = chartType === 'bar' ? 'pie' : 'bar';
        renderChart();
    });

    renderChart();
</script>

</body>
</html>
