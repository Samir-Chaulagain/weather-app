<?php
    header("Access-Control-Allow-Origin: *");
    $mysqli=new mysqli("localhost","root","","db_2066031");
    // Select weather data for given parameters
        $sqli = "SELECT *
        FROM weather
        WHERE 
        weather_when >= DATE_SUB(NOW(), INTERVAL 3600 SECOND)
        ORDER BY weather_when DESC limit 1";
        $result = $mysqli -> query($sqli);

        // If 0 record found

        if ($result->num_rows == 0) {
        $url = 'https://api.openweathermap.org/data/2.5/weather?q=portland&appid=26315953eb0e8ff39b023cee9fa8fe0a';
        // Get data from openweathermap and store in JSON object
        $data = file_get_contents($url);
        $json = json_decode($data, true);

        // Fetch required fields
        
        $description = $json['weather'][0]['description'];
        $temp = $json['main']['temp'];
        $wind = $json['wind']['speed'];
        $wind_Deg=$json['wind']['deg'];
        $pressure=$json['main']['pressure'];
        $humidity=$json['main']['humidity'];
        $city = $json['name'];

        // Build INSERT SQL statement
        $sql = "INSERT INTO weather (weather_description, weather_temperature, weather_wind, wind_Deg, pressure, Humidity, city)
        VALUES('{$description}', '{$temp}', '{$wind}', '{$wind_Deg}', '{$pressure}', '{$humidity}', '{$city}')";
        
        // Run SQL statement and report errors
        if (!$mysqli -> query($sql)) {
        echo("<h4>SQL error description: " . $mysqli -> error . "</h4>");

        }
        }
?>