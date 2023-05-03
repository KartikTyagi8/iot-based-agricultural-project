<?php
session_start();
// Check if user is logged in
if(!isset($_SESSION['email'])) {
    header("Location: login_page.php");
    exit();
}

// Establish a database connection
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
$sql = "SELECT * FROM project_info where email = $email";
$result = mysqli_query($conn, $sql);

// Generate project cards
while ($row = mysqli_fetch_array($result)) {
  // Generate card HTML using data from the database
  echo '<div class="card">';
  echo '<h2>' . $row['name'] . '</h2>';
  echo '<p>' . $row['sensor'] . '</p>';
  echo '</div>';
}

mysqli_close($conn);
?>
