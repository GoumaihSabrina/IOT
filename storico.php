<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "iot_ambiente";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

$sql = "SELECT * FROM rilevazioni ORDER BY timestamp DESC";
$result = $conn->query($sql);

$rows = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
    echo json_encode($rows);
} else {
    echo "[]";
}

$conn->close();
?>
