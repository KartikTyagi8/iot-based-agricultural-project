<?php
    session_start();
    if(!isset($_SESSION['email'])) {
        header("Location: login_page.php");
        exit();
    }
    else{
        $boardid = $_GET['boardid'];
    }
?>
<!DOCTYPE html>
<html >
<head>
    <meta http-equiv="refresh" content="10" url="board_information.php">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="assets/board_information.css">
    <link rel="stylesheet" href="assets/style.css">
    <link rel="stylesheet" href="assets/utils.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
    
    
    <title>User Dashboard</title>
</head>
<body>
<?php

    $host = 'localhost'; // replace with your database host
    $username = 'root'; // replace with your database username
    $password = ''; // replace with your database password
    $database = 'onion_farming_solutions'; // replace with your database name
    $conn = mysqli_connect($host, $username, $password, $database);
    if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
    }
    $boardid = $_GET['boardid'];
    // Query the database for projects
    $sql = "SELECT * FROM boards where boardid = '$boardid'";
    $result = mysqli_query($conn, $sql);

    $row = mysqli_fetch_assoc($result);
    $channelid = $row['channelid'];
    $apikey = $row['apikey'];

?>

  <div class="container flex">
    <div class="sidebar flex flex-direction-column">
      <section class="company-info">
        <img src="assets/img/logo.png" style="margin-top:10px; margin-left:5px; margin-right:10px;" alt="company-logo">
        <span style="font-size: 27px;">Sensor Flow</span>
      </section>
      <ul class="items flex flex-direction-column " style="list-style: none;">
        <li onclick="goToDashBoard()" style="cursor:pointer;">My Dashboard</li>
        <li style="cursor:pointer;">My Projects</li>
        <li>
          <form method="POST" action="logout.php">
          <input type="submit" name="logout" value="Logout" style="width:100px; height:30px; font-size:15px; font-weight: bold; background-color:#DADE00; border:1px solid transparent; cursor:pointer;">
    </form></li>
      </ul>
      <div class="user-info justify-center item-center" >
        <div class="flex">
          <img src="assets/img/user_image.png" style="height: 40px; width: 40px; border-radius: 50%; margin-right: 5px;" alt="">
          <ul style="list-style: none;">
          <?php
            $host = 'localhost'; // replace with your database host
            $username = 'root'; // replace with your database username
            $password = ''; // replace with your database password
            $database = 'onion_farming_solutions'; // replace with your database name
            $email = $_SESSION['email'];
            $conn = mysqli_connect($host, $username, $password, $database);
            if (!$conn) {
              die("Database connection failed: " . mysqli_connect_error());
            }

            $sql = "SELECT firstname,lastname FROM users where email = '$email'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result);
            echo "<li style='font-size: 16px'>$row[firstname] $row[lastname]</li>
            <li style='font-size: 14px;'>$email</li>"
            ?>
          </ul>
        </div>
      </div>
      
    </div>
    <div class="main-box">
      <div class="dashboard-header flex space-between justify-center item-center" style="height: 45px; justify-content:right;">
        <span class="material-symbols-outlined" style="size: 25px; color: grey; font-size:30px;"> notifications</span>
      </div>
      <nav class="flex space-between" style="margin: 5px 30px;">
        <span style="font-size: 24px; font-weight: 80; padding-top: 5px; margin-left: 33px;">
            RACK INFORMATION
    </span>
      </nav>

      <div class="container-projects" style="padding: 20px 20px; flex-wrap: wrap;height: 437px; margin: 10px 60px; border: 1px solid grey; box-shadow: 0 0 5px rgba(0, 0, 0, 0.5); align-items: stretch; ">
            <ul class="flex" style="list-style:none;">
                <li class="data-representation" style="background-color: #e0ebff; color: #2472ff">&#x2022; Good </li>
                <li class="data-representation" style="background-color: #fdffa3; color: #5e6100;">&#x2022; Warning </li>
                <li class="data-representation" style="background-color: #ffd3d2; color: #f71300;">&#x2022; Alert </li>
            </ul>
                

                <div class="sensor-representation flex" style="justify-content: space-around; margin-top:15px;">
                
                <div class="humidity-data-show">
                    <div class="humid-text-icon flex justify-center item-center" style="margin-bottom:38px">
                    <div class="circle" style="margin:5px 10px; height:40px; width:40px; border:1px solid black;border-radius: 50%; background-color:#EDF9F7;"><span class='material-symbols-outlined' style='font-size: 40px; color: black;'> ac_unit</span></div>
                    <div class="text-humidity" style="margin-left:10px">
                        <p style="font-size:18px; font-weight:200px;"> HUMIDITY </p>
                        <span>Status:</span>
                        <span class="humidity-status"></span>
                    </div>
                    </div>
                    
                <div class="speedometer-container">
                <div class="humidity-warning-div" >
            <div class="warning-pointy-container">Warning</div>
            <div class="warning-pointer-small"></div>
        </div>
        <div class="humidity-alert-div" >
          <div class="alert-pointy-container">Alert</div>
          <div class="alert-pointer-small"></div>
      </div>
      <div class="speedometer-text">
          <span class="value">
          <?php
                        
                        $url = "https://api.thingspeak.com/channels/{$channelid}/fields/2/last.json?api_key={$apikey}";
                        $data = file_get_contents($url);
                        $data = json_decode($data, true);

                        $humidity = $data['field2'];
                        $humidity = number_format($humidity,1);
                        echo "$humidity";
                        
                    ?>
          </span>
          <span class="unit">%</span>
      </div>
      <h1 class="center-point"></h1>
      <div class="speedometer-center-hide"></div>
      <div class="speedometer-bottom-hide"></div>
      <div class="arrow-container">
        <div class="humidity-arrow-wrapper speed-0">
          <div class="arrow"></div>
        </div>
      </div>
      <div class="speedometer-scale humidity-speedometer-scale-1"></div>
      <div class="speedometer-scale humidity-speedometer-scale-2"></div>
      <div class="speedometer-scale humidity-speedometer-scale-3"></div>
      <div class="speedometer-scale humidity-speedometer-scale-4"></div>
      <div class="speedometer-scale humidity-speedometer-scale-5"></div>
      <div class="speedometer-scale humidity-speedometer-scale-6"></div>
      <div class="speedometer-scale humidity-speedometer-scale-7"></div>
      <div class="speedometer-scale humidity-speedometer-scale-8"></div>
      <div class="speedometer-scale humidity-speedometer-scale-9"></div>
      <div class="speedometer-scale humidity-speedometer-scale-10"></div>
      <div class="speedometer-scale humidity-speedometer-scale-11"></div>
      <div class="speedometer-scale humidity-speedometer-scale-12"></div>
      <div class="speedometer-scale humidity-speedometer-scale-13"></div>
      <div class="speedometer-scale humidity-speedometer-scale-14"></div>
      <div class="speedometer-scale humidity-speedometer-scale-15"></div>
      <div class="speedometer-scale humidity-speedometer-scale-16"></div>
      <div class="speedometer-scale humidity-speedometer-scale-17"></div>
      <div class="speedometer-scale humidity-speedometer-scale-18"></div>
      <div class="speedometer-scale humidity-speedometer-scale-19"></div>
    </div>
                </div>
                <div class="vertical-bar" style="height: 320px;width: 1px;background-color: #ccc; margin: 20px 0px;"></div>
                <div class="temperature-data-show" >
                <div class="temperature-c-f flex" style="justify-content: space-between; margin-bottom:50px">
                <div class="temperature-data-show justify-center item-center">
                    <div class="temp-text-icon flex justify-center item-center" style="margin: 0px 10px;">
                        <div class="circle" style=" height:40px; width:40px; border:1px solid black;border-radius: 50%; background-color:#EDF9F7;"><span class='material-symbols-outlined' style='font-size: 40px; color: black;'> device_thermostat</span></div>
                        <div class="text-temperature justify-center item-center" style="margin:0px 30px">
                            <p style="font-size:18px; font-weight:200px;"> TEMPERATURE </p>
                            <span>Status:</span>
                        <span class="temperature-status"></span>
                        </div>
                    </div>
                    </div>
                    
                    </div>
                    
    <div class="speedometer-container">
    <div class="temperature-warning-div" >
            <div class="warning-pointy-container">Warning</div>
            <div class="warning-pointer-small"></div>
        </div>
      <div class="speedometer-text">
          <span class="value" style="font-size:39px;">
          <?php
                        $url = "https://api.thingspeak.com/channels/{$channelid}/fields/1/last.json?api_key={$apikey}";
                        $data = file_get_contents($url);
                        $data = json_decode($data, true);

                        $temperature = $data['field1'];
                        $temperature = number_format($temperature,1);

                        echo "$temperature";
                    ?>
          </span>
          <span class="unit">&#8451</span>
      </div>
      <h1 class="center-point"></h1>
      <div class="speedometer-center-hide"></div>
      <div class="speedometer-bottom-hide"></div>
      <div class="arrow-container">
        <div class="temperature-arrow-wrapper speed-0">
          <div class="arrow"></div>
        </div>
      </div>
      <div class="speedometer-scale temperature-speedometer-scale-1"></div>
      <div class="speedometer-scale temperature-speedometer-scale-2"></div>
      <div class="speedometer-scale temperature-speedometer-scale-3"></div>
      <div class="speedometer-scale temperature-speedometer-scale-4"></div>
      <div class="speedometer-scale temperature-speedometer-scale-5"></div>
      <div class="speedometer-scale temperature-speedometer-scale-6"></div>
      <div class="speedometer-scale temperature-speedometer-scale-7"></div>
      <div class="speedometer-scale temperature-speedometer-scale-8"></div>
      <div class="speedometer-scale temperature-speedometer-scale-9"></div>
      <div class="speedometer-scale temperature-speedometer-scale-10"></div>
      <div class="speedometer-scale temperature-speedometer-scale-11"></div>
      <div class="speedometer-scale temperature-speedometer-scale-12"></div>
      <div class="speedometer-scale temperature-speedometer-scale-13"></div>
      <div class="speedometer-scale temperature-speedometer-scale-14"></div>
      <div class="speedometer-scale temperature-speedometer-scale-15"></div>
      <div class="speedometer-scale temperature-speedometer-scale-16"></div>
      <div class="speedometer-scale temperature-speedometer-scale-17"></div>
      <div class="speedometer-scale temperature-speedometer-scale-18"></div>
      <div class="speedometer-scale temperature-speedometer-scale-19"></div>
    </div>
                    </div>
                    
            </div>
            
        </div>

        
        <div class="container-projects" style="padding: 20px 20px; flex-wrap: wrap;height: 20px; margin: 10px 60px; border: 1px solid grey; box-shadow: 0 0 5px rgba(0, 0, 0, 0.5); align-items: center; justify-content:center;">
            <span style="font-size:23px; font-weight: bold;">Note:</span>
            <span class="feedback-text" style="font-size: 20px;"></span>
    
    </div>


    <div class="container-projects" style="padding: 20px 20px; flex-wrap: wrap;height: 250px; margin: 10px 60px; border: 1px solid grey; box-shadow: 0 0 5px rgba(0, 0, 0, 0.5); align-items: stretch; overflow-y: auto;">
            <ul class="flex" style="list-style:none;">
                <li class="data-representation" style="background-color: #e0ebff; color: #2472ff">&#x2022; Good </li>
                <li class="data-representation" style="background-color: #fdffa3; color: #5e6100;">&#x2022; Warning </li>
                <li class="data-representation" style="background-color: #ffd3d2; color: #f71300;">&#x2022; Alert </li>
            </ul> 

            <div class="bar-chart-container" style="padding: 15px;height: 100px; margin: 30px 60px; background-color: #fff; align-items: stretch; overflow-y: auto;">
                <h2 class="bar-title">C<sub>2</sub>H<sub>4</sub></h2>
                <div class="bar">
                    <div class="inner-bar" data-percent="<?php
                        
                        $url = "https://api.thingspeak.com/channels/{$channelid}/fields/3/last.json?api_key={$apikey}";
                        $data = file_get_contents($url);
                        $data = json_decode($data, true);

                        $methane = $data['field3'];

                        echo "$methane";
                        
                    ?> PPM"></div>
            </div>
        </div>
            
     </div>


