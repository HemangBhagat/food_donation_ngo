<?php
    session_start();
    if(!isset($_SESSION['userid']))
    {
        header('location:login.php');
    }
	$conn = mysqli_connect("localhost","root","","ngo");
    $user_id= $_SESSION['userid'];
    $date = date('Y-m-d') ;
    $time = date('H:i:s');

    if(!empty($_POST['Done']))
    {
        if(!empty($_POST['add']))
        {
            $type=$_POST['req_type'];
            $servings = $_POST['req_servings'];
            $location = $_POST['loc'];
            $add=$_POST['add'];
            $sql="INSERT INTO `food_request`(user_id, req_type , servings , req_date, req_time, req_location) VALUES ($user_id,'{$type}',$servings,'{$date}','{$time}','{$location}')";
            $sql_run= mysqli_query($conn,$sql);
            $sql1="INSERT INTO `address` VALUES($user_id,'{$add}')";
            $sql1_run=mysqli_query($conn,$sql1);
            header('location:request_con.php'); 
        }
        else
        {
            $type=$_POST['req_type'];
            $servings = $_POST['req_servings'];
            $location = $_POST['loc'];
            $add=$_POST['add'];
            $sql="INSERT INTO `food_request`(user_id, req_type , servings , req_date, req_time, req_location) VALUES ($user_id,'{$type}',$servings,'{$date}','{$time}','{$location}')";
            $sql_run= mysqli_query($conn,$sql);
            header('location:request_con.php'); 
        }
    }
    

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Request</title>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBimqJizKom7LcizcvUdr-BGGq8dHEtCbE"></script>
        <script>
            var position = [15.496596, 73.835353];
            
            function initialize() { 
                var latlng = new google.maps.LatLng(position[0], position[1]);
                var myOptions = {
                    zoom: 16,
                    center: latlng,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                };
                map = new google.maps.Map(document.getElementById("mapCanvas"), myOptions);
            
                marker = new google.maps.Marker({
                    position: latlng,
                    map: map,
                    title: "Latitude:"+position[0]+" | Longitude:"+position[1]
                });
            
                google.maps.event.addListener(map, 'click', function(event) {
                    var result = [event.latLng.lat(), event.latLng.lng()];
                    transition(result);
                });
            }
            
            //Load google map
            google.maps.event.addDomListener(window, 'load', initialize);
            
            
            var numDeltas = 100;
            var delay = 10; //milliseconds
            var i = 0;
            var deltaLat;
            var deltaLng;
            
            function transition(result){
                i = 0;
                deltaLat = (result[0] - position[0])/numDeltas;
                deltaLng = (result[1] - position[1])/numDeltas;
                moveMarker();
            }
            
            function moveMarker(){
                position[0] += deltaLat;
                position[1] += deltaLng;
                var latlng = new google.maps.LatLng(position[0], position[1]);
                marker.setTitle("Latitude:"+position[0]+" | Longitude:"+position[1]);
                marker.setPosition(latlng);
                document.querySelector("#loc").value=position;
                // document.querySelector("#longitude").value=position[1];
                if(i!=numDeltas){
                    i++;
                    setTimeout(moveMarker, delay);
                }
            }
            </script>
            <style>
                #mapCanvas{
                            width: 500px;
                            height: 500px;
                        }
            </style>

    <link rel="stylesheet" href="assets/CSS/bootstrap5.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">

    <link rel="stylesheet" href="assets/CSS/custom.css"> <!--custom css of our own-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" type="text/css" href="navbar_style.css">
</head>
<body>

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
                <li><a class="dropdown-item" href="logout.php">Log-out</a></li>
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



<div class=" container-fluid mx-auto " style=" background:LightCyan; margin-bottom:50px">
    <div class="text-center"><h1>Request<h1></div>
</div>


                <form  action="#" method=POST>
                <div class="container">
                    <div class="p-2 border rounded bg-light my-2 mx-auto" style="max-width: 550px;">
                                        Food Type: <br><select class="custom-select" style="width:20%" name="req_type" id="req_type" >
                                        <optgroup label="Type">
                                            <option value="Veg"> Veg </option>
                                            <option value="Non_veg"> Non Veg </option>
                                            <option value="Any"> Any </option>
                                        </optgroup>
                                        </select>
                                            <br>
                                        <br>
                                        Servings: <br><input type="number" value="req_servings" name="req_servings" id="req_servings" placeholder="servings">
                                        <br>
                </div>
            </div>
            <div class="container">
                
                    <div class="p-2 border rounded bg-light my-2 mx-auto" style="max-width: 550px;">
                    Address: <br><textarea  name="add" value="add" rows="3" cols="30" >(optional)</textarea>
                  
                    <br>
                    <br>
                    <label for="loc">Location: </label><input type="text" id="loc" name="loc" placeholder="location">
                    <br>    
                    <center>         
                    <div id="mapCanvas"></div>
                    <br>
                    <button class="btn btn-primary" name="Done" id="Done" value="Done">Done</button>
            </center>
            </div>
            </div>
                </form>
    <div>
 
</script>
    <!--<script src="toggle.js"></script>-->
    <script src="assets/js/jquery.min.js"></script>   
<script src="assets/js/bootstrap5.bundle.min.js"></script>   
<script src="assets/js/customscripts.js"></script>   <!--custom js code of our own-->
</body>
</html>