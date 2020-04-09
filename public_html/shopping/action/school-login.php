<?php
require_once("../commonclass.php");
if(isset($_POST['submit'])){
	//$objSchool->setArrData($_POST);
	//$res = $objSchool->login();
	$objUsers->setArrData($_POST);
	$res = $objUsers->login();
	echo $res;
}
?>