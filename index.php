<?php
	session_start();
	require "database/database.php";
	if (isset($_SESSION['new'])) {
		header("Location: dashboard.php");
	}
	
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Hamro Karobar Online System</title>
    <link rel="icon" type="image/png" href="Img/Logo1.jpg"/>
	<link rel="stylesheet" type="text/css" href="css/index.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
</head>
<body>
<div id="toastBox"></div>
	<div class="wrapper">
		<h1>Login</h1>
		<form id="customerdata" action="" method="POST">
			<div class="username">
				<input type="text" name="username" id="uname" placeholder="Username" required>
			</div>
			<div class="username">
				<input type="password" name="pass" id="pass" placeholder="Password" required>
			</div>
			<div class="recover"><a href="Forget.php">Forget Password?</a></div>
		
			<input type="submit" value="Login" name="submit" id="submit">
			<div class="member">
				Not a member? <a href="Signup.php">
					Register Now
				</a>
			</div>
		</form>
	</div>
	<script>
        $(document).ready(function(){
            $("#submit").click(function(e){
            e.preventDefault();
            console.log('Submit Button Clicked');
            let uname = $("#uname").val();
            let pass = $("#pass").val();
            mydata = {uname:uname,pass:pass};
            $.ajax({
                url:"login/login_check.php",
                method: "POST",
                data: JSON.stringify(mydata),
                success: function(msg){
                    console.log(msg);
                    let toastBox = document.getElementById('toastBox');
                    let toast = document.createElement('div');
                    toast.classList.add('toast');
                    toast.innerHTML = msg;
                    toastBox.appendChild(toast);

                    if (msg.includes('Not')) {
                        toast.classList.add('error');
                    }
                    if (msg.includes('Empty')) {
                        toast.classList.add('invalid');
                    }
					if (msg.includes('Successful')) {
                   		 window.location = "dashboard.php";
                }

                    setTimeout(()=>{
                        toast.remove();
                    },3000);
                    $("#customerdata")[0].reset();
                },
            })
        });

        });
    </script>
</body>
</html>