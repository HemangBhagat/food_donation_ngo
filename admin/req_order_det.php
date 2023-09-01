<?php
session_start();
$conn = mysqli_connect("localhost","root","","ngo");

$reqid=$_SESSION['reqid'];
$sql1="SELECT * FROM `req_assign_food` WHERE requested_id=$reqid";
$sql1=mysqli_query($conn,$sql1);
echo $reqid;
include('includes/myprofile_header.php')
?>

<table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Requested Dish</th>
                    <th scope="col">Requested Servings</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <?php echo $sql1['food_assigned'];?>
                    </td>
                    <td>
                        <?php echo $sql1['serving'];?>
                    </td>
                </tr>

<?php
include('includes/footer.php');
include('includes/scripts.php');
?>