<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "iot_ambiente";

// Connessione al database
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

// Query: puoi filtrare per città o periodo se vuoi
$sql = "SELECT timestamp, temperatura FROM rilevazioni ORDER BY timestamp ASC";
$result = $conn->query($sql);

// Preparazione array PHP -> JS
$timestamps = [];
$temperatures = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $timestamps[] = $row['timestamp'];
        $temperatures[] = $row['temperatura'];
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Storico delle Temperature</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: sans-serif;
            padding: 20px;
            background: #f9f9f9;
        }
        h1 {
            text-align: center;
        }
        .chart-container {
            width: 90%;
            max-width: 800px;
            margin: 30px auto;
            background: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>

    <h1>Storico delle Temperature Rilevate</h1>

    <div class="chart-container">
        <canvas id="temperatureChart"></canvas>
    </div>

    <script>
        const ctx = document.getElementById('temperatureChart').getContext('2d');
        const temperatureChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?= json_encode($timestamps) ?>,
                datasets: [{
                    label: 'Temperatura (°C)',
                    data: <?= json_encode($temperatures) ?>,
                    borderColor: 'rgba(255, 99, 132, 1)',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    fill: true,
                    tension: 0.4,
                    pointRadius: 2
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Data e ora'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Temperatura (°C)'
                        },
                        beginAtZero: false
                    }
                }
            }
        });
    </script>

</body>
</html>