</div>
</div>
<style>
.bar{
    background-color: #f2f2f1;
    width: 80%;
    height: 25px;
    margin-bottom:40px;
    border: 1px solid transparent;
    border-radius:10px;
}

.inner-bar{
    background-color: #f71300;
    height: 100%;
    position: relative;
}

.inner-bar:after{
    position: absolute;
    right: 2.5%;
    content: attr(data-percent);
    line-height: 30px;
    color: white;
}

</style>


<script>

    function goToNextPage() {
    window.location.href = 'add_new_page.php';
    }
    function goToDashBoard() {
    window.location.href = 'dashboard.php';
    }

    let methane = '<?= $methane ?>';
    let meth = methane;
    meth = meth*30;
    meth = meth + "%";
    var methaneprogress = document.querySelector(".inner-bar");
    methaneprogress.style.width = meth;
    
    let humidityValue = '<?= $humidity ?>';
    var humid = humidityValue;
    var humidvalue = Math.round(((humid/100) * 180 ) / 10 ) * 10;
    var humidityspeedClass = "speed-" + humidvalue.toString();
    var humidityelement = document.getElementsByClassName("humidity-arrow-wrapper")[0];
    humidityelement.classList.add(humidityspeedClass);
    humidvalue = humidvalue/10 + 1;
    for (let i = 1; i <= humidvalue; i++) {
            let scale = document.getElementsByClassName("humidity-speedometer-scale-" + i);
            let scale1 = document.getElementsByClassName("humidity-speedometer-scale-" + 1);
            // alert(i);
            if(humidityValue < 60){
                if(humidityValue > 55 ){
                    scale[0].style.backgroundColor = "#5e6100";
                    scale1[0].style.backgroundColor = "#5e6100";
                }
                else{
                    scale[0].style.backgroundColor = "#f71300";
                    scale1[0].style.backgroundColor = "#f71300";
                }
            }
            else if(humidityValue >70){
                if(humidityValue > 75 ){
                    scale[0].style.backgroundColor = "#f71300";
                    scale1[0].style.backgroundColor = "#f71300";
                }
                else{
                    scale[0].style.backgroundColor = "#5e6100";
                    scale1[0].style.backgroundColor = "#5e6100";
                }
            }
            else{
                scale[0].style.backgroundColor = "#2472ff";
                scale1[0].style.backgroundColor = "#2472ff";
            }
        }

    
    var temperatureValue = '<?= $temperature ?>';
    var temp = parseInt(temperatureValue);
    if(temp>=0){
        temp=parseInt(temp) + 20;
    }
    else{
        temp=Math.abs(temp);
    }
    var tempvalue = Math.round(((temp/100) * 180 ) / 10 ) * 10;
    var temperaturespeedClass = "speed-" + tempvalue.toString();
    var temperatureelement = document.getElementsByClassName("temperature-arrow-wrapper")[0];
    temperatureelement.classList.add(temperaturespeedClass);
    tempvalue = tempvalue/10+1;
    for (let i = 1; i <= tempvalue; i++) {
            let scale = document.getElementsByClassName("temperature-speedometer-scale-" + i);
            if(temperatureValue>=0 && temperatureValue<=2){
                scale[0].style.backgroundColor = "#5e6100";
            }
            else if(temperatureValue >= 32){
                if(temperatureValue>=33){
                    scale[0].style.backgroundColor = "#f71300";
                }
                else{
                    scale[0].style.backgroundColor = "#5e6100";
                }
            }
            else if(temperatureValue >= 25 && temperatureValue <= 30){
                scale[0].style.backgroundColor = "#2472ff";
            }
            else if(temperatureValue >= 2 && temperatureValue <= 5){
                scale[0].style.backgroundColor = "#2472ff";
            }
            else{
                scale[0].style.backgroundColor = "#2472ff";
            }
        }
        var feedbacktext = document.querySelector(".feedback-text");
        if((humidityValue>=60 && humidityValue<=65) && (temperatureValue >= 25 && temperatureValue <= 30)){
            var text = 'Onions are in Healthy State';
            feedbacktext.textContent = text;
            feedbacktext.style.color = "#2472ff";
        }
        else if((humidityValue>=65 && humidityValue<=70) && (temperatureValue >= 0 && temperatureValue <= 5)){
            var text = 'Onions are in Healthy State';
            feedbacktext.textContent = text;
            feedbacktext.style.color = "#2472ff";
        }

        else if((humidityValue<60) && (temperatureValue >= 32)){
            var text = 'Weight Loss Could Happen to Onions';
            feedbacktext.textContent = text;
            feedbacktext.style.color = "#5e6100";
        }

        else if((humidityValue>70) && (temperatureValue >= 0 && temperatureValue <= 2)){
            var text = 'Sprouting Could Happen to Onions';
            feedbacktext.textContent = text;
            feedbacktext.style.color = "#5e6100";
        }

        else if((humidityValue>70) && (temperatureValue >32)){
            var text = 'Rotting Could Happen to Onions';
            feedbacktext.textContent = text;
            feedbacktext.style.color = "#5e6100";
        }
        else{
            var text = 'Either Temperature or Humidity Value are not suitable. Check it!';
            feedbacktext.textContent = text;
            feedbacktext.style.color = "#f71300";
        }

        var humiditystatus = document.querySelector(".humidity-status");
        if(humidityValue < 60){
                if(humidityValue > 55 ){
                    humiditystatus.style.color = "#5e6100";
                    humiditystatus.textContent = "Warning";
                }
                else{
                    humiditystatus.style.color = "#f71300";
                    humiditystatus.textContent = "Alert";
                }
            }
            else if(humidityValue >70){
                if(humidityValue > 75 ){
                    humiditystatus.style.color = "#f71300";
                    humiditystatus.textContent = "Alert";
                    
                }
                else{
                    humiditystatus.style.color = "#5e6100";
                    humiditystatus.textContent = "Warning";
                }
            }
            else{
                humiditystatus.style.color = "#2472ff";
                humiditystatus.textContent = "Good";
            }
            // <li class="data-representation" style="background-color: #e0ebff; color: #2472ff">&#x2022; Good </li>
            //     <li class="data-representation" style="background-color: #fdffa3; color: #5e6100;">&#x2022; Warning </li>
            //     <li class="data-representation" style="background-color: #ffd3d2; color: #f71300;">&#x2022; Alert </li>
            var temperaturestatus = document.querySelector(".temperature-status");
            if(temperatureValue>=0 && temperatureValue<=2){
                temperaturestatus.style.color = "#5e6100";
                temperaturestatus.textContent = "Warning";
            }
            else if(temperatureValue >= 32){
                if(temperatureValue>=33){
                    temperaturestatus.style.color = "#f71300";
                    temperaturestatus.textContent = "Alert";
                }
                else{
                    temperaturestatus.style.color = "#5e6100";
                    temperaturestatus.textContent = "Warning";
                }
            }
            else if(temperatureValue >= 25 && temperatureValue <= 30){
                temperaturestatus.style.color = "#2472ff";
                temperaturestatus.textContent = "Good";
            }
            else if(temperatureValue >= 2 && temperatureValue <= 5){
                temperaturestatus.style.color = "#2472ff";
                temperaturestatus.textContent = "Good";
            }
            else{
                temperaturestatus.style.color = "#2472ff";
                temperaturestatus.textContent = "Good";
            }

</script>

</body>
</html>