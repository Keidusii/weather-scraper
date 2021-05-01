<?php
    if ($_POST) {
        $city = $_POST["city"];
        $cityNoSpace = str_replace(" ", "-", $city);
        $content = file_get_contents("https://www.weather-forecast.com/locations/".$cityNoSpace."/forecasts/latest");
        
        $intro = "Weather for ".$city.":<br>";
        
        $file_headers = @get_headers("https://www.weather-forecast.com/locations/".$cityNoSpace."/forecasts/latest");
        if(!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found') {
            $exists = false;
        }
        else {
            $exists = true;
        }
        
        $pageArray = explode('(1&ndash;3 days)</div><p class="b-forecast__table-description-content"><span class="phrase">', $content);
        $secondPageArray = explode('</span></p></td>', $pageArray[1]);
        $weather = $secondPageArray[0];
        
        // max temp to F
        $weatherArray = explode("max", $weather);
        $weatherSecondArray = explode("°C", $weatherArray[1]);
        $weather = $weatherSecondArray[0];
        if ($weather[1] == "-") {
            if (is_numeric($weather[3])) {
                $temp = $weather[1].$weather[2].$weather[3];
            }
            else {
                $temp = $weather[1].$weather[2];
            }
            
        }
        else {
            if (is_numeric($weather[2])) {
                $temp = $weather[1].$weather[2];
            }
            else {
                $temp = $weather[1];
            }
        }
        
        $finalTemp = (int)$temp * 9 / 5 + 32;
        $finalTemp = round($finalTemp);
        $finalTemp = $finalTemp."&deg;F";
        $secondPageArray[0] = str_replace($temp."&deg;C", $finalTemp, $secondPageArray[0]);
        
        // min temp to F
        $weather = $secondPageArray[0];
        $weatherArray = explode("min", $weather);
        $weatherSecondArray = explode("°C", $weatherArray[1]);
        $weather = $weatherSecondArray[0];
        if ($weather[1] == "-") {
            if (is_numeric($weather[3])) {
                $temp = $weather[1].$weather[2].$weather[3];
            }
            else {
                $temp = $weather[1].$weather[2];
            }
            
        }
        else {
            if (is_numeric($weather[2])) {
                $temp = $weather[1].$weather[2];
            }
            else {
                $temp = $weather[1];
            }
        }
        
        $finalTemp = (int)$temp * 9 / 5 + 32;
        $finalTemp = round($finalTemp);
        $finalTemp = $finalTemp."&deg;F";
        $secondPageArray[0] = str_replace($temp."&deg;C", $finalTemp, $secondPageArray[0]);
    }


?>

<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Weather Scraper</title>

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
        <link rel="stylesheet" href="6-php/scraper.css">
    </head>
    <body>
        <h1>What's The Weather?</h1>
        <p>Enter the name of a city.</p>
        <form method="post">
            <div class="form-group">
                <input type="text" class="form-control" name="city" id="city" placeholder="Enter a city">
            </div>
            <button type="submit" class="btn btn-primary" id="submit">Submit</button>
        </form>
        
        <div id="content">
                <?php
                    if ($_POST && $exists == true) {
                        echo '<div id="report" class="alert alert-success" role="alert">'.$intro.$secondPageArray[0].'</div>';
                    } else if ($_POST && $exists == false) {
                        echo '<div id="report" class="alert alert-danger" role="alert">City not found, Try Again!</div>';
                    }
                    
                ?>
        </div>
        
        <!--Scripts-->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
        <script src="6-php/ws.js"></script>
    </body>
</html>