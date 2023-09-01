<?php
	session_start();
	
	$conn=mysqli_connect("localhost","root","","ngo");
	if($_SERVER['REQUEST_METHOD']=="POST")
	{
		if(!empty($_POST['submit']))
		{
			$email = $_SESSION['email'];
			$newpass=$_POST['new_password'];
			$reentered_password=$_POST['re-enter_new_pass'];
			if($newpass == $reentered_password)
			{	echo "entered if new pass";
				 $res1=mysqli_query($conn,"SELECT * FROM `registration` WHERE Email='{$email}'");
				 if(mysqli_error($conn))
				 {
					 echo mysqli_error($conn);
				 }
				 echo $email;
				 $count = mysqli_num_rows($res1);
				 echo $count;
				 if($count>0)
				 {
					 echo "entered if count";
					$password_hash = password_hash($newpass, PASSWORD_DEFAULT);
                    $res = mysqli_query($conn,"UPDATE `registration` SET password_hash='{$password_hash}' WHERE Email='{$email}'");
					$res = mysqli_query($conn,"DELETE FROM `OTP_table` WHERE email='{$email}'");
                    session_destroy();
					echo "before header";
                    header('location:login.php');
					echo "after header";
                    exit;
				 }
				$res2 = mysqli_query($conn,"SELECT * FROM `admins` WHERE email = '{$email}'");
                $count2 = mysqli_num_rows($res2);
                if ($count2>0) 
				{
					echo "entered if count2";
                    $password_hash = password_hash($newpass, PASSWORD_DEFAULT);
                    $res = mysqli_query($conn,"UPDATE `admins` SET password_hash='{$password_hash}' WHERE email='{$email}'");
					$res = mysqli_query($conn,"DELETE FROM `OTP_table` WHERE email='{$email}'");
                    session_destroy();
					echo "before header";
                    header('location:login.php');
					echo "after header";
					exit;
                }
			}
			else
			{
				echo "re-entered password is incorrect";
			}
		}
	}

?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Authentication</title>
		<link rel="stylesheet" href="test1.css">
		
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.1/font/bootstrap-icons.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
		<script src="https://use.fontawesome.com/releases/v5.0.7/js/all.js"></script>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	</head>
	<body>
		<div class="modal-dialog ">
		
			<div class="col-sm-8 main-section">
			
				<div class="modal-content">
					
					<form action="<?php echo $_SERVER['PHP_SELF'];?>"  method="post" >
						<div style="color:#007FFF; padding-top:5px; padding-bottom:0px">
							<div class="text-center">
								<h1>New Password</h1><hr>
							</div>
						</div>
						<div class="form-group">
							<input type="text" name="new_password" id="new_password" placeholder="Password" required>
						</div>
						<div class="form-group">
							<input type="text" name="re-enter_new_pass" id="re-enter_new_pass" placeholder="re-enter Password" required>
						</div>
						<button type="submit" class="btn" style="width:100%; border:none;; border:none;" name="submit" value="Submit">Submit<button>
					</form>
				</div>
			</div>
		</div>
	</body>
	