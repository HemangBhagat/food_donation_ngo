<?php
session_start();

$conn = mysqli_connect("localhost","root","","ngo");
$cur_date = date('Y-m-d') ;
    if(!empty($_POST['submit']))
    {
            $u_id=87703; // $_SESSION['userid'];
            $rating=$_POST['rating'];
            if(!empty($_POST['comment']))
            {
                $comment=$_POST['comment'];
                $insert=mysqli_query($conn,"INSERT INTO review (user_id,rev_date,comment,rating) VALUES ($u_id,'{$cur_date}','{$comment}',$rating)");
                if(mysqli_error($conn))
                {
                    echo mysqli_error($conn);
                }
            }
            else
            {
                $insert=mysqli_query($conn,"INSERT INTO review (user_id,rev_date,rating) VALUES ($u_id,'{$cur_date}',$rating)");
                if(mysqli_error($conn))
                {
                    echo mysqli_error($conn);
                }
            }
            header('location:reviews.php');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar</title>
    <link rel="stylesheet" type="text/css" href="navbar_style.css">

    <link rel="stylesheet" href="assets/CSS/bootstrap5.min.css">
    

    <link rel="stylesheet" href="assets/CSS/custom.css"> <!--custom css of our own-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script>
        (function($) {
         $( window ).scroll( function () {
    if ( $(document).scrollTop() > 300 ) {
      // Navigation Bar
      $('.navbar').removeClass('fadeIn');
      $('body').addClass('shrink');
      $('.navbar').addClass('fixed-top animated fadeInDown');
    } else {
      $('.navbar').removeClass('fadeInDown');
      $('.navbar').removeClass('fixed-top');
      $('body').removeClass('shrink');
      $('.navbar').addClass('animated fadeIn');
    }
  });  
})(jQuery);

    </script>
</head>
<body>
    <!-- Fixed navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container">
        <a class="navbar-brand" href="#">Food Donation NGO</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>        
        <div class="collapse navbar-collapse" id="navbarMain">
          <ul class="navbar-nav ml-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="donate.php">Donate</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="request.php">Request</a>
            </li>
            
            <li class="nav-item">
              <a class="nav-link disabled">Review</a>
            </li>
            <?php if(isset($_SESSION['user_name'])){ ?> 
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <?php echo $_SESSION['user_name']?>
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="admin/myprofile.php">My Profile</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="logout.php">Log-out</a></li>
              </ul>
            </li>
            <?php } else { ?>
                <li class="nav-item">
                    <a class="nav-link" href="login.php">Sign-in</a>
                </li>
            <?php } ?>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
    <div class="container jumbo">
<!--navbar end-->

<!-- comment section-->
    <section class="p-3 my-3">
            <div class="container">
                <h4>Comments:</h4>
                <form method="POST" action="#" id="commentForm">
                    <fieldset class="rate" onclick="inputValue">
                        <input type="radio" id="rating10" name="rating" value="10" /><label for="rating10" title="5 stars"></label>
                        <input type="radio" id="rating9" name="rating" value="9" /><label class="half" for="rating9" title="4 1/2 stars"></label>
                        <input type="radio" id="rating8" name="rating" value="8" /><label for="rating8" title="4 stars"></label>
                        <input type="radio" id="rating7" name="rating" value="7" /><label class="half" for="rating7" title="3 1/2 stars"></label>
                        <input type="radio" id="rating6" name="rating" value="6" /><label for="rating6" title="3 stars"></label>
                        <input type="radio" id="rating5" name="rating" value="5" /><label class="half" for="rating5" title="2 1/2 stars"></label>
                        <input type="radio" id="rating4" name="rating" value="4" /><label for="rating4" title="2 stars"></label>
                        <input type="radio" id="rating3" name="rating" value="3" /><label class="half" for="rating3" title="1 1/2 stars"></label>
                        <input type="radio" id="rating2" name="rating" value="2" /><label for="rating2" title="1 star"></label>
                        <input type="radio" id="rating1" name="rating" value="1" /><label class="half" for="rating1" title="1/2 star"></label>
                        <input type="radio" id="rating0" name="rating" value="0" /><label for="rating0" title="No star"></label>
                    </fieldset><br>
                    <textarea name="comment" placeholder="Add Your Comment Here(Optional)" rows="5" cols="50"><?php if(isset($_SESSION['logged_id'])) { if(isset($_SESSION['comment'])) {echo $_SESSION['comment']; $_SESSION['comment']="";}} ?></textarea>
                    <br>
                    <input type="number" name="rating" min="0.0" max="5.0" style="display: none;" id="ratingField" value="<?php if(isset($_SESSION['logged_id'])) { if(isset($_SESSION['comment'])) {echo $_SESSION['rating']; $_SESSION['rating']="";}} ?>" required>
                    <button type="submit" value="submit" name="submit" class="btn btn-primary">Submit</button>
                </form>
                <?php
                    $getreview=mysqli_query($conn,"SELECT * FROM `review` ");
                    if(mysqli_num_rows($getreview)>0)
                    {
                        while($review=$getreview->fetch_assoc())
                        {
                            ?>
                <div class="card my-4">
                    <h5 class="card-header">
                        <?php
                            $us=$review['user_id'];
                            $getuser=mysqli_query($conn,"SELECT * FROM `registration` WHERE User_id=$us");
                            if(mysqli_error($conn))
                            {
                                echo mysqli_error($conn);
                            }
                            else
                            {
                                $us=mysqli_fetch_assoc($getuser);
                                echo $us['Fname']." ".$us['Lname'];
                            }
                            ?>
                    </h5>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $review['rating']." / 5" ?></h5>
                        <p class="card-text"><?php echo $review['comment'] ?></p>
                    </div>
                </div>
                <?php
                    }
                    }
                    else
                    {
                    ?>
                <div class="card">
                    <div class="card-body">
                        No Comments
                    </div>
                </div>
                <?php
                    }
                    ?>
            </div>
        </section>

<script>
            let ratingField = document.querySelector('#ratingField');
            function inputValue(e) {
                let checkedInput = [...document.querySelector('.rate').querySelectorAll('input')].filter(inp => inp.checked)[0];
                // console.log(checkedInput.id.slice(6));
                let rating = parseInt(checkedInput.id.slice(6))*5/10;
                // console.log(rating);
                ratingField.value = rating;
            }
            document.querySelector("#commentForm").addEventListener('change', inputValue)
        </script>
        <script>
            let output = markdownToHTML(document.querySelector('#markdown-output').innerText);
            document.querySelector('#markdown-output').innerHTML = output;
        </script>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
<?php
            require './components/star.php';
            require './components/bootstrapcss.php';
            require './components/showdownjs.php';
            require './components/footer.php';
            require './components/fontawesome.php';
            require './components/bootstrapjs.php';
        ?>
</body>
</html>
    


