<?php
$apiKey = "b625a7c2e2bc4f208f555826252105"; // Sostituisci con la tua chiave
$city = "Vicenza";
$url = "http://api.weatherapi.com/v1/current.json?key=$apiKey&q=$city&aqi=yes";

// Invia la richiesta
$response = file_get_contents($url);

// Controlla se la richiesta è riuscita
if ($response !== false) {
    $data = json_decode($response, true);

    // Dati meteo
    echo "Condizione meteo: " . $data['current']['condition']['text'] . "\n";
    echo "Temperatura (°C): " . $data['current']['temp_c'] . "\n";

    // Dati qualità dell'aria
    echo "Qualità dell'aria (PM2.5): " . $data['current']['air_quality']['pm2_5'] . "\n";
    echo "Qualità dell'aria (PM10): " . $data['current']['air_quality']['pm10'] . "\n";
    echo "CO: " . $data['current']['air_quality']['co'] . "\n";
    echo "NO2: " . $data['current']['air_quality']['no2'] . "\n";
    echo "O3: " . $data['current']['air_quality']['o3'] . "\n";
} else {
    echo "Errore nella richiesta API.";
}
?>
