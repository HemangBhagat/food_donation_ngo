<?php
session_start();
error_reporting(0);
$conn = mysqli_connect("localhost","root","","ngo");
$curr_date=date('Y-m-d');

$sql1="SELECT * FROM `driver_det` ";
$sql1_run=mysqli_query($conn,$sql1);
$num = mysqli_num_rows($sql1_run);

$select=mysqli_query($conn,"SELECT * FROM `donation` WHERE don_date = '{$curr_date}' ORDER BY priority DESC");
$rows=mysqli_num_rows($select);
if(mysqli_error($conn))
            {
                echo mysqli_error($conn);
                return false;
            }


if(!empty($_POST['assign']))
{
    $donationid = $_POST['assign'];
    $assgn_driver =  $_POST['driver'];
    $sqlq = "UPDATE `donation` SET Status=1 WHERE donation_id = $donationid";
    $sqlq_run = mysqli_query($conn,$sqlq);
    
    $sql3="INSERT into `don_assign_driver` VALUES ($donationid,$assgn_driver)";
    $sql3_run=mysqli_query($conn,$sql3);

}
if(!empty($_POST['check']))
{
    $_SESSION['donid'] = $_POST['check'];
    header('location:display_don_det.php');
}
include('includes/header.php');
?>

<table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Donation ID</th>
                    <th scope="col">User ID</th>
                    <th scope="col">Date</th>
                    <th scope="col">Time</th>
                    <th scope="col">Status</th>
                    <th scope="col">Priority</th>
                    <th scope="col">Location</th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                    <th scope="col">Order_details</th>


                </tr>
            </thead>
            <tbody>
            <?php
                
                if($rows>0)
                {
                    foreach($select as $rows)
                    {
                        ?>
                        <tr>
                        <th scope="rows"><?php echo $rows['donation_id'] ?></th>
                        <td><?php echo $rows['user_id'] ?></td>
                        <td><?php echo $rows['don_date'] ?></td>
                        <td><?php echo $rows['don_time'] ?></td>
                        <td><?php                               //status
                                 if($rows['status']==0)
                                 {
                                     echo "Pending";
                                 }
                                 else if($rows['status']==1)
                                 {
                                     echo "Assigned";
                                 }
                                 else
                                 {
                                     echo "Complete";
                                 }
                            ?>
                        </td>
                        <td><?php echo $rows['priority'] ?></td>
                        <td><?php echo $rows['location'] ?></td>
                        <form action="#" method="POST">
                            <td>

                                <select name="driver" id="driver">
                                    <optgroup label="Drivers">
                                        
                                            <?php
                                                if($num>0)
                                                {
                                                    foreach($sql1_run as $num)
                                                    {
                                                        $driver_name = $num['d_fname']." ".$num['d_lname'];
                                                        ?>
                                                        <option value = "<?php echo $num['d_userid']?>"> <?php echo $driver_name ?> </option>
                                                        <?php
                                                    }

                                                }
                                            ?>
    
                                    </optgroup>
                                </select>
                            </td>
                            <td>
                       
                                <button type="submit" class="btn btn-primary" name="assign" value="<?php echo $rows['donation_id'] ?>">Assign</button>
                        
                            </td>
                            <td>
                            <button type="submit" class="btn btn-primary" name="check" value="<?php echo $rows['donation_id'] ?>">Check</button>
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
