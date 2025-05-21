<?php
require_once 'config.php';

function getWeatherData($city) {
    $apiKey = "b625a7c2e2bc4f208f555826252105" ;
    $url = "http://api.weatherapi.com/v1/current.json?key=$apiKey&q=$city&aqi=yes";
    $response = file_get_contents($url);
    if ($response !== false) {
        return json_decode($response, true);
    } else {
        return null;
    }
}
?>
