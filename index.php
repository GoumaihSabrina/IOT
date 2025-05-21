<?php
require_once 'meteo.php';

$city1 = "Vicenza";
$city2 = "Bolzano";

$data1 = getWeatherData($city1);
$data2 = getWeatherData($city2);
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Meteo</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php foreach ([['data' => $data1, 'label' => 'Vicenza'], ['data' => $data2, 'label' => 'Bolzano']] as $cityInfo): 
    $d = $cityInfo['data'];
    if (!$d) continue;
?>
    <div class="card">
        <div class="city"><?= htmlspecialchars($d['location']['name']) ?>, <?= htmlspecialchars($d['location']['country']) ?></div>
        
        <div class="section">
            <div class="label">Condizione meteo:</div>
            <div class="value"><?= htmlspecialchars($d['current']['condition']['text']) ?></div>
            <div class="label">Temperatura:</div>
            <div class="value"><?= $d['current']['temp_c'] ?> °C</div>
        </div>

        <div class="section air">
            <div class="label">Qualità dell'aria (µg/m³):</div>
            <div class="value">PM2.5: <?= round($d['current']['air_quality']['pm2_5'], 1) ?></div>
            <div class="value">PM10: <?= round($d['current']['air_quality']['pm10'], 1) ?></div>
            <div class="value">CO: <?= round($d['current']['air_quality']['co'], 1) ?></div>
            <div class="value">NO₂: <?= round($d['current']['air_quality']['no2'], 1) ?></div>
            <div class="value">O₃: <?= round($d['current']['air_quality']['o3'], 1) ?></div>
        </div>
    </div>
<?php endforeach; ?>

</body>
</html>
