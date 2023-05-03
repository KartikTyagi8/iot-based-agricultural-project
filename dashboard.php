

<?php
    session_start();
    if(!isset($_SESSION['email'])) {
        header("Location: login_page.php");
        exit();
    }
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'> -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="assets/style.css">
    <link rel="stylesheet" href="assets/utils.css">
    
    <title>User Dashboard</title>
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
        <input type="submit" name="logout" value="Logout" style="cursor:pointer; width:100px; height:30px; font-size:15px; font-weight: bold; background-color:#DADE00; border:1px solid transparent;">
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
        <span style="font-size: 25px; color: grey;"> Dashboard </span>
        <!-- <div class="notification"> -->
        <span class="material-symbols-outlined" style="size: 25px; color: grey; font-size:30px"> notifications</span>
        <!-- </div> -->
      </div>
      <nav class="flex space-between" style="margin: 5px 30px;">
        <span style="font-size: 24px; font-weight: 80; padding-top: 5px;">All Projects</span>
        <div class="right flex space-between">
          <form class="search-bar">
          <input type="search" id="search-input" placeholder="Search..." style="width: 271px; height: 49px; border-radius: 10px; margin-right: 10px;">
          <button type="submit">Search</button>
        </form>
          <button class="add-new-btn" onclick="goToNextPage()" style="cursor:pointer;" >Add New<span class="material-symbols-outlined">add</span></button>
        </div>
      </nav>

      <div class="container-projects flex" style="padding: 20px 20px; flex-wrap: wrap;height: 550px; margin: 10px 20px; border: 1px solid grey; border-radius: 20px; box-shadow: 0 0 5px rgba(0, 0, 0, 0.5); align-items: stretch; overflow-y: auto;">
      
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
      $sql = "SELECT * FROM project_info where email = '$email'";
      $result = mysqli_query($conn, $sql);

      // Generate project cards
      while ($row = mysqli_fetch_array($result)) {
        // Generate card HTML using data from the database
        echo "
        
          <div class = 'card' style = ' height: 200px; width: 18rem; border-radius:10px; border: 1px solid grey;box-shadow: 0 0 10px rgba(0, 0, 0, 0.5); margin: 5px 20px; '>
          <a href='arduino_page.php?project_id=$row[id]' style='text-decoration: none; color:black;'>
          <img src='assets/img/orchard-farm-concept.jpg' style='width:18rem; height: 70%; border-radius: 10px'>
            <h3 class= 'card-title' style='margin: 5px 10px;'>$row[name]</h3>
            <p class= 'card-sensor' style='margin: 5px 10px;'>Number of sensors: $row[sensor]</p>
            </a>
            </div>
        

        ";
      }
      ?>
      <div>
      
    </div>
  </div>

<script>
  function goToNextPage() {
    window.location.href = 'add_new_page.php';
  }
  function goToDashBoard() {
    window.location.href = 'dashboard.php';
  }

  const searchInput = document.querySelector('#search-input');
  searchInput.addEventListener('input', searchProjects);

  function searchProjects() {
  const searchTerm = searchInput.value.toLowerCase();
  const projectCards = document.querySelectorAll('.card');
  
  projectCards.forEach(card => {
    const title = card.querySelector('.card-title').textContent.toLowerCase();
    if (title.includes(searchTerm)) {
      card.style.display = 'block';
    } else {
      card.style.display = 'none';
    }
  });
}


</script>


  
</body>
</html>