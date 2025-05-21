<?php
// --- Configurazione API ---
$apiKey = "b625a7c2e2bc4f208f555826252105";

// --- Città supportate ---
$cittaDisponibili = ["Vicenza", "Bolzano"];
$citta = isset($_GET['citta']) && in_array($_GET['citta'], $cittaDisponibili) ? $_GET['citta'] : "Vicenza";

// --- Data selezionata o default a ieri ---
$data = isset($_GET['data']) ? $_GET['data'] : date('Y-m-d', strtotime('-1 day'));
$anno = date('Y', strtotime($data));
$mese = date('m', strtotime($data));

// --- Dati giornalieri API ---
$giornoUrl = "https://api.weatherapi.com/v1/history.json?key=$apiKey&q=$citta&dt=$data";
$giornoResponse = file_get_contents($giornoUrl);

// --- Dati mensili ---
$oggi = date('Y-m-d');
$fineMese = date('Y-m-t', strtotime($data));
$endDate = ($fineMese > $oggi) ? $oggi : $fineMese;

$meseUrl = "https://api.weatherapi.com/v1/history.json?key=$apiKey&q=$citta&dt={$anno}-{$mese}-01&end_dt=$endDate";
$meseResponse = file_get_contents($meseUrl);
?>

<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <title>Dati Storici Meteo</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
  <h2>Dati storici meteo</h2>

  <form method="GET">
    <label for="citta">Seleziona città:</label>
    <select name="citta" id="citta">
      <?php foreach ($cittaDisponibili as $nomeCitta): ?>
        <option value="<?php echo $nomeCitta; ?>" <?php echo $citta === $nomeCitta ? 'selected' : ''; ?>>
          <?php echo $nomeCitta; ?>
        </option>
      <?php endforeach; ?>
    </select>

    <label for="data">Seleziona una data:</label>
    <input type="date" id="data" name="data" max="<?php echo date('Y-m-d'); ?>" value="<?php echo $data; ?>">

    <button type="submit">Mostra dati</button>
  </form>

  <hr>

  <?php
  if ($giornoResponse !== false) {
      $data_json = json_decode($giornoResponse, true);
      $giorno = $data_json['forecast']['forecastday'][0]['day'];

      echo "<h3>Dati per $citta - Giorno: $data</h3>";
      echo "<ul>";
      echo "<li><strong>Condizione:</strong> " . $giorno['condition']['text'] . "</li>";
      echo "<li><strong>Temperatura Max:</strong> " . $giorno['maxtemp_c'] . " °C</li>";
      echo "<li><strong>Temperatura Min:</strong> " . $giorno['mintemp_c'] . " °C</li>";
      echo "<li><strong>Temperatura Media:</strong> " . $giorno['avgtemp_c'] . " °C</li>";
      echo "<li><strong>Umidità Media:</strong> " . $giorno['avghumidity'] . " %</li>";
      echo "</ul>";
  } else {
      echo "<p>Errore nel recupero dei dati giornalieri per $citta.</p>";
  }

  // --- Prepara dati per grafici ---
  $labels = [];
  $tempMax = [];
  $tempMin = [];
  $tempAvg = [];
  $pm25 = [];

  if ($meseResponse !== false) {
      $mese_data = json_decode($meseResponse, true);
      foreach ($mese_data['forecast']['forecastday'] as $day) {
          $labels[] = $day['date'];
          $tempMax[] = $day['day']['maxtemp_c'];
          $tempMin[] = $day['day']['mintemp_c'];
          $tempAvg[] = $day['day']['avgtemp_c'];
          $pm25[] = isset($day['day']['air_quality']['pm2_5']) ? $day['day']['air_quality']['pm2_5'] : null;
      }
  }
  ?>

  <h3>Grafico temperature - mese <?php echo "$mese/$anno"; ?> - <?php echo $citta; ?></h3>
  <canvas id="tempChart" width="600" height="300"></canvas>

  <h3>Grafico qualità dell'aria (PM2.5) - mese <?php echo "$mese/$anno"; ?> - <?php echo $citta; ?></h3>
  <canvas id="airChart" width="600" height="300"></canvas>

  <script>
    const labels = <?php echo json_encode($labels); ?>;
    const tempMax = <?php echo json_encode($tempMax); ?>;
    const tempMin = <?php echo json_encode($tempMin); ?>;
    const tempAvg = <?php echo json_encode($tempAvg); ?>;
    const pm25 = <?php echo json_encode($pm25); ?>;

    new Chart(document.getElementById('tempChart'), {
      type: 'line',
      data: {
        labels: labels,
        datasets: [
          { label: 'Max °C', data: tempMax, borderColor: 'red', fill: false },
          { label: 'Min °C', data: tempMin, borderColor: 'blue', fill: false },
          { label: 'Media °C', data: tempAvg, borderColor: 'orange', fill: false }
        ]
      },
      options: {
        responsive: true,
        scales: { y: { beginAtZero: false } }
      }
    });

    new Chart(document.getElementById('airChart'), {
      type: 'bar',
      data: {
        labels: labels,
        datasets: [
          { label: 'PM2.5', data: pm25, backgroundColor: 'green' }
        ]
      },
      options: {
        responsive: true,
        scales: { y: { beginAtZero: true } }
      }
    });
  </script>
</body>
</html>
