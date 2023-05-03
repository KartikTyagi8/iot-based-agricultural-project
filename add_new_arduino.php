<?php
    session_start();
    if(!isset($_SESSION['email'])) {
        header("Location: login_page.php");
        exit();
    }
    else{
      $email = $_SESSION['email'];
      $project_id = $_GET['project_id'];
    }
?>

<!DOCTYPE html>
<html>
<head>
	<title>Add Board</title>
	<link rel="stylesheet" href="assets/add_new_page.css">
</head>
<body>
<div>
		 <?php

            session_start();
            if(isset($_POST['submit'])) {
                $project_id = $_POST['project_id'];
                $channel_id = $_POST['channel_id'];
                $sensors = $_POST['sensors'];
                $apikey = $_POST['apikey'];
                // Connect to MySQL database
                $host = 'localhost';
                $user = 'root';
                $pass = '';
                $dbname = 'onion_farming_solutions';
                $conn = mysqli_connect($host, $user, $pass, $dbname);
                $sql = "INSERT INTO boards (projectid,channelid,sensors,apikey) VALUES ('$project_id', '$channel_id','$sensors','$apikey')";
                $result = mysqli_query($conn, $sql);
                header("Location: arduino_boards.php?project_id=$project_id");
                exit;
            }
			
		?> 
	</div>
	<div class="container">
		<img class="logo" src="assets/img/logo.png" alt="Company Logo">
		<div class="title">Give the details of your new Board</div>
        
		<form action="add_new_arduino.php" method="post">
            <input type="hidden" name="project_id" value="<?php  echo $project_id; ?>">
            <label for="channel_id" style="font-size: 20px; text-align: left;">Channel Id</label>
			<input type="text" id="channel_id" name="channel_id" required  style="width: 100%; height: 25px;">
            <label for="apikey" style="font-size: 20px; text-align: left;">API KEY</label>
			<input type="text" id="apikey" name="apikey" required  style="width: 100%; height: 25px;">
			<label for="sensors" style="font-size: 20px; text-align: left;">Number of Sensors</label>
			<input type="number" id="sensors" name="sensors" required  style="width: 100%; height: 25px;">
			<input type="submit" name="submit" value="submit" style="background-color: #DADE00;height: 45px;width: 100%;border-radius: 10px; border: 1px solid transparent; cursor:pointer;">
      <!-- <div class="signup">Not a member? <a href="register.php">Sign up</a></div> -->
		</form>
		
	</div>
</body>
</html>
