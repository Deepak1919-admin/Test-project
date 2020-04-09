<?php 
session_start();
ob_start();
require_once '../init.php';
$objUsers=load_class("Users");
	if(isset($_POST['edit'])){
		if($_POST['first_name']!=""&&$_POST['email']!=""){
			 $objUsers->setArrData($_POST);
			$objUsers -> update();
			$_SESSION['msg']='<div class="alert alert-success" role="alert">Updated Successfully</div>';
		}
	}
header("location:".$_SERVER['HTTP_REFERER']);
?>