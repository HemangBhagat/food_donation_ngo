
<?php
session_start();
$conn = mysqli_connect("localhost","root","","ngo");
$donid=$_SESSION['donidv'];
$select = "SELECT location FROM `donation` WHERE donation_id = $donid";
$select_run = mysqli_query($conn,$select);
if(mysqli_error($conn))
            {
                echo mysqli_error($conn);
                echo "\n";
                return false;
            }
$run=mysqli_fetch_assoc($select_run);
$loc = $run['location'];
$loc1 = explode (",",$loc );

$sql2="SELECT user_id FROM `donation` WHERE donation_id=$donid ";
$sql2_run=mysqli_query($conn,$sql2);
$fetch2=mysqli_fetch_assoc($sql2_run);
$id=$fetch2['user_id'];
if(mysqli_error($conn))
{
    echo mysqli_error($conn);
    echo "\n";
    return false;
}

$sql3="SELECT Address FROM `address` WHERE user_id=$id ";
$sql3_run=mysqli_query($conn,$sql3);
$fetch3=mysqli_fetch_assoc($sql3_run);
echo  "hello";
if(!empty($_POST['goback']))
{
    header('location:pickup.php');
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Dashboard - Driver</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
   
            <style>
              #map {
        height: 450px;
        /* The height is 400 pixels */
        width: 850px;
        /* The width is the width of the web page */
      }
            </style>
      </head>

    <body class="sb-nav-fixed">
        <?php
            //include('includes/topnavbar.php');
        ?>
        <div id="layoutSidenav">
            <?php
               // include('includes/sidebar_driver.php');
            ?>
            <div id="layoutSidenav_content">
                <main>

<div class="container">
           <div  class="p-2 border rounded bg-light my-2 mx-auto" style="max-width: 875px; transform:translate(-14%,-10%)">
    <strong>Address: </strong><?php
            $n="none";
            if($fetch3['Address']!= '{$n}')
            {
              echo $fetch3['Address'];
            }
    ?>                  
    <br>
    <br>
    <div id="map"></div>
  </div>
</div>
<form action="#" methpd="POST">
<button type="submit" class="btn btn-primary" name="goback" id="goback" value="goback" > Go Back </button>
</form>




<script
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBimqJizKom7LcizcvUdr-BGGq8dHEtCbE&callback=initMap&libraries=&v=weekly"
            async
        ></script>
        <script>
            // Initialize and add the map
            function initMap() {
              // The location of Uluru
              const location = { lat: <?php echo $loc1[0] ?>, lng: <?php echo $loc1[1]?> };
              // The map, centered at Uluru
              const map = new google.maps.Map(document.getElementById("map"), {
                zoom: 20,
                center:location,
              });
              // The marker, positioned at Uluru
              const marker = new google.maps.Marker({
                position: location,
                map: map
              });
            
            }
        </script>

<?php
include('includes/footer.php');
include('includes/scripts.php');
?>
