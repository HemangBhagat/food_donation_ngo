<?php
include('includes/header.php');
$conn = mysqli_connect("localhost","root","","ngo");
?>

<div class="container-fluid px-4">
    <h2 class="mt-4">Users</h2>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
        <li class="breadcrumb-item active">users</li>

    </ol>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Registered user</h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>User-ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>UserName</th>
                                <th>Phone No.</th>
                                <th>Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $query="SELECT * from `registration`";
                                $query_run=mysqli_query($conn,$query);
                                $rows=mysqli_num_rows($query_run);
                                
                                if($rows>0)
                                {
                                    foreach($query_run as $rows)
                                    {
                                        ?>
                                            <tr>
                                                <td><?php echo $rows['User_id']?></td>
                                                <td><?php echo $rows['Fname']?></td>
                                                <td><?php echo $rows['Lname']?></td>
                                                <td><?php echo  $rows['Username']?></td>
                                                <td><?php echo $rows['Phone']?></td>
                                                <td><?php echo $rows['Email']?></td>
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
