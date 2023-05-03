<?php

session_start();
    if(!isset($_SESSION['email'])) {
        header("Location: login_page.php");
        exit();
    }
    else{
        $project_id = $_GET['project_id'];
    }
?>

<?php
                        
    $url = "https://api.thingspeak.com/channels/{$channelid}/fields/2/last.json?api_key={$apikey}";
    $data = file_get_contents($url);
    $data = json_decode($data, true);
    $humidity = $data['field2'];

    $url1 = "https://api.thingspeak.com/channels/{$channelid}/fields/3/last.json?api_key={$apikey}";
    $data1 = file_get_contents($url1);
    $data1 = json_decode($data1, true);
    $temperature = $data1['field1'];

    $url2 = "https://api.thingspeak.com/channels/{$channelid}/fields/3/last.json?api_key={$apikey}";
    $data2 = file_get_contents($url2);
    $data2 = json_decode($data2, true);
    $methane = $data2['field3'];
                        
    ?>

<html lang="en">
<head>
    <!-- <meta http-equiv="refresh" content="10" url="arduino_boards.php"> -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="assets/style.css">
    <link rel="stylesheet" href="assets/utils.css">
    <title>Project</title>
</head>
<body>
    
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

            // Query the database for projects
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
      <div class="dashboard-header flex space-between justify-center item-center" style="height: 45px;">
        <span style="font-size: 25px; color: grey;"> Projects </span>
        <!-- <div class="notification"> -->
        <span class="material-symbols-outlined" style="size: 25px; color: grey; font-size:30px"> notifications</span>
        <!-- </div> -->
      </div>
      <nav class="flex space-between" style="margin: 5px 30px;">
        
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
      
            $sql = "SELECT * FROM project_info where id = '$project_id'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result);

            echo "<span style='font-size: 24px; font-weight: 80; padding-top: 5px; margin-top:20px;'>$row[name]</span>";
        ?>
    
    
        <div class="right flex space-between">
          <!-- <form class="search-bar">
          <input type="search" id="search-input" placeholder="Search..." style="width: 271px; height: 49px; border-radius: 10px; margin-right: 10px;">
          <button type="submit">Search</button>
        </form> -->
        <?php
            $project_id = $_GET['project_id'];
           echo  "<a href='add_new_arduino.php?project_id=$project_id' style='text-decoration: none; color:black;'>  
            <button class='add-new-btn' style='cursor:pointer;'>Add New<span class='material-symbols-outlined'>add</span></button>
            </a>";
        ?>
        </div>
      </nav>

      <div class="container-projects flex" style="padding: 20px 20px; flex-wrap: wrap; height: 550px; margin: 10px 20px; border: 1px solid grey; box-shadow: 0 0 5px rgba(0, 0, 0, 0.5);   align-items: stretch; overflow-y: auto;">
      

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

      // Query the database for projects
      $sql = "SELECT * FROM boards where projectid = '$project_id'";
      $result = mysqli_query($conn, $sql);

      $id = 1;

      while ($row = mysqli_fetch_array($result)) {
        
        echo "
        
        <div class='arduino-card justify-center item-center' style='box-shadow: 0 0 10px rgba(0, 0, 0, 0.5); margin: 5px 20px;height:142px; width:222px; flex-wrap:wrap; border:1px solid grey; border-radius: 26.27px;'>
        <a href='board_information.php?boardid=$row[boardid]' style='text-decoration: none; color:black;'>
            <div class='card-number ' style='text-align: center;margin: 10px 20px; font-size:22px;'>Rack No - {$id}</div>
        <div class='horizontal-bar' style='width: 100%;height: 1px;background-color: #ccc;'></div>
        <div class='icons flex justify-center item-center' style='flex-wrap:wrap; justify-content:space-around; margin-left:2px;margin-right:2px;'>
            <div class='justify-center'>
                    <div class='circle' style=' height:40px; width:40px; border:1px solid black;border-radius: 50%; background-color:#EDF9F7;'><span class='material-symbols-outlined humid-color' style='font-size: 40px;'> ac_unit</span></div>
                    <p style='text-align:center;'>Humid.</p>
            </div>
            <div class='vertical-bar' style='height: 97px;width: 1px;background-color: #ccc;'></div>
            <div class='justify-center'>
                <div class='circle' style=' height:40px; width:40px; border:1px solid black;border-radius: 50%; background-color:#EDF9F7;'><span class='material-symbols-outlined temp-color' style='font-size: 40px;'> device_thermostat</span></div>
                <p style='text-align:center;'>Temp.</p>
            </div>
            <div class='vertical-bar' style='height: 97px; width: 1px;background-color: #ccc;'></div>
            <div class='justify-center'>
                <div class='circle' style=' height:40px; width:40px; border:1px solid black;border-radius: 50%; background-color:#EDF9F7;'><span class='material-symbols-outlined methane-color' style='font-size: 40px;'> gas_meter</span></div>
                <p style='text-align:center;'>Gas</p>
            </div>
            
        </div>
        </a>
      </div>

        ";

        $id = $id +1;
      }
      ?>
    </div>
  </div>

  <script>
  function goToNextPage() {
    window.location.href = 'add_new_arduino.php?project_id=$project_id';
  }
  function goToDashBoard() {
    window.location.href = 'dashboard.php';
  }

</script>
</body>
</html>
