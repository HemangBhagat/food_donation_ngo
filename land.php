<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,600;0,700;1,200&display=swap" rel="stylesheet">
    <meta name="viewport" content="with=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>FOOD DONATION</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" type="text/css" href="navbar_style.css">

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


</head>
 <body>

 <!-- nav bar start-->
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
              <a class="nav-link active" href="request.php">Request</a>
            </li>
            
            <li class="nav-item">
              <a class="nav-link active" href="reviews.php">Review</a>
            </li>
            <?php if(isset($_SESSION['user_name'])){ ?> 
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <?php echo $_SESSION['user_name']?>
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="admin/myprofile.php">My Profile</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="logout.php">Logout</a></li>
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




     <section class="header">
         <div class="text-box">
             <h1>NGO FOOD DONATION</h1>
             <P> </P>
     </section>
<!--aboutus-->
    <section class="aboutus">
        <h2>ABOUT US</h2>
        <p>
            Our goal is To drop off essential food items for other charities, foundations and beneficiaries in need <br>
            Our NGO collects the donations made by the donars and donate it to the people in need 

        </p>
    </section>

<!--reveiws-->
     <section class="reveiws">
         <h3>COMMON QUESTIONS</h3>
    
         <div class="row">
         <div class="reveiws-col">
            <p>
               <strong>Q:How to contact us?</strong>
               <br>
               For queries you can contact us on <br>
                   our email fooddonationngo@gmail.com<br>
             
            </p>
        </div>
        <div class="reveiws-col">
            <p>
              <strong>Who are we?</strong>
              <br>
              We are a food donating NGO<br> we with the help from our donars<br>help the people in need by our donations
            </p>
        </div>
        <div class="reveiws-col">
            <p>
            <strong>Q:How to donate?</strong> 
             <br>
             first you need to register yourself then sign in <br> and click on the donate button and do the donation
            </p>
        </div>
        </div>

       <div class="icons">
            <i class="fa-brands fa-facebook"></i>
            <i class="fa-brands fa-twitter"></i>
            <i class="fa-brands fa-instagram"></i>
            <i class="fa-brands fa-linkedin"></i>
        </div>
     </section>
<script src="assets/js/jquery.min.js"></script>   
<script src="assets/js/bootstrap5.bundle.min.js"></script>   
<script src="assets/js/customscripts.js"></script> 


</body>
</html>