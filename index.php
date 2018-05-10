<?php 


if( isset($_GET['submit']) )
{
    $uname = htmlentities($_GET['username']);
    $pass = htmlentities($_GET['password']);
/*    echo $uname;
    echo "</br>";
    echo $pass;*/
    header('Location: /qtalk/chat.php');
}
else if (!empty($_GET['username']) && !empty($_GET['password']))
{
    $loginerror = "You must supply a username and password.";
}
else
{
    /*echo '<script language="javascript">';
	echo 'alert("Incorrect Username/Password!")';
	echo '</script>';*/
	$loginerror = "Please enter uname & pwd!";
}


$hostname = "localhost";
$username = "root";
$password = "mypass";
$database = "qtalk";


$con = mysqli_connect($hostname,$username,$password,$database);
$result = mysqli_query($con,"SELECT * FROM users");

while($res = mysqli_fetch_assoc($result)){
	
/*	echo $res["firstname"];
	echo "</br>";*/
	
}



?>
<style>

*{
	padding:0px;
	margin:0px;
}

body{
	background: url("images/rocky-shore.jpg") no-repeat center center fixed;
    background-color: lightblue;
    background-blend-mode: luminosity;
  	background-size: cover;
  	height: 100%;
  	overflow: hidden;
    font-family: Calibri, Candara, Segoe, "Segoe UI", Optima, Arial, sans-serif;
}

.slide{
    opacity: .9;
    width: 1080px;
	height: 530px;
	margin: 30px auto;

}

#block{
	margin: 10px auto;
	width: 300px;
	height: 300px;
	border-radius: 2px;
	background-color: dodgerblue;
	text-align: center;
	position: relative;
}

#frm{
	width: 250px;
    height: 200px;
    border-radius: 2px;
    background-color: white;
    margin: 0 auto;
    position: absolute;
    top: 14%;
    left: 9%;
}

#frm input{
	margin-bottom: 10px;
	border-radius: 2px;
}

#sub{
	
}

.btns{
	width:84px;
}
</style>
<head>
	<title>QTalk</title>
	<link rel="icon" href="images/qt.png" type="image/png" sizes="16x16">
	<script type="text/javascript">
		function login(){
			alert("QT");
		}
	</script>
</head>
<body>
	<div class="slide">
		<div id="block">
		<form id="frm" action="" method="get">
			<h2>Dashboard</h2>
			<div><?php echo $loginerror; ?></div>
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