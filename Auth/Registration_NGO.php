<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Registration</title>
		
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.1/font/bootstrap-icons.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
		<script src="https://use.fontawesome.com/releases/v5.0.7/js/all.js"></script>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
		
		<link rel="stylesheet" type="text/css" href="test1.css">
	</head>
	<body>
		<?php
			 session_start();
			 $error_message = "";	//to display error messages
			 
		if($_SERVER['REQUEST_METHOD']=="POST")
		{
			if(!empty($_POST["submit_reg"]))
			{
				// retrieve the name(Fname,Lname), username, email, password, phone, address, password
				$Fname = $_POST["Fname"];
				$Lname = $_POST["Lname"];
				$Username = $_POST["Username"];
				$phone = $_POST["phone"];
				$email = $_POST["email"];
				$password= $_POST["password"];

				// establish connection to db
				$conn = mysqli_connect("localhost","root","","ngo");
				if (!$conn) 
				{
					die("Connection failed: " . mysqli_connect_error());
				}
				echo "Connected successfully";
				
				$check_username = mysqli_query($conn, "SELECT * FROM `registration` WHERE Username='{$Username}'");
				$count_rows = mysqli_num_rows($check_username);
				
				$check_username_admin = mysqli_query($conn,"SELECT * FROM `admins` WHERE admin_username='{$Username}'");
				$count_rows_admin = mysqli_num_rows($check_username_admin);
				
				if($count_rows==0 && $count_rows_admin==0)
				{
					echo "new user";
					// check if the user with the entered email already exists in db, if email already exists, do not allow to register
					$res = mysqli_query($conn,"SELECT * FROM `registration` WHERE Email='{$email}'");
					$count = mysqli_num_rows($res);
	
					$res2 = mysqli_query($conn,"SELECT * FROM `ADMINS` WHERE Email='{$email}'");
					$count2 = mysqli_num_rows($res2);
					
					if($count<1 && $count2<1)
					{
						echo " email does not exist ";
                        //GENERATE HASH FOR PASSWORD
                        $password_hash = password_hash($password, PASSWORD_DEFAULT);
						A:
						$User_id=rand(10000,99999);
						/*$sql=mysqli_query($conn,"SELECT * FROM 'registration'");
						if(mysqli_num_rows($sql)>0)
						{
							while($row['userID']==$userID)
							{
								goto A;
							}
						}*/
						
                        //here we generate OTP
                        $OTP = rand(100000,999999);
						
						 //Here the sending process begins
                        require_once("OTPmailing_function.php");
                        $mail_status = sendOTP($email,$OTP,false);
						
						if($mail_status == 1) 
						{
							echo " mail sent";
							$temp = mysqli_query($conn,"INSERT INTO `temp` VALUES ('{$Fname}', '{$Lname}', '{$Username}', '$User_id', '$phone', '{$email}','{$password_hash}')");
							$res = mysqli_query($conn,"INSERT INTO `otp_table` VALUES ('{$OTP}','{$email}')");
								
							$_SESSION['email'] = $email;
                            header('location:OTP_page.php'); //redirect to otp_page
                            exit;
                            ob_end_flush();
							
						}
						else 
						{
							$error_message= "Email address is not valid";
                            $_SESSION['error_message'] ;
							header('loaction:error_msg.php');
							exit(0);
                        }
					}
					if($count>=1 && $count2>=1)
					{
						$error_message=="Email already exists.";
						$_SESSION['error_message'];
						header('loaction:error_msg.php');
						exit(0);
					}
				}
				if($count_rows!=0 && $count_rows_admin!=0)
				{
					$error_message="Username already taken.";
					$_SESSION['error_message'];
					header('loaction:error_msg.php');
					exit(0);
				}
			}
		}
			
		?>
		<div class="modal-dialog ">
		
			<div class="col-sm-8 main-section">
			
				<div class="modal-content">
					<form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
					<div style="color:#007FFF; padding-top:5px; padding-bottom:0px">
						<div class="text-center">
							<h1>Registration</h1><hr>
						</div>
					</div>
						<div class="form-group">
							<label>First Name:</label>
							<input type="text" name="Fname" id="Fname" placeholder="First Name" required>
						</div>
						<div class="form-group">
						<label>Last Name:</label>
								<input type="text" name="Lname" id="Lname" placeholder="Last Nmae" required>
						</div>
						
						<div class="form-group">
						<label>Username:</label>
							<input type="text" name="Username" id="Username" placeholder="Username" required>
						</div>
						<div class="form-group">
						<label>Phone Number:</label>
						<input type="text" name="phone" id="phone" placeholder="Phone number" required>
						</div>
						<div class="form-group">
						<label>Email-ID:</label>
							<input type="text" name="email" id="email" placeholder="Email" required>
						</div>
						<div class="form-group">
						<label>Password:</label>
							<input type="password" name="password" id="reg-password" placeholder="User password" required>
						</div>
						<div class="form-group">
							<input type="checkbox" id="show_password" onclick="show_hide_password()">
							<label class="form-check-label" for="show-password" style="transform: translate(0%,-69%);">Show Password</label>
						</div>
						<div class="text-center">
							<button type="submit" style="width:100%" class="btn" value="Submit" name="submit_reg" id="submit_reg">
							<i class="fas fa-registered"></i></i>Register
							</button>
						</div>
					</form>
				</div>
			</div>	
		</div>
					
		<script>
		function show_hide_password() 
		{
			var x = document.getElementById("reg-password");
			if (x.type === "password") 
			{
					x.type = "text";
			} 
			else 
			{
				x.type = "password";
			}
		}
		</script>
	</body>
</html>