<?php
// Parametri da query string o form
$min = $_GET['min'] ?? null;
$max = $_GET['max'] ?? null;
$avg = $_GET['avg'] ?? null;
$hum = $_GET['hum'] ?? null;
$pm25 = $_GET['pm25'] ?? null;
$pm10 = $_GET['pm10'] ?? null;

// Controllo campi obbligatori
if (!$min || !$max || !$avg || !$hum || !$pm25 || !$pm10) {
    http_response_code(400);
    echo json_encode(["errore" => "Parametri mancanti"]);
    exit;
}

// Comando shell
$comando = escapeshellcmd("python3 predict.py $min $max $avg $hum $pm25 $pm10");
$output = shell_exec($comando);

// Mostra risultato
header('Content-Type: application/json');
echo $output;
?>
