<div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">User Details</div>
                            <a class="nav-link" href="myprofile.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                                Donations
                            </a>
                            <a class="nav-link" href="myprofile_request.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                                Request
                            </a>
                            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="layout-static.html">Static Navigation</a>
                                    <a class="nav-link" href="layout-sidenav-light.html">Light Sidenav</a>
                                </nav>
                            </div>
                            
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        <?php 
                                $user_id=87703;// $_SESSION['userid'];
                                $query="SELECT * FROM `registration` WHERE User_id = $user_id";
                                $query_run=mysqli_query($conn,$query);
                                $queryrow=mysqli_fetch_assoc($query_run);
                                $name=$queryrow['Fname']." ".$queryrow['Lname'];
                                echo $name;
                        ?>
                    </div>
                </nav>
            </div>