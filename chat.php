<?php 
session_start();
include('dbconfig.php');

$uname = "";
$uname = $_SESSION["username"];

$msg_from = $uname;
$msg_to = "";

if(isset($_GET['to'])){
	$msg_to = $_GET['to'];
}

if(isset($_POST['msgsend'])){
	$msg_body = $_POST['msg'];
	$msg_body = trim($msg_body);

	$msg_from = $uname;
	$msg_to = $_GET['to'];

	if($msg_body){
		$resv = mysqli_query($con, "INSERT INTO `messages` (`msg_from`,`msg_to`,`msg_body`) VALUES ('$msg_from', '$msg_to', '$msg_body')");
		if($resv){}else{ echo "Error: Sorry! message could not be sent!"; }
	}
}	


?>

<head>
	<title>QTalk</title>
	<link rel="icon" href="images/qt.png" type="image/png" sizes="16x16">
	<link rel="stylesheet" type="text/css" href="style.css?ver.0.0.3"/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="https://code.jquery.com/jquery-1.10.2.js"></script>

	<script>
		function loadChat(arg){
			window.location.href = "chat.php?to=";
			$(".chatblock").css("background", "transparent");
			$(arg).css("background", "#ededed33");
		}

		$(document).ready(function(){
			var elem = document.getElementById('scrollElem');
			elem.scrollTop = elem.scrollHeight;
		});

		function typing(){
			document.getElementById("typeStat").style.visibility = "visible";
		}

		function notTyping(){
			document.getElementById("typeStat").style.visibility = "hidden";
		}

	</script>
</head>

<body>
	<div style="width: 97%; height: 2px; text-align: right; padding: 10px 10px;"><a href="logout.php">Logout</a></div>
	<div class="slide">
		<div style="margin: 0px auto;background: none;width:1080px;display: inline-block;">
			<div class="leftc">
				<div id="chat">
					<div style="width:30px;display: inline-block;"><img style="width:20px;" src="images\chat.png"></div>
					<div style="width:200px;display: inline-block;"><h3 style="color:white;">Simple Chat</h3></div>
					<div style="width:30px;display: inline-block;float:right;"><img style="width:20px;float:right;" src="images\collapse-left.png"></div>	
				</div>
				<div style="background-color:dimgray;">
					<div id="recent">
						<div style="width:30px;display: inline-block;">
							<img style="width:20px;" src="images\clock.png">
						</div>
						<div style="width:200px;display: inline-block;">
							<h3 style="color:white;display: inline-block;">RECENT CHATS</h3>
							<span id="recentcount" style="">4</span>
						</div>
						<div style="width:30px;display: inline-block;float:right;">
							<img style="width:20px;float:right;" src="images\arrow-down.png">
						</div>
					</div>
				</div>
				<div id="chatheads">

					<?php					
					$result = mysqli_query($con, "SELECT * FROM `chats` WHERE '$uname' IN(ini_user, rec_user) ORDER BY id DESC");

					while($res = mysqli_fetch_assoc($result)){
						if($res['ini_user'] == $uname){ $chatto =  $res['rec_user'];} else { $chatto = $res['ini_user'];} 
					?>
						<div class="chatblock" onclick="window.location.href='chat.php?to=<?php echo $chatto; ?>'">
							<div style="width:40px;display: inline-block;">
								<img class="profile" src="images\m1.jpg">
							</div>
							<div style="width:200px;display: inline-block;">
								<h3 class="username"><?php echo $chatto; ?></h3>
								<span class="status"></span>
								<?php
									$lastChat = mysqli_query ($con, "SELECT msg_body FROM messages WHERE msg_from = '$msg_from' AND msg_to = '$msg_to' ORDER BY id DESC LIMIT 1");
									$lastChatRow = mysqli_fetch_assoc($lastChat);
									echo '<script type="text/javascript">alert("'.$lastChatRow['msg_body'].'")</script>';
								?>
								<p class="lastchat"><?php echo $lastChat; ?></p>
							</div>
							<div style="width:50px;display: inline-block;">
								<p class="timestamp" style="">03.42</p>
								<span class="chatcount">4</span>
							</div>	
						</div>

					<?php					
					}  // end of while loop
					?>

					<div class="more">
						<img src="images\dots.png" style="width:20px;display: inline-block;">
					</div>
				</div>
			</div>
			<div class="rightc">
				<div id="chatbox">
					<div style="width:30px;display: inline-block;"><p class="timestamp" style="font-weight: bold;">To : </p></div>
					<div style="width:200px;display: inline-block;"><h3 style="color:white;"><?php if($msg_to == ""){} else { echo $msg_to; } ?></h3></div>
					<div style="width:30px;display: inline-block;float:right;"><img style="width:25px;height:20px;float:right;" src="images\vdo.png"></div>	
				</div>

				<div id="mainchatbox">
					<div id="scrollElem">
						<?php
						$line = true;
						$resn = mysqli_query($con, "SELECT * FROM messages WHERE (msg_from, msg_to) IN (('$msg_from','$msg_to'), ('$msg_to','$msg_from'))");
						// $resn = getMessages($msg_from, $msg_to, $purposeid);
						while($rown = mysqli_fetch_assoc($resn)){

							if($rown['msg_from'] != $msg_from){
								if($rown['msg_read_to'] == "no"){
									if($line){
										echo "<div id='unline' style='border-bottom: 1px solid lightgrey; float:left; width: 100%; margin: 10px 0px; height:auto;'>unread messages</div>";
										$line = false;
									}

								}
							}

							if($rown['msg_from'] == $msg_from){
							?><div class="schat"><div style="width:90%;padding-left: 30px;"><?php echo $rown['msg_body']; ?><img class="profile" src="images\m1.jpg" style="float:right;margin-right: -3px;"></div></div><br/><?php
							}else{
							?><div class="rchat"><img class="profile" src="images\m2.jpg" style="float:left;margin-left: -3px;margin-right: 10px;"><div style="width:90%;padding-left: 40px;"><?php echo $rown['msg_body']; ?></div></div><?php
							}
						}
						?>
					</div>			
				</div>
				<br/><p id="typeStat"><img src="images\idots.png" style="width:30px;">&ensp;Typing...</p>
				<div id="sender">
					<form action="" method="POST" autocomplete="off">
					<div id="inparea">
						<input type="text" name="msg" id="msg" onfocus="typing()" onblur="notTyping()" autocomplete="off" required>
					</div>
					<div style="display: inline-block; width: 20%;">
						<!-- ##### SEAMLESS SENDING OF MESSAGES = ONCLICK CALL AJAX FUNCTION = W/OUT PAGE REFRESH ON EVERY SUBMIT --> 
						<input type="submit" name="msgsend" id="sendbtn" value="Send">
					</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	
	<?php
		 if($rown['msg_from'] != $msg_from){
		 	$yes = "yes";
		 	$query = mysqli_query($con, "UPDATE messages SET msg_read_to='$yes' WHERE msg_to='$msg_from'");
		 	if($query){ }else{ echo "<script>console.log( 'Internal Error: Sorry! msgReadUp query not updated!' );</script>"; }
		 }
	?>

	<script type="text/javascript">
		(function (){	
				var x = $('#unline').position();
				document.getElementById('mainchatbox').scrollTop = document.getElementById('mainchatbox').scrollHeight;
				document.getElementById('mainchatbox').scrollTop = x.top - 20;		
		})();		
	</script>
</body>
