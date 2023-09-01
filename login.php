<?php

	session_start(); //start the session, needed for $_SESSION
	$conn = mysqli_connect("localhost","root","","ngo"); // establish connection to database
	$error_message = "";
	
	// here the password and username checking for login will take place
	if($_SERVER['REQUEST_METHOD']=="POST")
	{
		if(!empty($_POST["login"]))
		{
			// retrieve the username and password
            $username = $_POST['username'];
            $password = $_POST['password'];

			// search if the entered username and password are present in the Registraion table or ADMINS table. 
            // If yes, then allow login.
			$res = mysqli_query($conn,"SELECT * FROM `registration` WHERE Username='{$username}'");
            $count = mysqli_num_rows($res);
			
			$count2 = 0;
			$count3 = 0;
			if($count<1)
			{
				echo "inside count cond";
				echo $username;
                $res2 = mysqli_query($conn,"SELECT * FROM `admins` WHERE admin_username='$username'");
                $count2 = mysqli_num_rows($res2); 

				$res3 =  mysqli_query($conn,"SELECT * FROM `driver_det` WHERE d_username='$username'");
				$count3 = mysqli_num_rows($res3); 
            }
			if($count>0 || $count2>0 || $count3>0)
			{	
				if($count>0)
				{
                 $row=mysqli_fetch_array($res,MYSQLI_ASSOC); //fetch the row of data from above registartion table
				 $password_hash = $row['password_hash'];		//password stored in the row from the table is stored in a var
				}
				if($count2>0)
				{
                    $r_res2=mysqli_fetch_array($res2,MYSQLI_ASSOC); //fetch the row of data from above admins table
					$password_hash = $r_res2['password_hash'];		//password stored in the row from the table is stored in a var

				}
				if($count3>0)
				{
                    $r_res3=mysqli_fetch_array($res3,MYSQLI_ASSOC); //fetch the row of data from above admins table
					$password_hash = $r_res3['d_password_hash'];		//password stored in the row from the table is stored in a var

				}
				
				if(password_verify($password,$password_hash))
				{
					// set the session array for the rest of the webpages to access the auth status, whether user is logged in, or not.
					if(mysqli_error($conn))
					{
						echo mysqli_error($conn);
					}
					if ($count>0)
					{
						// $query = mysqli_query($conn,"SELECT User_id FROM `registration` WHERE Username='$username'");
						// $queryres = mysqli_fetch_array($query,MYSQLI_ASSOC);
						$_SESSION['user_name']=$row['Fname']." ".$row['Lname'];
						$_SESSION['userid']=$row['User_id'];
						header('location:start.php');
                    	exit;
					}
					if ($count2>0)
					{
                        // if the user is an admin, this will be set, so anywhere if we need to impose restrictions(for eg. in answering reviews, admin block..etc) 
                        // then we can check if $_SESSION['admin'] is set. If its set then user is an admin.
                        $_SESSION['admin'] = "YES";
						$_SESSION['ad_username']=$username;
						header('location:admin/admin_panel.php');
						exit;
                    }
					if ($count3>0)
					{
						$_SESSION['d_user_name']=$r_res3['d_fname'].' '.$r_res3['d_lname'];
						$_SESSION['driver_id'] = $r_res3['d_userid'];
						header('location:admin/driver.php');
						exit;
					}
				}
				else 
				{
                    $error_message = "Incorrect password";
					echo $error_message;
				}
			}
			else
			{
                $error_message = "This user is not registered";
				echo $error_message;
            }
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Login</title>
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
					<form class="col-12" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post" >
						<div style="color:#007FFF; padding-top:5px; padding-bottom:0px">
							<div class="text-center">
								<h1>Login</h1><hr>
							</div>
						</div>
						<div class="form-group">
							<div class="input-group-addon" style=" position:absolute; bottom:68%; color:#555e60; padding-left:7px;">
							<i class="fas fa-user"></i>
							</div>
							<input type="text" class="form-control" name="username" placeholder="Username"  required >
						</div>
						
						<div class="form-group">
							<div class="input-group-addon" style=" position:absolute; bottom:52%; color:#555e60; padding-left:7px;">
							<i class="fas fa-lock"></i>
							</div>
							<input type="password" class="form-control" id="reg-password" name="password" placeholder="Password" required>
						</div>
							<input type="checkbox" id="show_password" onclick="show_hide_password()">
							<label class="form-check-label" for="show-password" style="transform: translate(-1%,-9%);">Show Password</label>
						<br>
						<a href="forget_password.php" target="_self">Forgot Password?</a>
						<br>
						<div class="text-center">
							<button type="submit" class="btn" id="login" name="login" value="login">
							<i class="fas fa-sign-in-alt"></i>Login
						</button>
						</div>
						<hr>
						<div class="text-center">
						<label>Don't have an account?</label> <a href="Registration_NGO.php" target="_self">Register</a>
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