<?php
	session_start();
    //getting email
    $email_id = $_SESSION['email'];
    //$error_message = "";
	
	if($_SERVER['REQUEST_METHOD']=="POST")
	{
		if(!empty($_POST['submit_OTP']) && !empty($_POST['OTP_text_box'])) 
		{
            // retrieve the otp entered by the user
			$OTP = $_POST['OTP_text_box'];
			
			// establish connection to db
            $conn = mysqli_connect("localhost","root","","ngo");

			//checking if user entered otp is the same that was generated
			$res = mysqli_query($conn,"SELECT * FROM `otp_table` WHERE OTP='{$OTP}' "); 
			$count  = mysqli_num_rows($res);
			
			if($count>0)
			{
				// delete the otp entry associated with the registered user
				$res = mysqli_query($conn,"DELETE FROM `otp_table` WHERE email='{$email_id}'");
				 
				$result = mysqli_query($conn, "SELECT * FROM `temp` WHERE Email='{$email_id}'");
				$num_rows=mysqli_num_rows($result);
				
                $row=mysqli_fetch_array($result,MYSQLI_ASSOC); //fetch the row of data from above table
                $Username = $row['Username'];
				$userid = $row['User-id'];
				$Password_hash = $row['Password_hash'];
				$Fname = $row['Fname'];
				$Lname = $row['Lname'];
				$Phone = $row['Phone'];
				$Email = $row['Email'];
                if($num_rows>0)
				{
					echo "else condition to insert data into reg table";
                    //insert new user in the registration table
                    $res = mysqli_query($conn, "INSERT INTO `registration` VALUES('{$Fname}','{$Lname}', '{$Username}', '{$userid}', '{$Phone}','{$Email}','{$Password_hash}')");
                } 
				
				// delete the temp user that was created for the above user previously and also delete the expired temp users
                $row = mysqli_query($conn," DELETE FROM `temp` WHERE Email='{$email}' ");
				 
				header('location:login.php');    //redirect to login_page
				exit;
			}
			else 
			{
				$error_message = "Invalid OTP!";
			}
			if(!empty($_POST['resend_OTP']))
			{
				// establish connection to db
				$conn = mysqli_connect("localhost","root","","ngo");

				//delete previous otp and temp user
				$res = mysqli_query($conn,"DELETE FROM `OTP_table` WHERE email='{$email}'");

				//here we generate OTP
				$OTP = rand(100000,999999);
				
				//Here the sending process begins
				require_once("mailing_function.php");
				$mail_status = sendOTP($email,$OTP,false);
				
				if($mail_status == 1) 
				{ 
					 // INSERT VALUES IN OTP TABLE
					$res = mysqli_query($conn,"INSERT INTO `OTP_table` VALUES ('{$OTP}' , '{$email}')");
                
					header('location:OTP_page.php'); //redirect to otp_page
					exit;
				}
			}
		}
	}
			
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>OTP PAGE</title>
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
		<div class="modal-dialog ">
		
			<div class="col-sm-8 main-section">
			
				<div class="modal-content">		
					<form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
						<div style="color:#007FFF; padding-top:5px; padding-bottom:0px">
							<div class="text-center">
								<h1>Verification</h1><hr>
							</div>
						</div>
						<div class="form-group">
							<div class="text-center">
								<input type="text" name="OTP_text_box" id="OTP_text_box" placeholder="Enter verification code">
							</div>
						</div>
						<div class="text-center">
						<button type="submit" style="width:100%;" class="btn btn primary" name="submit_OTP" value="submit OTP"> 
							<b>SUBMIT</b>
						</button>
						</div>
						<br>
						<input type="submit" name="resend_OTP" value="Resend OTP">
						<br><br>
					</form>
				</div>
			</div>
		</div>
</body>
</html>