<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "iot_ambiente";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

$sql = "SELECT * FROM rilevazioni ORDER BY timestamp DESC LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode($row);
} else {
    echo "Nessun dato disponibile";
}

$conn->close();
?>
