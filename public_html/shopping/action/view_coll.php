<?php 
session_start();
ob_start();
require_once '../commonclass.php'; 
$_POST["user_id"] = $_SESSION['user']['user_id'];
$_POST['status'] = 1;
$result = $objCollobration->checkStatus($_POST["user_id"],$_POST['collobration_id']);
if(empty($result)){
	$objNotification->setArrData($_POST);
	$objNotification->insert();	
}
$res = $objCollobration->GetRowContent($_POST['collobration_id']);
echo '<form class="form-horizontal" name="forgotpass" id="forgotpass" method="post" action="">
		<div class="form-group">
			<div class="col-sm-4">
				<label class="control-label" for="username">Type:</label>
			</div>
			<div class="col-sm-6">
				<label class="control-label" for="username">'.$res['type'].'</label>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-4">
				<label class="control-label" for="username">Title:</label>
			</div>
			<div class="col-sm-6">
				<label class="control-label" for="username">'.$res['title'].'</label>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-4">
				<label class="control-label" for="username">Description:</label>
			</div>
			<div class="col-sm-6">
				<label class="" for="username">'.$res['description'].'</label>
			</div>
		</div>';
		if($res['price'] !=""){
			if($res['commission']=='aed'){ $commission = "AED"; }else { $commission = "%"; }
		echo '<div class="form-group">
			<div class="col-sm-4">
				<label class="control-label" for="username">Commission:</label>
			</div>
			<div class="col-sm-6">
				<label class="control-label" for="username">'.$res['price'].' '.$commission.'</label>
			</div>
		</div>';
		}
	echo '<div class="form-group">
			<div class="col-sm-4">
				<label class="control-label" for="username">Telephone:</label>
			</div>
			<div class="col-sm-6">
				<label class="control-label" for="username">'.$res['phone'].'</label>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-4">
				<label class="control-label" for="username">Email:</label>
			</div>
			<div class="col-sm-6">
				<label class="control-label" for="username">'.$res['email'].'</label>
			</div>
		</div>';
	echo '</form>';
?>
