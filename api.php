<?php
$apiKey = "b625a7c2e2bc4f208f555826252105 ";


$url = "http://api.weatherapi.com/v1/current.json?key=$apiKey&q=$city&aqi=yes";


$response = file_get_contents($url);


if ($response !== false) {
    $data = json_decode($response, true);


    echo "📍 Location: " . $data['location']['name'] . ", " . $data['location']['country'] . "\n";
    echo "🌤️ Weather condition: " . $data['current']['condition']['text'] . "\n";
    echo "🌡️ Temperature: " . $data['current']['temp_c'] . " °C\n";

   
    echo "🫁 Air Quality:\n";
    echo "   - PM2.5: " . $data['current']['air_quality']['pm2_5'] . "\n";
    echo "   - PM10: " . $data['current']['air_quality']['pm10'] . "\n";
    echo "   - CO (Carbon Monoxide): " . $data['current']['air_quality']['co'] . "\n";
    echo "   - NO₂ (Nitrogen Dioxide): " . $data['current']['air_quality']['no2'] . "\n";
    echo "   - O₃ (Ozone): " . $data['current']['air_quality']['o3'] . "\n";
} 

else {
    echo "❌ Error: Unable to get data from WeatherAPI.";
}
?>
