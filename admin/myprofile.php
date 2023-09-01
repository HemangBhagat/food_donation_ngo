<?php
$conn = mysqli_connect("localhost","root","","ngo");
session_start();
if(!isset($_SESSION['userid']))
    {
        header('location:login.php');
    }
$user_id= $_SESSION['userid'];
$cur_date = date('Y-m-d') ;

$query="SELECT * FROM `registration` WHERE User_id = $user_id";
$query_run=mysqli_query($conn,$query);
$queryrow=mysqli_fetch_assoc($query_run);
$rows = mysqli_num_rows($query_run);

$query1="SELECT * FROM `food_donated` WHERE User_id = $user_id";
$query_run1=mysqli_query($conn,$query1);
$queryrow1=mysqli_fetch_assoc($query_run1);
$rows1 = mysqli_num_rows($query_run);



include('includes/myprofile_header.php');

?>

<div class="container-fluid px-4">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4>Profile Information</h4>
                </div>
                <div class="card-body">
                    <p> <strong> First Name: <?php echo $queryrow['Fname']; ?> </strong> </p>
                    <p> <strong> Last Name: <?php echo $queryrow['Lname']?> </strong> </p>
                    <p> <strong> Username: <?php echo $queryrow['Username']?> </strong> </p>
                    <p> <strong> Pnone No: <?php echo $queryrow['Phone']?> </strong> </p>
                    <p> <strong> Email: <?php echo $queryrow['Email']?> </strong> </p>
                </div>
            </div>
        </div>
    </div>
</div>
<br>
<div class="container-fluid px-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Donations</h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Donation ID</th>
                                <th>Dishes</th>
                                <th>Servings</th>
                                <th>Donation Date</th>
                                <th>Status</th>
                                <th>Assigned Driver</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $pre_id=0;$pre_date=0;$print_date=0;$print_stat=0;$print_dri=0;
                                if($rows1>0)
                                {
                                    foreach($query_run1 as $queryrow1)
                                    {
                                        $query2="SELECT * FROM `donation` WHERE User_id = $user_id";
                                        $query_run2=mysqli_query($conn,$query2);
                                        $queryrow2=mysqli_fetch_assoc($query_run2);
                                        $rows2 = mysqli_num_rows($query_run2);
                                        $donid = $queryrow1['donation_id'];
                                                                             
                                        $sql3 = "SELECT don_date From `donation` WHERE donation_id = $donid";
                                        $sql3_run=mysqli_query($conn,$sql3);
                                        $sql3_f = mysqli_fetch_assoc($sql3_run);
                                        
                                        $sql4 = "SELECT status From `donation` WHERE donation_id = $donid";
                                        $sql4_run=mysqli_query($conn,$sql4);
                                        $sql4_f = mysqli_fetch_assoc($sql4_run);
                                                                             ?>
                                            <tr>
                                                <td><?php 
                                                            if($pre_id == $queryrow1['donation_id'])
                                                            { echo ""; 
                                                                $print_stat=0;
                                                                $print_date=0;
                                                                $print_dri=0;}
                                                            else{
                                                                echo $queryrow1['donation_id'];
                                                                $pre_id=$queryrow1['donation_id'];
                                                                $print_stat=1;
                                                                $print_date=1;
                                                                $print_dri=1;
                                                            }
                                                
                                                ?></td>
                                                <td><?php echo $queryrow1['food_name']?></td>
                                                <td><?php echo $queryrow1['serving']?></td>
                               
                                                <td>
                                                    <?php 
                                                        if($pre_id == $queryrow1['donation_id'] && $print_date==0)
                                                        {echo "";}
                                                        else{
                                                        echo $sql3_f['don_date'];
                                                        }
                                                    ?>
                                                </td>
                                        
                                                <td>
                                        
                                                    <?php
                                                        if($pre_id == $queryrow1['donation_id'] && $print_stat==0)
                                                        {echo "";}
                                                        else{                                                                                    
                                                            if($sql4_f['status']==0)
                                                            {
                                                                echo "Pending";
                                                            }
                                                            else if($sql4_f['status']==1)
                                                            {
                                                                echo "Assigned";
                                                            }
                                                            else
                                                            {
                                                                echo "Complete";
                                                            }
                                                        }   
                                                        ?>
                                                </td>
                                                <td>
                                                    <?php
                                                        if($pre_id == $queryrow1['donation_id'] && $print_dri==0)
                                                        {echo "";}
                                                        else{   
                                                            $sql5 = "SELECT * From `don_assign_driver` WHERE donation_id = $donid";
                                                            $sql5_run=mysqli_query($conn,$sql5);
                                                            $sql5_f = mysqli_fetch_assoc($sql5_run);
                                                            $driverid=$sql5_f['assgn_driver_id'];
                                                            //echo $donid;
                                                            if($sql4_f['status']==0)
                                                            {
                                                                echo "None";
                                                             }
                                                            else if($sql4_f['status']==1)
                                                            {
                                                                $sql6 = "SELECT * From `driver_det` WHERE d_userid = $driverid";
                                                                $sql6_run=mysqli_query($conn,$sql6);
                                                                $sql6_f = mysqli_fetch_assoc($sql6_run);
                                                                $name=$sql6_f['d_fname']." ".$sql6_f['d_lname'];
                                                                echo $name;
                                                            }
                                                            else if($sql4_f['status']==2)
                                                            {
                                                                $sql6 = "SELECT * From `driver_det` WHERE d_userid = $driverid";
                                                                $sql6_run=mysqli_query($conn,$sql6);
                                                                $sql6_f = mysqli_fetch_assoc($sql6_run);
                                                                $name=$sql6_f['d_fname']." ".$sql6_f['d_lname'];
                                                                echo $name;
                                                            }
                                                        }
                                                            ?>
                                                </td>
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
                                if($rows1>0)
                                {
                                    foreach($query_run1 as $queryrow1)
                                    {
                                        ?>
                                        <tr>
                                            <td>
                                            <?php 
                        
                                                
                            
                                             ?>
                                             </td>
                                        </tr>
                                        <?php
                                    }
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
