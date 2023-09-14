<?php
	require 'database/database.php';

	if (isset($_POST['submit'])) {
		$user = $_POST['user'];
		$email = $_POST['email'];
		$pass = $_POST['pass'];
		$cpass = $_POST['cpass'];

		if ($pass == $cpass) {
			$sql = "INSERT INTO user VALUES ('','$email','$user','$pass')";

			if ($con->query($sql) === TRUE) {
				echo "<script>alert('New Account Registered !!!');</script>";
				header("Refresh:0");
			}
			else {
				echo "Error: " . $sql . "<br>" . $conn->error;
			}
		}
		else{
			echo "<script>alert('Password Does not Matched !!!');</script>";
				header("Refresh:0");
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login Page</title>
	<link rel="stylesheet" type="text/css" href="css/index.css">
</head>
<body>
	<div class="wrapper">
		<h1>Sign Up</h1>
		<form action="" method="POST" id="form">
			<div class="username">
				<input type="text" name="user" required placeholder="Username">
			</div>
			<div class="username">
				<input type="text" name="email" required placeholder="Email" id="email" onkeyup="validate()">
				<span id="text"></span>
			</div>
			<div class="username">
				<input type="password" name="pass" required placeholder="Password" id="pass" onkeyup="verifyPassword()">
				<span id="ptext"></span>
			</div>
			<div class="username">
				<input type="password" name="cpass" required placeholder="Re-Enter Password" id="cpass" onkeyup="cpassword()">
				<span id="ctext"></span>
			</div>
			<div class="terms">
				<input type="checkbox" id="checkbox">
				<label for="checkbox">I agree to these <a href="Terms.php">Terms & Conditions</a></label>
			</div>
			<input type="submit" value="Sign Up" name="submit">
			<div class="member">
				Already a member? <a href="index.php">
					Login Here
				</a>
			</div>
		</form>
	</div>
	<script>
		function validate() {
			var form = document.getElementById('form');
			var email = document.getElementById('email').value;
			var text = document.getElementById('text');
			var pattern = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

			if (email.match(pattern)) {
				form.classList.add('valid');
				form.classList.remove('invalid');
				text.innerHTML = "Your Email is Valid Email Address.";
				text.style.color = "#28a745";
			}
			else
			{
				form.classList.remove('valid');
				form.classList.add('invalid');
				text.innerHTML = "Please Enter Valid Email Address.";
				text.style.color = "#ff0000";
			}
			if (email == "") {
				form.classList.remove('valid');
				form.classList.remove('invalid');
				text.innerHTML = "";
				text.style.color = "#00ff00";
			}
		}
		function verifyPassword() {  
			var form = document.getElementById('form');
			var pass = document.getElementById('pass').value;
			var ptext = document.getElementById('ptext'); 
			
			//minimum password length validation  
			if(pass.length <= 7) {  
				form.classList.remove('valid');
				form.classList.add('invalid');
				ptext.innerHTML = "Password Shuould be 8 Character Length.";
				ptext.style.color = "#ff0000";
			}  
			 else {  
				form.classList.add('valid');
				form.classList.remove('invalid');
				ptext.innerHTML = "Password Valid.";
				ptext.style.color = "#28a745"; 
			} 
			if (pass == "") {
				form.classList.remove('valid');
				form.classList.remove('invalid');
				ptext.innerHTML = "";
				ptext.style.color = "#00ff00";
			} 
		}  
			function cpassword() {
				var form = document.getElementById('form');
				var pass = document.getElementById('pass').value;
				var cpass = document.getElementById('cpass').value;
				var ctext = document.getElementById('ctext');

				if(pass!=cpass) {  
					form.classList.remove('valid');
					form.classList.add('invalid');
					ctext.innerHTML = "Password Does not Match.";
					ctext.style.color = "#ff0000";
				} else {  
					form.classList.add('valid');
					form.classList.remove('invalid');
					ctext.innerHTML = "Password Matches.";
					ctext.style.color = "#28a745"; 
				}  
				if (cpass == "") {
				form.classList.remove('valid');
				form.classList.remove('invalid');
				ctext.innerHTML = "";
				ctext.style.color = "#00ff00";
			}
		}
	</script>
</body>
</html>