<?php 
	require("functions.php");
	
    require("Helper.class.php");
	$Helper = new Helper();
	
	require("User.class.php");
	$User = new User($mysqli);
	
	if(isset ($_SESSION["userId"])) {
		header("Location: data.php");
		exit();
	}
	
	$signupEmailError = "";
	$signupEmail = "";
	$loginEmail = "";
	$loginPassword = "";
	
	if (isset ($_POST["signupEmail"])) {
		
		
		if (empty ($_POST["signupEmail"])) {
			
			
			$signupEmailError = "See väli on kohustuslik";
			
		} else {
				
			
			$signupEmail = $_POST["signupEmail"];
		}
		
	}
	
	$signupPasswordError = "";
	
	if (isset ($_POST["signupPassword"])) {
		
		
		if (empty ($_POST["signupPassword"])) {
			
		
			$signupPasswordError = "See väli on kohustuslik";
			
		} else {
			
			if (strlen ($_POST["signupPassword"]) < 8 ) {
				
				$signupPasswordError = "Parool peab olema vähemalt 8 tm pikk";
				
			}
			
		}
		
	}
	
	
	$gender = "";
	if(isset($_POST["gender"])) {
		if(!empty($_POST["gender"])){
			
			$gender = $_POST["gender"];
		}
	}
	$birthdateError = "*";
	 
	 if (isset($_POST["birthdate"])) {
		
		
		if (empty ($_POST["birthdate"])) {
			
			$birthdateError = "Sisesta oma sünnikuupäev!";
		}
	}
	$loginEmailError = "*";
	$loginEmail = "";
	if (isset ($_POST["loginEmail"])) {
		if (empty ($_POST["loginEmail"])) {
			$loginEmailError = "* Väli on kohustuslik!";
		
		} else {
			$loginEmail = $_POST["loginEmail"];
			}
			
	
	}
	
	$loginPasswordError = "*";
	if (isset ($_POST["loginPassword"])) {
		if (empty ($_POST["loginPassword"])) {
			$loginPasswordError = "* Väli on kohustuslik!";
		}
	}	
		
	
	if ( isset($_POST["signupEmail"]) &&
		 isset($_POST["signupPassword"]) &&
		 $signupEmailError == "" && 
		 empty($signupPasswordError)
	   ) {
		
	
		echo "salvestan...<br>";
		echo "email ".$signupEmail."<br>";
		//echo "parool ".$_POST["signupPassword"]."<br>";
		
		$password = hash("sha512", $_POST["signupPassword"]);
		

		echo "räsi ".$password."<br>";
		
		
		$User->signup($signupEmail, $password);
		
	}	
	
	
	$notice = "";
	
	if (	isset($_POST["loginEmail"]) && 
			isset($_POST["loginPassword"]) && 
			!empty($_POST["loginEmail"]) && 
			!empty($_POST["loginPassword"]) 
	) {
		$notice = $User->login($_POST["loginEmail"], $_POST["loginPassword"]);
		
		if(isset($notice->success)){
			header("Location: login.php");
			exit();
		}else {
			$notice = $notice->error;
			var_dump($notice->error);
		}
		
	}
	
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Sisselogimise leht</title>
	</head>
	<body>
	
		<h1>Logi sisse</h1>
		<p style="color:red;"> <?=$notice;?></p>
		<form method="POST" >
	
			<label>E-post</label><br>
			<input name="loginEmail" type="email"  value="<?=$loginEmail;?>" > <?php echo $loginEmailError; ?>
			<br> <br>
			<label>Parool</label><br>
			<input name="loginPassword" type="password"> <?php echo $loginPasswordError; ?>
			<br> <br>
			<input type="submit" value="Logi sisse">			
		</form>
		
			<h1>Loo kasutaja</h1>
		
		<form method="POST" >
		
			<label>E-post</label><br>
			<input name="signupEmail" type="email" value="<?=$signupEmail;?>"> <?php echo $signupEmailError; ?>
			<br> <br>
			<label>Parool</label><br>
			<input name="signupPassword" type="password"> <?php echo $signupPasswordError; ?>
			<br> <br>
			
			<?php if ($gender == "female") { ?>
				<input type="radio" name="gender" value="female" checked> female<br>
			<?php } else { ?>
				<input type="radio" name="gender" value="female" > female<br>
			<?php } ?>
			
			<?php if ($gender == "male") { ?> 
							<input type="radio" name="gender" value="male" checked> male<br>
			<?php } else { ?>
				<input type="radio" name="gender" value="male" > male<br>
			<?php } ?>
			
			
			<?php if ($gender == "other") { ?>
				<input type="radio" name="gender" value="other" checked> other<br>
			<?php } else { ?>
				<input type="radio" name="gender" value="other" > other<br>
			<?php } ?>
			
			<br><br>
			<label>Sunnikuupaev:</label><br> 
			<input name="birthdate" type="date"> <?php echo $birthdateError; ?><br><br>
			
			<input type="submit" value="Loo kasutaja">
			
		</form>

		
	


</html> 
