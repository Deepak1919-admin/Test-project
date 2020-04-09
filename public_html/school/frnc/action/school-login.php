<?php
require_once("../../commonclass.php");
if(isset($_POST['submit'])){
	$objSchool->setArrData($_POST);
	$res = $objSchool->login();
	echo $res;
}
?>