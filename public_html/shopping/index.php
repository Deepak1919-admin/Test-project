<?php
session_start();
ob_start();
require_once("commonclass.php");
if(isset($_SESSION['dream'])){ 
	if($_SESSION['dream']['type']=='school' && isset($_SESSION['dream']['code'])){ 
		header("location:list.php");
	}else if($_SESSION['dream']['type']=='corporate'){
		header("location:corporate.php");
	}
else if($_SESSION['dream']['type']=='user' && isset($_SESSION['dream']['code'])){
		header("location:list.php");
	}
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
    <title>Dream-Login</title>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/hover.css" rel="stylesheet" media="all">
	<link rel="stylesheet" href="css/magnific-popup.css">
    <!-- Custom styles for this template -->
	<link href="css/font-awesome.min.css" rel='stylesheet' type='text/css'>
	<link href="css/style.css" rel="stylesheet">
	<link href="css/sweetalert.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

	<link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700' rel='stylesheet' type='text/css'>
</head>
<body>
	<div class="header">
	<div class="container">
		<div class="col-sm-5">
			<div class="logo"><img src="images/logo.png"></div>
		</div>
		<div class="col-sm-7">
			<div class="row">
				<div class="col-sm-6">
					<div class="flags">
						<ul>
							<!--<li><a href=""><img src="images/fl.png"></a></li>
							<li><a href=""><img src="images/fls.png"></a></li>
							<li><a href=""><img src="images/flg.png"></a></li>-->
						</ul>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="login">
						<ul>
							
							<?php if(isset($_SESSION['dream'])){
								?>
								<li><a href="javascript:void(0);">Welcome <?php echo $_SESSION['dream']['name']; ?> |</a></li>
								<?php
								if($_SESSION['dream']['type']=='school' && isset($_SESSION['dream']['code'])){
									echo '<li><a href="school.php">My Account |</a></li>';
echo '<li><a href="cart.php"><i class="fa fa-shopping-cart"></i> Cart </a></li>';
								}else if($_SESSION['dream']['type']=='corporate'){
									echo '<li><a href="corporate.php">My Account |</a></li>';
								}
								echo '<li><a href="logout.php">Logout |</a></li>';
							}else{
								echo '<li><a href="#" data-toggle="modal" data-target="#register-modal">Register </a></li>';
							} ?>
							
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="top-ban"><img src="images/t-ban.png">
	<div class="search-optn">
		<div class="green-btn"><input type="button" value="School  Uniforms" data-toggle="modal" data-target="#schlogin-modal"></div>
<?php if(!isset($_SESSION['dream'])){?>
		<div class="green-btn"><input type="button" value="Registered Corporate Customers" data-toggle="modal" data-target="#corlogin-modal"></div>
		<div class="login-text">Login Into Your Account</div>
		<div class="row">
			<form class="form-horizontal" action="" role="form" name="login" method="post" id="login">
				<div class="top-ons">
					<div class="col-xs-6">
						<div class="logn-txt"><input type="text" name="email" placeholder="Email"></div>
					</div>
					<div class="col-xs-6">
						<div class="logn-fb"><a href="social_login.php?provider=Facebook"><img src="images/fbs-bg.png"></a></div>
					</div>
				</div>
				<div class="top-ons">
					<div class="col-xs-6">
						<div class="logn-txt"><input type="password" name="password" placeholder="Password"></div>
					</div>
					<div class="col-xs-6">
						<div class="logn-goog"><a href="social_login.php?provider=Google"><img src="images/signs.png"></a></div>
					</div>
				</div>
				<div class="col-xs-6">
					<div class="red-btn"><input type="submit" name="submit" value="Submit"></div>
				</div>
				<div class="col-xs-6">
					<div class="red-btn"><input type="button" value="New Sign Up" data-toggle="modal" data-target="#register-modal"></a></div>
				</div>
			</form>
		</div>
		<div class="login-bottom">
  <a href="" data-toggle="modal" data-target="#forgot-user" style="float:left">Forgot your password? Click here</a>
  <a href="" data-toggle="modal" data-target="#help">Do you need help? click here</a>
</div>

		<?php }?>
	</div>
	<div class="copy">© Copyright 2016 Dream Uniforms LLC, Dubai.</div>
</div>
<!--------------------Login modal------------------------------->
<div class="modal fade" id="schlogin-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
     <div class="modal-dialog ">
        <div class="modal-content">
			<div class="modal-header">
                <div class="loginmodal-container" style="max-width:100% !important">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h1>School Login</h1>
				</div>
			</div>
			<div class="modal-body">
				<div class="tab-content">
				<?php if(($_SESSION['dream']['type'] =='school' && isset($_SESSION['dream'])) ||($_SESSION['dream']['type'] =='user' && isset($_SESSION['dream']))){?>
					<form class="form-horizontal" action="" role="form" name="code-login" method="post" id="code-login">
						<div class="form-group">
							<label class="control-label col-sm-4" for="username">School Code:</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="code" name="code" placeholder="School Code">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-4" for="pwd"></label>
							<div class="col-sm-6">
								<input type="submit" name="submit" class="btn btn-primary loginmodal-submit" value="Login">
							</div>
						</div>
					</form>
				<?php }else{?>
					<form class="form-horizontal" action="" role="form" name="schoo-login" method="post" id="schoo-login">
						
						<div class="form-group">
							<label class="control-label col-sm-4" for="username">School Code:</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="code" name="code" placeholder="School Code">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-4" for="email">Email:</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="email" name="email" placeholder="Email">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-4" for="pwd">Password:</label>
							<div class="col-sm-6">
								<input type="password" class="form-control" id="password" placeholder="password" name="password">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-4" for="pwd"></label>
							<div class="col-sm-6">
								<input type="submit" name="submit" class=" btn btn-primary loginmodal-submit" value="Login">
							</div>
						</div>
						<div class="login-help">
							<a href="" data-toggle="modal" data-target="#forgot-school" id="forgotPasswords"><font color="black" > <b>Forgot Password</b></font></a>
						</div>
					</form>
				<?php }?>
				</div>
			</div>
			<div class="modal-footer">
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="corlogin-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
     <div class="modal-dialog ">
        <div class="modal-content">
			<div class="modal-header">
                <div class="loginmodal-container" style="max-width:100% !important">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h1>Corporate Login</h1>
				</div>
			</div>
			<div class="modal-body">
				<div class="tab-content">
					<form class="form-horizontal" action="" role="form" name="corporate-login" method="post" id="corporate-login">
						<div class="form-group">
							<label class="control-label col-sm-4" for="username">Email:</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="email" name="email" placeholder="Email">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-4" for="pwd">Password:</label>
							<div class="col-sm-6">
								<input type="password" class="form-control" id="password" placeholder="password" name="password">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-4" for="pwd"></label>
							<div class="col-sm-6">
								<input type="submit" name="submit" class="btn btn-primary loginmodal-submit" value="Login">
							</div>
						</div>
						<div class="login-help">
							<a href="" data-toggle="modal" data-target="#forgot-corporate" id="forgotPasswordc"><font color="black" > <b>Forgot Password</b></font></a>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<!--------------------Login modal------------------------------->

<!--------------------register modal---------------------------->
<div class="modal fade" id="register-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">

    <div class="modal-dialog ">
        <div class="modal-content">
			<div class="modal-header">
                <div class="loginmodal-container" style="max-width:100% !important">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                    <h1>Sign Up</h1>
				</div>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" enctype="multipart/form-data" role="form" method="post" id="registerForm">
					<div class="loginmodal-container" style="max-width:100% !important">
						<div class="form-group">
							<label class="control-label col-sm-4" for="username">Email Address:</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="email" name="email" placeholder="Enter email">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-4" for="pwd">Password:</label>
							<div class="col-sm-6">
								<input type="password" class="form-control" id="password1" placeholder="Enter password" name="password">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-4" for="pwd">Confirm Password:</label>
							<div class="col-sm-6">
								<input type="password" class="form-control" id="con_password" placeholder="Enter Confirm Password" name="con_password">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-4" for="pwd"></label>
							<div class="col-sm-6">
								<input type="submit" name="register" class=" btn btn-primary loginmodal-submit" value="Register">
							</div>
						</div>
						<div id="alert"></div>
					</div>
				</form>
			</div>
        </div>
    </div>
</div>
<!--------------------register modal End---------------------------->

<!--------------------Forgot modal Start---------------------------->
<div class="modal fade" id="forgot-user" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4>Forgot Password</h4><br>
			</div>
			<div class="modal-body">
				<div class="loginmodal-container">
					<form class="form-horizontal" name="forgotUser" id="forgotUser" method="post" action="">
						<div class="form-group">
							<label class="control-label col-sm-4" for="pwd">Email:</label>
							<div class="col-sm-6">
								<div class="mobile-wrap">
									<input class="form-control" type="text" name="email" placeholder="Email">
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-4" for="pwd"></label>
							<div class="col-sm-6">
								<input type="submit" name="forgot"  class="btn btn-primary" value="Submit">
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
    </div>
</div>

<div class="modal fade" id="help" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4>Help</h4><br>
			</div>
			<div class="modal-body">
				<div class="loginmodal-container">
					<?php if($GetHelp['description'])
                                          {
                                        echo $GetHelp['description'];
                                         }  ?>
				</div>
			</div>
		</div>
    </div>
</div>

<div class="modal fade" id="forgot-school" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4>Forgot Password</h4><br>
			</div>
			<div class="modal-body">
				<div class="loginmodal-container">
					<form class="form-horizontal" name="forgotSchool" id="forgotSchool" method="post" action="">
						<div class="form-group">
							<label class="control-label col-sm-4" for="pwd">Email:</label>
							<div class="col-sm-6">
								<div class="mobile-wrap">
									<input class="form-control" type="text" name="email" placeholder="Email">
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-4" for="pwd"></label>
							<div class="col-sm-6">
								<input type="submit" name="forgot"  class="btn btn-primary" value="Submit">
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
    </div>
</div>

<div class="modal fade" id="forgot-corporate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4>Forgot Password</h4><br>
			</div>
			<div class="modal-body">
				<div class="loginmodal-container">
					<form class="form-horizontal" name="forgotCorporate" id="forgotCorporate" method="post" action="">
						<div class="form-group">
							<label class="control-label col-sm-4" for="pwd">Email:</label>
							<div class="col-sm-6">
								<div class="mobile-wrap">
									<input class="form-control" type="text" name="email" placeholder="Email">
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-4" for="pwd"></label>
							<div class="col-sm-6">
								<input type="submit" name="forgot"  class="btn btn-primary" value="Submit">
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
    </div>
</div>
<!--------------------Forgot modal End---------------------------->


<script src="js/jquery-2.1.3.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.bxslider.min.js"></script>
<script src="js/jquery.magnific-popup.js"></script>
<script src="js/jquery.validate.min.js"></script>
<script src="js/sweetalert.min.js"></script>
<script>
$('#forgotPasswords').click(function () {
	$('#schlogin-modal').modal('hide');
})
$('#forgotPasswordc').click(function () {
	$('#corlogin-modal').modal('hide');
})
$("#forgotUser").validate({
	rules:{
		email:{
			required: true,
		},
	},
	errorPlacement: function(error,element) {
		element.attr('placeholder',error.text());
	},
	submitHandler: function(){
		dataString = $('#forgotUser').serialize();
		$.ajax({
			type: "POST",
			url: "action/forgotuser.php",
			data: dataString,
			success: function(msd){
				//alert(msd);
				swal({
					title: "",
					text: "",
					showConfirmButton: false,
					//imageUrl: 'images/loading.gif'
				});
				if(msd==1){
					swal({ title:  "Success", type: "success",text:"mail Send  Successfully!",showConfirmButton: false,timer: 2000 },
						function(){
							location.reload(true);
						});
				}else{
					swal({ title:  "Error!", type: "error",text:"Failed Try Again!",showConfirmButton: false,timer: 2000 });
				}
			}
		});
	}
});
$("#forgotSchool").validate({
	rules:{
		email:{
			required: true,
		},
	},
	errorPlacement: function(error,element) {
		element.attr('placeholder',error.text());
	},
	submitHandler: function(){
		dataString = $('#forgotSchool').serialize();
		$.ajax({
			type: "POST",
			url: "action/forgotuser.php",
			data: dataString,
			success: function(msd){
				//alert(msd);
				swal({
					title: "",
					text: "",
					showConfirmButton: false,
					//imageUrl: 'images/loading.gif'
				});
				if(msd==1){
					swal({ title:  "Success", type: "success",text:"mail Send  Successfully!",showConfirmButton: false,timer: 2000 },
						function(){
							location.reload(true);
						});
				}else{
					swal({ title:  "Error!", type: "error",text:"Failed Try Again!",showConfirmButton: false,timer: 2000 });
				}
			}
		});
	}
});
$("#forgotCorporate").validate({
	rules:{
		email:{
			required: true,
		},
	},
	errorPlacement: function(error,element) {
		element.attr('placeholder',error.text());
	},
	submitHandler: function(){
		dataString = $('#forgotCorporate').serialize();
		$.ajax({
			type: "POST",
			url: "action/forgotcorporate.php",
			data: dataString,
			success: function(msd){
				//alert(msd);
				swal({
					title: "",
					text: "",
					showConfirmButton: false,
					//imageUrl: 'images/loading.gif'
				});
				if(msd==1){
					swal({ title:  "Success", type: "success",text:"mail Send  Successfully!",showConfirmButton: false,timer: 2000 },
						function(){
							location.reload(true);
						});
				}else{
					swal({ title:  "Error!", type: "error",text:"Failed Try Again!",showConfirmButton: false,timer: 2000 });
				}
			}
		});
	}
});
$("#schoo-login").validate({
	rules:
	{
		email:
		{
			required: true,
			email:true
		},
		code:
		{
			required: true
		},
		password:
		{
			required: true
		},
	},
	errorPlacement: function(error,element) {
		//element.attr('placeholder',error.text());
	},
	submitHandler: function()
	{
		dataString = $('#schoo-login').serialize();
		$.ajax({
			type: "POST",
			url: "action/school-login.php",
			data: dataString,
			success: function(msd)
			{
				swal({
					title: "",
					text: "",
					showConfirmButton: false,
				});
				if(msd==1){
					swal({ title:  "Success", type: "success",text:"Login Successfully!",showConfirmButton: false,timer: 2000 },
					function(){
						location.reload(true);
					});
				}else{
					swal({ title:  "Error!", type: "error",text:"Failed Try Again!",showConfirmButton: false,timer: 2000 });
				}
			}
		})
	}
});
$("#code-login").validate({
	rules:
	{
		code:
		{
			required: true
		},
	},
	errorPlacement: function(error,element) {
		//element.attr('placeholder',error.text());
	},
	submitHandler: function()
	{
		dataString = $('#code-login').serialize();
		$.ajax({
			type: "POST",
			url: "action/code-login.php",
			data: dataString,
			success: function(msd)
			{
				swal({
					title: "",
					text: "",
					showConfirmButton: false,
				});
				if(msd==1){
					swal({ title:  "Success", type: "success",text:"Login Successfully!",showConfirmButton: false,timer: 2000 },
					function(){
						location.reload(true);
					});
				}else{
					swal({ title:  "Error!", type: "error",text:"Failed Try Again!",showConfirmButton: false,timer: 2000 });
				}
			}
		})
	}
});
$("#corporate-login").validate({
	rules:
	{
		email:
		{
			required: true,
			email:true
		},
		password:
		{
			required: true
		},
	},
	errorPlacement: function(error,element) {
		//element.attr('placeholder',error.text());
	},
	submitHandler: function()
	{
		dataString = $('#corporate-login').serialize();
		$.ajax({
			type: "POST",
			url: "action/corporate-login.php",
			data: dataString,
			success: function(msd)
			{
				swal({
					title: "",
					text: "",
					showConfirmButton: false,
				});
				if(msd==1){
					swal({ title:  "Success", type: "success",text:"Login Successfully!",showConfirmButton: false,timer: 2000 },
					function(){
						location.reload(true);
					});
				}else{
					swal({ title:  "Error!", type: "error",text:"Failed Try Again!",showConfirmButton: false,timer: 2000 });
				}
			}
		})
	}
});
$("#login").validate({
	rules:
	{
		email:
		{
			required: true,
			email:true
		},
		password:
		{
			required: true
		},
	},
	errorPlacement: function(error,element) {
		//element.attr('placeholder',error.text());
	},
	submitHandler: function()
	{
		dataString = $('#login').serialize();
        $.ajax({
			type: "POST",
            url: "action/login.php",
            data: dataString,
            success: function(msd)
            {
				swal({
					title: "",
					text: "",
					showConfirmButton: false,
				});
				if(msd==1){

					swal({ title:  "Success", type: "success",text:"Login Successfully!",showConfirmButton: false,timer: 1500},
					function(){
						location.reload(true);
					});
				}else{
					swal({ title:  "Error!", type: "error",text:"Failed Try Again!",showConfirmButton: false,timer: 1500});
				}
			}
		})
	}
});
$("#registerForm").validate({
	rules:
	{
		first_name:
		{
			required: true
		},
		phone:
		{
			required: true,
			number: true
		},
		email:
		{
			required: true,
			email:true
		},
		gender:
		{
			required: true
		},
		username:
		{
			required: true
		},
		password:
		{
			required: true
		},
		con_password:
		{
			required: true,
			equalTo: "#password1"
		},
	},
	errorPlacement: function(error,element) {
		//element.attr('placeholder',error.text());
	},
	submitHandler: function()
	{
		var dataString = new FormData($("#registerForm")[0]);
		$.ajax({
			type: "POST",
			url: "action/register.php",
			data: dataString,
			cache: false,
			contentType: false,
			processData: false,
			success: function(msd)
			{
				if(msd==1){
					$('#alert').html('<div class="alert alert-danger" role="alert">Email Already Exist</div>');
                    $("#alert").fadeIn();
				}else
				if(msd==3){
					document.getElementById("registerForm").reset();
					$('#alert').html('<div class="alert alert-success" role="alert">Registered Successfully</div>');
					$("#alert").fadeIn().fadeOut(5000);
					setTimeout(function () { $('#register-modal').modal('hide'); location.reload(true); }, 4000);
				}
			}
		})
	}
});
	
</script>
  </body>
</html>