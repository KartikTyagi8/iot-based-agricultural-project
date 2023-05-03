<?php

session_start();
    if(!isset($_SESSION['email'])) {
        header("Location: login_page.php");
        exit();
    }
// // Redirect back to the projects page
    $host = 'localhost'; // replace with your database host
      $username = 'root'; // replace with your database username
      $password = ''; // replace with your database password
      $database = 'onion_farming_solutions'; // replace with your database name
      $email = $_SESSION['email'];
      $conn = mysqli_connect($host, $username, $password, $database);
      if (!$conn) {
        die("Database connection failed: " . mysqli_connect_error());
      }
      $project_id = $_GET['project_id'];
      // Query the database for projects
      $sql = "SELECT id FROM project_info where email = '$email'";
      $result = mysqli_query($conn, $sql);
      $_SESSION['session']=$email;
      
header("Location: arduino_boards.php?project_id=$project_id");



?>