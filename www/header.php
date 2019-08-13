<!--
=========================================================
 Light Bootstrap Dashboard - v2.0.1
=========================================================

 Product Page: https://www.creative-tim.com/product/light-bootstrap-dashboard
 Copyright 2019 Creative Tim (https://www.creative-tim.com)
 Licensed under MIT (https://github.com/creativetimofficial/light-bootstrap-dashboard/blob/master/LICENSE)

 Coded by Creative Tim

=========================================================

 The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.  -->
<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="icon" type="image/png" href="favicon.ico">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>GOES Tools Panel<?php if (isset($title)) { echo " - " . $title; } ?></title>
    <meta content='width=device-width, initial-scale=1.0, user-scalable=1, shrink-to-fit=no' name='viewport' />
    <link href="./assets/css/google-fonts.css" rel="stylesheet" />
    <link href="./assets/css/font-awesome.min.css" rel="stylesheet" />
    <link href="./assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="./assets/css/light-bootstrap-dashboard.css?v=2.0.0 " rel="stylesheet" />
    <!--   Core JS Files   -->
    <script src="./assets/js/core/jquery.3.2.1.min.js" type="text/javascript"></script>
    <script src="./assets/js/core/popper.min.js" type="text/javascript"></script>
    <script src="./assets/js/core/bootstrap.min.js" type="text/javascript"></script>
    <!--  Plugin for Switches, full documentation here: http://www.jque.re/plugins/version3/bootstrap.switch/ -->
    <script src="./assets/js/plugins/bootstrap-switch.js"></script>
    <!-- Control Center for Light Bootstrap Dashboard: scripts for the example pages etc -->
    <script src="./assets/js/light-bootstrap-dashboard.js?v=2.0.0 " type="text/javascript"></script>
</head>

<body>
    <div class="wrapper">
      <?php
      /*
      <!--
      Tip 1: You can change the color of the sidebar using: data-color="purple | blue | green | orange | red"
      Tip 2: you can also add an image using data-image tag
      -->
      <!--
        <div class="sidebar" data-image="./assets/img/sidebar-5.jpg">
            <div class="sidebar-wrapper">
                <div class="logo">
                    <a href="http://www.creative-tim.com" class="simple-text">
                        Creative Tim
                    </a>
                </div>
                <ul class="nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="dashboard.html">
                            <i class="nc-icon nc-chart-pie-35"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link" href="./user.html">
                            <i class="nc-icon nc-circle-09"></i>
                            <p>User Profile</p>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link" href="./table.html">
                            <i class="nc-icon nc-notes"></i>
                            <p>Table List</p>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link" href="./typography.html">
                            <i class="nc-icon nc-paper-2"></i>
                            <p>Typography</p>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link" href="./icons.html">
                            <i class="nc-icon nc-atom"></i>
                            <p>Icons</p>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link" href="./maps.html">
                            <i class="nc-icon nc-pin-3"></i>
                            <p>Maps</p>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link" href="./notifications.html">
                            <i class="nc-icon nc-bell-55"></i>
                            <p>Notifications</p>
                        </a>
                    </li>
                    <li class="nav-item active active-pro">
                        <a class="nav-link active" href="upgrade.html">
                            <i class="nc-icon nc-alien-33"></i>
                            <p>Upgrade to PRO</p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        -->
      */
      ?>
        <div class="main-panel">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg " color-on-scroll="500">
                <div class="container-fluid">
                    <a class="navbar-brand" href="index.php"><strong> <span style="color:#1DC7EA;">GOES Tools</span></strong> <span style="color:#9368E9;">Panel</span> </a>
                    <div class="collapse navbar-collapse justify-content-end" id="navigation">
                      <?php
                      /*
                      <!--
                        <ul class="nav navbar-nav mr-auto">
                            <li class="nav-item">
                                <a href="#" class="nav-link" data-toggle="dropdown">
                                    <i class="nc-icon nc-palette"></i>
                                    <span class="d-lg-none">Dashboard</span>
                                </a>
                            </li>
                            <li class="dropdown nav-item">
                                <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                                    <i class="nc-icon nc-planet"></i>
                                    <span class="notification">5</span>
                                    <span class="d-lg-none">Notification</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <a class="dropdown-item" href="#">Notification 1</a>
                                    <a class="dropdown-item" href="#">Notification 2</a>
                                    <a class="dropdown-item" href="#">Notification 3</a>
                                    <a class="dropdown-item" href="#">Notification 4</a>
                                    <a class="dropdown-item" href="#">Another notification</a>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nc-icon nc-zoom-split"></i>
                                    <span class="d-lg-block">&nbsp;Search</span>
                                </a>
                            </li>
                        </ul>
                        -->
                      */
                      ?>
                        <ul class="navbar-nav ml-auto">
                          <li class="nav-item dropdown">
                                <!--<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">-->
                                <a class="nav-link" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="nc-icon nc-bullet-list-67"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                                    <a class="dropdown-item" href="product-viewer.php">
                                        <i class="fa fa-globe"></i>&nbsp;&nbsp;Product Viewer
                                    </a>
                                    <a class="dropdown-item" href="nws-viewer.php">
                                        <i class="fa fa-mixcloud"></i>&nbsp;&nbsp;NWS Viewer
                                    </a>
                                    <!--
                                    <a class="dropdown-item" href="text-viewer.php">
                                        <i class="fa fa-signal"></i>&nbsp;&nbsp;Text Viewer
                                    </a>
                                    -->
                                    <div class="divider"></div>
                                    <a class="dropdown-item" href="signal.php">
                                        <i class="fa fa-signal"></i>&nbsp;&nbsp;Signal Status
                                    </a>
                                    <a class="dropdown-item" href="server.php">
                                        <i class="fa fa-server"></i>&nbsp;&nbsp;Server Status
                                    </a>
                                    <!--
                                    <a class="dropdown-item" href="settings.php">
                                        <i class="fa fa-gear"></i>&nbsp;&nbsp;Settings
                                    </a>
                                    -->
                                    <div class="divider"></div>
                                    <a class="dropdown-item" href="about.php">
                                        <i class="fa fa-info"></i>&nbsp;&nbsp;About
                                    </a>
                                    <!--
                                    <a href="#" class="dropdown-item text-danger">
                                        <i class="fa fa-signal"></i>&nbsp;&nbsp;Status
                                    </a>
                                    -->
                                </div>
                            </li>
                            <?php
                            /*
                            <!--
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-bars"></i>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <a class="dropdown-item" href="#">Action</a>
                                    <a class="dropdown-item" href="#">Another action</a>
                                    <a class="dropdown-item" href="#">Something</a>
                                    <a class="dropdown-item" href="#">Something else here</a>
                                    <div class="divider"></div>
                                    <a class="dropdown-item" href="#">Separated link</a>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="status.php">
                                    <span class="no-icon">Status</span>
                                </a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link" href="status.php">
                                  <i class="fa fa-signal" style="font-size:12px; margin-bottom:2px;"></i> Status
                              </a>
                            </li>
                            -->
                            */
                            ?>
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- End Navbar -->
