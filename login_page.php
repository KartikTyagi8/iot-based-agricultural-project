
<!DOCTYPE html>
<html>
<head>
	<title>Login Page</title>
	<link rel="stylesheet" href="assets/login_page.css">
</head>
<body>
<div>
		<?php

            session_start();
            if(isset($_POST['login'])) {
                $email = $_POST['emailid'];
                $password = $_POST['password'];
                $host = 'localhost';
                $user = 'root';
                $pass = '';
                $dbname = 'onion_farming_solutions';
                $conn = mysqli_connect($host, $user, $pass, $dbname);
                if($conn) {
                    $query = "SELECT * FROM users WHERE email='$email' AND password='$password'";
                    $result = mysqli_query($conn, $query);
                    if(mysqli_num_rows($result) == 1) {
                        $_SESSION['email'] = $email;
                        header("Location: dashboard.php");
                        exit();
                    } else {
                        echo "<p>Invalid email or password</p>";
                    }
                    mysqli_close($conn);
                } else {
                    echo "<p>Failed to connect to database</p>";
                }
            }
		?>
	</div>
	<div class="container">
		<img class="logo" src="assets/img/logo.png" alt="Company Logo">
		<div class="title">Welcome to Sensor Flow</div>
		<form method="POST" action="login_page.php">
        <label for="emailid" style="font-size: 20px; text-align: left;">Email ID:</label>
			<input type="email" id="emailid" name="emailid" required placeholder="johndoe27@gmail.com" style="width: 100%; height: 25px;">
			<label for="password" style="font-size: 20px; text-align: left;">Password:</label>
			<input type="password" id="password" name="password" required placeholder="**************" style="width: 100%; height: 25px;">
			<input type="submit" name="login"  value="Login" style="cursor:pointer; background-color: #DADE00;height: 45px;width: 100%;border-radius: 10px; border: 1px solid transparent;">
      <div class="signup">Not a member? <a href="register.php">Sign up</a></div>
		</form>
		
	</div>
</body>
</html>
