<?php
session_start();

$donid = $_SESSION['donid'];
$conn = mysqli_connect("localhost","root","","ngo");

if(!empty($_POST['goback']))
{
    header('location:pickup.php');
}
include('includes/header.php');
?>

<div class="container-fluid px-4">
    <h2 class="mt-4">Donation</h2>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Details</li>

    </ol>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4><?php echo $_SESSION['donid']?> </h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Donation ID</th>
                                <th>Dish</th>
                                <th>Type</th>
                                <th>Servings</th>
                                <th>Time</th>
                                <th>Priority</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $query="SELECT * from `food_donated` WHERE donation_id=$donid ";
                                $query_run=mysqli_query($conn,$query);
                                $rows=mysqli_num_rows($query_run);
                                
                                if($rows>0)
                                {
                                    foreach($query_run as $rows)
                                    {
                                        ?>
                                            <tr>
                                                <td><?php echo $_SESSION['donid'];?></td>
                                                <td><?php echo $rows['food_name']?></td>
                                                <td><?php echo $rows['type']?></td>
                                                <td><?php echo  $rows['serving']?></td>
                                                <td><?php echo $rows['cook_time']?></td>
                                                <td><?php echo $rows['priority']?></td>
                                            </tr>
                                        <?php
                                    }
                                }
                                else
                                {
                                    ?>
                                        <tr>
                                            <td colspan="6">  No Record Found  </td>
                                        </tr>
                                    <?php
                                }
                                ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<br>
</div>
<form action="#" method=POST>
    <button type="submit" class="btn btn-primary" name="goback" id="goback" value="goback" > Go Back </button>
</form>

<?php
include('includes/footer.php');
include('includes/scripts.php');
?>