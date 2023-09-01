<?php
$conn = mysqli_connect("localhost","root","","ngo");
 session_start();
 include('includes/driver_header.php');
 
$cur_date = date('Y-m-d') ;

$sql0="SELECT * FROM `food_request` ";
$sql0_run=mysqli_query($conn,$sql0);
$fet0=mysqli_fetch_assoc($sql0_run);
$userid=$fet0['user_id'];
$reqid=$fet0['request_id'];


$sql1="SELECT * FROM `req_assign_food` WHERE request_id=$reqid";
$sql1_run=mysqli_query($conn,$sql1);
$fet1=mysqli_fetch_assoc($sql1_run);
$row1=mysqli_num_rows($sql1_run);


$sql2="SELECT * FROM `food_request` WHERE user_id= $userid";
$sql2_run=mysqli_query($conn,$sql2);
$fet2=mysqli_fetch_assoc($sql2_run);

if(!empty($_POST['view']))
{
    $_SESSION['reqidv'] = $_POST['view'];
    header('location:req_map1.php');
}
if(!empty($_POST['check']))
{
    $_SESSION['reqid'] = $_POST['check'];
    header('location:req_order_det.php');
}
if(!empty($_POST['deli']))
{
    $del = $_POST['deli'];
    $sqlq = "UPDATE `food_request` SET status=2 WHERE request_id = $del";
    $sqlq_run = mysqli_query($conn,$sqlq);
    if(mysqli_error($conn))
    {
        echo mysqli_error($conn);
    }
}

?>
<table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Donation ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Status</th>
                    <th scope="col">Type</th>
                    <th scope="col">Location</th>
                    <th scope="col">Order_details</th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody><?php
                $pre_id=0;$pname=0;$pstat=0;
                if($row1>0)
                {
                    foreach($sql2_run as $fet2)
                    {
                        // $sql2="SELECT * FROM `food_request` WHERE user_id= $userid";
                        // $sql2_run=mysqli_query($conn,$sql2);
                        // $fet2=mysqli_fetch_assoc($sql2_run);

                        ?>
                        <tr>
                            <td>
                                <?php
                                    if($pre_id == $fet2['request_id'])
                                    { echo ""; 
                                        $pname=0;
                                    }
                                    else{
                                        echo $fet2['request_id'];
                                        $pre_id = $fet2['request_id'];
                                        $pname=1;
                                    }
                                ?>
                            </td>

                            <td>
                                <?php
                                        $id=$fet2['user_id'];
                                        $s1="SELECT * FROM `registration` where User_id=$id";
                                        $s1_run=mysqli_query($conn,$s1);
                                        $fets1=mysqli_fetch_assoc($s1_run);
                                        $name=$fets1['Fname']." ".$fets1['Lname'];
                                        echo $name;
                                ?>
                            </td>

                            <td>
                            <?php
                                if($fet2['status']==0)
                                {
                                    echo "Pending";
                                }
                                else if($fet2['status']==1)
                                {
                                    echo "Assigned";
                                }
                                else
                                {
                                    echo "Complete";
                                }
                            ?>
                            </td>

                            <td>
                            <?php
                                echo $fet2['req_type'];
                            ?>
                            </td>

                            <td>
                            <form action="#" method="POST">
                                <button class="btn btn-primary" type="submit" name="view" value="<?php echo $fet2['request_id']?>">View</button>
                            </form>
                            
                            </td>

                            <td>
                            
                                <form action="#" method="POST">
                                <button class="btn btn-primary" type="submit" name="check" value="<?php echo $fet2['request_id']?>">check</button>
                            </form>
                            
                            </td>
                            
                            <td>
                            <form action="#" method="POST">
                                <button class="btn btn-primary" type="submit" name="deli" value="<?php echo $fet2['request_id']?>">Delivered</button>
                            </form>
                            </td>
                        </tr>
                        <?php
                    }
                }
                ?>
            </tbody>
</table>
<?php
include('includes/footer.php');
include('includes/scripts.php');
?>
