<?php
ob_start();
session_start();
require_once("commonclass.php");
if(!isset($_SESSION['dream'])){
	header("location:index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Dream-List</title>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/hover.css" rel="stylesheet" media="all">
	<link rel="stylesheet" href="css/magnific-popup.css">
	<link rel="icon" type="image/png"  href="images/in-logo.png">
    <!-- Custom styles for this template -->
	<link href="css/font-awesome.min.css" rel='stylesheet' type='text/css'>
	<link href="css/style.css" rel="stylesheet">
	<link href="css/flexslider.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

	<link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700' rel='stylesheet' type='text/css'>
	
  </head>
	<body>  

<?php 
$getschLogo=$objSchool->schoollogo($_SESSION['dream'][code]);
if($getschLogo['school_logo'])
{
$imgpath="multimedia/school/". $getschLogo['school_logo'];

}
else
{
 $imgpath="images/in-logo.png";
}

?>
		<div class="detail-head">
			<div class="detail-nav">
				<div class="container">
					<div class="col-sm-4">
			
					</div>
					<div class="col-sm-8">
						<div class="row">
							<div class="col-sm-4">
								<div class="flags-deatil">
									<ul>
									<?php if($_SEESION['dream']['type'] != 'corporate'){?>
										<!--<li><a href="arab/school.php"><img src="images/fl.png" style="opacity:.4"></a></li>-->
										<li><a href="school.php"><img src="images/fls.png" style="opacity:1"></a></li>
										<li><a href="frnc/list.php"><img src="images/flg.png" style="opacity:.4" ></a></li>
									<?php }?>
									</ul>
								</div>
							</div>
							<div class="col-sm-8">
								<div class="login-detail">
									<ul>
										<li><a href="javascript:void(0);">Welcome <?php echo $_SESSION['dream']['name']; ?> |</a></li>
										<li><a href="myacc.php">My Account |</a></li>
										<li><a href="logout.php">Logout </a></li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="sec-detail">
				<div class="container">
					<div class="col-sm-2">
						<div class="inn-logo"><img src="<?php echo $imgpath;?>"></div>
					</div>
					<div class="col-sm-8">
						<div class="row">
							<div class="n-dream">
								<ul>
									<!--<li><a href="list.php?mmid=5"><div class="direct-btn">DIRECT PURCHASE</div></a></li>-->
									<li><a href="list.php?mmid=5"><div class="direct-btn">ORDER ONLINE</div></a></li>
								<?php 
									if(isset($_SESSION['dream']))
									{
										if($_SESSION['dream']['type']=='school' || isset($_SESSION['dream']['code'])){
											echo '<li><a href="school.php?mmid=6"><div class="schl-btn">ABOUT US</div></a></li>
											<li><a href="shop.php?mmid=7"><div class="schl-btn">SHOP LOCATION</div></a></li>';
											//<li><a href="size.php?mmid=8"><div class="schl-btn">UNAVILABLE SIZES</div></a></li>
										}else if($_SESSION['dream']['type']=='corporate'){
											echo '<li class="col-sm-2"><a href="corporate.php"><div class="schl-btn">CORPORATE PROFILE</div></a></li>';
										}
									}
								?>
									
									
									<li>
										<div class="detail-cart"><a href="cart.php?mmid=9">
											<div class="carti"><i class="fa fa-shopping-cart"></i></div>
											<div class="aed">MY CART (<?php echo count($_SESSION['cart']); ?>)</div></a>
										</div>
									</li>
								</ul>	
							</div>
						</div>
					</div>
					
					<!--<div class="col-sm-2">
						<div class="inn-logo"><img src="images/in-logo.png"></div>
					</div>-->
					
				</div>
			</div>
		</div>