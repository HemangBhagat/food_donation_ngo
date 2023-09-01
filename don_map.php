<?php
    session_start(); //start the session, needed for $_SESSION

	$conn = mysqli_connect("localhost","root","","ngo"); // establish connection to database
	$error_message = "";

    if($_SERVER['REQUEST_METHOD']=="POST")
	{
		if(!empty($_POST["Done"]))
		{
            $location=$_POST['loc'];
            $donationid=$_SESSION['donation_id'];
            $sql="UPDATE `donation` SET location = ('{$location}') where donation_id = $donationid ";
            $sql_run= mysqli_query($conn,$sql);
            header('location:donate_con.php');
        }
    }
	

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pickup Location</title>
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
</head>
<body>
    <div id="mapCanvas"></div>
                   
<br>
<form action="<?php echo $_SERVER["PHP_SELF"];?>" method="POST">
    <label for="loc">Location: </label><br><input type="text" id="loc" name="loc">
    <br>
    <button class="btn btn-primary" name="Done" id="Done" value="Done">Done</button>
</form>


</body>
</html>