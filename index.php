<?php 

include('dbconfig.php');

$uname = "";
$pass = "";

if(isset($_GET['submit'])){
    $uname = htmlentities($_GET['username']);
	$pass = htmlentities($_GET['password']);


	//Querying from the database where username matches entered $Uname and password matches entered $pass	
	$result = mysqli_query($con, "SELECT * FROM `users` WHERE username='$uname' AND password='$pass'");

	//If the match is successful, we are counting the number of rows of the result given by the query
	$count = mysqli_num_rows($result);

	//The username and password combination must be unique, so, there should be only 1 row for the login to be successful
	if($count == 1){

		//If login is successful redirect to chat.php
		header("Location: chat.php");
		exit();
	} else {

		//Else give Invalid credentials! message
		$loginerror = "Invalid credentials! Please try again.";
	}

} else if (!empty($_GET['username']) && !empty($_GET['password'])){
    $loginerror = "You must supply a username and password.";
} else {
	$loginerror = "Please enter uname & pwd!";
}


?>

<head>
	<title>QTalk</title>
	<link rel="icon" href="images/qt.png" type="image/png" sizes="16x16">
	<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
	<div class="slide">
		<div id="block">
		<form id="frm" action="" method="get">
			<h2>Dashboard</h2>
			<div id="alert"><?php echo $loginerror; ?></div>
			<input type="text" name="username" id="username" placeholder="Username">
			<input type="password" name="password" id="password" placeholder="Password">
			<div id="sub">
				<button class="btns" type="submit" name="submit">Sign In</button>
				<button class="btns">Sign Up</button>
			</div>
		</form>	
		<p style="padding-top: 250px;">Forgot your password<a href="#"> Click Here!</a></p>
	</div>
	</div>
</body>