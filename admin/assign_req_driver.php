<?php
session_start();
$num=0;
$conn = mysqli_connect("localhost","root","","ngo");
$curr_date=date('Y-m-d');
$userid=$_SESSION['usid'];
echo $userid;
$sql1="SELECT * FROM `driver_det` ";
$sql1_run=mysqli_query($conn,$sql1);
$rows = mysqli_num_rows($sql1_run);
if(mysqli_error($conn))
            {
                echo mysqli_error($conn);
                return false;
            }

$select=mysqli_query($conn,"SELECT * FROM `food_request` WHERE user_id=$userid ");
$rows1=mysqli_fetch_assoc($select);
$rows11=mysqli_num_rows($select);
echo $rows11;
if(mysqli_error($conn))
            {
                echo mysqli_error($conn);
                return false;
            }
echo "HELLO";


if(isset($_GET['no'])&&$_GET['no']!="--")
{
    $num=$_GET['no'];
    $_SESSION['num']=$num;
    echo $num;
}
echo "hello";
if(!empty($_POST['done'])&& isset($num))
    {
        $reqid = $_POST['done'];
        $assgn_driver =  $_POST['driver'];
        $sql3="INSERT into `req_assign_driver` VALUES ($reqid,$assgn_driver)";
        $sql3_run=mysqli_query($conn,$sql3);

        $sqlq = "UPDATE `food_request` SET status=1 WHERE request_id = $reqid";
        $sqlq_run = mysqli_query($conn,$sqlq);

        for($i=1; $i<=$_SESSION['num']; $i++)
        {
            $fitem=$_POST['food_item'.$i];
            $serve1=$_POST['servings'.$i];
                
                $queryitem=mysqli_query($conn,"SELECT * from `total_food` WHERE foodname='{$fitem}' ");
                $res_queryitem = mysqli_fetch_array($queryitem,MYSQLI_ASSOC);
                $curr_quan=$res_queryitem['total_quantity'];
                $ftype=$res_queryitem['ftype'];
                echo $ftype;

                $new_total=$curr_quan-$serve1;
        
                $query1 = mysqli_query($conn,"INSERT INTO `req_assign_food` VALUES ($reqid,$serve1,'{$fitem}','{$ftype}' )");
                if(mysqli_error($conn))
                {
                    echo mysqli_error($conn);
                    return false;
                }

                $update=mysqli_query($conn,"UPDATE total_food SET total_quantity=$new_total WHERE foodname='$fitem'");
                if(mysqli_error($conn))
                {
                    echo mysqli_error($conn);
                    return false;
                }

            header('location:requests.php');
        }
    }
    require './includes/header.php';
?>
<label for="amount">
            number of donation:
        </label>
<select name="amount" id="amount" onchange="changetype()">
            <option value="--">--</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
</select>
    <form action="#" method="post" enctype="multipart/form-data" >
        
        <hr>
    <?php
        if($rows11>0)
        {
                    for($i=1; $i<=$num; $i++)
                    {
                      //  foreach($select as $rows1)
               // {
                    ?>
                        <div class="container">
                            <div data-name="dish_field<?php echo $i?>" class="p-2 border rounded bg-light my-2 mx-auto" style="max-width: 550px;">
                                    <label for="">
                                        <p>Dishes:</p>
                                    </label><select name="food_item<?php echo $i?>" id="food_item<?php echo $i?>">
                                        <optgroup label="VEG">
                                            <option value="rice">Rice</option>
                                            <option value="Bread">Roti/Bread</option>
                                            <option value="veg_gravy">paneer/potato/mix veggies gravy</option>
                                        </optgroup>
                                        <optgroup label="NON-veg">
                                            <option value="fish_gravy">Fish Gravy</option>
                                            <option value="chicken_gravy">Chicken Gravy</option>
                                        </optgroup>
                                    </select>
                                    <br>
                                    <label for="servings<?php echo $i?>">
                                        <P>Servings</p>
                                    </label><input type="number" name="servings<?php echo $i?>" id="servings<?php echo $i?>">
                                    <br>
                                    <hr>
                                </div>
            <?php }?>
                                <label for="driver">Assign Driver: </label><br><select name="driver" id="driver">
                                                        <optgroup label="Drivers">
                                                            
                                                                <?php
                                                                    if($rows>0)
                                                                    {
                                                                        foreach($sql1_run as $rows)
                                                                        {
                                                                            $driver_name = $rows['d_fname']." ".$rows['d_lname'];
                                                                            ?>
                                                                            <option value = "<?php echo $rows['d_userid']?>"> <?php echo $driver_name ?> </option>
                                                                            <?php
                                                                        }

                                                                    }
                                                                ?>
                        
                                                        </optgroup>
                                                    </select>
                                                    
                <button type="submit" class="btn btn-primary" name="done" value="<?php echo $rows1['request_id'] ?>">Done</button>
            
    <?php } ?>
    </form>

<script defer> 
    function changetype(){
        var x=document.getElementById("amount").value
        var restring ="/Ngo/admin/assign_req_driver.php?no="+x
        window.location=restring
    }
</script>

<?php
include('includes/footer.php');
include('includes/scripts.php');
?>
