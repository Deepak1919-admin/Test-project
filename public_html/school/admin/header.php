<?php
ob_start();
session_start();
if(!isset($_SESSION['admin'])) header("Location:index.php");
include('../init.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title><?php echo SITE_NAME ?> : Admin</title>
    <!-- GLOBAL STYLES - Include these on every page. -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700,300italic,400italic,500italic,700italic|Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel="stylesheet" type="text/css">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <!-- PAGE LEVEL PLUGIN STYLES -->
    <!-- THEME STYLES - Include these on every page. -->
    <link href="css/style.css" rel="stylesheet">
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    <div id="wrapper">
        <!-- begin TOP NAVIGATION -->
        <nav class="navbar-top" role="navigation">
            <!-- begin BRAND HEADING -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle pull-right" data-toggle="collapse" data-target=".sidebar-collapse">
                    <i class="fa fa-bars"></i> Menu
                </button>
                <div class="navbar-brand">
                    <a href="home.php" title="Visit Site">
                        <?php echo SITE_NAME ?>
                    </a>
                </div>
            </div>
            <!-- end BRAND HEADING -->
            <div class="nav-top">
                <!-- begin MESSAGES/ALERTS/TASKS/USER ACTIONS DROPDOWNS -->
                <ul class="nav navbar-right">
                   
                    <!-- begin USER ACTIONS DROPDOWN -->
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-user"></i>  <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            
                            <li>
                                <a href="#">
                                    <i class="fa fa-gear"></i> Change password
                                </a>
                            </li>
                            <li>
                                <a class="logout_open" href="logout.php">
                                    <i class="fa fa-sign-out"></i> Logout
                                 
                                </a>
                            </li>
                        </ul>
                       
                    </li>
                  
                </ul>
               
            </div>
          
        </nav>
       
       <?php include("sidebar.php"); ?>
     
        <div id="page-wrapper">