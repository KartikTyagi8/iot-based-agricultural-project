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
  <meta charset="UTF-8">
  <title>Dashboard Example</title>
  <link rel="stylesheet" href="dashboard_user.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

</head>
<body>
  <div class="container">
    <div class="left-section">
      <div class="company-info">
        <img src="orchard-farm-concept.jpg" alt="Company Logo">
        <h2> Sensor Flow </h2>
      </div>
      <div class="dashboard-btn">
      <span class="material-symbols-outlined">dashboard</span>
        <a href="#dashboard">My Dashboard</a>
      </div>
      <div class="project-info">
        <h3>My Projects</h3>
      </div>
      <div class="username">
        <p>Username: exampleuser</p>
      </div>

      <form method="POST" action="logout.php">
        <input type="submit" name="logout" value="Logout">
    </form>

      <a hre></a>
    </div>
    <div class="right-section" id="dashboard">
      <!-- Add your content for the dashboard here -->
      <div class="dashboard">
        <div class="dashboard-header">
          <div class="notification">
          <span class="material-symbols-outlined"> notifications</span>
          </div>
          <div class="search-bar">
            <input type="text" placeholder="Search...">
            <i class="fa fa-search"></i>
          </div>
          <button class="add-project-btn">
            <i class="fa fa-plus"></i> Add New
          </button>
        </div>
        <div class="header"></div>
          <div class="projects-container"></div>
      </div>
      
    </div>
  </div>
  <script src="script.js"></script>

    <!-- <script>
        document.getElementById("logout-btn").addEventListener("click", function() {
            // Create an AJAX request to the logout.php script
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "logout.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if(xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200) {
                    // Redirect the user to the login page
                    window.location.href = "login_page.php";
                }
            }
            xhr.send();
        });
    </script> -->

</body>
</html>


