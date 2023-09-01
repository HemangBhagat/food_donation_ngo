<div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Core</div>
                            <a class="nav-link" href="admin_panel.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>
                            <a class="nav-link" href="registered_user.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                                Registered User
                            </a>
                            <a class="nav-link" href="donations.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                                Donations
                            </a>
                            <a class="nav-link" href="requests.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                                Requests
                            </a>
                            <a class="nav-link" href="drivers.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                                Drivers
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
                        <?php //echo $_SESSION['ad_username'] ?>
                    </div>
                </nav>
            </div>