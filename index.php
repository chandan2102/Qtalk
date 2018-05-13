<?php 
session_start();
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

		//If login is successful set user session variable and redirect to chat.php
		$_SESSION["username"] = $uname;
		
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

// Signup Code Block - Start

$unameN = "";
$passN = "";
$fname = "";
$lname = "";
$email = "";
$registererror = "";


if(isset($_GET['register'])){

	$fname = htmlentities($_GET['fname']);
	$lname = htmlentities($_GET['lname']);
    $unameN = htmlentities($_GET['uname']); //different username variable to avoid clash with login username
	$email = htmlentities($_GET['email']);
	$passN = htmlentities($_GET['pwd']); //different password variable to avoid clash with login password


	$exist = mysqli_query($con, "SELECT * FROM `users` WHERE username='$unameN'");
	$check = mysqli_num_rows($exist);

	if($check == 1){
		$registererror = "Username already exists, Please try other options.";
	}else{
		$res = mysqli_query($con, "INSERT INTO `users`(`firstname`, `lastname`, `username`, `email`, `password`) VALUES ('$fname', '$lname', '$unameN', '$email', '$passN')");

		if($res){
			$registererror = "Registration successful!";
			$_SESSION["username"] = $unameN;
			header("Location: chat.php");
			exit();

		}else{ 
			$registererror = "Error: Sorry! Registration Failed!"; 
		}
	}

}

?>

<head>
	<title>QTalk</title>
	<link rel="icon" href="images/qt.png" type="image/png" sizes="16x16">
	<link rel="stylesheet" type="text/css" href="style.css">

	<script type="text/javascript">
		
		function opnRegFrm(){
			document.getElementById("block").style.display = "none";
			document.getElementById("rblock").style.display = "block";
		}

		function closeRegFrm(){
			document.getElementById("rblock").style.display = "none";
			document.getElementById("block").style.display = "block";
		}


	</script>
</head>

<body>
	<div class="slide">
		<div id="block">
			<form id="frm" action="" method="get" >
				<h2>Dashboard</h2>
				<div id="alert"><?php echo $loginerror; ?></div>
				<input type="text" name="username" id="username" placeholder="Username">
				<input type="password" name="password" id="password" placeholder="Password">
				<div id="sub">
					<button class="btns" type="submit" name="submit">Sign In</button>
				</div>
			</form>
			<button class="btnss" onclick="opnRegFrm()">Sign Up</button>
			<p style="padding-top: 250px;">Forgot your password<a href="#"> Click Here!</a></p>
		</div>
		<div id="rblock">
			<img src="images/close.png" onclick="closeRegFrm()" style="width:20px;height:20px;float:right; margin:5px;">
			<form id="rfrm" action="" method="get" >
				<h2>Registration</h2>
				<div id="alertt"><?php echo $registererror; ?></div>
				<input type="text" name="fname" id="fname" placeholder="First Name">
				<input type="text" name="lname" id="lname" placeholder="Last Name">
				<input type="text" name="uname" id="uname" placeholder="Username">
				<input type="password" name="pwd" id="pwd" placeholder="Password">
				<input type="text" name="email" id="email" placeholder="Email">
				<div id="sub">
					<button class="btnsss" type="submit" name="register">Register</button>
				</div>
			</form>
		</div>
	</div>
</body>