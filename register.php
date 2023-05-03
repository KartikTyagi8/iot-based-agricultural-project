<!DOCTYPE html>
<html>
<head>
	<title>Login Page</title>
	<link rel="stylesheet" href="assets/register.css">
</head>
<body>
<div>
		<?php
			// Retrieve form data
			$firstname = $_POST['firstname'];
			$lastname = $_POST['lastname'];
			$username = $_POST['username'];
			$password = $_POST['password'];
			$emailid = $_POST['emailid'];
			

			// Connect to MySQL database
			$host = 'localhost';
			$user = 'root';
			$pass = '';
			$dbname = 'onion_farming_solutions';
			$conn = mysqli_connect($host, $user, $pass, $dbname);

			$sql = "SELECT * FROM users WHERE email='$emailid'";
			$result = mysqli_query($conn, $sql);

			if (mysqli_num_rows($result) == 1) {
				echo "<p>Email ID already registered.</p>";
				
			} else {
				$sql = "INSERT INTO users (firstname,lastname,username,password, email) VALUES ('$firstname', '$lastname', '$username', '$password', '$emailid')";
				$result = mysqli_query($conn, $sql);
				echo "Registration successful.";
				header("Location: login_page.php");
    			exit();
			}
		?>
	</div>
	<div class="container">
		<img class="logo" src="assets/img/logo.png" alt="Company Logo">
		<div class="title">Welcome to Sensor Flow</div>
		<form action="register.php" method="post">
			<label for="firstname" style="font-size: 20px; text-align: left;">First Name:</label>
			<input type="text" id="firstname" name="firstname" required placeholder="John" style="width: 100%; height: 25px;">
			<label for="lastname" style="font-size: 20px; text-align: left;">Last Name:</label>
			<input type="text" id="lastname" name="lastname" required placeholder="Doe" style="width: 100%; height: 25px;">
			<label for="username" style="font-size: 20px; text-align: left;">Username:</label>
			<input type="text" id="username" name="username" required placeholder="johndoe27" style="width: 100%; height: 25px;">
			<label for="password" style="font-size: 20px; text-align: left;">Password:</label>
			<input type="password" id="password" name="password" required placeholder="**************" style="width: 100%; height: 25px;">
            <label for="emailid" style="font-size: 20px; text-align: left;">Email ID:</label>
			<input type="email" id="emailid" name="emailid" required placeholder="johndoe27@gmail.com" style="width: 100%; height: 25px;">
			<button type="submit" name="create">Register<span class="arrow">&#8594;</span></button>
      <div class="signup">Already a member? <a href="login_page.php">Log In</a></div>
		</form>
		
	</div>
</body>
</html>