<?php
include('includes/header.php');
$conn = mysqli_connect("localhost","root","","ngo");

?>

<div class="container-fluid px-4">
    <h2 class="mt-4">Drivers</h2>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Details</li>
        <li class="breadcrumb-item active">Driver</li>

    </ol>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Registered Drivers</h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Username</th>
                                <th>Phone No</th>
                                <th>Driver ID</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $query="SELECT * from `driver_det`";
                                $query_run=mysqli_query($conn,$query);
                                $rows=mysqli_num_rows($query_run);
                                
                                if($rows>0)
                                {
                                    foreach($query_run as $row)
                                    {
                                        ?>
                                            <tr>
                                                <td><?php echo $row['d_fname']?></td>
                                                <td><?php echo $row['d_lname']?></td>
                                                <td><?php echo $row['d_username']?></td>
                                                <td><?php echo  $row['d_phone']?></td>
                                                <td><?php echo $row['d_userid']?></td>
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

</div>

<?php
include('includes/footer.php');
include('includes/scripts.php');
?>
