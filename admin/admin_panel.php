<?php
session_start();
include('includes/header.php');
$conn = mysqli_connect("localhost","root","","ngo");

$sql1="SELECT * FROM `registration` ";
$sql1_run=mysqli_query($conn,$sql1);
$row1=mysqli_num_rows($sql1_run);

$sql2="SELECT * FROM `donation` ";
$sql2_run=mysqli_query($conn,$sql2);
$row2=mysqli_num_rows($sql2_run);

$sql3="SELECT * FROM `food_request` ";
$sql3_run=mysqli_query($conn,$sql3);
$row3=mysqli_num_rows($sql3_run);

$sql4="SELECT * FROM `driver_det` ";
$sql4_run=mysqli_query($conn,$sql4);
$row4=mysqli_num_rows($sql4_run);

?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Admin Panel</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">Total Registerd user</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <?php echo $row1?>
              </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning text-white mb-4">
                <div class="card-body">Total Requests</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <?php echo $row2?>
              </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">Drivers Available</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <?php echo $row3?>
              </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card bg-danger text-white mb-4">
                <div class="card-body">Total Donation Orders</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <?php echo $row4?>
              </div>
            </div>
        </div>
    </div>

</div>

<?php
include('includes/footer.php');
include('includes/scripts.php');
?>
