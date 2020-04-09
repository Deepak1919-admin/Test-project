<?php
session_start();
ob_start();

// include init
include('../init.php');

//Create the Class Objects
$objAdmin = load_class('Admin');

if(isset($_SESSION['admin']) && $_SESSION['admin']!="") header("Location:home.php");
if(isset($_POST["submit"])) {
	if($_POST["username"] == "" || $_POST["password"] == "") {
		$login_fail_msg = "<span style='color:red'>Please enter User Name / Password</span>";
	} else {
		$objAdmin->setArrData($_POST);
		$result = $objAdmin->login();
		if($result) {
			if(isset($_SESSION["login_ref"])){
				$ref = $_SESSION["login_ref"];
				unset($_SESSION["login_ref"]);
				redirect($ref);
			} else {
				redirect("home.php");
			}
		} else {
		  $login_fail_msg = "<span style='color:red'>Wrong User name / Password.</span>";
		}
	} 
}else{
    $login_fail_msg = 'Please login with your Username and Password.';
}
?>

<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title><?php echo SITE_NAME ?> :: Admin Login</title>
    <!-- GLOBAL STYLES - Include these on every page. -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700,300italic,400italic,500italic,700italic|Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel="stylesheet" type="text/css">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/login.css" rel="stylesheet">
</head>
<body>
	<div class="container ">
		<div class="row" id="pwd-container"> 
			<div class="col-md-4"></div>
			<div class="col-md-4">
				<section class="login-form">
					<div class="alert alert-info">
						<?php echo $login_fail_msg ?>
					</div>
					<form class="form-horizontal" action="" method="post" role="login">
						<div>
						<img src="../images/logo.png" width="150">
						</div>
						<input type="text" name="username" placeholder="Username" required class="form-control input-lg" value="" />
						<input type="password" class="form-control input-lg" name="password" placeholder="Password" required="" />
						<div class="pwstrength_viewport_progress"></div>
						<button type="submit" name="submit" class="btn btn-lg btn-primary btn-block">Login</button>
					</form>
					<div class="form-links">
						<a href="www.i3sis.com">A2solution</a>
					</div>
				</section>
		  </div>
		  <div class="col-md-4"></div>
		</div>
	</div>
</body>
</html>



