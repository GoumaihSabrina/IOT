<?php
$cittaDisponibili = ["Vicenza", "Bolzano"];
$citta = $_GET['citta'] ?? "Vicenza";

// --- Recupera i dati correnti della città da WeatherAPI ---
$apiKey = "b625a7c2e2bc4f208f555826252105";
$url = "http://api.weatherapi.com/v1/current.json?key=$apiKey&q=$citta&aqi=yes";
$response = file_get_contents($url);
$data = json_decode($response, true);

$errore = false;
$temperatura = $umidita = $pm25 = $pm10 = $temp_min = $temp_max = null;

if ($data && isset($data['current'])) {
    $temperatura = $data['current']['temp_c'];
    $umidita = $data['current']['humidity'];
    $pm25 = $data['current']['air_quality']['pm2_5'] ?? 10.0;
    $pm10 = $data['current']['air_quality']['pm10'] ?? 15.0;
    $temp_min = $temperatura - 3;
    $temp_max = $temperatura + 3;

    // --- Chiamata allo script Python con i dati correnti ---
    $comando = escapeshellcmd("python3 predict.py $temp_min $temp_max $temperatura $umidita $pm25 $pm10");
    $output = shell_exec($comando);
    $risultato = json_decode($output, true);
} else {
    $errore = true;
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Previsione AI - Domani</title>
    <style>
        body { font-family: Arial; margin: 2rem auto; max-width: 600px; }
        .box { padding: 20px; background: #f2f2f2; border-left: 5px solid #007acc; margin-top: 20px; }
        .button {
            background: #007acc;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            margin-top: 20px;
        }
        .button:hover { background-color: #005f99; }
        select, button { padding: 8px; }
    </style>
</head>
<body>

<h2>Previsione IA - Temperatura per Domani</h2>

<form method="get">
    <label for="citta">Seleziona città:</label>
    <select name="citta" id="citta">
        <?php foreach ($cittaDisponibili as $nome): ?>
            <option value="<?= $nome ?>" <?= $citta === $nome ? 'selected' : '' ?>><?= $nome ?></option>
        <?php endforeach; ?>
    </select>
    <button type="submit">Mostra Previsione</button>
</form>

<?php if ($errore): ?>
    <p><strong>Errore:</strong> Impossibile ottenere i dati per <?= htmlspecialchars($citta) ?>.</p>
<?php elseif (isset($risultato['temperatura_prevista'])): ?>
    <div class="box">
        <p><strong>Città:</strong> <?= htmlspecialchars($citta) ?></p>
        <p><strong>Data previsione:</strong> <?= date('Y-m-d', strtotime('+1 day')) ?></p>
        <p><strong>Temperatura prevista:</strong> <?= $risultato['temperatura_prevista'] ?> °C</p>
        <p><em>(Stima basata su: Temp. attuale <?= $temperatura ?>°C, Umidità <?= $umidita ?>%, PM2.5 <?= $pm25 ?>, PM10 <?= $pm10 ?>)</em></p>
    </div>
<?php endif; ?>

<a href="index.php" class="button">Torna alla Home</a>

</body>
</html>
