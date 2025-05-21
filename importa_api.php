<?php
// --- Impostazioni API ---
$apiKey = "b625a7c2e2bc4f208f555826252105"; // Chiave API
$city = "Vicenza";
$url = "http://api.weatherapi.com/v1/current.json?key=$apiKey&q=$city&aqi=yes";

// --- Richiesta API ---
$response = file_get_contents($url);

if ($response !== false) {
    $data = json_decode($response, true);

    // Estrazione dati
    $temperatura = $data['current']['temp_c'];
    $qualita_aria = $data['current']['air_quality']['pm2_5'];
    $umidita = $data['current']['humidity']; // Aggiungi anche nel DB se non presente

    // --- Connessione DB ---
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "iot_ambiente";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connessione fallita: " . $conn->connect_error);
    }

    // Query inserimento
    $sql = "INSERT INTO rilevazioni (temperatura, qualita_aria, umidita)
            VALUES ('$temperatura', '$qualita_aria', '$umidita')";

    if ($conn->query($sql) === TRUE) {
        echo "Dati importati con successo dal meteo API!";
    } else {
        echo "Errore nella query: " . $conn->error;
    }

    $conn->close();
} else {
    echo "Errore nella richiesta API.";
}
?>
