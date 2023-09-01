<?php
	
	session_start(); //start the session, needed for $_SESSION
	$conn=mysqli_connect("localhost","root","","ngo");
	$error_message="";
	
	if($_SERVER['REQUEST_METHOD']=="POST")
	{
		if(!empty($_POST['genarate']))
		{
			$email = $_POST['email_con_newpass'];
			$_SESSION['email'] = $email;
			$res = mysqli_query($conn, "SELECT * FROM `registration` WHERE Email='{$email}'");
			$count = mysqli_num_rows($res);
			if($count>0)
			{
				$OTP = rand(100000,999999);
				require_once("OTPmailing_function.php");
				$mail_status = sendOTP($email,$OTP,false);
				if($mail_status==1){
				$res = mysqli_query($conn,"INSERT INTO `OTP_table` VALUES ('{$OTP}','{$email}')");
				}
			}
			
			else
			{
				echo "Email not registered";
			}
		}
		if(!empty($_POST['submit_otp']))
		{
			$OTP = $_POST['otp_email'];
			$res = mysqli_query($conn,"SELECT * FROM `otp_table` WHERE OTP='{$OTP}' "); 
			$count  = mysqli_num_rows($res);
			
			if($count>0)
			{
				header('location:new_password.php');
			}
			else
			{
				echo "Invalid OTP ";
			}
		}
	}
	
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Authentication</title>
		<link rel="stylesheet" type="text/css" href="test1.css">

		<!--<link rel="stylesheet" href="style2.css">-->
		<!-- BOOTSTRAP -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://use.fontawesome.com/releases/v5.0.7/js/all.js"></script>
	</head>
	<body>
		<div class="modal-dialog ">
		
			<div class="col-sm-8 main-section">
			
				<div class="modal-content">
					<br>
					
					<form action="<?php echo $_SERVER['PHP_SELF'];?>"  method="post" >
						<div class="form-group">
							<div class="input-group-addon" style=" position:absolute; bottom:77%; color:#555e60; padding-left:7px;">
								<i class="fas fa-envelope"></i>
							</div>
							<input type="text" class="form-control" name="email_con_newpass" style="width:100%;" id="email" placeholder="Email" required>
							<button class="btn" style="width:100%" type="submit" name="genarate" value="Generate OTP">
								<label>Generate</label>
							</button>
						</div>
					</form>
					<form action="<?php echo $_SERVER['PHP_SELF'];?>"  method="post" >
						<div class="form-group">
							<input type="text" class="form-control" name="otp_email" id="OTP" placeholder="OTP">
							<button type="submit" class="btn btn primary" name="submit_otp" style="width:100%;" value="Submit" required>
								Submit OTP
							<button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</body>
	