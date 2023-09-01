<?php
$conn = mysqli_connect("localhost","root","","ngo");
 session_start();


$dri_id = 1933; //$_SESSION['driver_id']
$curr_date=date('Y-m-d');

$select=mysqli_query($conn,"SELECT * FROM `donation` WHERE don_date = '{$curr_date}' ORDER BY priority DESC");
$rows=mysqli_num_rows($select);
if(!empty($_POST['check']))
{
    $_SESSION['donid'] = $_POST['check'];
    header('location:display_don_det.php');
}
if(!empty($_POST['view']))
{
    $_SESSION['donidv'] = $_POST['view'];
    header('location:don_map1.php');
}
if(!empty($_POST['pickup']))
{
    $donationid=$_POST['pickup'];
    $sqlq = "UPDATE `donation` SET Status=2 WHERE donation_id = $donationid";
    $sqlq_run = mysqli_query($conn,$sqlq);
}

include('includes/driver_header.php');
?>

<table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Donation ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Status</th>
                    <th scope="col">Priority</th>
                    <th scope="col">Location</th>
                    <th scope="col">Order_details</th>
                    <th scope="col"></th>
                    <th scope="col"></th>


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
                        <td scope="rows"><?php echo $rows['donation_id'] ?></td>
                        <td><?php 
                                    $uid=$rows['user_id'];
                                    $sql="SELECT * FROM `registration` WHERE User_id=$uid";
                                    $sql_run=mysqli_query($conn,$sql);
                                    $fetch=mysqli_fetch_assoc($sql_run);
                                    echo $fetch['Fname']." ".$fetch["Lname"];
                        ?></td>
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
                        <form action="#" method="POST">
                        <td>                               
                             <button type="submit" class="btn btn-primary" name="view" value="<?php echo $rows['donation_id'] ?>">view</button>
                        </td>
                       
                            <td>
                       
                                <button type="submit" class="btn btn-primary" name="check" value="<?php echo $rows['donation_id'] ?>">Check</button>
                        
                            </td>
                            <td>
                            <button type="submit" class="btn btn-primary" name="pickup" value="<?php echo $rows['donation_id'] ?>"> Picked-up </button>
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
