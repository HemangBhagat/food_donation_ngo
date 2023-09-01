<?php

session_start();

$conn = mysqli_connect("localhost","root","","ngo");

$cur_date = date('Y-m-d');
$sql1="SELECT * FROM `food_request` WHERE req_date = '{$cur_date}' ";
$sql1_run = mysqli_query($conn, $sql1); 
$rows1= mysqli_num_rows($sql1_run);

    if(!empty($_POST['assign']))
    {
        $_SESSION['usid']=$_POST['assign'];
        header('location:assign_req_driver.php'); 
    }
    require './includes/header.php';
    ?>
    <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Request ID</th>
                    <th scope="col">User ID</th>
                    <th scope="col">Request Type</th>
                    <th scope="col">Servings</th>
                    <th scope="col">Date</th>
                    <th scope="col">Time</th>
                    <th scope="col">Status</th>
                    <th scope="col">Location</th>
                    <th scope="col">Assigned Food</th>
                    <th scope="col"></th>

                </tr>
            </thead>
            <tbody>
            <?php
                
                if($rows1>0)
                {
                    foreach($sql1_run as $rows1)
                    {
                        ?>
                        <tr>
                        <th scope="rows"><?php echo $rows1['request_id'] ?></th>
                        <td><?php echo $rows1['user_id'] ?></td>
                        <td><?php echo $rows1['req_type'] ?></td>
                        <td><?php echo $rows1['servings'] ?></td>
                        <td><?php echo $rows1['req_date'] ?></td>
                        <td><?php echo $rows1['req_time'] ?></td>
                        <td><?php                               //status
                                 if($rows1['status']==0)
                                 {
                                     echo "Pending";
                                 }
                                 else if($rows1['status']==1)
                                 {
                                     echo "Assigned";
                                 }
                                 else
                                 {
                                     echo "Complete";
                                 }
                            ?>
                        </td>
                        <td><?php echo $rows1['req_location'] ?></td>
                        <form action="#" method="POST">
                            <td>
                                <button type="submit" class="btn btn-primary" name="assign" value="<?php echo $rows1['user_id']?>">Assign</button>
                        </form>
                            </td>
                        </tr>
                        <?php
                    }
                }
                else
                {
                    ?>
                    <p>No Reuqests Registered Currently</p>
                    <?php
                }
            ?>
            </tbody>
        </table>

<?php
include('includes/footer.php');
include('includes/scripts.php');
?>
