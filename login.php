
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
