<?php
session_start();
$conn = mysqli_connect("localhost","root","","ngo");

$query1="SELECT * from `food_request`";
$query1_run=mysqli_query($conn,$query1);
if(mysqli_error($conn))
{
    echo mysqli_error($conn);
}
$qfet1=mysqli_fetch_assoc($query1_run);
$qrow1 = mysqli_num_rows($query1_run);
$reqid1=$qfet1['request_id'];
$user_id=$qfet1['user_id'];
$query="SELECT * FROM `registration` WHERE User_id = $user_id";
$query_run=mysqli_query($conn,$query);
if(mysqli_error($conn))
{
    echo mysqli_error($conn);
}
$queryrow=mysqli_fetch_assoc($query_run);
if(mysqli_error($conn))
            {
                echo mysqli_error($conn);
                echo "\n";
                return false;
            }
$rows = mysqli_num_rows($query_run);

$query2="SELECT * from `req_assign_food` WHERE request_id = $reqid1";
$query2_run=mysqli_query($conn,$query2);
$qfet2=mysqli_fetch_assoc($query2_run);
$qrow2 = mysqli_num_rows($query1_run);
if(mysqli_error($conn))
            {
                echo mysqli_error($conn);
                echo "\n";
                return false;
            }
$reqid2=$qfet2['request_id'];

$query3="SELECT * from `req_assign_driver` WHERE request_id = $reqid1";
$query3_run=mysqli_query($conn,$query3);
$qfet3=mysqli_fetch_assoc($query3_run);

if(mysqli_error($conn))
            {
                echo mysqli_error($conn);
                echo "\n";
                return false;
            }
$reqid3=$qfet3['assign_driver'];

$user_id=87703;// $_SESSION['userid'];
include('includes/myprofile_header.php')
?>
<div class="container-fluid px-4">
    <h2 class="mt-4">  REQUESTS </h2>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Request Details</h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Request ID</th>
                                <th>Request type</th>
                                <th>Assigned Food</th>
                                <th>Type Assigned</th>
                                <th>Servings</th>
                                <th>Request Date</th>
                                <th>Status</th>
                                <th>Assigned Driver</th>
                                <th>Driver Phone No.</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if($qrow1>0)
                                {
                                    foreach($query1_run as $qfet1)
                                    {
                                        ?>
                                            <tr>
                                                <td><?php echo $qfet1['request_id']?></td>
                                                <td><?php
                                                        echo $qfet1['req_type'];
                                                ?></td>
                                                <td><?php 
                                                        if($qrow2>0)
                                                        {
                                                            foreach($query2_run as $qfet2)
                                                            {
                                                                echo $qfet2['food_assigned']."  ,  " ;
                                                            }
                                                        }
                                                ?></td>
                                                <td><?php 
                                                        if($qrow2>0)
                                                        {
                                                            foreach($query2_run as $qfet2)
                                                            {
                                                                echo $qfet2['type']." , ";
                                                            }
                                                        }
                                                
                                                
                                                ?></td>
                                                <td><?php 
                                                        if($qrow2>0)
                                                        {
                                                            foreach($query2_run as $qfet2)
                                                            {
                                                                echo $qfet2['serving']." , ";
                                                            }
                                                        }
                                                ?></td>
                                                <td><?php 
                                                        echo $qfet1['req_date'];
                                                ?></td>
                                                <td><?php 

                                                                                     //status
                                                        if($qfet1['status']==0)
                                                        {
                                                            echo "Pending";
                                                        }
                                                        else if($qfet1['status']==1)
                                                        {
                                                            echo "Assigned";
                                                        }
                                                        else
                                                        {
                                                            echo "Complete";
                                                        }
                                                    

                                                ?></td>
                                                <td><?php
                                                        
                                                        if($qfet1['status']==0)
                                                        {
                                                            echo "None";
                                                         }
                                                        else if($qfet1['status']==1)
                                                        {
                                                            $q="SELECT * from `driver_det` WHERE d_userid=$reqid3";
                                                            $q_run=mysqli_query($conn,$q);
                                                            $qfet4=mysqli_fetch_assoc($q_run);
                                                            $name = $qfet4['d_fname']." ".$qfet4['d_lname'];
                                                            echo $name;
                                                        }
                                                ?></td>
                                                <td>
                                                    <?php
                                                    
                                                            $select1="SELECT d_phone FROM `driver_det` WHERE d_userid=$reqid3";
                                                            $select1_run=mysqli_query($conn,$select1);
                                                            $sfet=mysqli_fetch_assoc($select1_run);
                                                            echo $sfet['d_phone'];
                                                            
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