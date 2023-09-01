<?php
session_start();
include('includes/driver_header.php');
$conn = mysqli_connect("localhost","root","","ngo");

$sql2="SELECT * FROM `donation` ";
 $sql2_run=mysqli_query($conn,$sql2);
 $row2=mysqli_num_rows($sql2_run);
 
 $sql3="SELECT * FROM `food_request` ";
 $sql3_run=mysqli_query($conn,$sql3);
 $row3=mysqli_num_rows($sql3_run);

?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Driver Panel</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">Total Pickup</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <?php
                        echo $row2;
                    ?>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
              </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning text-white mb-4">
                   <div class="card-body">Total Delivery</div>
                    <div class="card-footer d-flex align-items-center justify-content-between">                            <a class="small text-white stretched-link" href="#">View Details</a>
                    <?php
                        echo $row3;
                    ?>
                    </div>
            </div>
        </div>
    </div>

</div>

<?php
include('includes/footer.php');
include('includes/scripts.php');
?>
