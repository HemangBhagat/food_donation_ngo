
<ul class="nav nav-tabs">
  
    <li class="nav-item">
      <a class="nav-link active" aria-current="page" href="#">Home</a>
    </li>
    
    <li class="nav-item">
      <a class="donate.php" href="#">Donate</a>
    </li>
    <li class="nav-item">
      <a class="request.php">Request</a>
    </li>
    <li class="nav-item">
      <a class="review.php">Reviews</a>
    </li>
    
    <?php if(isset($_SESSION['user_name'])){ ?>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Dropdown</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">MY Profile</a></li>
            <li><a class="dropdown-item" href="#">Another action</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Separated link</a></li>
          </ul>
        </li>
    <?php } else { ?>
      <li class="nav-item">
        <a class="nav-link" href="login.php">Sign-in</a>
      </li>
   <?php } ?>
  </ul>
</ul>