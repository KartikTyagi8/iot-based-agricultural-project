<?php
    session_start();
    if(!isset($_SESSION['email'])) {
        header("Location: login_page.php");
        exit();
    }
    else{
      $email = $_SESSION['email'];
    }
?>

<!DOCTYPE html>
<html>
<head>
	<title>Add Project</title>
	<link rel="stylesheet" href="assets/add_new_page.css">
</head>
<body>
<div>
		 <?php

            // session_start();
            if(isset($_POST['submit'])) {
                $name = $_POST['name'];
                $sensor = $_POST['sensor'];
                $email = $_SESSION['email'];
                // Connect to MySQL database
                $host = 'localhost';
                $user = 'root';
                $pass = '';
                $dbname = 'onion_farming_solutions';
                $conn = mysqli_connect($host, $user, $pass, $dbname);
                $sql = "INSERT INTO project_info (email,name,sensor) VALUES ('$email','$name', '$sensor')";
                $result = mysqli_query($conn, $sql);
                header("Location: dashboard.php");
            }
			
		?> 
	</div>
	<div class="container">
		<img class="logo" src="assets/img/logo.png" alt="Company Logo">
		<div class="title">Give the details of your new project</div>
		<form action="add_new_page.php" method="post">
        <label for="text" style="font-size: 20px; text-align: left;">Project Name</label>
			<input type="text" id="name" name="name" required  style="width: 100%; height: 25px;">
			<label for="number" style="font-size: 20px; text-align: left;">Number of Sensors</label>
			<input type="number" id="sensor" name="sensor" required  style="width: 100%; height: 25px;">
			<input type="submit" name="submit" value="submit" style="background-color: #DADE00;height: 45px;width: 100%;border-radius: 10px; border: 1px solid transparent; cursor:pointer;">
      <!-- <div class="signup">Not a member? <a href="register.php">Sign up</a></div> -->
		</form>
		
	</div>
</body>
</html>
