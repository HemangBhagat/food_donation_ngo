<?php
    $num=0;
    session_start();
    
	$conn = mysqli_connect("localhost","root","","ngo");
    $user_id= $_SESSION['userid'];
    $date = date('Y-m-d') ;
    $time = date('H:i:s');
    
    if(isset($_GET['no'])&&$_GET['no']!="--")
    {
        $num=$_GET['no'];
        $_SESSION['num']=$num;
    }
    if(!empty($_POST['Donate'])&& isset($num))
    {
        function sql_query($conn, $sql, $return_last_id=false)
        {
            $sql = mysqli_query($conn,$sql);
            if(mysqli_error($conn))
            {
                echo mysqli_error($conn);
                echo "\n";
                return false;
            }
            if($return_last_id)
            {
                return mysqli_insert_id($conn);
            }
            return $sql;
        }
        $prio=$_POST['pri'];

        $sql="INSERT INTO `donation`(user_id, don_date, don_time,priority) VALUES ($user_id,'{$date}','{$time}',$prio)";
        $don =  sql_query($conn, $sql, true);
        $_SESSION['donation_id']=$don;
        for($i=1; $i<=$_SESSION['num']; $i++)
        {
            $fitem1=$_POST['food_item'.$i];
            echo "fitem1";
            echo $fitem1;
           $serve1=$_POST['servings'.$i];
            $c_time1=$_POST['ctime'.$i];
            
            $queryitem=mysqli_query($conn,"SELECT ftype from `total_food` where foodname='{$fitem1}' ");
            $res_queryitem = mysqli_fetch_array($queryitem,MYSQLI_ASSOC);
            $ftype1=$res_queryitem['ftype'];
            echo $ftype1;
            $query="SELECT * FROM `total_food` WHERE foodname = '{$fitem1}'";
            $query_run=mysqli_query($conn,$query);
            $queryrow=mysqli_fetch_assoc($query_run);
            if(mysqli_error($conn))
            {
                echo mysqli_error($conn);
                return false;
            }
            $quan=$queryrow['total_quantity'];
    
            
            $total_quan = $serve1 + $quan;

            $sqlq = "UPDATE `total_food` SET total_quantity=$total_quan WHERE foodname='{$fitem1}'";
            $sqlq_run = mysqli_query($conn,$sqlq);
            if(mysqli_error($conn))
            {
                echo mysqli_error($conn);
                return false;
            }
            
            $query1 = mysqli_query($conn,"INSERT INTO `food_donated` VALUES ($don,$user_id,'{$fitem1}','{$ftype1}', $serve1, '{$c_time1}',$prio )");
            if(mysqli_error($conn))
            {
                echo mysqli_error($conn);
                return false;
            }
        }
        header('location:don_map.php');
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donation</title>

    <link rel="stylesheet" href="assets/CSS/bootstrap5.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">

    <link rel="stylesheet" href="assets/CSS/custom.css"> <!--custom css of our own-->

    <script>
        (function($) {
         $( window ).scroll( function () {
    if ( $(document).scrollTop() > 300 ) {
      // Navigation Bar
      $('.navbar').removeClass('fadeIn');
      $('body').addClass('shrink');
      $('.navbar').addClass('fixed-top animated fadeInDown');
    } else {
      $('.navbar').removeClass('fadeInDown');
      $('.navbar').removeClass('fixed-top');
      $('body').removeClass('shrink');
      $('.navbar').addClass('animated fadeIn');
    }
  });  
})(jQuery);

    </script>

</head>
<body>

<!-- nav bar start-->
    <!-- Fixed navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container">
        <a class="navbar-brand" href="#">Food Donation NGO</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>        
        <div class="collapse navbar-collapse" id="navbarMain">
          <ul class="navbar-nav ml-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="donate.php">Donate</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" href="request.php">Request</a>
            </li>
            
            <li class="nav-item">
              <a class="nav-link active" href="reviews.php">Review</a>
            </li>
            <?php if(isset($_SESSION['user_name'])){ ?> 
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <?php echo $_SESSION['user_name']?>
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="admin/myprofile.php">My Profile</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="logout.php">Logout</a></li>
              </ul>
            </li>
            <?php } else { ?>
                <li class="nav-item">
                    <a class="nav-link" href="login.php">Sign-in</a>
                </li>
            <?php } ?>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
    <div class="container jumbo">
        <!-- navbar end-->
        <div class=" container-fluid mx-auto " style=" background:LightCyan; margin-bottom:50px">
    <div class="text-center"><h1>Donate<h1></div>
</div>
<div class="card text-center">
  <div class="card-header">
    Donation Details
  </div>
  <div class="card-body">
    <h5 class="card-title">Number Of Donation:</h5>
    <select name="amount" id="amount" onchange="changetype()">
                                    <option value="--">--</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
  </div>
</div>          

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?> " method="post" enctype="multipart/form-data" >
        
        <hr>
        <?php
            for($i=1; $i<=$num; $i++)
            {

            
        ?>
       <div class="container">
           <div data-name="dish_field<?php echo $i?>" class="p-2 border rounded bg-light my-2 mx-auto" style="max-width: 550px;">
                <label for="">
                    <p>Dishes:</p>
                </label><select name="food_item<?php echo $i?>" id="food_item<?php echo $i?>">
                    <optgroup label="VEG">
                        <option value="Rice">Rice</option>
                        <option value="Bread">Roti/Bread</option>
                        <option value="Veg Gravy">paneer/potato/mix veggies gravy</option>
                    </optgroup>
                    <optgroup label="NON-veg">
                        <option value="Fish Gravy">Fish Gravy</option>
                        <option value="Chicken_Gravy">Chicken Gravy</option>
                    </optgroup>
                </select>
                <br>
                <label for="servings<?php echo $i?>">
                    <P>Servings</p>
                </label><input type="number" name="servings<?php echo $i?>" id="servings<?php echo $i?>">
                <br>
                <label for="ctime<?php echo $i?>">time it was prepared: </label><br><input type="time" name="ctime<?php echo $i?>" id="ctime<?php echo $i?>">
                <hr>
            </div>
            <?php }?>
            <hr>
            <div class="card text-center">
                
  <div class="card-header">
    <p><strong>Select Priority For The Donation</strong></p>
  </div>
  <div class="card-body">
    <h5 class="card-title"></h5>
        <div data-name="dish_field2">
                
            <input type="radio" name="pri" value="1"><label for="low"> Low Priority   </label>
            <input type="radio" name="pri" value="2"><label for="medium">Medium Priority</label>
            <input type="radio" name="pri" value="3"><label for="high">High Priority</label>
            <br>
            <button type="submit" class="btn btn-primary" name="Donate" value="Donate">Donate</button>
       </div>
       </div>
       </div>
    </form>
    <script defer> 
        function changetype(){
            var x=document.getElementById("amount").value
            var restring ="/Ngo/donate.php?no="+x
            window.location=restring
        }
    </script>
    <!--<script src="toggle.js"></script>-->
    <script src="assets/js/jquery.min.js"></script>   
<script src="assets/js/bootstrap5.bundle.min.js"></script>   
<script src="assets/js/customscripts.js"></script>   <!--custom js code of our own-->
</body>
</html>