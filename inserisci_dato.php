<?php
$servername = "localhost";
$username = "root"; // cambia se usi un altro utente
$password = "";
$dbname = "iot_ambiente";

// Ricevi dati via GET o POST
$temperatura = $_GET['temperatura'];
$qualita_aria = $_GET['qualita_aria'];
$umidita = $_GET['umidita'];

// Connessione
$conn = new mysqli($servername, $username, $password, $dbname);

// Controllo
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

// Inserimento
$sql = "INSERT INTO rilevazioni (temperatura, qualita_aria, umidita) 
        VALUES ('$temperatura', '$qualita_aria', '$umidita')";

if ($conn->query($sql) === TRUE) {
    echo "Dati inseriti correttamente";
} else {
    echo "Errore: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
